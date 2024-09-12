@if ($history->isEmpty())
    <div class="alert alert-outline-warning">
        <p>Data Belum Ada</p>
    </div>
@endif
@foreach ($history as $d)
<ul class="listviews image-listview">
    <li>
        <div class="item">
            @php
                $path = Storage::url('uploads/absensi/'.$d->foto_in);
            @endphp
            <img src="{{ url($path) }}" alt="image" class="image">
            <div class="in">
                <div>
                    {{ date("d-m-Y", strtotime($d->tgl_presensi)) }} <br>
                    {{-- <small class="text-muted">{{ $d->unit_kerja }}</small> --}}
                </div>
                <span class="badge {{ $d->jam_in < '09:00' ? 'bg-success' : 'bg-danger' }}">
                    {{ $d->jam_in < '09:00' ? 'Absen' : 'No Absen' }}
                </span>
                @if($d->jam_out)
                    <span class="badge bg-secondary">absen</span>
                @else
                    <span class="badge bg-warning">absen?</span>
                @endif
            </div>
        </div>        
    </li>
</ul>
@endforeach