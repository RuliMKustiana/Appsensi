@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">
                        Konfigurasi Lokasi Kantor
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
                        @if (Session::get('success'))
                            <div class="alert alert-succes">
                                {{ Session::get('success') }}
                            </div>
                        @endif

                        @if (Session::get('warning'))
                            <div class="alert alert-warning">
                                {{ Session::get('warning') }}
                            </div>
                        @endif
                        <form action="/konfigurasi/updatelokasikantor" method="POST">
                            @csrf
                            {{-- Location Kantor --}}
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-icon mb-3">
                                        <span class="input-icon-addon">
                                            <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-map-pin-2">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7" />
                                                <path d="M9 4v13" />
                                                <path d="M15 7v5" />
                                                <path
                                                    d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879z" />
                                                <path d="M19 18v.01" />
                                            </svg>
                                        </span>
                                        <input type="text" value="{{ $lok_kantor->lokasi_kantor }}" id="lokasi_kantor"
                                            class="form-control" name="lokasi_kantor" placeholder="Lokasi Kantor">
                                    </div>
                                </div>
                            </div>
                            {{-- Radius --}}
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-icon mb-3">
                                        <span class="input-icon-addon">
                                            <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="currentColor"
                                                class="icon icon-tabler icons-tabler-filled icon-tabler-radar">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M12 10a2 2 0 0 1 1.678 .911l.053 .089h7.269l.117 .007a1 1 0 0 1 .883 .993c0 5.523 -4.477 10 -10 10a1 1 0 0 1 -1 -1v-7.269l-.089 -.053a2 2 0 0 1 -.906 -1.529l-.005 -.149a2 2 0 0 1 2 -2m9.428 -1.334a1 1 0 0 1 -1.884 .668a8 8 0 1 0 -10.207 10.218a1 1 0 0 1 -.666 1.886a10 10 0 1 1 12.757 -12.772m-4.628 -.266a1 1 0 0 1 -1.6 1.2a4 4 0 1 0 -5.6 5.6a1 1 0 0 1 -1.2 1.6a6 6 0 1 1 8.4 -8.4" />
                                            </svg>
                                        </span>
                                        <input type="text" value="{{ $lok_kantor->radius }}" id="radius"
                                            class="form-control" name="radius" placeholder="Radius Location">
                                    </div>
                                </div>
                            </div>
                            {{-- Button Update --}}
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-primary w-100">
                                        Upadate
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
