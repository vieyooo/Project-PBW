<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Http\Requests\SupplierRequest;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * INDEX — Tampil daftar supplier (supplier-lihat.php)
     * GET /supplier
     */
    public function index(Request $request)
    {
        // Validasi nilai limit (hanya 5,10,15,20)
        $allowedLimits = [5, 10, 15, 20];
        $limit = in_array((int) $request->get('limit'), $allowedLimits)
            ? (int) $request->get('limit')
            : 10;

        $suppliers = Supplier::orderBy('id_supplier', 'asc')
            ->paginate($limit)
            ->withQueryString(); // pertahankan ?limit=xx di link pagination

        return view('supplier.index', compact('suppliers', 'limit'));
    }

    /**
     * CREATE — Tampil form tambah (supplier-tambah.php bagian GET)
     * GET /supplier/create
     */
    public function create()
    {
        $idOtomatis = Supplier::generateId();
        return view('supplier.create', compact('idOtomatis'));
    }

    /**
     * STORE — Simpan data baru (supplier-tambah.php bagian POST)
     * POST /supplier
     */
    public function store(SupplierRequest $request)
    {
        Supplier::create([
            'id_supplier'   => Supplier::generateId(),
            'nama_supplier' => $request->nama_supplier,
            'alamat'        => $request->alamat,
            'no_telp'       => $request->no_telp,
            'fax'           => $request->fax,
            'pic_supplier'  => $request->pic_supplier,
        ]);

        return redirect()->route('supplier.index')
            ->with('success', 'Berhasil! Data supplier baru telah ditambahkan.');
    }

    /**
     * EDIT — Tampil form ubah (supplier-ubah.php bagian GET)
     * GET /supplier/{id}/edit
     */
    public function edit(string $id)
    {
        // findOrFail: otomatis 404 jika tidak ada
        $supplier = Supplier::findOrFail($id);
        return view('supplier.edit', compact('supplier'));
    }

    /**
     * UPDATE — Simpan perubahan (supplier-ubah.php bagian POST)
     * PUT /supplier/{id}
     */
    public function update(SupplierRequest $request, string $id)
    {
        $supplier = Supplier::findOrFail($id);

        $supplier->update([
            'nama_supplier' => $request->nama_supplier,
            'alamat'        => $request->alamat,
            'no_telp'       => $request->no_telp,
            'fax'           => $request->fax,
            'pic_supplier'  => $request->pic_supplier,
        ]);

        return redirect()->route('supplier.index')
            ->with('success', 'Berhasil! Data supplier telah diperbarui.');
    }

    /**
     * DESTROY — Hapus data (supplier-hapus.php)
     * DELETE /supplier/{id}
     */
    public function destroy(string $id)
    {
        $supplier = Supplier::findOrFail($id);

        // Cek relasi ke tabel pembelian sebelum hapus
        $jumlahPembelian = $supplier->pembelians()->count();

        if ($jumlahPembelian > 0) {
            return redirect()->route('supplier.index')
                ->with('error', "Gagal menghapus! Supplier ini masih memiliki {$jumlahPembelian} transaksi pembelian.");
        }

        $supplier->delete();

        return redirect()->route('supplier.index')
            ->with('success', 'Berhasil! Data supplier telah dihapus.');
    }
}
