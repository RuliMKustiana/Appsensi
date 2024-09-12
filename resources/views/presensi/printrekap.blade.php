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
    <!-- Set also "landscape" if you need -->
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
            font-size: 10px;
        }

        .tablepresensi tr td {
            border: 1px solid #000000;
            padding: 5px;
            font-size: 12px;
            text-align: center
        }

        .foto {
            width: 40px;
            height: 30px;
        }

        body.A4.landscape .sheet {
            width: 310mm !important;
            height: 210 !important;
        }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="A4 landscape">
   
    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm">
        <table style="width: 100%;">
            <tr>
                <td style="width: 150px;">
                    <img src="{{ asset('assets/img/logo-bpkad.png') }}" width="150" height="50" alt="">
                </td>
                <td style="text-align: left;">
                    <span id="title">
                        REKAP PRESENSI PEGAWAI HONORER <br>
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

        <table class="tablepresensi">
            <tr>
                <th rowspan="2">ID</th>
                <th rowspan="2">Nama Pegawai</th>
                <th colspan="{{ $jmlhari }}">Bulan {{ $bln[$bulan] }} {{ $tahun }}</th>
                <th rowspan="2">JH</th>
                <th rowspan="2">TH</th>
                <th rowspan="2">JI</th>
                <th rowspan="2">JS</th>
                <th rowspan="2">JC</th>
                <th rowspan="2">JD</th>
            </tr>
            <tr>
                @foreach ($rangetanggal as $d)
                    @if ($d != null)
                        <th>{{ date('d', strtotime($d)) }}</th>
                    @endif
                @endforeach
            </tr>
            @foreach ($rekap as $r)
                <tr>
                    <td>{{ $r->nip }}</td>
                    <td>{{ $r->nama_lengkap }}</td>

                    @php
                        $jml_hadir = 0;
                        $jml_izin = 0;
                        $jml_sakit = 0;
                        $jml_cuti = 0;
                        $jml_dinas = 0;
                        $jml_alpa = 0;
                    @endphp

                    @for ($i = 1; $i <= $jmlhari; $i++)
                        @php
                            $tgl_ke = 'tgl_' . $i;
                            $status = '';
                            if ($r->$tgl_ke != null) {
                                $datapresensi = explode('|', $r->$tgl_ke);
                                $status = $datapresensi[2];
                            } else {
                                $status = '';
                            }

                            if ($status == 'h') {
                                $jml_hadir += 1;
                            }

                            if ($status == 'i') {
                                $jml_izin += 1;
                            }

                            if ($status == 's') {
                                $jml_sakit += 1;
                            }

                            if ($status == 'c') {
                                $jml_cuti += 1;
                            }

                            if ($status == 'd') {
                                $jml_dinas += 1;
                            }

                            if (empty($status)) {
                                $jml_alpa += 1;
                            }
                        @endphp
                        <td>
                            {{ $status }}
                        </td>
                    @endfor

                    <td>{{ !empty($jml_hadir) ? $jml_hadir : '' }}</td> <!-- Total Hadir -->
                    <td>{{ !empty($jml_alpa) ? $jml_alpa : '' }}</td> <!-- Total Tidak Hadir -->
                    <td>{{ !empty($jml_izin) ? $jml_izin : '' }}</td>
                    <td>{{ !empty($jml_sakit) ? $jml_sakit : '' }}</td>
                    <td>{{ !empty($jml_cuti) ? $jml_cuti : '' }}</td>
                    <td>{{ !empty($jml_dinas) ? $jml_dinas : '' }}</td>
                </tr>
            @endforeach
        </table>
        <table width="100%" style="margin-top: 20px;">
            <tr>
                <td style="vertical-align: top;">
                    <strong>Keterangan:</strong><br>
                    <table style="width: 100%; margin-top: 10px;">
                        <tr>
                            <td style="width: 30px;">JH</td>
                            <td>: Jumlah Hadir</td>
                        </tr>
                        <tr>
                            <td>TH</td>
                            <td>: Tidak Hadir</td>
                        </tr>
                        <tr>
                            <td>JI</td>
                            <td>: Jumlah Izin</td>
                        </tr>
                        <tr>
                            <td>JS</td>
                            <td>: Jumlah Sakit</td>
                        </tr>
                        <tr>
                            <td>JC</td>
                            <td>: Jumlah Cuti</td>
                        </tr>
                        <tr>
                            <td>JD</td>
                            <td>: Jumlah Dinas</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>


        <table width="100%" style="margin-top: 100px">
            <tr>
                <td style="text-align: right">Garut, {{ $tanggal }} {{ $namabulan }} {{ $tahunini }}
                </td>
            </tr>
            <tr>
                <td style="text-align: right; vertical-align:bottom" height="120px">
                    <u>{{ $kepalanama }}</u> <br>
                    <i><b>{{ $jabatan }}</b></i>
                </td>
            </tr>
        </table>
    </section>

</body>

</html>
