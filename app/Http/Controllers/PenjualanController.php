<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Petugas;
use App\Models\Pelanggan;
use App\Models\Barang;
use App\Models\BahanBaku;
use App\Models\Bom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    // Fungsi terbilang
    private function terbilang($angka)
    {
        $angka = abs((float)$angka);
        $baca  = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
        $terbilang = "";

        if ($angka < 12) {
            $terbilang = " " . $baca[$angka];
        } else if ($angka < 20) {
            $terbilang = $this->terbilang($angka - 10) . " Belas";
        } else if ($angka < 100) {
            $terbilang = $this->terbilang($angka / 10) . " Puluh" . $this->terbilang($angka % 10);
        } else if ($angka < 200) {
            $terbilang = " Seratus" . $this->terbilang($angka - 100);
        } else if ($angka < 1000) {
            $terbilang = $this->terbilang($angka / 100) . " Ratus" . $this->terbilang($angka % 100);
        } else if ($angka < 2000) {
            $terbilang = " Seribu" . $this->terbilang($angka - 1000);
        } else if ($angka < 1000000) {
            $terbilang = $this->terbilang($angka / 1000) . " Ribu" . $this->terbilang($angka % 1000);
        } else if ($angka < 1000000000) {
            $terbilang = $this->terbilang($angka / 1000000) . " Juta" . $this->terbilang($angka % 1000000);
        } else if ($angka < 1000000000000) {
            $terbilang = $this->terbilang($angka / 1000000000) . " Milyar" . $this->terbilang(fmod($angka, 1000000000));
        }
        return trim($terbilang);
    }

    // Index: daftar penjualan dengan filter status
    public function index(Request $request)
    {
        $limit = $request->get('limit', 10);
        $allowedLimits = [5, 10, 15, 20];
        if (!in_array($limit, $allowedLimits)) $limit = 10;

        $status_filter = $request->get('status', 'semua');
        $query = Penjualan::with(['petugas', 'pelanggan']);

        if ($status_filter === 'lunas') {
            $query->where('SISA_TAGIHAN', '<=', 0);
        } elseif ($status_filter === 'belum') {
            $query->where('SISA_TAGIHAN', '>', 0);
        }

        $penjualans = $query->orderBy('ID_PENJUALAN', 'desc')->paginate($limit);
        $penjualans->appends(['limit' => $limit, 'status' => $status_filter]);

        return view('penjualan.index', compact('penjualans', 'status_filter'));
    }

    // Form tambah
    public function create()
    {
        // Auto-generate ID: INV-4001, INV-4002, ...
        $lastId = Penjualan::max('ID_PENJUALAN');
        if ($lastId) {
            $angka = (int) substr($lastId, 4) + 1;
        } else {
            $angka = 4001;
        }
        $idOtomatis = 'INV-' . sprintf("%04d", $angka);

        $petugas = Petugas::orderBy('NAMA_PETUGAS', 'asc')->get();
        $pelanggan = Pelanggan::orderBy('NAMA_PELANGGAN', 'asc')->get();

        return view('penjualan.create', compact('idOtomatis', 'petugas', 'pelanggan'));
    }

    // Simpan data
   public function store(Request $request)
{
    // =============================================
    // 1. VALIDASI (ID_PENJUALAN TIDAK DIREQUIRE)
    // =============================================
    $request->validate([
        'TANGGAL'       => 'required|date',
        'JATUH_TEMPO'   => 'required|date',
        'ID_PETUGAS'    => 'required',
        'ID_PELANGGAN'  => 'required',
        'SUBTOTAL'      => 'required|numeric|min:0',
        'DISKON'        => 'nullable|numeric|min:0',
        'SISA_TAGIHAN'  => 'required|numeric|min:0',
        'PESAN'         => 'nullable',
    ]);

    // =============================================
    // 2. GENERATE ID OTOMATIS
    // =============================================
    $lastId = Penjualan::max('ID_PENJUALAN');
    if ($lastId) {
        $angka = (int) substr($lastId, 4) + 1;
    } else {
        $angka = 4001;
    }
    $idPenjualan = 'INV-' . sprintf("%04d", $angka);

    // =============================================
    // 3. HITUNG TOTAL & TERBILANG
    // =============================================
    $subtotal = (float) $request->SUBTOTAL;
    $diskon   = (float) ($request->DISKON ?? 0);
    $total    = max(0, $subtotal - $diskon);
    $terbilang = $this->terbilang($total) . ' Rupiah';

    // =============================================
    // 4. SIAPKAN DATA
    // =============================================
    $data = [
        'ID_PENJUALAN'  => $idPenjualan,
        'TANGGAL'       => $request->TANGGAL,
        'JATUH_TEMPO'   => $request->JATUH_TEMPO,
        'ID_PETUGAS'    => $request->ID_PETUGAS,
        'ID_PELANGGAN'  => $request->ID_PELANGGAN,
        'SUBTOTAL'      => $subtotal,
        'DISKON'        => $diskon,
        'SISA_TAGIHAN'  => $request->SISA_TAGIHAN,
        'PESAN'         => $request->PESAN,
        'TOTAL'         => $total,
        'TERBILANG'     => $terbilang,
    ];

   
       $penjualan = Penjualan::create($data);
return redirect()->route('detailpenjualan.index', ['id' => $penjualan->ID_PENJUALAN])
                 ->with('success', 'Berhasil! Data penjualan baru telah ditambahkan. Silakan tambahkan item barang.');
    }

    // Form edit
    public function edit($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $petugas = Petugas::orderBy('NAMA_PETUGAS', 'asc')->get();
        $pelanggan = Pelanggan::orderBy('NAMA_PELANGGAN', 'asc')->get();

        return view('penjualan.edit', compact('penjualan', 'petugas', 'pelanggan'));
    }

    // Update data
    public function update(Request $request, $id)
    {
        $penjualan = Penjualan::findOrFail($id);

        $request->validate([
            'TANGGAL' => 'required|date',
            'JATUH_TEMPO' => 'required|date',
            'ID_PETUGAS' => 'required',
            'ID_PELANGGAN' => 'required',
            'SUBTOTAL' => 'required|numeric|min:0',
            'DISKON' => 'nullable|numeric|min:0',
            'SISA_TAGIHAN' => 'required|numeric|min:0',
            'PESAN' => 'nullable',
        ]);

        $subtotal = (float) $request->SUBTOTAL;
        $diskon = (float) ($request->DISKON ?? 0);
        $total = max(0, $subtotal - $diskon);
        $terbilang = $this->terbilang($total) . ' Rupiah';

        $data = $request->only([
            'TANGGAL', 'JATUH_TEMPO', 'ID_PETUGAS', 'ID_PELANGGAN',
            'SUBTOTAL', 'DISKON', 'SISA_TAGIHAN', 'PESAN'
        ]);
        $data['TOTAL'] = $total;
        $data['TERBILANG'] = $terbilang;

        $penjualan->update($data);

        return redirect()->route('penjualan.index', ['limit' => $request->get('limit', 10)])
                         ->with('success', 'Berhasil! Data penjualan telah diperbarui.');
    }

    // Hapus data
    public function destroy(Request $request, $id)
    {
        $penjualan = Penjualan::findOrFail($id);

        // Penjualan punya banyak DetailPenjualan (foreign key ID_PENJUALAN).
        // MySQL akan menolak penghapusan penjualan selama masih ada baris
        // detail_penjualan yang mengacu ke ID_PENJUALAN ini (error 1451 /
        // Integrity constraint violation). Jadi detail-nya harus dihapus
        // dulu (cascade manual di sisi kode) sebelum menghapus induknya.
        // Dibungkus DB::transaction supaya kalau salah satu proses gagal,
        // semua dibatalkan (tidak ada data yang setengah terhapus).
        DB::transaction(function () use ($penjualan) {
            $penjualan->detailPenjualans()->delete();
            $penjualan->delete();
        });

        return redirect()->route('penjualan.index', ['limit' => $request->get('limit', 10)])
                         ->with('success', 'Data penjualan beserta seluruh detail itemnya berhasil dihapus.');
    }

    public function cetakInvoice($id)
{
    $penjualan = Penjualan::with(['pelanggan', 'petugas'])->findOrFail($id);
    $detail = DetailPenjualan::with('barang')
                ->where('ID_PENJUALAN', $id)
                ->orderBy('ID_BARANG', 'asc')
                ->get();

    return view('penjualan.detail.cetak', compact('penjualan', 'detail'));
}
}