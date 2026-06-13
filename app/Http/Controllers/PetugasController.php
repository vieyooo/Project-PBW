<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PetugasController extends Controller
{
    // Index: daftar petugas dengan pagination dan limit
    public function index(Request $request)
    {
        $limit = $request->get('limit', 10);
        $allowedLimits = [5, 10, 15, 20];
        if (!in_array($limit, $allowedLimits)) $limit = 10;

        $petugas = Petugas::orderBy('ID_PETUGAS', 'asc')->paginate($limit);
        $petugas->appends(['limit' => $limit]);

        return view('petugas.index', compact('petugas'));
    }

    // Form tambah
    public function create()
    {
        // Auto generate ID: PG-1001, PG-1002, ...
        $lastId = Petugas::max('ID_PETUGAS');
        if ($lastId) {
            $angka = (int) substr($lastId, 3) + 1;
        } else {
            $angka = 1001;
        }
        $idOtomatis = 'PG-' . sprintf("%04d", $angka);

        $jabatanOptions = [
            'Owner/Konsultan Interior',
            'Head Of Production',
            'Teknisi Senior (Restomod)',
            'Teknisi Junior (Jahit/Pola)',
            'Admin & Customer Services'
        ];
        return view('petugas.create', compact('idOtomatis', 'jabatanOptions'));
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'ID_PETUGAS'   => 'required|unique:petugas,ID_PETUGAS',
            'NAMA_PETUGAS' => 'required|string|max:100',
            'JABATAN'      => 'required|string|max:100',
            'ttd'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->only(['ID_PETUGAS', 'NAMA_PETUGAS', 'JABATAN']);

        // Upload file tanda tangan jika ada
        if ($request->hasFile('ttd')) {
            $file = $request->file('ttd');
            $filename = $data['ID_PETUGAS'] . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/ttd'), $filename);
            $data['FILE_TTD'] = $filename;
        }

        Petugas::create($data);

        return redirect()->route('petugas.index', ['limit' => $request->get('limit', 10)])
                         ->with('success', 'Petugas berhasil ditambahkan.');
    }

    // Form edit
    public function edit($id)
    {
        $petugas = Petugas::findOrFail($id);
        $jabatanOptions = [
            'Owner/Konsultan Interior',
            'Head Of Production',
            'Teknisi Senior (Restomod)',
            'Teknisi Junior (Jahit/Pola)',
            'Admin & Customer Services'
        ];
        return view('petugas.edit', compact('petugas', 'jabatanOptions'));
    }

    // Update data
    public function update(Request $request, $id)
    {
        $petugas = Petugas::findOrFail($id);

        $request->validate([
            'NAMA_PETUGAS' => 'required|string|max:100',
            'JABATAN'      => 'required|string|max:100',
            'ttd'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->only(['NAMA_PETUGAS', 'JABATAN']);

        // Hapus tanda tangan jika checkbox dicentang
        if ($request->has('hapus_ttd') && $request->hapus_ttd == '1') {
            if ($petugas->FILE_TTD && file_exists(public_path('img/ttd/' . $petugas->FILE_TTD))) {
                unlink(public_path('img/ttd/' . $petugas->FILE_TTD));
            }
            $data['FILE_TTD'] = null;
        }

        // Upload file baru jika ada
        if ($request->hasFile('ttd')) {
            // Hapus file lama jika ada
            if ($petugas->FILE_TTD && file_exists(public_path('img/ttd/' . $petugas->FILE_TTD))) {
                unlink(public_path('img/ttd/' . $petugas->FILE_TTD));
            }
            $file = $request->file('ttd');
            $filename = $petugas->ID_PETUGAS . '_' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/ttd'), $filename);
            $data['FILE_TTD'] = $filename;
        }

        $petugas->update($data);

        return redirect()->route('petugas.index', ['limit' => $request->get('limit', 10)])
                         ->with('success', 'Data petugas berhasil diupdate.');
    }

    // Hapus data (dengan cek relasi ke penjualan)
    public function destroy(Request $request, $id)
    {
        $petugas = Petugas::findOrFail($id);

        // Cek apakah petugas memiliki transaksi penjualan
        $jumlahPenjualan = \App\Models\Penjualan::where('ID_PETUGAS', $id)->count();
        if ($jumlahPenjualan > 0) {
            return redirect()->route('petugas.index', ['limit' => $request->get('limit', 10)])
                             ->with('error', "Gagal hapus! Petugas masih memiliki $jumlahPenjualan transaksi PENJUALAN. Hapus transaksi tersebut dulu.");
        }

        // Hapus file tanda tangan jika ada
        if ($petugas->FILE_TTD && file_exists(public_path('img/ttd/' . $petugas->FILE_TTD))) {
            unlink(public_path('img/ttd/' . $petugas->FILE_TTD));
        }

        $petugas->delete();

        return redirect()->route('petugas.index', ['limit' => $request->get('limit', 10)])
                         ->with('success', 'Data petugas berhasil dihapus.');
    }
}