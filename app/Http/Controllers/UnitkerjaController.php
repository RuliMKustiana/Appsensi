<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class UnitkerjaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search'); // Field pencarian tunggal
        $query = Unit::query();
        $query->select('*');
        $query->orderBy('kode_unit');  // Urutan data unit

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_unit', 'like', '%' . $search . '%')
                    ->orWhere('kode_unit', 'like', '%' . $search . '%');
            });
        }

        $unit = $query->paginate(10);
        return view('unitkerja.index', compact('unit'));
    }




    public function store(Request $request)
    {
        $kode_unit = $request->kode_unit;
        $nama_unit = $request->nama_unit;
        $data = [
            'kode_unit' => $kode_unit,
            'nama_unit' => $nama_unit
        ];

        $simpan = DB::table('unit')->insert($data);
        if ($simpan) {
            return Redirect::back()->with(['succes' => 'Data Berhasil Disimpan']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan']);
        }
    }

    public function edit(Request $request)
    {
        $kode_unit = $request->kode_unit;
        $unitkerja = DB::table('unit')->where('kode_unit', $kode_unit)->first();
        return view('unitkerja.edit', compact('unitkerja'));
    }

    public function update($kode_unit, Request $request)
    {
        $nama_unit = $request->nama_unit;
        $data = [
            'nama_unit' => $nama_unit
        ];

        $update = DB::table('unit')->where('kode_unit', $kode_unit)->update($data);
        if($update){
            return Redirect::back()->with(['success'=>'Data Berhasil Di Update']);
        } else {
            return Redirect::back()->with(['warning'=>'Data Gagal Di Update']);
        }
    }

    public function delete($kode_unit)
    {
        $delete = DB::table('unit')->where('kode_unit',$kode_unit)->delete();
        if($delete){
            return Redirect::back()->with(['success'=>'Data Berhasil Dihapus']);
        }else{
            return Redirect::back()->with(['warning'=>'Data Gagal Dihapus']);
        }
    }
}
