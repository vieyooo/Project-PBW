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
        $request->validate([
            'ID_PENJUALAN' => 'required',
            'ID_BARANG' => 'required',
            'QTY' => 'required|numeric|min:1',
        ]);

        $id_penjualan = $request->ID_PENJUALAN;
        $id_barang = $request->ID_BARANG;
        $qty = (int) $request->QTY;

        // Ambil harga barang
        $barang = Barang::findOrFail($id_barang);
        $harga_satuan = $barang->HARGA_SATUAN;
        $jumlah = $qty * $harga_satuan;

        // Insert detail
        DetailPenjualan::create([
            'ID_PENJUALAN' => $id_penjualan,
            'ID_BARANG' => $id_barang,
            'QTY' => $qty,
            'JUMLAH' => $jumlah
        ]);

        // Kurangi stok bahan baku berdasarkan BOM
        $boms = Bom::where('ID_BARANG', $id_barang)->get();
        foreach ($boms as $bom) {
            $bahan = BahanBaku::findOrFail($bom->ID_BAHAN_BAKU);
            $bahan_terpakai = $qty * $bom->JUMLAH;
            $bahan->STOK = $bahan->STOK - $bahan_terpakai;
            $bahan->save();
        }

        return redirect()->route('detailpenjualan.index', ['id' => $id_penjualan])
                         ->with('success', 'Berhasil menambahkan barang & stok bahan baku otomatis berkurang!');
    }

    // Form edit detail
    public function edit(Request $request)
    {
        $id_penjualan = $request->get('id');
        $id_barang = $request->get('barang');

        $detail = DetailPenjualan::where('ID_PENJUALAN', $id_penjualan)
            ->where('ID_BARANG', $id_barang)
            ->firstOrFail();

        $barang = Barang::findOrFail($id_barang);

        return view('penjualan.detail.edit', compact('detail', 'barang', 'id_penjualan'));
    }

    // Update detail
    public function update(Request $request)
    {
        $request->validate([
            'QTY' => 'required|numeric|min:1',
            'HARGA_SATUAN' => 'required|numeric|min:0',
        ]);

        $id_penjualan = $request->ID_PENJUALAN;
        $id_barang = $request->ID_BARANG;

        $detail = DetailPenjualan::where('ID_PENJUALAN', $id_penjualan)
            ->where('ID_BARANG', $id_barang)
            ->firstOrFail();

        $qty = (int) $request->QTY;
        $harga_satuan = (float) $request->HARGA_SATUAN;
        $jumlah = $qty * $harga_satuan;

        $detail->QTY = $qty;
        $detail->JUMLAH = $jumlah;
        $detail->save();

        return redirect()->route('detailpenjualan.index', ['id' => $id_penjualan])
                         ->with('success', 'Detail berhasil diupdate.');
    }

    // Hapus detail
    public function destroy(Request $request)
    {
        $id_penjualan = $request->get('id');
        $id_barang = $request->get('barang');

        $detail = DetailPenjualan::where('ID_PENJUALAN', $id_penjualan)
            ->where('ID_BARANG', $id_barang)
            ->firstOrFail();
        $detail->delete();

        return redirect()->route('detailpenjualan.index', ['id' => $id_penjualan])
                         ->with('success', 'Detail barang berhasil dihapus.');
    }

    // Cetak invoice
    public function cetak(Request $request)
    {
        $id = $request->get('id');
        $penjualan = Penjualan::with(['petugas', 'pelanggan'])->findOrFail($id);
        $detail = DetailPenjualan::with('barang')
            ->where('ID_PENJUALAN', $id)
            ->orderBy('ID_BARANG', 'asc')
            ->get();

        return view('penjualan.detail.cetak', compact('penjualan', 'detail'));
    }
}