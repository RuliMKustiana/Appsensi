@extends('layouts.presensi')
@section('content')
    <div class="section" id="user-section">
        <div class="d-flex align-items-center justify-content-between">
            <div class="app-title">Appsensi</div>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-reset" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="avatar me-3">
                        @php
                            $user = Auth::guard('karyawan')->user();
                            $defaultPhoto = 'assets/img/nophoto.png'; // Path to the default avatar

                            if (!empty($user->foto) && $user->foto != 'nophoto.png') {
                                $path = Storage::url('uploads/karyawan/' . $user->foto);
                            } else {
                                $path = asset($defaultPhoto);
                            }
                        @endphp

                        <div class="avatar me-3">
                            <img src="{{ url($path) }}" alt="avatar" class="img-fluid rounded-circle"
                                style="cursor: pointer;">
                        </div>
                    </div>
                </a>
                <ul class="dropdown-menu custom-dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li><a class="dropdown-item" href="/editprofile">Settings</a></li>
                    <li><a class="dropdown-item" href="/proseslogout">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>


    <div class="section2" id="menu-section">
        <h5 class="ml-1">Selamat Datang😉</h5>
        <div id="user-info">
            <h4 id="user-name" class="mb-0">{{ Auth::guard('karyawan')->user()->nama_lengkap }}</h4>
        </div>
        <hr class="divider bg-light">
        <div class="row text-center justify-content-center">
            {{-- Column Absen --}}
            <div class="col-3">
                <span class="badge badge-notification position-absolute top-0 end-0">{{ $rekappresensi->jmlhadir }}</span>
                <div class="card absen-card">
                    <div class="card-body small-card-body">
                        <ion-icon name="hand-left" class="icon text-white"></ion-icon>
                    </div>
                </div>
                <span class="label">Hadir</span>
            </div>
            {{-- Column History --}}
            <div class="col-3">
                <span class="badge badge-notification position-absolute top-0 end-0">{{ $rekapizin->jmlizin }}</span>
                <div class="card history-card">
                    <div class="card-body small-card-body">
                        <ion-icon name="receipt" class="icon text-white"></ion-icon>
                    </div>
                </div>
                <span class="label">History</span>
            </div>
            {{-- Column Sakit Card --}}
            <div class="col-3 position-relative">
                <span class="badge badge-notification position-absolute top-0 end-0">{{ $rekapizin->jmlsakit }}</span>
                <div class="card sick-card">
                    <div class="card-body small-card-body">
                        <ion-icon name="medkit" class="icon text-white"></ion-icon>
                    </div>
                </div>
                <span class="label">Sakit</span>
            </div>
            {{-- Column Telat --}}
            <div class="col-3">
                <span
                    class="badge badge-notification position-absolute top-0 end-0">{{ $rekappresensi->jmlterlambat }}</span>
                <div class="card telat-card">
                    <div class="card-body small-card-body">
                        <ion-icon name="time" class="icon text-white"></ion-icon>
                    </div>
                </div>
                <span class="label">Telat</span>
            </div>
        </div>
    </div>
    <div class="section mt-4" id="presence-section">
        <div class="section mt-1" id="view-section">
            <div id="rekappresensi" class="mt-2">
                <h3>Rekap Presensi {{ $bln[$bulanini] }} {{ $tahunini }}</h3>
            </div>
            <div class="presencetab mt-2">
                <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                    <ul class="nav nav-tabs style1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                                Bulan Ini
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                                Leaderboard
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content mt-2" style="margin-bottom:100px;">
                    <div class="tab-pane fade show active" id="home" role="tabpanel">
                        <ul class="listview image-listview">
                            @foreach ($historybulanini as $d)
                                @php
                                    $path = Storage::url('uploads/absensi/' . $d->foto_in);
                                @endphp
                                <li>
                                    <div class="item">
                                        {{-- icon absen masuk --}}
                                        <div class="checkmark-done-custom">
                                            <ion-icon name="checkmark-done-outline"></ion-icon>
                                        </div>
                                        {{-- notif belum absen --}}
                                        <div class="in">
                                            <div>{{ date('d-m-Y', strtotime($d->tgl_presensi)) }}</div>
                                            <span class="badge {{ $d->jam_in < '09:00' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $d->jam_in < '09:00' ? 'Absen' : 'No Absen' }}
                                            </span>
                                            <span
                                                class="badge badge-warning">{{ $presensihariini != null && $d->jam_out != null ? $d->jam_out : 'Absen?' }}</span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel">
                        <ul class="listview image-listview">
                            @foreach ($leaderboard as $d)
                                @php
                                    $path = Storage::url('uploads/karyawan/' . $d->foto);
                                @endphp
                                <li>
                                    <div class="item">
                                        @if (empty($d->foto) || $d->foto == 'nophoto.png')
                                            <img src="{{ asset('assets/img/nophoto.png') }}" class="avatar-leader"
                                                alt="">
                                        @else
                                            <img src="{{ url($path) }}" class="avatar-leader" alt="">
                                        @endif
                                        <div class="in">
                                            <div>
                                                {{ $d->nama_lengkap }} <br>
                                                <small class="text-muted">{{ $d->unit_kerja }}</small>
                                            </div>
                                            <span class="badge {{ $d->jam_in < '09:00' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $d->jam_in < '09:00' ? 'Absen' : 'No Absen' }}
                                            </span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
