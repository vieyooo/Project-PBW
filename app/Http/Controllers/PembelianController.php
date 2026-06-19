<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Supplier;
use App\Models\BahanBaku; // Memastikan model BahanBaku ter-import secara benar
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PembelianController extends Controller
{
    // LIST semua pembelian
    public function index(Request $request)
    {
        $limit = $request->input('limit', 10);

        $pembelian = Pembelian::with('supplier')
            ->orderByDesc('TANGGAL')
            ->paginate($limit);

        return view('pembelian.index', compact('pembelian', 'limit'));
    }

    // FORM tambah pembelian utama
    public function create()
    {
        $suppliers = Supplier::all();
        $last = Pembelian::orderByDesc('NO_INVOICE')->first();
        $lastNum = $last ? intval(substr($last->NO_INVOICE, 3)) : 6000;
        $newNumber = 'PO-' . ($lastNum + 1);
        return view('pembelian.create', compact('suppliers', 'newNumber'));
    }

    // SIMPAN tambah pembelian utama
    public function store(Request $request)
    {
        $request->validate([
            'NO_INVOICE'  => 'required|unique:pembelian,NO_INVOICE',
            'TANGGAL'     => 'required|date',
            'ID_SUPPLIER' => 'required',
            'JUMLAH_HARGA'=> 'required|numeric|min:0',
            'ONGKOS_KIRIM'=> 'nullable|numeric|min:0',
            'DISKON'      => 'nullable|numeric|min:0',
            'SCAN_NOTA'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Hapus titik/koma dari format rupiah
        $jumlah = (float) str_replace(['.', ','], ['', '.'], $request->JUMLAH_HARGA);
        $ongkir = (float) str_replace(['.', ','], ['', '.'], $request->ONGKOS_KIRIM ?? 0);
        $diskon = (float) str_replace(['.', ','], ['', '.'], $request->DISKON ?? 0);

        // Hitung NILAI_DPP dan PPN (11%)
        $nilaiDpp = $jumlah * (100 / 111);
        $ppn = $jumlah - $nilaiDpp;
        $total = ($nilaiDpp + $ppn + $ongkir) - $diskon;

        // Upload scan nota
        $scanPath = null;
        if ($request->hasFile('SCAN_NOTA')) {
            $file = $request->file('SCAN_NOTA');
            $filename = $request->NO_INVOICE . '_' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $path = 'img/scan_nota/';
            $file->move(public_path($path), $filename);
            $scanPath = $path . $filename;
        }

        Pembelian::create([
            'NO_INVOICE'   => $request->NO_INVOICE,
            'TANGGAL'      => $request->TANGGAL,
            'ID_SUPPLIER'  => $request->ID_SUPPLIER,
            'JUMLAH_HARGA' => $jumlah,
            'NILAI_DPP'    => $nilaiDpp,
            'PPN'          => $ppn,
            'ONGKOS_KIRIM' => $ongkir,
            'DISKON'       => $diskon,
            'TOTAL_INVOICE'=> $total,
            'SCAN_NOTA'    => $scanPath,
        ]);

        return redirect()->route('pembelian.show', $request->NO_INVOICE)
                         ->with('success', 'Pembelian berhasil ditambahkan!');
    }

    // DETAIL pembelian + list bahan baku
    public function show($id)
    {
        $pembelian = Pembelian::with(['supplier', 'details.bahanBaku'])->findOrFail($id);
        
        // Mengambil details secara eksplisit untuk dikirim ke view show.blade.php
        $details = $pembelian->details; 

        return view('pembelian.show', compact('pembelian', 'details'));
    }

    // FORM tambah detail bahan baku per invoice
    public function createDetail($no_invoice)
    {
        // 1. Memastikan data invoice ini memang ada di database
        $pembelian = Pembelian::where('NO_INVOICE', $no_invoice)->firstOrFail();
        
        // 2. Ambil semua data bahan baku untuk isi dropdown di form
        $bahanBakus = BahanBaku::orderBy('JENIS', 'asc')->get(); 

        // 3. Kirimkan kedua variabel tersebut ke view
        return view('pembelian.detail-tambah', [
            'noInvoice'  => $pembelian->NO_INVOICE,
            'bahanBakus' => $bahanBakus
        ]);
    }

    // FORM edit pembelian utama
    public function edit($id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $suppliers = Supplier::all();
        return view('pembelian.edit', compact('pembelian', 'suppliers'));
    }

    // SIMPAN edit pembelian utama
    public function update(Request $request, $id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $request->validate([
            'TANGGAL'     => 'required|date',
            'ID_SUPPLIER' => 'required',
            'JUMLAH_HARGA'=> 'required|numeric|min:0',
            'ONGKOS_KIRIM'=> 'nullable|numeric|min:0',
            'DISKON'      => 'nullable|numeric|min:0',
            'SCAN_NOTA'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Hapus titik/koma dari format rupiah
        $jumlah = (float) str_replace(['.', ','], ['', '.'], $request->JUMLAH_HARGA);
        $ongkir = (float) str_replace(['.', ','], ['', '.'], $request->ONGKOS_KIRIM ?? 0);
        $diskon = (float) str_replace(['.', ','], ['', '.'], $request->DISKON ?? 0);

        // Hitung NILAI_DPP dan PPN (11%)
        $nilaiDpp = $jumlah * (100 / 111);
        $ppn = $jumlah - $nilaiDpp;
        $total = ($nilaiDpp + $ppn + $ongkir) - $diskon;

        // Upload scan nota
        $scanPath = $pembelian->SCAN_NOTA;
        if ($request->hasFile('SCAN_NOTA')) {
            // Hapus file lama
            if ($scanPath && file_exists(public_path($scanPath))) {
                unlink(public_path($scanPath));
            }
            $file = $request->file('SCAN_NOTA');
            $filename = $pembelian->NO_INVOICE . '_' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $path = 'img/scan_nota/';
            $file->move(public_path($path), $filename);
            $scanPath = $path . $filename;
        }

        // Hapus scan jika checkbox dicentang
        if ($request->has('hapus_scan') && $request->hapus_scan == '1') {
            if ($scanPath && file_exists(public_path($scanPath))) {
                unlink(public_path($scanPath));
            }
            $scanPath = null;
        }

        $pembelian->update([
            'TANGGAL'      => $request->TANGGAL,
            'ID_SUPPLIER'  => $request->ID_SUPPLIER,
            'JUMLAH_HARGA' => $jumlah,
            'NILAI_DPP'    => $nilaiDpp,
            'PPN'          => $ppn,
            'ONGKOS_KIRIM' => $ongkir,
            'DISKON'       => $diskon,
            'TOTAL_INVOICE'=> $total,
            'SCAN_NOTA'    => $scanPath,
        ]);

        return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil diupdate!');
    }

    // HAPUS pembelian
    public function destroy($id)
    {
        $pembelian = Pembelian::findOrFail($id);

        if ($pembelian->details()->count() > 0) {
            return redirect()->route('pembelian.index')
                ->with('error', "Gagal! Invoice $id masih punya detail. Hapus detail dulu.");
        }

        if ($pembelian->SCAN_NOTA && file_exists(public_path($pembelian->SCAN_NOTA))) {
            unlink(public_path($pembelian->SCAN_NOTA));
        }

        $pembelian->delete();
        return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil dihapus!');
    }
}