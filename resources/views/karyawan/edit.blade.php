<form action="/karyawan/{{ $karyawan->nip }}/update" method="POST" id="frmKaryawan" enctype="multipart/form-data">
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
                <input type="text" readonly value="{{ $karyawan->nip }}" id="nip" class="form-control"
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
                <input type="text" value="{{ $karyawan->nama_lengkap }}" id="nama_lengkap" class="form-control"
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
                <input type="text" value="{{ $karyawan->no_hp }}" id="no_hp" class="form-control"
                    name="no_hp" placeholder="No. HP">
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <div class="form-label">Add Photo</div>
            <input type="file" name="foto" class="form-control">
            <input type="hidden" name="old_foto" value="{{ $karyawan->foto }}">
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
                        <option {{ $karyawan->kode_unit == $d->kode_unit ? 'selected' : '' }}
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
                    <button class="btn btn-primary w-100">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>