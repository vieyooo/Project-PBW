<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangBomController extends Controller
{
    public function index($id)
    {
        $barang = Barang::findOrFail($id);

        $bomData = DB::table('bom')
            ->join('bahan_baku', 'bom.ID_BAHAN_BAKU', '=', 'bahan_baku.ID_BAHAN_BAKU')
            ->where('bom.ID_BARANG', $id)
            ->select('bom.*', 'bahan_baku.JENIS', 'bahan_baku.KODE', 'bahan_baku.HARGA_BELI', 'bahan_baku.SATUAN', 'bahan_baku.STOK')
            ->orderBy('bom.ID_BAHAN_BAKU')
            ->get();

        return view('barang.bom.index', compact('barang', 'bomData'));
    }

    public function create($id)
    {
        $barang = Barang::findOrFail($id);
        $bahanBaku = DB::table('bahan_baku')->orderBy('JENIS', 'asc')->get();
        return view('barang.bom.create', compact('barang', 'bahanBaku'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'id_bahan' => 'required|exists:bahan_baku,ID_BAHAN_BAKU',
            'jumlah'   => 'required|numeric|min:0.01',
        ]);

        $exists = DB::table('bom')
            ->where('ID_BARANG', $id)
            ->where('ID_BAHAN_BAKU', $request->id_bahan)
            ->exists();

        if ($exists) {
            return redirect()->route('barang.bom.index', $id)
                ->with('error', 'Bahan baku sudah ada dalam BOM barang ini.');
        }

        DB::table('bom')->insert([
            'ID_BARANG'     => $id,
            'ID_BAHAN_BAKU' => $request->id_bahan,
            'JUMLAH'        => $request->jumlah,
        ]);

        return redirect()->route('barang.bom.index', $id)
            ->with('success', 'BOM berhasil ditambahkan!');
    }

    public function edit($id, $id_bahan)
    {
        $barang = Barang::findOrFail($id);
        $bom = DB::table('bom')
            ->where('ID_BARANG', $id)
            ->where('ID_BAHAN_BAKU', $id_bahan)
            ->first();

        if (!$bom) {
            return redirect()->route('barang.bom.index', $id)
                ->with('error', 'Data BOM tidak ditemukan.');
        }

        // Tambahkan informasi bahan baku
        $bahan = DB::table('bahan_baku')->where('ID_BAHAN_BAKU', $id_bahan)->first();
        $bom->JENIS = $bahan->JENIS ?? '';

        $bahanBaku = DB::table('bahan_baku')->orderBy('JENIS', 'asc')->get();

        return view('barang.bom.edit', compact('barang', 'bom', 'bahanBaku'));
    }

    public function update(Request $request, $id, $id_bahan)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:0.01',
        ]);

        DB::table('bom')
            ->where('ID_BARANG', $id)
            ->where('ID_BAHAN_BAKU', $id_bahan)
            ->update(['JUMLAH' => $request->jumlah]);

        return redirect()->route('barang.bom.index', $id)
            ->with('success', 'BOM berhasil diupdate!');
    }

    public function destroy($id, $id_bahan)
    {
        DB::table('bom')
            ->where('ID_BARANG', $id)
            ->where('ID_BAHAN_BAKU', $id_bahan)
            ->delete();

        return redirect()->route('barang.bom.index', $id)
            ->with('success', 'BOM berhasil dihapus!');
    }

    public function cetak($id)
    {
        $barang = Barang::findOrFail($id);

        $bomData = DB::table('bom')
            ->join('bahan_baku', 'bom.ID_BAHAN_BAKU', '=', 'bahan_baku.ID_BAHAN_BAKU')
            ->where('bom.ID_BARANG', $id)
            ->select('bom.*', 'bahan_baku.JENIS', 'bahan_baku.KODE', 'bahan_baku.HARGA_BELI', 'bahan_baku.SATUAN')
            ->orderBy('bom.ID_BAHAN_BAKU')
            ->get();

        // Tambahkan total harga per item
        foreach ($bomData as $item) {
            $item->TOTAL_HARGA = $item->JUMLAH * $item->HARGA_BELI;
        }

        return view('barang.bom.cetak', compact('barang', 'bomData'));
    }
}