@extends('layouts.admin.tabler')
@section('content')

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Data Admin
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
        <div class="row mb-2">
            <div class="col-12">
                <a href="#" class="btn btn-primary" id="btnAddAdmin">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-table-plus">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12.5 21h-7.5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v7.5" />
                        <path d="M3 10h18" />
                        <path d="M10 3v18" />
                        <path d="M16 19h6" />
                        <path d="M19 16v6" />
                    </svg>
                    Tambah Data</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Admin</th>
                            <th>Email</th>
                            <th>No. HP</th>
                            <th>Foto</th>
                            <th>Jabatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user as $d)
                        @php
                        $path = Storage::url('uploads/Admin/'.$d->photo);
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration}}</td>
                            <td>{{ $d->name }}</td>
                            <td>{{ $d->email }}</td>
                            <td>{{ $d->no_handphone }}</td>
                            <td>
                                @if(empty($d->photo))
                                <img src="{{ asset('assets/img/nophoto.png') }}" class="avatar" alt="">
                                @else
                                <img src="{{ url($path) }}" class="avatar" alt="">
                                @endif
                            </td>
                            <td>{{ $d->jabatan }}</td>
                            <td>
                                {{-- button reset password --}}
                                <div style="display: flex; gap: 10px; align-items: center;">
                                <a href="/user/{{ Crypt::encrypt($d->id) }}/resetpassword" class="btn btn-warning">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-cloud-lock">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M19 18a3.5 3.5 0 0 0 0 -7h-1c.397 -1.768 -.285 -3.593 -1.788 -4.787c-1.503 -1.193 -3.6 -1.575 -5.5 -1s-3.315 2.019 -3.712 3.787c-2.199 -.088 -4.155 1.326 -4.666 3.373c-.512 2.047 .564 4.154 2.566 5.027" />
                                        <path d="M8 15m0 1a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-6a1 1 0 0 1 -1 -1z" />
                                        <path d="M10 15v-2a2 2 0 1 1 4 0v2" />
                                    </svg>
                                    <span>Reset</span>
                                </a>
                                <form action="/admin/{{ $d->id }}/delete"
                                    method="POST" style="margin: 0;">
                                    @csrf
                                    <a class=" btn btn-red deleted-confirm">
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
        </div>
    </div>
    </div>
</div>

{{-- Add Admin --}}
<div class="modal modal-blur fade" id="modal-inputdataadmin" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Data Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/user/store" method="POST" id="frmAdmin" enctype="multipart/form-data">
                    @csrf
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
                                <input type="text" value="" id="name" class="form-control"
                                    name="name" placeholder="Username">
                            </div>
                        </div>
                    </div>
                    {{-- Add Email --}}
                    <div class="row">
                        <div class="col-12">
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-mail">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                                        <path d="M3 7l9 6l9 -6" />
                                    </svg>
                                </span>
                                <input type="text" value="" id="email" class="form-control"
                                    name="email" placeholder="E-Mail">
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
                                <input type="text" value="" id="no_handphone" class="form-control"
                                    name="no_handphone" placeholder="Nomor Handphone">
                            </div>
                        </div>
                    </div>
                    {{-- Add Jabatan --}}
                    <div class="row">
                        <div class="col-12">
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users-group">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1" />
                                        <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M17 10h2a2 2 0 0 1 2 2v1" />
                                        <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M3 13v-1a2 2 0 0 1 2 -2h2" />
                                    </svg>
                                </span>
                                <input type="text" value="" id="jabatan" class="form-control"
                                    name="jabatan" placeholder="Jabatan">
                            </div>
                        </div>
                    </div>

                    {{-- Add foto --}}
                    <div class="row mt-2">
                        <div class="col-12">
                            <div class="form-label">Add Photo</div>
                            <input type="file" name="photo" class="form-control">
                        </div>
                    </div>
                    {{-- Button Save --}}
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="form-group">
                                <button class="btn btn-primary w-100">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('myscript')
<script>
    $(function() {
        $("#btnAddAdmin").click(function() {
            $("#modal-inputdataadmin").modal("show");
        });

        $("#frmAdmin").submit(function() {
            var name = $("#name").val();
            var email = $("#email").val();
            var no_handphone = $("#no_handphone").val();
            var jabatan = $("#jabatan").val();
            if (name == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Nama Harus Diisi!',
                    background: '#f8d7da',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK',
                    customClass: {
                        title: 'my-custom-title-class',
                        popup: 'my-custom-popup-class'
                    }
                });
                $("#name").focus();
                return false;
            } else if (email == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Email Harus Diisi!',
                    background: '#f8d7da',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK',
                    customClass: {
                        title: 'my-custom-title-class',
                        popup: 'my-custom-popup-class'
                    }
                });
                $("#email").focus();
                return false;
            } else if (no_handphone == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Nomor Handphone Harus Diisi!',
                    background: '#f8d7da',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK',
                    customClass: {
                        title: 'my-custom-title-class',
                        popup: 'my-custom-popup-class'
                    }
                });
                $("#no_handphone").focus();
                return false;
            } else if (jabatan == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Jabatan Harus Diisi!',
                    background: '#f8d7da',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK',
                    customClass: {
                        title: 'my-custom-title-class',
                        popup: 'my-custom-popup-class'
                    }
                });
                $("#jabatan").focus();
                return false;
            }
            return true;
        });
    });

    $(".deleted-confirm").click(function(e) {
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
                        form.submit();
                        Swal.fire({
                            title: "Deleted!",
                            text: "Data Berhasil Dihapus",
                            icon: "success"
                        });
                    }
                });
            });
</script>
@endpush