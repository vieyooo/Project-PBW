<?php
namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Supplier;
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

    // FORM tambah
    public function create()
    {
        $suppliers = Supplier::all();
        $last = Pembelian::orderByDesc('NO_INVOICE')->first();
        $lastNum = $last ? intval(substr($last->NO_INVOICE, 3)) : 6000;
        $newNumber = 'PO-' . ($lastNum + 1);
        return view('pembelian.create', compact('suppliers', 'newNumber'));
    }

    // SIMPAN tambah
    public function store(Request $request)
    {
        $request->validate([
            'NO_INVOICE'  => 'required|unique:pembelian,NO_INVOICE',
            'TANGGAL'     => 'required|date',
            'ID_SUPPLIER' => 'required',
            'JUMLAH_HARGA'=> 'required|numeric|min:0',
            'SCAN_NOTA'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $scanPath = null;
        if ($request->hasFile('SCAN_NOTA')) {
            $scanPath = $request->file('SCAN_NOTA')->store('scan_nota', 'public');
        }

        $jumlah    = (float) $request->JUMLAH_HARGA;
        $ongkir    = (float) ($request->ONGKOS_KIRIM ?? 0);
        $diskon    = (float) ($request->DISKON ?? 0);
        $total     = $jumlah + $ongkir - $diskon;

        Pembelian::create([
            'NO_INVOICE'   => $request->NO_INVOICE,
            'TANGGAL'      => $request->TANGGAL,
            'ID_SUPPLIER'  => $request->ID_SUPPLIER,
            'JUMLAH_HARGA' => $jumlah,
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
        return view('pembelian.show', compact('pembelian'));
    }

    // FORM edit
    public function edit($id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $suppliers = Supplier::all();
        return view('pembelian.edit', compact('pembelian', 'suppliers'));
    }

    // SIMPAN edit
    public function update(Request $request, $id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $request->validate([
            'TANGGAL'     => 'required|date',
            'ID_SUPPLIER' => 'required',
            'JUMLAH_HARGA'=> 'required|numeric|min:0',
            'SCAN_NOTA'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $scanPath = $pembelian->SCAN_NOTA;
        if ($request->hasFile('SCAN_NOTA')) {
            if ($scanPath) Storage::disk('public')->delete($scanPath);
            $scanPath = $request->file('SCAN_NOTA')->store('scan_nota', 'public');
        }

        $jumlah = (float) $request->JUMLAH_HARGA;
        $ongkir = (float) ($request->ONGKOS_KIRIM ?? 0);
        $diskon = (float) ($request->DISKON ?? 0);
        $total  = $jumlah + $ongkir - $diskon;

        $pembelian->update([
            'TANGGAL'      => $request->TANGGAL,
            'ID_SUPPLIER'  => $request->ID_SUPPLIER,
            'JUMLAH_HARGA' => $jumlah,
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

        if ($pembelian->SCAN_NOTA) {
            Storage::disk('public')->delete($pembelian->SCAN_NOTA);
        }

        $pembelian->delete();
        return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil dihapus!');
    }
}