<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Barang;
use App\Models\BahanBaku;
use App\Models\Bom;
use Illuminate\Http\Request;

class DetailPenjualanController extends Controller
{
    // Lihat detail
    public function index(Request $request)
    {
        $id = $request->get('id');
        $penjualan = Penjualan::with(['petugas', 'pelanggan'])->findOrFail($id);
        $detail = DetailPenjualan::with('barang')
            ->where('ID_PENJUALAN', $id)
            ->orderBy('ID_BARANG', 'asc')
            ->get();

        return view('penjualan.detail.index', compact('penjualan', 'detail'));
    }

    // Form tambah detail
    public function create(Request $request)
    {
        $id_penjualan = $request->get('id');
        $penjualan = Penjualan::findOrFail($id_penjualan);

        // Ambil barang yang belum ada di detail
        $barangs = Barang::whereNotIn('ID_BARANG', function($query) use ($id_penjualan) {
            $query->select('ID_BARANG')
                  ->from('detail_penjualan')
                  ->where('ID_PENJUALAN', $id_penjualan);
        })->orderBy('NAMA_BARANG', 'asc')->get();

        return view('penjualan.detail.create', compact('penjualan', 'barangs'));
    }

    // Simpan detail
    public function store(Request $request)
{
    // Ambil ID_PENJUALAN dari request, jika kosong coba ambil dari parameter 'id' (jika ada di URL)
    $id_penjualan = $request->input('ID_PENJUALAN');
    if (empty($id_penjualan)) {
        // Coba dari query string 'id' atau dari route parameter
        $id_penjualan = $request->query('id') ?? $request->route('id');
    }

    // Jika tetap kosong, coba ambil dari session atau generate (tapi seharusnya sudah ada)
    if (empty($id_penjualan)) {
        return back()->withErrors(['ID_PENJUALAN' => 'ID Penjualan tidak ditemukan.']);
    }

    // Validasi (tanpa required ID_PENJUALAN karena sudah kita tangani)
    $request->validate([
        'ID_BARANG' => 'required|exists:barang,ID_BARANG',
        'QTY' => 'required|numeric|min:1',
    ]);

    // Proses simpan detail...
    $id_barang = $request->ID_BARANG;
    $qty = (int) $request->QTY;

    $barang = Barang::findOrFail($id_barang);
    $harga_satuan = $barang->HARGA_SATUAN;
    $jumlah = $qty * $harga_satuan;

    DetailPenjualan::create([
        'ID_PENJUALAN' => $id_penjualan,
        'ID_BARANG' => $id_barang,
        'QTY' => $qty,
        'JUMLAH' => $jumlah
    ]);

    // Kurangi stok bahan baku...
    $boms = Bom::where('ID_BARANG', $id_barang)->get();
    foreach ($boms as $bom) {
        $bahan = BahanBaku::findOrFail($bom->ID_BAHAN_BAKU);
        $bahan_terpakai = $qty * $bom->JUMLAH;
        $bahan->STOK = $bahan->STOK - $bahan_terpakai;
        $bahan->save();
    }

    return redirect()->route('detailpenjualan.index', ['id' => $id_penjualan])
                     ->with('success', 'Item berhasil ditambahkan.');
}
  
    // Form edit detail
   public function edit(Request $request)
{
    $id_penjualan = $request->query('id_penjualan');
    $id_barang = $request->query('id_barang');
    
    $penjualan = Penjualan::findOrFail($id_penjualan);
    $detail = DetailPenjualan::where('ID_PENJUALAN', $id_penjualan)
                ->where('ID_BARANG', $id_barang)
                ->firstOrFail();
                
    return view('penjualan.detail.edit', compact('penjualan', 'detail'));
}

    public function update(Request $request)
{
    $id_penjualan = $request->query('id_penjualan');
    $id_barang = $request->query('id_barang');

    if (empty($id_penjualan) || empty($id_barang)) {
        return back()->withErrors(['error' => 'ID Penjualan atau ID Barang tidak ditemukan.']);
    }

    $request->validate([
        'QTY' => 'required|numeric|min:1',
        'HARGA_SATUAN' => 'required|numeric|min:0',
    ]);

    // Update langsung dengan kondisi
    $affected = DetailPenjualan::where('ID_PENJUALAN', $id_penjualan)
                ->where('ID_BARANG', $id_barang)
                ->update([
                    'QTY' => $request->QTY,
                    'JUMLAH' => $request->QTY * $request->HARGA_SATUAN,
                ]);

    if ($affected) {
        return redirect()->route('detailpenjualan.index', ['id' => $id_penjualan])
                         ->with('success', 'Detail berhasil diupdate.');
    } else {
        return back()->withErrors(['error' => 'Data tidak ditemukan atau tidak ada perubahan.']);
    }
}
    // Hapus detail
    public function destroy(Request $request)
{
    $id_penjualan = $request->query('id_penjualan');
    $id_barang = $request->query('id_barang');

    if (empty($id_penjualan) || empty($id_barang)) {
        return back()->withErrors(['error' => 'ID Penjualan atau ID Barang tidak ditemukan.']);
    }

    $deleted = DetailPenjualan::where('ID_PENJUALAN', $id_penjualan)
                ->where('ID_BARANG', $id_barang)
                ->delete();

    if ($deleted) {
        return redirect()->route('detailpenjualan.index', ['id' => $id_penjualan])
                         ->with('success', 'Item berhasil dihapus.');
    } else {
        return back()->withErrors(['error' => 'Item tidak ditemukan.']);
    }
}

    public function cetakInvoice($id)
{
    $penjualan = Penjualan::with(['pelanggan', 'petugas'])->findOrFail($id);
    $detail = DetailPenjualan::with('barang')
                ->where('ID_PENJUALAN', $id)
                ->orderBy('ID_BARANG', 'asc')
                ->get();

    return view('penjualan.detail.cetak', compact('penjualan', 'detail'));
}
}