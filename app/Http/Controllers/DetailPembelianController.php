<?php
namespace App\Http\Controllers;

use App\Models\DetailPembelian;
use App\Models\Pembelian;
use App\Models\BahanBaku;
use Illuminate\Http\Request;

class DetailPembelianController extends Controller
{
    // FORM tambah bahan baku ke invoice
    public function create($no_invoice)
    {
        $pembelian = Pembelian::with('supplier')->findOrFail($no_invoice);
        $sudahAda  = DetailPembelian::where('NO_INVOICE', $no_invoice)->pluck('ID_BAHAN_BAKU');
        $bahanBaku = BahanBaku::whereNotIn('ID_BAHAN_BAKU', $sudahAda)->get();
        return view('pembelian.detail-tambah', compact('pembelian', 'bahanBaku'));
    }

    // SIMPAN tambah bahan baku
    public function store(Request $request, $no_invoice)
    {
        $request->validate([
            'ID_BAHAN_BAKU' => 'required|exists:bahan_baku,ID_BAHAN_BAKU',
            'QTY'           => 'required|integer|min:1',
            'HARGA_BELI'    => 'required|numeric|min:1', // diubah
        ]);

        DetailPembelian::create([
            'NO_INVOICE'    => $no_invoice,
            'ID_BAHAN_BAKU' => $request->ID_BAHAN_BAKU,
            'QTY'           => $request->QTY,
            'HARGA_BELI'    => $request->HARGA_BELI, // diubah
        ]);

        $this->updateTotal($no_invoice);

        return redirect()->route('pembelian.show', $no_invoice)
                         ->with('success', 'Bahan baku berhasil ditambahkan!');
    }

    // FORM edit qty/harga
    public function edit($no_invoice, $id_bahan)
    {
        $detail = DetailPembelian::where('NO_INVOICE', $no_invoice)
            ->where('ID_BAHAN_BAKU', $id_bahan)
            ->firstOrFail();

        $bahanBakus = BahanBaku::orderBy('JENIS', 'asc')->get();

        return view('pembelian.detail-ubah', [
            'noInvoice'  => $no_invoice,
            'detail'     => $detail,
            'bahanBakus' => $bahanBakus
        ]);
    }

    // SIMPAN edit qty/harga
    public function update(Request $request, $no_invoice, $id_bahan)
    {
        $request->validate([
            'QTY'        => 'required|integer|min:1',
            'HARGA_BELI' => 'required|numeric|min:1', // diubah
        ]);

        DetailPembelian::where('NO_INVOICE', $no_invoice)
            ->where('ID_BAHAN_BAKU', $id_bahan)
            ->update([
                'QTY'        => $request->QTY,
                'HARGA_BELI' => $request->HARGA_BELI, // diubah
            ]);

        $this->updateTotal($no_invoice);

        return redirect()->route('pembelian.show', $no_invoice)
                         ->with('success', 'Detail berhasil diupdate!');
    }

    // HAPUS bahan baku dari invoice
    public function destroy($no_invoice, $id_bahan)
    {
        DetailPembelian::where('NO_INVOICE', $no_invoice)
            ->where('ID_BAHAN_BAKU', $id_bahan)
            ->delete();

        $this->updateTotal($no_invoice);

        return redirect()->route('pembelian.show', $no_invoice)
                         ->with('success', 'Detail berhasil dihapus!');
    }

    // Helper: hitung ulang TOTAL_INVOICE
    private function updateTotal($no_invoice)
    {
        $total = DetailPembelian::where('NO_INVOICE', $no_invoice)
            ->selectRaw('SUM(QTY * HARGA_BELI) as total') // diubah
            ->value('total');

        Pembelian::where('NO_INVOICE', $no_invoice)
            ->update(['TOTAL_INVOICE' => $total ?? 0]);
    }
}