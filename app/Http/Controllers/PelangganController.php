<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->get('limit', 10);
        $allowed = [5,10,15,20];
        if (!in_array($limit, $allowed)) $limit = 10;

       $pelanggans = Pelanggan::orderBy('ID_PELANGGAN', 'desc')->paginate($limit);
        $pelanggans->appends(['limit' => $limit]);

        return view('pelanggans.index', compact('pelanggans'));
    }

    public function create()
    {
        $max_id = Pelanggan::max('ID_PELANGGAN');

        if ($max_id) {
            $angka = (int) substr($max_id, 4);
            $angka++;
        } else {
            $angka = 2001;
        }

        $id_otomatis = "PLG-" . sprintf("%04d", $angka);

        return view('pelanggans.create', compact('id_otomatis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telp' => 'required|string|max:20',
            'fax' => 'nullable|string|max:20',
        ]);

        $max_id = Pelanggan::max('ID_PELANGGAN');
        if ($max_id) {
            $angka = (int) substr($max_id, 4) + 1;
        } else {
            $angka = 2001;
        }
        $id_otomatis = "PLG-" . sprintf("%04d", $angka);

        Pelanggan::create([
            'ID_PELANGGAN' => $id_otomatis,
            'NAMA_PELANGGAN' => $request->nama_pelanggan,
            'ALAMAT' => $request->alamat,
            'NO_TELP' => $request->no_telp,
            'FAX' => $request->fax,
        ]);

        return redirect()->route('pelanggans.index')->with('success', 'Data pelanggan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('pelanggans.edit', compact('pelanggan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telp' => 'required|string|max:20',
            'fax' => 'nullable|string|max:20',
        ]);

        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update([
            'NAMA_PELANGGAN' => $request->nama_pelanggan,
            'ALAMAT' => $request->alamat,
            'NO_TELP' => $request->no_telp,
            'FAX' => $request->fax,  // ← FAX ambil dari form huruf kecil
        ]);

        return redirect()->route('pelanggans.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(Request $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $count = Penjualan::where('ID_PELANGGAN', $id)->count();
        if ($count > 0) {
            return redirect()->route('pelanggans.index', ['limit' => $request->get('limit',10)])
                             ->with('error', "Gagal hapus! Masih memiliki $count transaksi penjualan.");
        }
        $pelanggan->delete();
        return redirect()->route('pelanggans.index', ['limit' => $request->get('limit',10)])
                         ->with('success', 'Berhasil hapus data pelanggan.');
    }
}