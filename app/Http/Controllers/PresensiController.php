<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Pengajuanizin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PresensiController extends Controller
{
    public function create()
    {
        $hariini = date("Y-m-d");
        $nip = Auth::guard('karyawan')->user()->nip;
        $cek = DB::table('presensi')->where('tgl_presensi', $hariini)->where('nip', $nip)->count();
        $lok_kantor = DB::table('konfigurasi_lokasi')->where('id', 1)->first();
        return view('presensi.create', compact('cek', 'lok_kantor'));
    }

    public function store(Request $request)
    {
        $nip = Auth::guard('karyawan')->user()->nip;
        $tgl_presensi = date("Y-m-d");
        $jam = date("H:i:s");

        // Validasi Jarak
        $lok_kantor = DB::table('konfigurasi_lokasi')->where('id', 1)->first();
        $lok = explode(",", $lok_kantor->lokasi_kantor);
        $latitudekantor = $lok[0];
        $longitudekantor = $lok[1];
        $lokasi = $request->lokasi;
        $lokasiuser = explode(",", $lokasi);
        $latitudeuser = $lokasiuser[0];
        $longitudeuser = $lokasiuser[1];

        $jarak = $this->distance($latitudekantor, $longitudekantor, $latitudeuser, $longitudeuser);
        $radius = round($jarak["meters"]);

        // User Foto Selfie
        $image = $request->image;
        $folderPath = "public/uploads/absensi/";

        // Menambahkan timestamp atau identifikasi unik lainnya pada nama file
        $timestamp = time(); // atau bisa menggunakan uniqid(), microtime(), atau metode lainnya
        $image_parts = explode(";base64", $image);
        $image_base64 = base64_decode($image_parts[1]);

        $cek = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nip', $nip)->count();
        if ($radius > $lok_kantor->radius) {
            echo "error|Maaf anda berada diluar radius " . $radius . " Meter dari Kantor|";
        } else {
            if ($cek > 0) {
                $fileNameOut = $nip . "-" . $tgl_presensi . "-out-" . $timestamp . ".png";
                $fileOut = $folderPath . $fileNameOut;
                $data_pulang = [
                    'jam_out' => $jam,
                    'foto_out' => $fileNameOut,
                    'lokasi_out' => $lokasi
                ];
                $update = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nip', $nip)->update($data_pulang);
                if ($update) {
                    echo "success|Terimakasih!|out";
                    Storage::put($fileOut, $image_base64);
                } else {
                    echo "error|Maaf Anda Gagal Melakukan Absen|out";
                }
            } else {
                $fileNameIn = $nip . "-" . $tgl_presensi . "-in-" . $timestamp . ".png";
                $fileIn = $folderPath . $fileNameIn;
                $data = [
                    'nip' => $nip,
                    'tgl_presensi'  => $tgl_presensi,
                    'jam_in' => $jam,
                    'foto_in' => $fileNameIn,
                    'lokasi_in' => $lokasi,
                    'status' => 'h'
                ];

                $simpan = DB::table('presensi')->insert($data);
                if ($simpan) {
                    echo "success|Terimakasih!!|in";
                    Storage::put($fileIn, $image_base64);
                } else {
                    echo "error|Maaf Anda Gagal Melakukan Absen|in";
                }
            }
        }
    }

    //Menghitung Jarak
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }

    public function editprofile()
    {
        $nip = Auth::guard('karyawan')->user()->nip;
        $karyawan = DB::table('karyawan')->where('nip', $nip)->first();
        return view('presensi.editprofile', compact('karyawan'));
    }

    public function profile()
    {
        $nip = Auth::guard('karyawan')->user()->nip;
        $karyawan = DB::table('karyawan')->where('nip', $nip)->first();
        return view('presensi.profile', compact('karyawan'));
    }

    public function updateprofile(Request $request)
    {
        $nip = Auth::guard('karyawan')->user()->nip;

        // Validasi input
        $validator = Validator::make(
            $request->all(),
            [
                'nama_lengkap' => 'required',
                'no_hp' => 'required',
            ],
            [
                'nama_lengkap.required' => 'Nama lengkap harus diisi.',
                'no_hp.required' => 'Nomor HP harus diisi.',
            ]
        );

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $password = Hash::make($request->password);
        $karyawan = DB::table('karyawan')->where('nip', $nip)->first();
        if ($request->hasFile('foto')) {
            $foto = $nip . "." . time() . "." . $request->file('foto')->getClientOriginalExtension();
            if (!empty($karyawan->foto)) {
                Storage::delete("public/uploads/karyawan/{$karyawan->foto}");
            }
            $request->file('foto')->storeAs('public/uploads/karyawan', $foto);
        } else {
            $foto = $karyawan->foto;
        }

        if (empty($request->password)) {
            $data =
                [
                    'nama_lengkap' => $nama_lengkap,
                    'no_hp' => $no_hp,
                    'foto' => $foto
                ];
        } else {
            $data =
                [
                    'nama_lengkap' => $nama_lengkap,
                    'no_hp' => $no_hp,
                    'password' => $password,
                    'foto' => $foto
                ];
        }
        $update = DB::table('karyawan')->where('nip', $nip)->update($data);
        if ($update) {
            if ($request->hasFile('foto')) {
                $folderPath = "public/uploads/karyawan";
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update']);
        } else {
            return Redirect::back()->with(['error' => 'Data Gagal Di Update']);
        }
    }

    public function history()
    {
        $bln = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('presensi.history', compact('bln'));
    }

    public function gethistory(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nip = Auth::guard('karyawan')->user()->nip;

        $history = DB::table('presensi')
            ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
            ->where('nip', $nip)
            ->orderBy('tgl_presensi')
            ->get();

        return view('presensi.gethistory', compact('history'));
    }

    public function izin()
    {
        $nip = Auth::guard('karyawan')->user()->nip;
        $dataizin = DB::table('pengajuan_izin')->where('nip', $nip)->get();
        return view('presensi.izin', compact('dataizin'));
    }

    public function buatizin()
    {
        return view('presensi.buatizin');
    }



    public function storeizin(Request $request)
    {
        $nip = Auth::guard('karyawan')->user()->nip;
        $tgl_izin_dari = $request->tgl_izin_dari;
        $tgl_izin_sampai = $request->tgl_izin_sampai;
        $status = $request->status;
        $keterangan = $request->keterangan;
        $bulan = date("m", strtotime($tgl_izin_dari));
        $tahun = date("Y", strtotime($tgl_izin_dari));
        $thn = substr($tahun, 2, 2);

        $lastizin = DB::table('pengajuan_izin')
            ->whereRaw('MONTH(tgl_izin_dari)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_izin_dari)="' . $tahun . '"')
            ->orderBy('kode_izin', 'desc')
            ->first();

        $lastkodeizin = $lastizin != null ? $lastizin->kode_izin : "";
        $format = "iz" . $bulan . $thn;
        $kode_izin = buatkode($lastkodeizin, $format, 3);

        if ($request->hasFile('sid')) {
            $sid = $kode_izin . "." . $request->file('sid')->getClientOriginalExtension();
        } else {
            $sid = null;
        }

        $data = [
            'kode_izin' => $kode_izin,
            'nip' => $nip,
            'tgl_izin_dari' => $tgl_izin_dari,
            'tgl_izin_sampai' => $tgl_izin_sampai,
            'status' => $status,
            'keterangan' => $keterangan,
            'doc_sid' => $sid
        ];

        $simpan = DB::table('pengajuan_izin')->insert($data);

        if ($simpan) {
            if ($request->hasFile('sid')) {
                $sid = $kode_izin . "." . $request->file('sid')->getClientOriginalExtension();
                $folderPath = "public/uploads/sid/";
                $request->file('sid')->storeAs($folderPath, $sid);
            }
            return redirect('/presensi/izin')->with('success', 'Data Berhasil Disimpan');
        } else {
            return redirect('/presensi/izin')->with('error', 'Data Gagal Disimpan');
        }
    }

    public function monitoringpresensi()
    {
        return view('presensi.monitoringpresensi');
    }

    public function getpresensi(Request $request)
    {
        $tanggal = $request->tanggal;
        $presensi = DB::table('presensi')
            ->select('presensi.*', 'nama_lengkap', 'nama_unit')
            ->join('karyawan', 'presensi.nip', '=', 'karyawan.nip')
            ->join('unit', 'karyawan.kode_unit', '=', 'unit.kode_unit')
            ->where('tgl_presensi', $tanggal)
            ->get();

        return view('presensi.getpresensi', compact('presensi'));
    }

    public function laporan()
    {
        $bln = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $karyawan = DB::table('karyawan')->orderBy('nama_lengkap')->get();
        return view('presensi.laporan', compact('bln', 'karyawan'));
    }

    public function printlaporan(Request $request)
    {
        $nip = $request->nip;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $bln = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        $tanggal = date('d');
        $namabulan = $bln[$bulan];
        $tahunini = $tahun;
        $kepalanama = Auth::guard('user')->user()->name;
        $jabatan = Auth::guard('user')->user()->jabatan;

        $karyawan = DB::table('karyawan')->where('nip', $nip)
            ->join('unit', 'karyawan.kode_unit', '=', 'unit.kode_unit')
            ->first();

        $presensi = DB::table('presensi')
            ->select('presensi.*', 'keterangan')
            ->leftJoin('pengajuan_izin', 'presensi.kode_izin', '=', 'pengajuan_izin.kode_izin')
            ->where('presensi.nip', $nip)
            ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
            ->orderBy('tgl_presensi')
            ->get();

        if (isset($_POST['exporttoexcel'])) {
            $time = date("d-M-Y H:i:s");

            header("Content-type: aplication/vnd-ms-excel");

            header("Content-Disposition: attachment; filename=Laporan Absen Pegawai  $time.xls");
            return view('presensi.printlaporan', compact('bulan', 'tahun', 'bln', 'karyawan', 'presensi', 'tanggal', 'namabulan', 'tahunini', 'kepalanama', 'jabatan'));
        }
        return view('presensi.printlaporan', compact('bulan', 'tahun', 'bln', 'karyawan', 'presensi', 'tanggal', 'namabulan', 'tahunini', 'kepalanama', 'jabatan'));
    }

    public function rekap()
    {
        $bln = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        return view('presensi.rekap', compact('bln'));
    }

    public function printrekap(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $dari = $tahun . "-" . $bulan . "-01";
        $sampai = date("Y-m-t", strtotime($dari));
        $bln = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $tanggal = date('d');
        $namabulan = $bln[$bulan];
        $tahunini = $tahun;
        $kepalanama = Auth::guard('user')->user()->name;
        $jabatan = Auth::guard('user')->user()->jabatan;

        $select_date = "";
        $field_date = "";
        $i = 1;
        while (strtotime($dari) <= strtotime($sampai)) {
            $rangetanggal[] = $dari;
            $select_date .= "MAX(IF(tgl_presensi = '$dari',
                            CONCAT(
                            IFNULL(jam_in,'NA'),'|',
                            IFNULL(jam_out,'NA'),'|',
                            IFNULL(presensi.status,'NA'),'|',
                            IFNULL(presensi.kode_izin,'NA'),'|',
                            IFNULL(pengajuan_izin.keterangan,'NA'),'|'
                            ), NULL)) AS tgl_" . $i . ",";

            $field_date .= "tgl_" . $i . ",";
            $i++;
            $dari = date("Y-m-d", strtotime("+1 day", strtotime($dari)));
        }



        $jmlhari = count($rangetanggal);
        $lastrange = $jmlhari - 1;
        $sampai = $rangetanggal[$lastrange];
        if ($jmlhari == 30) {
            array_push($rangetanggal, NULL);
        } else if ($jmlhari == 29) {
            array_push($rangetanggal, NULL, NULL);
        } else if ($jmlhari == 28) {
            array_push($rangetanggal, NULL, NULL, NULL);
        }

        $query = Karyawan::query();
        $query->selectRaw(
            "$field_date karyawan.nip, nama_lengkap, unit.nama_unit"
        );

        $query->leftJoin(
            DB::raw("(
                SELECT
                $select_date            
                presensi.nip
                FROM presensi
                LEFT JOIN pengajuan_izin ON presensi.kode_izin = pengajuan_izin.kode_izin
                WHERE tgl_presensi BETWEEN '$rangetanggal[0]' AND '$sampai'
                GROUP BY presensi.nip
                ) presensi"),
            function ($join) {
                $join->on('karyawan.nip', '=', 'presensi.nip');
            }
        );
        $query->leftJoin('unit', 'karyawan.kode_unit', '=', 'unit.kode_unit');

        $query->orderBy('karyawan.nip');

        $rekap = $query->get();


        if (isset($_POST['exporttoexcel'])) {
            $time = date("d-M-Y H:i:s");

            header("Content-type: aplication/vnd-ms-excel");

            header("Content-Disposition: attachment; filename=Rekapitulasi Absen Pegawai  $time.xls");
        }

        return view('presensi.printrekap', compact('tanggal', 'bulan', 'bln', 'namabulan', 'tahun', 'tahunini', 'kepalanama', 'rekap', 'rangetanggal', 'jmlhari', 'jabatan'));
    }

    public function izinsakit(Request $request)
    {
        // Query utama untuk data izinsakit
        $query = Pengajuanizin::query();
        $query->select('kode_izin', 'tgl_izin_dari', 'tgl_izin_sampai', 'pengajuan_izin.nip', 'nama_lengkap', 'kode_unit', 'status', 'status_approved', 'keterangan');
        $query->join('karyawan', 'pengajuan_izin.nip', '=', 'karyawan.nip');

        // Menambahkan filter berdasarkan tanggal jika ada input dari request
        if (!empty($request->dari) && !empty($request->sampai)) {
            $query->whereBetween('tgl_izin_dari', [$request->dari, $request->sampai]);
        }

        // Menambahkan filter berdasarkan status jika ada input dari request
        if (!empty($request->status)) {
            $query->where('pengajuan_izin.status', 'like', '%' . $request->status . '%');
        }

        // Menambahkan filter berdasarkan nama lengkap jika ada input dari request
        if (!empty($request->nama_lengkap)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_lengkap . '%');
        }

        // Menambahkan filter berdasarkan status persetujuan
        if ($request->status_approved === '0' || $request->status_approved === '1' || $request->status_approved === '2') {
            $query->where('status_approved', $request->status_approved);
        }

        // Urutkan data berdasarkan tanggal izin dari terbaru
        $query->orderBy('tgl_izin_dari', 'desc');

        // Mendapatkan data izin sakit dengan paginasi
        $izinsakit = $query->paginate(10);
        $izinsakit->appends($request->all());

        // Menghitung jumlah data dengan status pending
        $pendingCount = Pengajuanizin::where('status_approved', '0')->count();

        // Mengirim data ke view
        return view('presensi.izinsakit', compact('izinsakit', 'pendingCount'));
    }

    public function approvedizinsakit(Request $request)
    {
        $status_approved = $request->status_approved;
        $kode_izin = $request->kode_izin_form;
        $dataizin = DB::table('pengajuan_izin')->where('kode_izin', $kode_izin)->first();
        $nip = $dataizin->nip;
        $tgl_dari = $dataizin->tgl_izin_dari;
        $tgl_sampai = $dataizin->tgl_izin_sampai;
        $status = $dataizin->status;
        DB::beginTransaction();
        try {
            if ($status_approved == 1) {
                while (strtotime($tgl_dari) <= strtotime($tgl_sampai)) {

                    DB::table('presensi')->insert([
                        'nip' => $nip,
                        'tgl_presensi' => $tgl_dari,
                        'status' => $status,
                        'kode_izin' => $kode_izin
                    ]);
                    $tgl_dari = date("Y-m-d", strtotime("+1 days", strtotime($tgl_dari)));
                }
            }

            DB::table('pengajuan_izin')->where('kode_izin', $kode_izin)->update([
                'status_approved' => $status_approved
            ]);
            DB::commit();
            return Redirect::back()->with(['success' => 'Data Berhasil Diproses']);
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(['warning' => 'Data Gagal Diproses']);
        }

        // $update = DB::table('pengajuan_izin')->where('kode_izin', $kode_izin)->update([
        //     'status_approved' => $status_approved
        // ]);
        // if ($update) {
        //     return Redirect::back()->with(['success' => 'Data Berhasil Di Update']);
        // } else {
        //     return Redirect::back()->with(['warning' => 'Data Gagal Di Update!']);
        // }
    }

    public function batalkanizinsakit($kode_izin)
    {

        DB::beginTransaction();
        try {
            DB::table('pengajuan_izin')->where('kode_izin', $kode_izin)->update([
                'status_approved' => 0
            ]);
            DB::table('presensi')->where('kode_izin', $kode_izin)->delete();
            DB::commit();
            return Redirect::back()->with(['success' => 'Data Berhasil Di Batalkan']);
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(['warning' => 'Data Gagal Di Batalkan']);
        }

        $update = DB::table('pengajuan_izin')->where('kode_izin', $kode_izin)->update([
            'status_approved' => 0
        ]);
        if ($update) {
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Di Update!']);
        }
    }

    public function cekpengajuanizin(Request $request)
    {
        // Ambil nilai dari request
        $tgl_izin_dari = $request->tgl_izin_dari;
        $tgl_izin_sampai = $request->tgl_izin_sampai;

        // Ambil NIP dari karyawan yang sedang login
        $nip = Auth::guard('karyawan')->user()->nip;

        // Pastikan nama kolom di database benar
        // Ubah 'tgl_izn' menjadi 'tgl_izin' (atau sesuai dengan nama kolom yang benar)
        $cek = DB::table('pengajuan_izin')->where('nip', $nip)->where('tgl_izin_dari', $tgl_izin_dari, 'tgl_izin_sampai', $tgl_izin_sampai)->count();

        // Kembalikan hasil sebagai response JSON
        return response()->json($cek);
    }

    public function showact($kode_izin)
    {
        $dataizin = DB::table('pengajuan_izin')->where('kode_izin', $kode_izin)->first();

        return view('presensi.showact', compact('dataizin'));
    }

    public function delete($kode_izin)
    {
        try {
            $cekdataizin = DB::table('pengajuan_izin')->where('kode_izin', $kode_izin)->first();
            $doc_sid = $cekdataizin->doc_sid;
            DB::table('pengajuan_izin')->where('kode_izin', $kode_izin)->delete();
            if ($doc_sid != null) {
                Storage::delete('/public/uploads/sid/' . $doc_sid);
            }
            return redirect('/presensi/izin')->with('success', 'Data Berhasil Dihapus');
        } catch (\Exception $e) {
            return redirect('/presensi/izin')->with('error', 'Data Gagal Dihapus');
            //throw $th;
        }
    }

    public function deleteAllData()
    {
        DB::table('pengajuan_izin')->truncate(); // Menghapus semua data di tabel

        return redirect()->back()->with('success', 'All data deleted successfully!');
    }

    public function showfile(Request $request)
    {
        $kode_izin = $request->kode_izin; // Mengambil kode_izin dari request
        // Ambil doc_sid dari tabel pengajuan_izin berdasarkan kode_izin
        $presensi = DB::table('pengajuan_izin')->select('doc_sid')->where('kode_izin', $kode_izin)->first();

        return view('presensi.showfile', compact('presensi'));
    }

    public function profileadmin()
    {
        $id = Auth::guard('user')->user()->nip;
        $user = DB::table('users')->where('id', $id)->first();
        return view('presensi.profileadmin', compact('user'));
    }

    public function editprofileadmin()
    {
        $id = Auth::guard('user')->user()->id;
        $user = DB::table('users')->where('id', $id)->first();

        return view('presensi.editprofileadmin', compact('user'));
    }

    public function updateprofileadmin(Request $request)
    {
        $id = Auth::guard('user')->user()->id;
        $name = $request->name;
        $email = $request->email;
        $no_handphone = $request->no_handphone;
        $jabatan = $request->jabatan;

        // Mendapatkan user yang sedang login
        $user = DB::table('users')->where('id', $id)->first();

        // Pengecekan apakah password diisi atau tidak
        if (empty($request->password)) {
            $data = [
                'name' => $name,
                'jabatan' => $jabatan,
                'email' => $email,
                'no_handphone' => $no_handphone
            ];
        } else {
            $password = Hash::make($request->password);
            $data = [
                'name' => $name,
                'jabatan' => $jabatan,
                'email' => $email,
                'no_handphone' => $no_handphone,
                'password' => $password
            ];
        }

        // Pengecekan apakah ada file foto yang diupload
        if ($request->hasFile('photo')) {
            // Membuat nama file baru berdasarkan ID pengguna dan ekstensi file
            $photo = $id . "." . $request->file('photo')->getClientOriginalExtension();

            // Menghapus foto lama jika ada
            if (!empty($user->photo)) {
                Storage::delete("public/uploads/admin/{$user->photo}");
            }

            // Menyimpan nama file baru ke dalam array data untuk diupdate di database
            $data['photo'] = $photo;
        } else {
            // Jika tidak ada foto baru yang diupload, gunakan nama file lama
            $photo = $user->photo;
        }

        // Update data user
        $update = DB::table('users')->where('id', $id)->update($data);

        if ($update) {
            // Jika ada file yang diupload, simpan file tersebut ke folder
            if ($request->hasFile('photo')) {
                $folderPath = "public/uploads/admin";
                $request->file('photo')->storeAs($folderPath, $photo);
            }
            return Redirect::back()->with('success', 'Profile updated successfully.');
        } else {
            return Redirect::back()->with('error', 'Failed to update profile.');
        }
    }
}
