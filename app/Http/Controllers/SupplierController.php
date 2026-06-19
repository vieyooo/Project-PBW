<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $limit = (int) $request->get('limit', 10);
        $allowed = [5, 10, 15, 20];
        if (!in_array($limit, $allowed)) {
            $limit = 10;
        }

        $suppliers = Supplier::orderBy('ID_SUPPLIER', 'desc')->paginate($limit);

        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        $max_id = Supplier::max('ID_SUPPLIER');

        if ($max_id) {
            $urutan = (int) substr($max_id, 4, 3);
            $urutan++;
        } else {
            $urutan = 1;
        }

        $id_otomatis = "SUP-" . sprintf("%03d", $urutan);

        return view('suppliers.create', compact('id_otomatis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pic_supplier'  => 'required|string|max:255',
            'nama_supplier' => 'required|string|max:255',
            'no_telp'       => 'required|string|max:20',
            'fax'           => 'nullable|string|max:20',
            'alamat'        => 'required|string',
        ]);

        $max_id = Supplier::max('ID_SUPPLIER');

        if ($max_id) {
            $urutan = (int) substr($max_id, 4, 3);
            $urutan++;
        } else {
            $urutan = 1;
        }

        $id_otomatis = "SUP-" . sprintf("%03d", $urutan);

        Supplier::create([
            'ID_SUPPLIER'   => $id_otomatis,
            'NAMA_SUPPLIER' => $request->nama_supplier,
            'ALAMAT'        => $request->alamat,
            'NO_TELP'       => $request->no_telp,
            'FAX'           => $request->fax,
            'PIC_SUPPLIER'  => $request->pic_supplier,
        ]);

        return redirect()->route('suppliers.index')->with('success', 'Data supplier baru telah ditambahkan.');
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'pic_supplier'  => 'required|string|max:255',
            'nama_supplier' => 'required|string|max:255',
            'no_telp'       => 'required|string|max:20',
            'fax'           => 'nullable|string|max:20',
            'alamat'        => 'required|string',
        ]);

        $supplier->update([
            'NAMA_SUPPLIER' => $request->nama_supplier,
            'ALAMAT'        => $request->alamat,
            'NO_TELP'       => $request->no_telp,
            'FAX'           => $request->fax,
            'PIC_SUPPLIER'  => $request->pic_supplier,
        ]);

        return redirect()->route('suppliers.index')->with('success', 'Data supplier telah diperbarui.');
    }

    public function destroy(Supplier $supplier)
    {
        $totalPembelian = \DB::table('PEMBELIAN')
            ->where('ID_SUPPLIER', $supplier->ID_SUPPLIER)
            ->count();

        if ($totalPembelian > 0) {
            return redirect()->route('suppliers.index')
                ->with('error', "Gagal menghapus! Supplier ini masih memiliki {$totalPembelian} transaksi pembelian. Hapus transaksi pembelian terlebih dahulu.");
        }

        $supplier->delete();

        return redirect()->route('suppliers.index')->with('success', 'Data supplier telah dihapus.');
    }
}