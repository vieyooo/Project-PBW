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
            'HARGA_JUAL'    => 'required|numeric|min:1',
        ]);

        DetailPembelian::create([
            'NO_INVOICE'    => $no_invoice,
            'ID_BAHAN_BAKU' => $request->ID_BAHAN_BAKU,
            'QTY'           => $request->QTY,
            'HARGA_JUAL'    => $request->HARGA_JUAL,
        ]);

        $this->updateTotal($no_invoice);

        return redirect()->route('pembelian.show', $no_invoice)
                         ->with('success', 'Bahan baku berhasil ditambahkan!');
    }

    // FORM edit qty/harga
    public function edit($no_invoice, $id_bahan)
    {
        $pembelian = Pembelian::findOrFail($no_invoice);
        $detail    = DetailPembelian::with('bahanBaku')
                        ->where('NO_INVOICE', $no_invoice)
                        ->where('ID_BAHAN_BAKU', $id_bahan)
                        ->firstOrFail();
        return view('pembelian.detail-ubah', compact('pembelian', 'detail'));
    }

    // SIMPAN edit qty/harga
    public function update(Request $request, $no_invoice, $id_bahan)
    {
        $request->validate([
            'QTY'        => 'required|integer|min:1',
            'HARGA_JUAL' => 'required|numeric|min:1',
        ]);

        DetailPembelian::where('NO_INVOICE', $no_invoice)
            ->where('ID_BAHAN_BAKU', $id_bahan)
            ->update([
                'QTY'        => $request->QTY,
                'HARGA_JUAL' => $request->HARGA_JUAL,
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
            ->selectRaw('SUM(QTY * HARGA_JUAL) as total')
            ->value('total');

        Pembelian::where('NO_INVOICE', $no_invoice)
            ->update(['TOTAL_INVOICE' => $total ?? 0]);
    }
}