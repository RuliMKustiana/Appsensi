@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <h2 class="page-title">
                    Data Pengajuan Izin
                </h2>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                @if (Session::get('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
                @endif

                @if (Session::get('warning'))
                <div class="alert alert-warning">
                    {{ Session::get('warning') }}
                </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form action="/presensi/izinsakit" method="GET" autocomplete="off">
                    <div class="row">
                        {{-- Berdasarkan Tanggal Dari --}}
                        <div class="col-6">
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-month">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                        <path d="M16 3v4" />
                                        <path d="M8 3v4" />
                                        <path d="M4 11h16" />
                                        <path d="M7 14h.013" />
                                        <path d="M10.01 14h.005" />
                                        <path d="M13.01 14h.005" />
                                        <path d="M16.015 14h.005" />
                                        <path d="M13.015 17h.005" />
                                        <path d="M7.01 17h.005" />
                                        <path d="M10.01 17h.005" />
                                    </svg>
                                </span>
                                <input type="text" value="{{ Request('dari') }}" id="dari" class="form-control"
                                    name="dari" placeholder="Dari">
                            </div>
                        </div>
                        {{-- Berdasarkan Tanggal Sampai --}}
                        <div class="col-6">
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-month">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                        <path d="M16 3v4" />
                                        <path d="M8 3v4" />
                                        <path d="M4 11h16" />
                                        <path d="M7 14h.013" />
                                        <path d="M10.01 14h.005" />
                                        <path d="M13.01 14h.005" />
                                        <path d="M16.015 14h.005" />
                                        <path d="M13.015 17h.005" />
                                        <path d="M7.01 17h.005" />
                                        <path d="M10.01 17h.005" />
                                    </svg>
                                </span>
                                <input type="text" value="{{ Request('sampai') }}" id="sampai"
                                    class="form-control" name="sampai" placeholder="Sampai">
                            </div>
                        </div>
                    </div>
                    {{-- 4 Kolom --}}
                    <div class="row">
                        <div class="col-3">
                            <div class="input-icon mb-3">
                                <div class="form-group">
                                    <select name="status" id="status" class="form-control">
                                        <option value="">Jenis Izin</option>
                                        <option value="i">Izin</option>
                                        <option value="s">Sakit</option>
                                        <option value="c">Cuti</option>
                                        <option value="d">Dinas</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- Kolom 2 Nama --}}
                        <div class="col-3">
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-at">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                        <path d="M16 12v1.5a2.5 2.5 0 0 0 5 0v-1.5a9 9 0 1 0 -5.5 8.28" />
                                    </svg>
                                </span>
                                <input type="text" value="{{ Request('nama_lengkap') }}" id="nama_lengkap"
                                    class="form-control" name="nama_lengkap" placeholder="Username">
                            </div>
                        </div>
                        {{-- Kolom 3 Status --}}
                        <div class="col-3">
                            <div class="form-group">
                                <select name="status_approved" id="status_approved" class="form-select">
                                    <option value="">Pilih Status</option>
                                    <option value="0" {{ Request('status_approved') === '0' ? 'selected' : '' }}>
                                        Pending</option>
                                    <option value="1" {{ Request('status_approved') == 1 ? 'selected' : '' }}>Di
                                        Setujui</option>
                                    <option value="2" {{ Request('status_approved') == 2 ? 'selected' : '' }}>Di
                                        Tolak</option>
                                </select>
                            </div>
                        </div>
                        {{-- Kolom 4 Button --}}
                        <div class="col-3">
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                        <path d="M21 21l-6 -6" />
                                    </svg>
                                    Cari
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        {{-- Kolom 5 Button Delete --}}
        <div class="col-3">
            <div class="form-group">
                <form action="{{ route('deleteAllData') }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete all data?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M4 7h16" />
                            <path d="M10 11v6" />
                            <path d="M14 11v6" />
                            <path d="M5 7l1 -1h12l1 1" />
                            <path d="M6 7v14a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2V7" />
                        </svg>
                        Delete All Data
                    </button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>No.</td>
                            <td>Tanggal</td>
                            <td>ID</td>
                            <td>Nama Pegawai</td>
                            <td>Unit Kerja</td>
                            <td>Status</td>
                            <td>Keterangan</td>
                            <td>File</td>
                            <td>Approved</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($izinsakit as $d)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ date('d-m-Y', strtotime($d->tgl_izin_dari)) }} s/d
                                {{ date('d-m-Y', strtotime($d->tgl_izin_sampai)) }}
                            </td>
                            <td>{{ $d->nip }}</td>
                            <td>{{ $d->nama_lengkap }}</td>
                            <td>{{ $d->kode_unit }}</td>
                            <td>
                                @if ($d->status == 'i')
                                Izin
                                @elseif($d->status == 's')
                                Sakit
                                @elseif($d->status == 'd')
                                Dinas
                                @elseif($d->status == 'c')
                                Cuti
                                @else
                                Tidak Diketahui
                                @endif
                            </td>
                            <td>{{ $d->keterangan }}</td>
                            <td>
                                <a href="#" class="btn btn-primary showfile" id="{{ $d->kode_izin }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-files">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M15 3v4a1 1 0 0 0 1 1h4" />
                                        <path
                                            d="M18 17h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h4l5 5v7a2 2 0 0 1 -2 2z" />
                                        <path d="M16 17v2a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h2" />
                                    </svg>
                                </a>
                            </td>
                            <td>
                                @if ($d->status_approved == 1)
                                <span class="badge bg-success">Disetujui</span>
                                @elseif($d->status_approved == 2)
                                <span class="badge bg-danger">Ditolak</span>
                                @else
                                <span class="badge bg-warning">Pending</span>
                                @endif
                            </td>
                            <td>
                                @if ($d->status_approved == 0)
                                <a href="#" class="btn btn-sm btn-primary approve"
                                    kode_izin="{{ $d->kode_izin }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                        <path
                                            d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                        <path d="M16 5l3 3" />
                                    </svg>
                                    Setting
                                </a>
                                @else
                                <a href="/presensi/{{ $d->kode_izin }}/batalkanizinsakit"
                                    class="btn btn-sm btn-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M18 6l-12 12" />
                                        <path d="M6 6l12 12" />
                                    </svg>
                                    Batalkan
                                </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $izinsakit->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
{{-- Action --}}
<div class="modal modal-blur fade" id="modal-izinsakit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Izin/Sakit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/presensi/approvedizinsakit" method="POST">
                    @csrf
                    <input type="hidden" id="kode_izin_form" name="kode_izin_form">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <select name="status_approved" id="status_approved" class="form-select">
                                    <option value="1">Setujui</option>
                                    <option value="2">Tolak</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <div class="form-group">
                                <button class="btn btn-primary w-100" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-send">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 14l11 -11" />
                                        <path
                                            d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" />
                                    </svg>
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<div class="modal modal-blur fade" id="modal-showfile" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">File Pengajuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="loadfile">
            </div>
        </div>
    </div>
</div>

@push('myscript')
<script>
    $(function() {
        $(".approve").click(function(e) {
            e.preventDefault();
            var kode_izin = $(this).attr("kode_izin");
            $("#kode_izin_form").val(kode_izin);
            $("#modal-izinsakit").modal("show");
        });

        $("#dari, #sampai").datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        });

        $(".showfile").click(function(e) {
            var kode_izin = $(this).attr("id"); // Menggunakan id sebagai kode_izin
            $.ajax({
                type: 'POST',
                url: '/showfile',
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_izin: kode_izin // Kirim kode_izin, bukan id
                },
                cache: false,
                success: function(respond) {
                    $("#loadfile").html(respond); // Tampilkan respon di modal
                }
            });
            $("#modal-showfile").modal("show");
        });
    });
</script>
@endpush