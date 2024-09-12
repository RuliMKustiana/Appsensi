@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="titles"
                        style="display: flex; flex-direction: column; align-items: center; text-align: center; margin-right: 0%; margin-bottom:20px; margin-top: 19px;">
                        <h1>Profile</h1>
                    </div>
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
                            <div class="d-flex justify-content-between align-items-center">
                                <!-- Left Side: Avatar, Name, Email -->
                                <div class="d-flex flex-column align-items-center">
                                    <div class="avatar2 text-center">
                                        @php
                                            $user = Auth::guard('user')->user();
                                            $defaultPhoto = 'assets/img/nophoto.png';

                                            if (!empty($user->photo) && $user->photo != 'nophoto.png') {
                                                $path = Storage::url('uploads/admin/' . $user->photo);
                                            } else {
                                                $path = asset($defaultPhoto);
                                            }
                                        @endphp
                                        <div class="avatar2">
                                            <img src="{{ url($path) }}" alt="avatar" class="img-fluid rounded-circle">
                                        </div>                                        
                                    </div>
                                    <div class="text-center mt-1">
                                        <span id="user-name-profile"
                                            class="mb-0">{{ Auth::guard('user')->user()->name }}</span>
                                    </div>
                                    <div class="text-center mt-1">
                                        <a href="#" class="btn btn-primary editprofile" id="{{ Auth::guard('user')->user()->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                <path
                                                    d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                <path d="M16 5l3 3" />
                                            </svg>
                                            Edit Profile
                                        </a>
                                    </div>
                                </div>

                                
                                <!-- Right Side: User Information and Button -->
                                <div class="flex-grow-1 ms-4">
                                        <div class="user-info-item d-flex align-items-center mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-id">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z" />
                                                <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                <path d="M15 8l2 0" />
                                                <path d="M15 12l2 0" />
                                                <path d="M7 16l10 0" />
                                            </svg>
                                            <span class="ms-2">{{ Auth::guard('user')->user()->name }}</span>
                                        </div>
                                        <div class="user-info-item d-flex align-items-center mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-briefcase-2">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M3 9a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9z" />
                                                <path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2" />
                                            </svg>
                                            <span class="ms-2">{{ Auth::guard('user')->user()->jabatan }}</span>
                                        </div>
                                        <div class="user-info-item d-flex align-items-center mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-at">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                                <path d="M16 12v1.5a2.5 2.5 0 0 0 5 0v-1.5a9 9 0 1 0 -5.5 8.28" />
                                            </svg>
                                            <span class="ms-2">{{ Auth::guard('user')->user()->email }}</span>
                                        </div>
                                        <div class="user-info-item d-flex align-items-center mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-phone-call">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                                                <path d="M15 7a2 2 0 0 1 2 2" />
                                                <path d="M15 3a6 6 0 0 1 6 6" />
                                            </svg>
                                            <span class="ms-2">{{ Auth::guard('user')->user()->no_handphone }}</span>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Edit Profile Admin --}}
    <div class="modal modal-blur fade" id="modal-editprofileadmin" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="loadeditformprofile">

                </div>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
<script>
    $(function() {
        $(".editprofile").click(function() {
                var id = $(this).attr('id');
                $.ajax({
                    type: 'POST',
                    url: '/presensi/editprofileadmin',
                    cache: false,
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    },
                    success: function(respond) {
                        $("#loadeditformprofile").html(respond);
                    }
                });
                $("#modal-editprofileadmin").modal("show");
            });
    });
</script>
    
@endpush
