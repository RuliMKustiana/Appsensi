<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KonfigurasiController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\UnitkerjaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::middleware(['guest:karyawan'])->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');
    
    Route::post('/proseslogin', [AuthController::class, 'proseslogin']);

    Route::get('/to-admin', function () {
        return redirect()->route('loginadmin');
    })->name('to-admin');
});

Route::middleware(['guest:user'])->group(function () {
    Route::get('/panel', function () {
        return view('auth.loginadmin');
    })->name('loginadmin');

    Route::post('/prosesloginadmin', [AuthController::class, 'prosesloginadmin']);

    Route::get('/to-karyawan', function () {
        return redirect()->route('login');
    })->name('to-karyawan');
});

    Route::middleware(['auth:karyawan'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/proseslogout', [AuthController::class, 'proseslogout']);

    //presensi
    Route::get('/presensi/create', [PresensiController::class, 'create'])->name('presensi.create');
    Route::post('/presensi/store', [PresensiController::class, 'store'])->name('presensi.store');

    //edit profile
    Route::get('/editprofile', [PresensiController::class, 'editprofile']);
    Route::post('/presensi/{nip}/updateprofile', [PresensiController::class, 'updateprofile'])->name('updateprofile');
    
    //profile
    Route::get('/profile', [PresensiController::class, 'profile']);

    //history
    Route::get('/presensi/history', [PresensiController::class, 'history']);
    Route::post('/gethistory', [PresensiController::class, 'gethistory']);

    //Izin
    Route::get('/presensi/izin', [PresensiController::class, 'izin']);
    Route::get('/presensi/buatizin', [PresensiController::class, 'buatizin']);
    Route::post('/presensi/storeizin', [PresensiController::class, 'storeizin'])->name('storeizin');
    Route::post('/presensi/cekpengajuanizin', [PresensiController::class, 'cekpengajuanizin']);
 
    Route::get('/izin/{kode_izin}/showact', [PresensiController::class, 'showact']);
    Route::get('/izin/{kode_izin}/delete', [PresensiController::class, 'delete']);

    
});


    Route::middleware(['auth:user'])->group(function () {
    Route::get('/proseslogoutadmin', [AuthController::class, 'proseslogoutadmin']);
    Route::get('/panel/dashboardadmin', [DashboardController::class, 'dashboardadmin']);
    Route::get('/user',[AdminController::class, 'index']);
    Route::post('/user/store',[AdminController::class, 'store']);
    Route::get('/user/{id}/resetpassword', [AdminController::class, 'resetpassword']);
    Route::post('/admin/{id}/delete', [AdminController::class, 'delete']);

    //Karyawan
    Route::get('/karyawan', [KaryawanController::class, 'index']);
    Route::post('/karyawan/store', [KaryawanController::class, 'store']);
    Route::post('/karyawan/edit', [KaryawanController::class, 'edit']);
    Route::post('/karyawan/{nip}/update', [KaryawanController::class, 'update']);
    Route::post('/karyawan/{nip}/delete', [KaryawanController::class, 'delete']);
    Route::get('/karyawan/{nip}/resetpassword', [KaryawanController::class, 'resetpassword']);

    //Unit Kerja
    Route::get('/unitkerja', [UnitkerjaController::class, 'index']);
    Route::post('/unitkerja/store', [UnitkerjaController::class, 'store']);
    Route::post('/unitkerja/edit', [UnitkerjaController::class, 'edit']);
    Route::post('/unitkerja/{kode_unit}/update', [UnitkerjaController::class, 'update']);
    Route::post('/unitkerja/{kode_unit}/delete', [UnitkerjaController::class, 'delete']);

    //Monitor Presensi
    Route::get('/presensi/monitoringpresensi', [PresensiController::class, 'monitoringpresensi']);
    Route::post('/getpresensi', [PresensiController::class, 'getpresensi']);
    // Route::post('/lokasi', [PresensiController::class, 'lokasipeta']);

    //Print Laporan Presensi
    Route::get('presensi/laporan', [PresensiController::class, 'laporan']);
    Route::post('presensi/printlaporan', [PresensiController::class, 'printlaporan']);

    //Rekapitulasi Presensi
    Route::get('presensi/rekap', [PresensiController::class, 'rekap']);
    Route::post('presensi/printrekap', [PresensiController::class, 'printrekap']);

    //Izin Sakit Presensi
    Route::get('presensi/izinsakit', [PresensiController::class, 'izinsakit']);
    Route::post('presensi/approvedizinsakit', [PresensiController::class, 'approvedizinsakit']);
    Route::get('presensi/{kode_izin}/batalkanizinsakit', [PresensiController::class, 'batalkanizinsakit']);
    Route::post('/showfile', [PresensiController::class, 'showfile']);

    // Hapus Data Pengajuan Izin
    Route::delete('/delete-all-data', [PresensiController::class, 'deleteAllData'])->name('deleteAllData');


    //Konfigurasi Lokasi Kantor
    Route::get('/konfigurasi/lokasikantor', [KonfigurasiController::class, 'lokasikantor']);
    Route::post('/konfigurasi/updatelokasikantor', [KonfigurasiController::class, 'updatelokasikantor']);

    //profile admin
    Route::get('/presensi/profileadmin', [PresensiController::class, 'profileadmin']);

    //Edit Profile Admin
    Route::get('/editprofileadmin', [PresensiController::class, 'editprofileadmin']);
    Route::post('/presensi/editprofileadmin', [PresensiController::class, 'editprofileadmin']);
    Route::post('/presensi/{name}/updateprofileadmin', [PresensiController::class, 'updateprofileadmin']);

});
