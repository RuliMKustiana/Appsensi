<!-- Custom Bottom Menu -->
<div class="customBottomMenu">
    <a href="/dashboard" class="menuItem {{ request()->is('dashboard') ? 'active' : '' }}">
        <div class="menuCol">
            <ion-icon name="home-outline"></ion-icon>
            <strong>Home</strong>
        </div>
    </a>
    <a href="/presensi/history" class="menuItem {{ request()->is('presensi/history') ? 'active' : '' }}">
        <div class="menuCol">
            <ion-icon name="document-text-outline"></ion-icon>
            <strong>History</strong>
        </div>
    </a>
    <a href="/presensi/create" class="menuItem">
        <div class="menuCol">
            <div class="customActionButton large">
                <ion-icon name="camera"></ion-icon>
            </div>
        </div>
    </a>
    <a href="/presensi/izin" class="menuItem {{ request()->is('presensi/izin') ? 'active' : '' }}">
        <div class="menuCol">
            <ion-icon name="calendar-outline"></ion-icon>
            <strong>Izin</strong>
        </div>
    </a>
    <a href="/profile" class="menuItem {{ request()->is('presensi/profile') ? 'active' : '' }}">
        <div class="menuCol">
            <ion-icon name="people-outline"></ion-icon>
            <strong>Profile</strong>
        </div>
    </a>
</div>
<!-- * Custom Bottom Menu -->
