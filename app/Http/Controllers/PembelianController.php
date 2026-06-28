<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Supplier;
use App\Models\BahanBaku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->input('limit', 10);
        $pembelian = Pembelian::with('supplier')
            ->orderByDesc('TANGGAL')
            ->paginate($limit);
        return view('pembelian.index', compact('pembelian', 'limit'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $last = Pembelian::orderByDesc('NO_INVOICE')->first();
        $lastNum = $last ? intval(substr($last->NO_INVOICE, 3)) : 6000;
        $newNumber = 'PO-' . ($lastNum + 1);
        return view('pembelian.create', compact('suppliers', 'newNumber'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'NO_INVOICE'  => 'required|unique:pembelian,NO_INVOICE',
            'TANGGAL'     => 'required|date',
            'ID_SUPPLIER' => 'required',
            'JUMLAH_HARGA'=> 'required|numeric|min:0',
            'ONGKOS_KIRIM'=> 'nullable|numeric|min:0',
            // DISKON dihapus dari validasi
            'SCAN_NOTA'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $jumlah = (float) str_replace(['.', ','], ['', '.'], $request->JUMLAH_HARGA);
        $ongkir = (float) str_replace(['.', ','], ['', '.'], $request->ONGKOS_KIRIM ?? 0);

        $nilaiDpp = $jumlah * (100 / 111);
        $ppn = $jumlah - $nilaiDpp;
        $total = $nilaiDpp + $ppn + $ongkir; // tanpa diskon

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
            // 'DISKON' => $diskon, // tidak ada
            'TOTAL_INVOICE'=> $total,
            'SCAN_NOTA'    => $scanPath,
        ]);

        return redirect()->route('pembelian.show', $request->NO_INVOICE)
                         ->with('success', 'Pembelian berhasil ditambahkan!');
    }

    public function show($id)
    {
        $pembelian = Pembelian::with(['supplier', 'details.bahanBaku'])->findOrFail($id);
        $details = $pembelian->details;
        return view('pembelian.show', compact('pembelian', 'details'));
    }

    public function createDetail($no_invoice)
    {
        $pembelian = Pembelian::where('NO_INVOICE', $no_invoice)->firstOrFail();
        $bahanBakus = BahanBaku::orderBy('JENIS', 'asc')->get();
        return view('pembelian.detail-tambah', [
            'noInvoice'  => $pembelian->NO_INVOICE,
            'bahanBakus' => $bahanBakus
        ]);
    }

    public function edit($id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $suppliers = Supplier::all();
        return view('pembelian.edit', compact('pembelian', 'suppliers'));
    }

    public function update(Request $request, $id)
    {
        $pembelian = Pembelian::findOrFail($id);

        $request->validate([
            'TANGGAL'     => 'required|date',
            'ID_SUPPLIER' => 'required',
            'JUMLAH_HARGA'=> 'required|numeric|min:0',
            'ONGKOS_KIRIM'=> 'nullable|numeric|min:0',
            // DISKON dihapus
            'SCAN_NOTA'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $jumlah = (float) str_replace(['.', ','], ['', '.'], $request->JUMLAH_HARGA);
        $ongkir = (float) str_replace(['.', ','], ['', '.'], $request->ONGKOS_KIRIM ?? 0);

        $nilaiDpp = $jumlah * (100 / 111);
        $ppn = $jumlah - $nilaiDpp;
        $total = $nilaiDpp + $ppn + $ongkir; // tanpa diskon

        $scanPath = $pembelian->SCAN_NOTA;
        if ($request->hasFile('SCAN_NOTA')) {
            if ($scanPath && file_exists(public_path($scanPath))) {
                unlink(public_path($scanPath));
            }
            $file = $request->file('SCAN_NOTA');
            $filename = $pembelian->NO_INVOICE . '_' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $path = 'img/scan_nota/';
            $file->move(public_path($path), $filename);
            $scanPath = $path . $filename;
        }

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
            // 'DISKON' => $diskon, // tidak ada
            'TOTAL_INVOICE'=> $total,
            'SCAN_NOTA'    => $scanPath,
        ]);

        return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil diupdate!');
    }

  public function destroy($id)
{
    try {
        DB::beginTransaction();

        $pembelian = Pembelian::with('details')->findOrFail($id);

        $pembelian->details()->delete();

        if ($pembelian->SCAN_NOTA && file_exists(public_path($pembelian->SCAN_NOTA))) {
            unlink(public_path($pembelian->SCAN_NOTA));
        }

        $pembelian->delete();

        DB::commit();

        return redirect()->route('pembelian.index')
                         ->with('success', 'Pembelian beserta seluruh detailnya berhasil dihapus!');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->route('pembelian.index')
                         ->with('error', 'Gagal menghapus: ' . $e->getMessage());
    }
}
}