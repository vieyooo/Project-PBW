<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Gunakan Auth::check() — konsisten dengan middleware 'auth' di routes
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $petugas     = Auth::user();
        $menu        = $request->query('menu', 'dashboard');
        $adminName   = $petugas->NAMA_PETUGAS;
        $adminId     = $petugas->ID_PETUGAS;
        $adminAvatar = strtoupper(substr($adminName, 0, 1));

        $data = compact('menu', 'adminName', 'adminId', 'adminAvatar');

        if ($menu === 'dashboard') {
            $data['total_petugas']   = DB::table('petugas')->count();
            $data['total_pelanggan'] = DB::table('pelanggan')->count();
            $data['total_barang']    = DB::table('barang')->count();
            $data['total_penjualan'] = DB::table('penjualan')->count();
            $data['total_pendapatan']= DB::table('penjualan')->sum('TOTAL') ?? 0;

            $nama_bulan_id = ['','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'];
            $bulan_tampil  = [];
            $data_penjualan = [];

            for ($i = 6; $i >= 0; $i--) {
                $date        = Carbon::now()->subMonths($i);
                $bulan_angka = $date->month;
                $tahun_angka = $date->year;

                $bulan_tampil[]   = $nama_bulan_id[$bulan_angka] . ' ' . $date->format('y');
                $data_penjualan[] = DB::table('penjualan')
                                      ->whereMonth('JATUH_TEMPO', $bulan_angka)
                                      ->whereYear('JATUH_TEMPO', $tahun_angka)
                                      ->sum('TOTAL') ?? 0;
            }

            $data['bulan_tampil']   = $bulan_tampil;
            $data['data_penjualan'] = $data_penjualan;

            $data['customers'] = DB::table('pelanggan')
                                   ->orderByDesc('ID_PELANGGAN')
                                   ->limit(5)->get();

            $data['transactions'] = DB::table('penjualan')
                                      ->leftJoin('pelanggan','penjualan.ID_PELANGGAN','=','pelanggan.ID_PELANGGAN')
                                      ->select('penjualan.ID_PENJUALAN','penjualan.JATUH_TEMPO as TANGGAL','penjualan.TOTAL','pelanggan.NAMA_PELANGGAN')
                                      ->orderByDesc('penjualan.JATUH_TEMPO')
                                      ->orderByDesc('penjualan.ID_PENJUALAN')
                                      ->limit(5)->get();
        }

        return view('dashboard', $data);
    }
}
