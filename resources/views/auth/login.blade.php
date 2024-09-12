<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>E-Presensi</title>
    <meta name="description" content="Mobilekit HTML Mobile UI Kit">
    <meta name="keywords" content="bootstrap 4, mobile template, cordova, phonegap, mobile, html" />
    <link rel="icon" type="image/png" href="{{ asset ('assets/img/favicon.png') }}"sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset ('assets/img/icon/192x192.png')}}">
    <link rel="stylesheet" href="{{ asset ('assets/css/style.css') }}">
    <link rel="manifest" href="__manifest.json">
    <style>
        body {
            background-image: url('{{ asset('assets/img/pattern.png') }}');
            background-size: cover; /* or 'contain' */
            background-repeat: repeat; /* or 'no-repeat' */
            background-position: center;
        }
    </style>
</head>
<body class="bg-white">
    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->
    <!-- App Capsule -->
    <div id="appCapsule" class="pt-0">
        <div class="login-form mt-1">
            <div class="section mt-1" id="login-section">
                <img src="{{ asset ('assets/img/login/login.png')}}" alt="image" class="form-image">
                <h3>Badan Pengelolaan Keuangan <br>dan Aset Daerah</h3>
                <h4>Silahkan Login</h4>
                <div class="section mt-1">
                    @php
                    $messagewarning = Session::get('warning');
                    @endphp
                    @if (Session::get('warning'))
                    <div class="alert alert-warning">
                        {{ $messagewarning }}
                    </div>                    
                    @endif                
                    <form action="/proseslogin" method="POST">
                        @csrf
                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <input type="text" name="nip" class="form-control" id="nip" placeholder="ID">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>
                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>
                        <div class="form-links mt-2">
                            <a href="{{ route('to-admin') }}" style="color: brown">Login sebagai Admin</a>
                        </div>
                        <div class="button">
                            <button type="submit" class="btn btn-primary w-100">Log in</button>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
    <!-- * App Capsule -->
    <!-- ///////////// Js Files ////////////////////  -->
    <!-- Jquery -->
    <script src="{{ asset ('assets/js/lib/jquery-3.4.1.min.js') }}"></script>
    <!-- Bootstrap-->
    <script src="{{ asset ('assets/js/lib/popper.min.js') }}"></script>
    <script src="{{ asset ('assets/js/lib/bootstrap.min.js') }}"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.js"></script>
    <!-- Owl Carousel -->
    <script src="{{ asset ('assets/js/plugins/owl-carousel/owl.carousel.min.js') }}"></script>
    <!-- jQuery Circle Progress -->
    <script src="{{ asset ('assets/js/plugins/jquery-circle-progress/circle-progress.min.js') }}"></script>
    <!-- Base Js File -->
    <script src="{{ asset ('assets/js/base.js') }}"></script>
</body>

</html>