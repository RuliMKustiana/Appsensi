<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>A4</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <!-- Set page size here: A5, A4 or A3 -->
    <style>
        @page {
            size: A4
        }

        #title {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 16px;
            font-weight: bold;
        }

        .tabledatakaryawan {
            margin-top: 40px;
        }

        .tabledatakaryawan td {
            padding: 5px;
        }

        .tablepresensi {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .tablepresensi tr th {
            border: 1px solid #000000;
            padding: 8px;
            background-color: lightgrey;
        }

        .tablepresensi tr td {
            border: 1px solid #000000;
            padding: 5px;
            font-size: 12px;
            text-align: center;
        }

        .foto {
            width: 40px;
            height: 30px;
        }
    </style>
</head>

<body class="A4">
   
    <!-- Set "A5", "A4" or "A3" for class name -->
    <!-- "landscape" class can also be set if needed -->

    <section class="sheet padding-10mm">
        <table style="width: 100%;">
            <tr>
                <td style="width: 150px;">
                    <img src="{{ asset('assets/img/logo-bpkad.png') }}" width="150" height="50" alt="">
                </td>
                <td style="text-align: left;">
                    <span id="title">
                        LAPORAN PRESENSI PEGAWAI HONORER <br>
                        PERIODE {{ strtoupper($bln[$bulan]) }} {{ $tahun }}<br>
                        BADAN PENGELOLAAN KEUANGAN DAN ASET DAERAH <br>
                    </span>
                    <span><i>Jl. Kiansantang No.3, Regol, Kec. Garut Kota, Kabupaten Garut, Jawa Barat 44118</i></span>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div style="border-bottom: 1px solid black; width: 100%;"></div>
                </td>
            </tr>
        </table>

        <table class="tabledatakaryawan">
            <!-- Pastikan hanya satu iterasi untuk pengulangan karyawan -->
            <tr>
                <td rowspan="6">
                    @if (empty($karyawan->foto) || $karyawan->foto == 'nophoto.png')
                        <img src="{{ asset('assets/img/nophoto.png') }}" class="avatar" alt="" width="120"
                            height="150">
                    @else
                        <img src="{{ url(Storage::url('uploads/karyawan/' . $karyawan->foto)) }}" class="avatar"
                            alt="" width="120" height="150">
                    @endif
                </td>
            </tr>
            <tr>
                <td>ID</td>
                <td>:</td>
                <td>{{ $karyawan->nip }}</td>
            </tr>
            <tr>
                <td>Nama Pegawai</td>
                <td>:</td>
                <td>{{ $karyawan->nama_lengkap }}</td>
            </tr>
            <tr>
                <td>Unit Kerja</td>
                <td>:</td>
                <td>{{ $karyawan->kode_unit }}</td>
            </tr>
            <tr>
                <td>No. HP</td>
                <td>:</td>
                <td>{{ $karyawan->no_hp }}</td>
            </tr>
            <tr>
                <td>Nama Unit Kerja</td>
                <td>:</td>
                <td>{{ $karyawan->nama_unit }}</td>
            </tr>
        </table>

        <table class="tablepresensi">
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Foto</th>
                <th>Jam Pulang</th>
                <th>Foto</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
            @foreach ($presensi as $d)
                @if ($d->status == 'h')
                    @php
                        $path_in = Storage::url('uploads/absensi/' . $d->foto_in);
                        $path_out = Storage::url('uploads/absensi/' . $d->foto_out);
                        $jamterlambat = selisih('09:00:00', $d->jam_in);
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ date('d-m-Y', strtotime($d->tgl_presensi)) }}</td>
                        <td>{{ $d->jam_in }}</td>
                        <td><img src="{{ url($path_in) }}" class="foto" alt=""></td>
                        <td>{{ $d->jam_out != null ? $d->jam_out : 'Belum Absen' }}</td>
                        <td>
                            @if ($d->jam_out != null)
                                <img src="{{ url($path_out) }}" class="foto" alt="">
                            @else
                                <img src="{{ url('/assets/img/photo-question.png') }}"
                                    style="width: 20px; height: 20px; display: block; margin: 0 auto;" alt="loading">
                            @endif
                        </td>
                        <td>{{ $d->status }}</td>
                        <td>
                            @if ($d->jam_in > '09:00')
                                Terlambat {{ $jamterlambat }}
                            @else
                                Tepat Waktu
                            @endif
                        </td>
                    </tr>
                    @else
                    @php
                    $path_in = Storage::url('uploads/absensi/' . $d->foto_in);
                    $path_out = Storage::url('uploads/absensi/' . $d->foto_out);
                    $jamterlambat = selisih('09:00:00', $d->jam_in);
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ date('d-m-Y', strtotime($d->tgl_presensi)) }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{ $d->status }}</td>
                    <td></td>
                </tr>
                @endif
            @endforeach
        </table>

        <table width="100%" style="margin-top: 100px;">
            <tr>
                <td style="text-align: right">Garut, {{ $tanggal }} {{ $namabulan }} {{ $tahunini }}</td>
            </tr>
            <tr>
                <td style="text-align: right; vertical-align: bottom;" height="120px">
                    <u>{{ $kepalanama }}</u> <br>
                    <i><b>{{ $jabatan }}</b></i>
                </td>
            </tr>
        </table>
    </section>
</body>

</html>
