<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $hariini = date('Y-m-d');
        $bulanini = date("m") * 1;
        $tahunini = date("Y");

        $nip = Auth::guard('karyawan')->user()->nip;
        $presensihariini = DB::table('presensi')
            ->where('nip', $nip)
            ->where('tgl_presensi', $hariini)
            ->first();

        $historybulanini = DB::table('presensi')
            ->where('nip', $nip)
            ->whereRaw('MONTH(tgl_presensi)="' . $bulanini . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahunini . '"')
            ->orderBy('tgl_presensi', 'desc')
            ->get();

        $rekappresensi = DB::table('presensi')
            ->selectRaw('COUNT(nip) as jmlhadir, SUM(IF(jam_in > "09:00",1,0)) as jmlterlambat')
            ->where('nip', $nip)
            ->whereRaw('MONTH(tgl_presensi)="' . $bulanini . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahunini . '"')
            ->first();

        $leaderboard = DB::table('presensi')
            ->join('karyawan', 'presensi.nip', '=', 'karyawan.nip')
            ->where('tgl_presensi', $hariini)
            ->orderBy('jam_in')
            ->get();

        $bln = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        $rekapizin = DB::table('pengajuan_izin')
            ->selectRaw('SUM(IF(status="i",1,0)) as jmlizin, SUM(IF(status="s",1,0)) as jmlsakit')
            ->where('nip', $nip)
            ->whereRaw('MONTH(tgl_izin_dari)="' . $bulanini . '"')
            ->whereRaw('YEAR(tgl_izin_dari)="' . $tahunini . '"')
            ->whereRaw('YEAR(tgl_izin_sampai)="' . $tahunini . '"')
            ->whereRaw('YEAR(tgl_izin_sampai)="' . $tahunini . '"')
            ->where('status_approved', 1)
            ->first();

        return view('dashboard.dashboard', compact(
            'presensihariini',
            'historybulanini',
            'bln',
            'bulanini',
            'tahunini',
            'rekappresensi',
            'leaderboard',
            'rekapizin'
        ));
    }

    public function dashboardadmin()
    {
        $hariini = date("Y-m-d");
        $rekappresensi = DB::table('presensi')
            ->selectRaw('COUNT(nip) as jmlhadir, SUM(IF(jam_in > "09:00",1,0)) as jmlterlambat')
            ->where('tgl_presensi', $hariini)
            ->first();

        $rekapizin = DB::table('pengajuan_izin')
            ->selectRaw('SUM(IF(status="i",1,0)) as jmlizin, SUM(IF(status="s",1,0)) as jmlsakit')
            ->where('tgl_izin_dari', $hariini)
            ->where('status_approved', 1)
            ->first();
        return view('dashboard.dashboardadmin', compact('rekappresensi', 'rekapizin'));
    }

}
