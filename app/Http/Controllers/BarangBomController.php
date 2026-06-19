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
            ->select('bom.*', 'bahan_baku.JENIS', 'bahan_baku.KODE', 'bahan_baku.HARGA_SATUAN', 'bahan_baku.SATUAN', 'bahan_baku.STOK')
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
        $barang = Barang::findOrFail($id);

        $request->validate([
            'id_bahan' => 'required|string',
            'jumlah'   => 'required|numeric|min:0.01',
        ]);

        $exists = DB::table('bom')
            ->where('ID_BARANG', $id)
            ->where('ID_BAHAN_BAKU', $request->id_bahan)
            ->exists();

        if ($exists) {
            return back()->withErrors('Bahan baku sudah terdaftar di BOM barang ini!')->withInput();
        }

        DB::table('bom')->insert([
            'ID_BARANG'     => $id,
            'ID_BAHAN_BAKU' => $request->id_bahan,
            'JUMLAH'        => $request->jumlah,
        ]);

        return redirect()->route('barang.bom.index', $id)->with('success', 'Bahan baku ditambahkan ke BOM.');
    }

    public function edit($id, $bahan)
    {
        $barang = Barang::findOrFail($id);

        $bom = DB::table('bom')
            ->join('bahan_baku', 'bom.ID_BAHAN_BAKU', '=', 'bahan_baku.ID_BAHAN_BAKU')
            ->where('bom.ID_BARANG', $id)
            ->where('bom.ID_BAHAN_BAKU', $bahan)
            ->select('bom.*', 'bahan_baku.JENIS', 'bahan_baku.SATUAN')
            ->first();

        if (!$bom) {
            return redirect()->route('barang.bom.index', $id)->with('error', 'Data BOM tidak ditemukan!');
        }

        return view('barang.bom.edit', compact('barang', 'bom'));
    }

    public function update(Request $request, $id, $bahan)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:0.01',
        ]);

        DB::table('bom')
            ->where('ID_BARANG', $id)
            ->where('ID_BAHAN_BAKU', $bahan)
            ->update(['JUMLAH' => $request->jumlah]);

        return redirect()->route('barang.bom.index', $id)->with('success', 'Data BOM telah diperbarui.');
    }

    public function destroy($id, $bahan)
    {
        DB::table('bom')
            ->where('ID_BARANG', $id)
            ->where('ID_BAHAN_BAKU', $bahan)
            ->delete();

        return redirect()->route('barang.bom.index', $id)->with('success', 'Bahan baku telah dihapus dari BOM.');
    }

    public function cetak($id)
    {
        $barang = Barang::findOrFail($id);

        $bomData = DB::table('bom')
            ->join('bahan_baku', 'bom.ID_BAHAN_BAKU', '=', 'bahan_baku.ID_BAHAN_BAKU')
            ->where('bom.ID_BARANG', $id)
            ->select('bom.*', 'bahan_baku.JENIS', 'bahan_baku.KODE', 'bahan_baku.HARGA_SATUAN', 'bahan_baku.SATUAN', 'bahan_baku.STOK')
            ->orderBy('bom.ID_BAHAN_BAKU')
            ->get()
            ->map(function ($item) {
                $item->TOTAL_HARGA = $item->JUMLAH * $item->HARGA_SATUAN;
                return $item;
            });

        return view('barang.bom.cetak', compact('barang', 'bomData'));
    }
}