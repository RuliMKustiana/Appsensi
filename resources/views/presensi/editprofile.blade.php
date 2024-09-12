@extends('layouts.presensi')
@section('content')
    <div class="section3" id="user-section3">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="arrow-back-outline"></ion-icon>
        </a>
        <div class="titles">Edit Profile</div>
        <div class="section2" id="menu-section2" style="margin-top: 380px">
            <div class="row">
                <div class="col">
                    @php
                        $messagesuccess = Session::get('success');
                        $messageerror = Session::get('error');
                    @endphp
                    {{-- Pesan Success Update --}}
                    @if (Session::get('success'))
                        <div class="alert alert-success">
                            {{ $messagesuccess }}
                        </div>
                    @endif
                    {{-- Pesan Error Update --}}
                    @if (Session::get('error'))
                        <div class="alert alert-danger">
                            {{ $messageerror }}
                        </div>
                    @endif
        
                    {{-- Tampilkan pesan error validasi --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
            <form action="/presensi/{{ $karyawan->nip }}/updateprofile" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col">
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="text" class="form-control" value="{{ $karyawan->nama_lengkap }}" name="nama_lengkap"
                                placeholder="Nama Lengkap" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="text" class="form-control" value="{{ $karyawan->no_hp }}" name="no_hp"
                                placeholder="No. HP" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="off">
                        </div>
                    </div>
                    <div class="custom-file-upload" id="fileUpload1">
                        <input type="file" name="foto" id="fileuploadInput" accept=".png, .jpg, .jpeg">
                        <label for="fileuploadInput">
                            <span>
                                <strong>
                                    <ion-icon name="image-outline"></ion-icon>
                                    <i>Tap to Upload</i>
                                </strong>
                            </span>
                        </label>
                    </div>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <button type="submit" class="btn btn-primary btn-block">
                                <ion-icon name="refresh-outline"></ion-icon>
                                Update
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
