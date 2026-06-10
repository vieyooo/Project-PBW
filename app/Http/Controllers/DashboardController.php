<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Pengecekan Session
        if (!session()->has('login') || session('login') !== true) {
            return redirect()->route('login');
        }

        $menu = $request->query('menu', 'dashboard');
        $adminName = session('nama_petugas', 'Admin');
        $adminId = session('id_petugas', '');
        $adminAvatar = strtoupper(substr($adminName, 0, 1));

        // Kumpulkan data dasar untuk dikirim ke view
        $data = compact('menu', 'adminName', 'adminId', 'adminAvatar');

        // Jika sedang di halaman dashboard utama, eksekusi query statistik
        if ($menu === 'dashboard') {
            $data['total_petugas'] = DB::table('petugas')->count();
            $data['total_pelanggan'] = DB::table('pelanggan')->count();
            $data['total_barang'] = DB::table('barang')->count();
            $data['total_penjualan'] = DB::table('penjualan')->count();
            $data['total_pendapatan'] = DB::table('penjualan')->sum('TOTAL') ?? 0;

            // Logika Grafik 7 Bulan Terakhir menggunakan Carbon
            $nama_bulan_id = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
            $bulan_tampil = [];
            $data_penjualan = [];

            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $bulan_angka = $date->month;
                $tahun_angka = $date->year;

                $bulan_tampil[] = $nama_bulan_id[$bulan_angka] . " " . $date->format('y');

                $total = DB::table('penjualan')
                            ->whereMonth('JATUH_TEMPO', $bulan_angka)
                            ->whereYear('JATUH_TEMPO', $tahun_angka)
                            ->sum('TOTAL') ?? 0;
                            
                $data_penjualan[] = $total;
            }

            $data['bulan_tampil'] = $bulan_tampil;
            $data['data_penjualan'] = $data_penjualan;

            // 5 Pelanggan Terbaru
            $data['customers'] = DB::table('pelanggan')
                                ->orderByDesc('ID_PELANGGAN')
                                ->limit(5)
                                ->get();

            // 5 Transaksi Terakhir (Join)
            $data['transactions'] = DB::table('penjualan')
                                    ->leftJoin('pelanggan', 'penjualan.ID_PELANGGAN', '=', 'pelanggan.ID_PELANGGAN')
                                    ->select('penjualan.ID_PENJUALAN', 'penjualan.JATUH_TEMPO as TANGGAL', 'penjualan.TOTAL', 'pelanggan.NAMA_PELANGGAN')
                                    ->orderByDesc('penjualan.JATUH_TEMPO')
                                    ->orderByDesc('penjualan.ID_PENJUALAN')
                                    ->limit(5)
                                    ->get();
        }

        return view('dashboard', $data);
    }
}