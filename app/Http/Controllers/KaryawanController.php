<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        $query = Karyawan::query();
        $query->select('karyawan.*', 'unit.nama_unit');
        $query->join('unit', 'karyawan.kode_unit', '=', 'unit.kode_unit');
        $query->orderBy('nip');  //urutan data karyawan

        if (!empty($request->nama_karyawan)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_karyawan . '%');
        }

        if (!empty($request->kode_unit)) {
            $query->where('karyawan.kode_unit', $request->kode_unit);
        }

        $karyawan = $query->paginate(10);
        $unit = DB::table('unit')->get();
        return view('karyawan.index', compact('karyawan', 'unit'));
    }

    public function store(Request $request)
    {
        $nip = $request->nip;
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $kode_unit = $request->kode_unit;
        $password = Hash::make('123');
        $karyawan = DB::table('karyawan')->where('nip', $nip)->first();
        if ($request->hasFile('foto')) {
            $foto = $nip . "." . time() . "." . $request->file('foto')->getClientOriginalExtension();
            if (!empty($karyawan->foto)) {
                Storage::delete("public/uploads/karyawan/{$karyawan->foto}");
            }
            $request->file('foto')->storeAs('public/uploads/karyawan', $foto);
        } else {
            // Set default foto jika tidak ada foto yang diunggah
            $foto = $karyawan->foto ?? 'nophoto.png';
        }

        try {
            $data = [
                'nip' => $nip,
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'kode_unit' => $kode_unit,
                'foto' => $foto,
                'password' => $password
            ];
            $simpan = DB::table('karyawan')->insert($data);
            if ($simpan) {
                if ($request->hasFile('foto')) {
                    $folderPath = "public/uploads/karyawan";
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success' => 'Data Berhasil Disimpan!']);
            }
        } catch (\Exception $e) {
            // dd($e);
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan!!!']);
        }
    }

    public function edit(Request $request)
    {
        $nip = $request->nip;
        $unit = DB::table('unit')->get();
        $karyawan = DB::table('karyawan')->where('nip', $nip)->first();
        return view('karyawan.edit', compact('unit', 'karyawan'));
    }

    public function update($nip, Request $request)
    {
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $kode_unit = $request->kode_unit;
        $old_foto = $request->old_foto;
        $karyawan = DB::table('karyawan')->where('nip', $nip)->first();

        if (!$karyawan) {
            return Redirect::back()->with(['warning' => 'Data Karyawan Tidak Ditemukan!']);
        }

        try {
            if ($request->hasFile('foto')) {
                $foto = $nip . "." . time() . "." . $request->file('foto')->getClientOriginalExtension();
                if (!empty($karyawan->foto)) {
                    Storage::delete("public/uploads/karyawan/{$karyawan->foto}");
                }
                $request->file('foto')->storeAs('public/uploads/karyawan', $foto);
            } else {
                $foto = $old_foto;
            }

            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'kode_unit' => $kode_unit,
                'foto' => $foto,
            ];

            $update = DB::table('karyawan')->where('nip', $nip)->update($data);

            if ($update) {
                return Redirect::back()->with(['success' => 'Data Berhasil Update!']);
            } else {
                return Redirect::back()->with(['warning' => 'Data Gagal Update!']);
            }
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => 'Data Gagal Update!']);
        }
    }

    public function delete($nip)
    {
        $delete = DB::table('karyawan')->where('nip', $nip)->delete();
        if ($delete) {
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return Redirect::back()->with(['error' => 'Data Gagal Dihapus']);
        }
    }


    public function resetpassword($nip)
    {
        $nip = Crypt::decrypt($nip);
        $password = Hash::make('123');
        $reset = DB::table('karyawan')->where('nip', $nip)->update([
            'password' => $password
        ]);

        if ($reset) {
            return Redirect::back()->with(['success' => 'Password Berhasil di Reset']);
        } else {
            return Redirect::back()->with(['warning' => 'Password Gagal di Reset']);
        }
    }
}
