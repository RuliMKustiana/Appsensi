@extends('layouts.presensi')
@section('content')
<div class="section3" id="user-section3">
    <a href="javascript:;" class="headerButton goBack">
        <ion-icon name="arrow-back-outline"></ion-icon>
    </a>
    <div class="titles">History</div>
</div>
    <div class="section mt-1" id="history-section">
        <div class="row" style="margin-top: 20px">
            <div class="col">
                {{-- bulan --}}
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <select name="bulan" id="bulan" class="form-control">
                                <option value="">Bulan</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value = "{{ $i }}" {{ date('m') == $i ? 'selected' : '' }}>
                                        {{ $bln[$i] }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
                {{-- tahun --}}
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <select name="tahun" id="tahun" class="form-control">
                                <option value="">Tahun</option>
                                @php
                                    $tahunmulai = 2024;
                                    $tahunskrg = date('Y');
                                @endphp
                                @for ($tahun = $tahunmulai; $tahun <= $tahunskrg; $tahun++)
                                    <option value="{{ $tahun }}" {{ date('Y') == $tahun ? 'selected' : '' }}>
                                        {{ $tahun }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
                {{-- button --}}
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" id="getdata">
                                <ion-icon name="search"></ion-icon>
                                Search
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="row">
                <div class="col" id="showhistory"></div>
            </div>
    </div>
@endsection

@push('myscript')
    <script>
        $(function() {
            $("#getdata").click(function(e) {
                var bulan = $("#bulan").val();
                var tahun = $("#tahun").val();
                $.ajax({
                    type: 'POST',
                    url: '/gethistory',
                    data: {
                        _token: "{{ csrf_token() }}",
                        bulan: bulan,
                        tahun: tahun
                    },
                    cache: false,
                    success: function(respond) {
                        $("#showhistory").html(respond);
                    }
                });
            });
        });
    </script>
@endpush
