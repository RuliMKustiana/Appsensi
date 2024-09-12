@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">
                        Data Pegawai Honorer
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
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
                                    <a href="#" class="btn btn-primary" id="btnAddkaryawan">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-table-plus">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M12.5 21h-7.5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v7.5" />
                                            <path d="M3 10h18" />
                                            <path d="M10 3v18" />
                                            <path d="M16 19h6" />
                                            <path d="M19 16v6" />
                                        </svg>
                                        Add Data
                                    </a>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <form action="/karyawan" method="GET">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <input type="text" name="nama_karyawan" id="nama_karyawan"
                                                        class="form-control" placeholder="Nama Karyawan"
                                                        value="{{ Request('nama_karyawan') }}">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <select name="kode_unit" id="kode_unit" class="form-select">
                                                        <option value="">Unit Kerja</option>
                                                        @foreach ($unit as $d)
                                                            <option
                                                                {{ Request('kode_unit') == $d->kode_unit ? 'selected' : '' }}
                                                                value="{{ $d->kode_unit }}">
                                                                {{ $d->nama_unit }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
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
                            <div class="row mt-2">
                                <div class="col-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>ID</th>
                                                <th>Nama</th>
                                                <th>No. HP</th>
                                                <th>Foto</th>
                                                <th>Unit Kerja</th>
                                                <th>Setting</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($karyawan as $d)
                                                @php
                                                    $path = Storage::url('uploads/karyawan/' . $d->foto);
                                                @endphp
                                                <tr>
                                                    <td>{{ $loop->iteration + $karyawan->firstitem() - 1 }}</td>
                                                    <td>{{ $d->nip }}</td>
                                                    <td>{{ $d->nama_lengkap }}</td>
                                                    <td>{{ $d->no_hp }}</td>
                                                    <td>
                                                        @if (empty($d->foto) || $d->foto == 'nophoto.png')
                                                            <img src="{{ asset('assets/img/nophoto.png') }}" class="avatar"
                                                                alt="">
                                                        @else
                                                            <img src="{{ url($path) }}" class="avatar" alt="">
                                                        @endif
                                                    </td>
                                                    <td>{{ $d->nama_unit }}</td>
                                                    <td>
                                                        <div style="display: flex; gap: 10px; align-items: center;">
                                                            {{-- button edit --}}
                                                            <a href="#" class=" btn btn-primary edit"
                                                                nip="{{ $d->nip }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-edit"
                                                                    style="margin-right: 8px;">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path
                                                                        d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                    <path
                                                                        d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                                    <path d="M16 5l3 3" />
                                                                </svg>
                                                                <span>Edit</span>
                                                            </a>

                                                            {{-- button reset password --}}
                                                            <a href="/karyawan/{{ Crypt::encrypt($d->nip) }}/resetpassword"
                                                                class="btn btn-warning">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-cloud-lock">
                                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                                        fill="none" />
                                                                    <path
                                                                        d="M19 18a3.5 3.5 0 0 0 0 -7h-1c.397 -1.768 -.285 -3.593 -1.788 -4.787c-1.503 -1.193 -3.6 -1.575 -5.5 -1s-3.315 2.019 -3.712 3.787c-2.199 -.088 -4.155 1.326 -4.666 3.373c-.512 2.047 .564 4.154 2.566 5.027" />
                                                                    <path
                                                                        d="M8 15m0 1a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-6a1 1 0 0 1 -1 -1z" />
                                                                    <path d="M10 15v-2a2 2 0 1 1 4 0v2" />
                                                                </svg>
                                                                <span>Reset</span>
                                                            </a>
                                                            {{-- button delete --}}
                                                            <form action="/karyawan/{{ $d->nip }}/delete"
                                                                method="POST" style="margin: 0;">
                                                                @csrf
                                                                <a class=" btn btn-red delete-confirm">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-trash"
                                                                        style="margin-right: 8px;">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none" />
                                                                        <path d="M4 7l16 0" />
                                                                        <path d="M10 11l0 6" />
                                                                        <path d="M14 11l0 6" />
                                                                        <path
                                                                            d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                        <path
                                                                            d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                                    </svg>
                                                                    <span>Delete</span>
                                                                </a>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{ $karyawan->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Add Karyawan --}}
    <div class="modal modal-blur fade" id="modal-inputdatakaryawan" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Data Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/karyawan/store" method="POST" id="frmKaryawan" enctype="multipart/form-data">
                        @csrf
                        {{-- Add Id --}}
                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-id">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z" />
                                            <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                            <path d="M15 8l2 0" />
                                            <path d="M15 12l2 0" />
                                            <path d="M7 16l10 0" />
                                        </svg>
                                    </span>
                                    <input type="text" value="" id="nip" class="form-control"
                                        name="nip" placeholder="ID">
                                </div>
                            </div>
                        </div>
                        {{-- Add Username --}}
                        <div class="row">
                            <div class="col-12">
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
                                    <input type="text" value="" id="nama_lengkap" class="form-control"
                                        name="nama_lengkap" placeholder="Username">
                                </div>
                            </div>
                        </div>
                        {{-- Add No. HP --}}
                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-phone-plus">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                                            <path d="M15 6h6m-3 -3v6" />
                                        </svg>
                                    </span>
                                    <input type="text" value="" id="no_hp" class="form-control"
                                        name="no_hp" placeholder="No. HP">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="form-label">Add Photo</div>
                                <input type="file" name="foto" class="form-control">
                            </div>
                        </div>
                        {{-- Add Unit Kerja --}}
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="form-label">Unit Kerja</div>
                                <div class="input-icon mb-3">
                                    <select name="kode_unit" id="kode_unit" class="form-select">
                                        <option value="">Unit Kerja</option>
                                        @foreach ($unit as $d)
                                            <option {{ Request('kode_unit') == $d->kode_unit ? 'selected' : '' }}
                                                value="{{ $d->kode_unit }}">
                                                {{ $d->nama_unit }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- Button Save --}}
                            <div class="row mt-2">
                                <div class="col-12">
                                    <div class="form-group">
                                        <button class="btn btn-primary w-100">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Edit Karyawan --}}
    <div class="modal modal-blur fade" id="modal-editdatakaryawan" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="loadeditform">

                </div>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        $(function() {
            $("#btnAddkaryawan").click(function() {
                $("#modal-inputdatakaryawan").modal("show");
            });

            $(".edit").click(function() {
                var nip = $(this).attr('nip');
                $.ajax({
                    type: 'POST',
                    url: '/karyawan/edit',
                    cache: false,
                    data: {
                        _token: "{{ csrf_token() }}",
                        nip: nip
                    },
                    success: function(respond) {
                        $("#loadeditform").html(respond);
                    }
                });
                $("#modal-editdatakaryawan").modal("show");
            });

            $(".delete-confirm").click(function(e) {
                var form = $(this).closest('form');
                e.preventDefault();
                Swal.fire({
                    title: "Apakah anda yakin Data ini ingin dihapus?",
                    text: "Jika 'Ya' maka Data akan dihapus permanen!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Hapus Saja!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Form akan dikirim jika konfirmasi 'Yes' dipilih
                        Swal.fire({
                            title: "Deleted!",
                            text: "Data Berhasil Dihapus",
                            icon: "success"
                        });
                    }
                });
            });


            $("#frmKaryawan").submit(function() {
                var nip = $("#nip").val();
                var nama_lengkap = $("#nama_lengkap").val();
                var no_hp = $("#no_hp").val();
                var kode_unit = $("frmKaryawan").find("#kode_unit").val();
                if (nip == "") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'ID Harus Diisi!',
                        background: '#f8d7da',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK',
                        customClass: {
                            title: 'my-custom-title-class',
                            popup: 'my-custom-popup-class'
                        }
                    });
                    $("#nip").focus();
                    return false;
                } else if (nama_lengkap == "") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Nama Lengkap Harus Diisi!',
                        background: '#f8d7da',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK',
                        customClass: {
                            title: 'my-custom-title-class',
                            popup: 'my-custom-popup-class'
                        }
                    });
                    $("#nama_lengkap").focus();
                    return false;
                } else if (no_hp == "") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'No. HP Harus Diisi!',
                        background: '#f8d7da',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK',
                        customClass: {
                            title: 'my-custom-title-class',
                            popup: 'my-custom-popup-class'
                        }
                    });
                    $("#no_hp").focus();
                    return false;
                } else if (kode_unit == "") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Unit Kerja Harus Dipilih!',
                        background: '#f8d7da',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK',
                        customClass: {
                            title: 'my-custom-title-class',
                            popup: 'my-custom-popup-class'
                        }
                    });
                    $("#kode_unit").focus();
                    return false;
                }
                return true;
            });
        });
    </script>
@endpush
