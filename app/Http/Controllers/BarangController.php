<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $limit = (int) $request->get('limit', 10);
        $allowed = [5, 10, 15, 20];
        if (!in_array($limit, $allowed)) {
            $limit = 10;
        }

        $barang = Barang::orderBy('ID_BARANG', 'desc')->paginate($limit);

        return view('barang.index', compact('barang'));
    }

    public function create()
    {
        $max_id = Barang::max('ID_BARANG');

        if ($max_id) {
            $urutan = (int) substr($max_id, 4);
            $urutan++;
        } else {
            $urutan = 3001;
        }

        $id_otomatis = "BRG-" . $urutan;

        return view('barang.create', compact('id_otomatis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang'  => 'required|string|max:255',
            'harga_satuan' => 'required|numeric|min:1',
        ]);

        $max_id = Barang::max('ID_BARANG');

        if ($max_id) {
            $urutan = (int) substr($max_id, 4);
            $urutan++;
        } else {
            $urutan = 3001;
        }

        $id_otomatis = "BRG-" . $urutan;

        $harga = str_replace(['.', ','], '', $request->harga_satuan);

        Barang::create([
            'ID_BARANG'    => $id_otomatis,
            'NAMA_BARANG'  => $request->nama_barang,
            'HARGA_SATUAN' => $harga,
        ]);

        return redirect()->route('barang.bom.index', $id_otomatis)->with('success', 'tambah');
    }

    public function edit(Barang $barang)
    {
        return view('barang.edit', ['data' => $barang]);
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama_barang'  => 'required|string|max:255',
            'harga_satuan' => 'required|string',
        ]);

        $harga = str_replace(['.', ','], '', $request->harga_satuan);

        $barang->update([
            'NAMA_BARANG'  => $request->nama_barang,
            'HARGA_SATUAN' => $harga,
        ]);

        return redirect()->route('barang.index')->with('success', 'Data barang telah diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        $totalPenjualan = DB::table('detail_penjualan')
            ->where('ID_BARANG', $barang->ID_BARANG)
            ->count();

        if ($totalPenjualan > 0) {
            return redirect()->route('barang.index')
                ->with('error', 'Gagal menghapus! Barang ini sudah pernah terjual. Hapus transaksi penjualan terlebih dahulu.');
        }

        // Hapus dulu semua data BOM (bahan baku) yang terkait dengan barang ini
        // supaya tidak melanggar foreign key constraint bom_ibfk_1
        DB::table('bom')->where('ID_BARANG', $barang->ID_BARANG)->delete();

        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Data barang telah dihapus.');
    }
}