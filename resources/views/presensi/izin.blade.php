@extends('layouts.presensi')
@section('content')
    <div class="section3" id="user-section3">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="arrow-back-outline"></ion-icon>
        </a>
        <div class="titles">Data Pegajuan Izin</div>
        <div class="row" style="margin-top: 70px">
            <div class="col">
                {{-- Pesan Success Update --}}
                @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif
    
                {{-- Pesan Error Update --}}
                @if (Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="section" id="pengajuan-section">
            <div class="section2" id="menu-section2">
                <h5>Daftar Pengajuan Izin</h5>
                <div id="user-info">
                    <h4 id="user-name" class="mb-0">Anda</h4>
                </div>
                <hr class="divider bg-light">
                
                {{-- <form method="GET" action="/presensi/izin">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <select name="bulan" id="bulan" class="form-control selectmaterialize">
                                    <option value="">Bulan</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">{{ $bln[$i] }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <select name="tahun" id="tahun" class="form-control selectmaterialize">
                                    <option value="">Tahun</option>
                                    @php
                                        $tahun_awal = 2024;
                                        $tahun_sekarang = date ("Y");
                                        for ($t= $tahun_awal; $t <= $tahun_sekarang ; $t++) { 
                                            echo "<option value='$t'>$t</option>" ;
                                        }
                                    @endphp
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-primary w-100">Search</button>
                        </div>
                    </div>
                </form> --}}

                <div class="section mt-1" id="view-section2">
                    <div class="row">
                        <div class="col">
                            <ul class="listviews image-listviews">
                                @foreach ($dataizin as $d)
                                @php
                                if($d->status=="i"){
                                    $status = "Izin";
                                }
                                else if($d->status=="s"){
                                    $status = "Sakit";
                                }
                                elseif ($d->status=="c"){
                                    $status = "Cuti";
                                }
                                elseif ($d->status=="d"){
                                    $status = "Dinas";
                                }
                                else{
                                    $status = "Not Found";
                                }
                                @endphp
                                    <div class="item card_izin" kode_izin ="{{ $d->kode_izin }}" data-toggle="modal" data-target="#actionSheetIconed">
                                        <div class="in">
                                            <div>
                                                {{ date('d-m-Y', strtotime($d->tgl_izin_dari)) }} || {{ date('d-m-Y', strtotime($d->tgl_izin_sampai)) }}
                                                ({{ $status}}) {{ hitunghari($d->tgl_izin_dari, $d->tgl_izin_sampai)}} Hari
                                                <br>
                                                <small class="texts-muted">{{ $d->keterangan }}</small>
                                                <p>
                                                    <span style="color: aqua;">
                                                    @if (!empty($d->doc_sid))
                                                    <u>Lihat File</u>
                                                    @endif
                                                    </span>
                                                </p>
                                            </div>
                                            @if ($d->status_approved == 0)
                                                <span class="badge custom-badge bg-warning">Waiting</span>
                                            @elseif ($d->status_approved == 1)
                                                <span class="badge custom-badge bg-success">Di Setujui</span>
                                            @elseif ($d->status_approved == 2)
                                                <span class="badge custom-badge bg-danger">Decline</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="custom-fab-button bottom-right" style="margin-bottom: 100px">
                <a href="/presensi/buatizin" class="custom-fab">
                    <ion-icon name="add-outline"></ion-icon>
                </a>
            </div>
        </div>
    </div>

    <!-- Modal Pop UP Action -->
 <div class="modal fade action-sheet" id="actionSheetIconed" tabindex="-1" role="dialog">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title">Action</h5>
             </div>
             <div class="modal-body" id="showact">
  
             </div>
         </div>
     </div>
 </div>

 <div class="modal fade dialogbox" id="deleteConfirm" data-backdrop="static" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yakin Dihapus ?</h5>
            </div>
            <div class="modal-body">
                Data Pengajuan Izin Akan dihapus
            </div>
            <div class="modal-footer">
                <div class="btn-inline">
                    <a href="#" class="btn btn-text-secondary" data-dismiss="modal">Batalkan</a>
                    <a href="" class="btn btn-text-primary" id="hapuspengajuan">Hapus</a>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@push('myscript')
<script>
    $(function(){
        $(".card_izin").click(function(e){
            var kode_izin = $(this).attr("kode_izin");
            $("#showact").load('/izin/'+kode_izin+'/showact');
        });
    });
</script>
@endpush
