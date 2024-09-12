<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $user = DB::table('users')->orderBy('id')->get();
        return view('user.index', compact('user'));
    }

    public function store(Request $request)
    {
        $id = $request->id;
        $name = $request->name;
        $email = $request->email;
        $no_handphone = $request->no_handphone;
        $jabatan = $request->jabatan;
        $password = Hash::make('123');
        $user = DB::table('users')->where('id', $id)->first();
        if ($request->hasFile('photo')) {
            $photo = $id . "." . time() . "." . $request->file('photo')->getClientOriginalExtension();
            if (!empty($user->photo)) {
                Storage::delete("public/uploads/Admin/{$user->photo}");
            }
            $request->file('photo')->storeAs('public/uploads/Admin', $photo);
        } else {
            $photo = null;
        }

        try {
            $data = [
                'id' => $id,
                'name' => $name,
                'no_handphone' => $no_handphone,
                'email' => $email,
                'jabatan' => $jabatan,
                'photo' => $photo,
                'password' => $password
            ];
            $simpan = DB::table('users')->insert($data);
            if ($simpan) {
                if ($request->hasFile('photo')) {
                    $folderPath = "public/uploads/Admin";
                    $request->file('photo')->storeAs($folderPath, $photo);
                }
                return Redirect::back()->with(['success' => 'Data Berhasil Disimpan!']);
            }
        } catch (\Exception $e) {
            // dd($e);
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan!!!']);
        }
    }

    public function resetpassword($id)
    {
        $id = Crypt::decrypt($id);
        $password = Hash::make('123');
        $reset = DB::table('users')->where('id', $id)->update([
            'password' => $password
        ]);

        if ($reset) {
            return Redirect::back()->with(['success' => 'Password Berhasil di Reset']);
        } else {
            return Redirect::back()->with(['warning' => 'Password Gagal di Reset']);
        }
    }

    public function delete($id)
    {
        $delete = DB::table('users')->where('id',$id)->delete();
        if($delete){
            return Redirect::back()->with(['success'=>'Data Berhasil Dihapus']);
        }else{
            return Redirect::back()->with(['warning'=>'Data Gagal Dihapus']);
        }
    }

}
