<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use Illuminate\Http\Request;

class BahanBakuController extends Controller
{
    public function index(Request $request)
    {
        $limit = (int) $request->get('limit', 10);
        $allowed = [5, 10, 15, 20];
        if (!in_array($limit, $allowed)) {
            $limit = 10;
        }

        $bahanBaku = BahanBaku::orderBy('ID_BAHAN_BAKU', 'asc')->paginate($limit);

        return view('bahan-bakus.index', compact('bahanBaku'));
    }

    public function create()
    {
        $max_id = BahanBaku::max('ID_BAHAN_BAKU');

        if ($max_id) {
            $urutan = (int) substr($max_id, 3);
            $urutan++;
        } else {
            $urutan = 7001;
        }

        $id_otomatis = "BB-" . $urutan;

        return view('bahan-bakus.create', compact('id_otomatis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode'         => 'required|string|max:50',
            'jenis'        => 'required|string|max:255',
            'harga_satuan' => 'required|string',
            'satuan'       => 'required|string|max:20',
            'stok'         => 'required|integer|min:0',
        ]);

        $max_id = BahanBaku::max('ID_BAHAN_BAKU');

        if ($max_id) {
            $urutan = (int) substr($max_id, 3);
            $urutan++;
        } else {
            $urutan = 7001;
        }

        $id_otomatis = "BB-" . $urutan;

        $harga = str_replace(['.', ','], '', $request->harga_satuan);

        BahanBaku::create([
            'ID_BAHAN_BAKU' => $id_otomatis,
            'JENIS'         => $request->jenis,
            'KODE'          => $request->kode,
            'HARGA_SATUAN'  => $harga,
            'SATUAN'        => $request->satuan,
            'STOK'          => $request->stok,
        ]);

        return redirect()->route('bahan-bakus.index')->with('success', 'Data bahan baku baru telah ditambahkan.');
    }

    public function edit(BahanBaku $bahan_baku)
    {
        return view('bahan-bakus.edit', ['data' => $bahan_baku]);
    }

    public function update(Request $request, BahanBaku $bahan_baku)
    {
        $request->validate([
            'kode'         => 'required|string|max:50',
            'jenis'        => 'required|string|max:255',
            'harga_satuan' => 'required|string',
            'satuan'       => 'required|string|max:20',
            'stok'         => 'required|integer|min:0',
        ]);

        $harga = str_replace(['.', ','], '', $request->harga_satuan);

        $bahan_baku->update([
            'JENIS'        => $request->jenis,
            'KODE'         => $request->kode,
            'HARGA_SATUAN' => $harga,
            'SATUAN'       => $request->satuan,
            'STOK'         => $request->stok,
        ]);

        return redirect()->route('bahan-bakus.index')->with('success', 'Data bahan baku telah diperbarui.');
    }

    public function destroy(BahanBaku $bahan_baku)
    {
        $totalBom = \DB::table('bom')
            ->where('ID_BAHAN_BAKU', $bahan_baku->ID_BAHAN_BAKU)
            ->count();

        if ($totalBom > 0) {
            return redirect()->route('bahan-bakus.index')
                ->with('error', "Gagal menghapus! Bahan baku ini masih digunakan di {$totalBom} produk. Hapus relasi BOM terlebih dahulu.");
        }

        $bahan_baku->delete();

        return redirect()->route('bahan-bakus.index')->with('success', 'Data bahan baku telah dihapus.');
    }
}