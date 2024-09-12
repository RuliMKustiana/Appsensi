@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">
                        Laporan Presensi
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-6">
                    <div class="card-body">
                        <form action="/presensi/printlaporan" target="_blank" method="POST">
                            @csrf
                            <div class="row mt-2">
                                <div class="col-12">
                                    <div class="form-group">
                                        <select name="bulan" id="bulan" class="form-select">
                                            <option value="">Bulan</option>
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value = "{{ $i }}"
                                                    {{ date('m') == $i ? 'selected' : '' }}>
                                                    {{ $bln[$i] }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-12">
                                    <div class="form-group">
                                        <select name="tahun" id="tahun" class="form-select">
                                            <option value="">Tahun</option>
                                            @php
                                                $tahunmulai = 2024;
                                                $tahunskrg = date('Y');
                                            @endphp
                                            @for ($tahun = $tahunmulai; $tahun <= $tahunskrg; $tahun++)
                                                <option value="{{ $tahun }}"
                                                    {{ date('Y') == $tahun ? 'selected' : '' }}>
                                                    {{ $tahun }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="row mt-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <select name="nip" id="nip" class="form-select">
                                        <option value="" disabled selected hidden>Pilih Karyawan</option>
                                        @foreach ($karyawan as $d)
                                        <option value="{{$d->nip}}">{{ $d->nama_lengkap }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-6">
                                <div class="form-group">
                                    <button type="submit" name="print" class="btn btn-primary w-100" id="printButton" disabled>
                                        <!-- SVG Icon for Print -->
                                        Print
                                    </button>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <button type="submit" name="exporttoexcel" class="btn btn-success w-100" id="exportButton" disabled>
                                        <!-- SVG Icon for Export to Excel -->
                                        Export to Excel
                                    </button>
                                </div>
                            </div>
                        </div>

                        <script>
                            document.getElementById('nip').addEventListener('change', function() {
                                var nipValue = this.value;
                                var isValid = nipValue !== ''; // Cek jika pilihan valid dipilih

                                // Aktifkan atau nonaktifkan tombol berdasarkan validitas pilihan
                                document.getElementById('printButton').disabled = !isValid;
                                document.getElementById('exportButton').disabled = !isValid;
                            });
                        </script>
@endsection
