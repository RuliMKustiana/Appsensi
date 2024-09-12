@extends('layouts.presensi')
@section('content')
    <div class="section3" id="user-section3">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="arrow-back-outline"></ion-icon>
        </a>
        <div class="titles">Profile</div>
    </div>
    <div class="section4" id="profile-section">
        <div class="avatar2 me-3">
            @php
                $user = Auth::guard('karyawan')->user();
                $defaultPhoto = 'assets/img/nophoto.png'; // Path to the default avatar

                if (!empty($user->foto) && $user->foto != 'nophoto.png') {
                    $path = Storage::url('uploads/karyawan/' . $user->foto);
                } else {
                    $path = asset($defaultPhoto);
                }
            @endphp
            <div class="avatar2 me-3">
                <img src="{{ url($path) }}" alt="avatar" class="img-fluid rounded-circle" style="cursor: pointer;">
            </div>
        </div>
        <span id="user-name-profile" class="mb-0">{{ Auth::guard('karyawan')->user()->nama_lengkap }}</span>
        <span id="user-role-profile">{{ Auth::guard('karyawan')->user()->unit->nama_unit }}</span>
        <hr class="divider bg-light">
        <div class="user-info-title">User Information</div>
        <div class="user-info-section">
            <div class="user-info-item">
                <ion-icon name="card-outline"></ion-icon>
                <span>{{ Auth::guard('karyawan')->user()->nama_lengkap }}</span>
            </div>
            <div class="user-info-item">
                <ion-icon name="call-outline"></ion-icon>
                <span>{{ Auth::guard('karyawan')->user()->no_hp }}</span>
            </div>
            <div class="user-info-item">
                <ion-icon name="briefcase-outline"></ion-icon>
                <span>{{ Auth::guard('karyawan')->user()->unit->nama_unit }}</span>
            </div>
            <div class="user-info-item">
                <ion-icon name="id-card-outline"></ion-icon>
                <span>{{ Auth::guard('karyawan')->user()->unit->kode_unit }}</span>
            </div>
        </div>

    </div>
@endsection
