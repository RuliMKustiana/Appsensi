@extends('layouts.presensi')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
<style>
    .datepicker-modal {
        max-height: 420px !important;
    }

    .datepicker-date-display {
        background-color: #b71c1c !important;
    }

    .datepicker-date-button {
        background-color: #b71c1c !important;
    }

    .btn-flat.datepicker-cancel.waves-effect {
        color: #b71c1c !important;
    }

    .btn-flat.datepicker-done.waves-effect {
        color: #b71c1c !important;
    }

    .datepicker-table td.is-selected {
        background-color: #b71c1c !important;
    }
</style>
@section('content')
    <div class="section3" id="user-section3">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="arrow-back-outline"></ion-icon>
        </a>
        <div class="titles">Pengajuan</div>
        <div class="sectionizin" id="menu-section4">
            <div class="row">
                <div class="col">
                    <form method="POST" action="/presensi/storeizin" id="frmIzin" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="text" id="tgl_izin_dari" name="tgl_izin_dari" class="form-control datepicker" autocomplete="off"
                                placeholder="Dari">
                        </div>

                        <div class="form-group">
                            <input type="text" id="tgl_izin_sampai" name="tgl_izin_sampai" class="form-control datepicker" autocomplete="off"
                                placeholder="Sampai">
                        </div>

                        <div class="form-group">
                            <input type="text" id="jml_hari" name="jml_hari" class="form-control" autocomplete="off"
                                placeholder="Jumlah Hari" readonly>
                        </div>

                        <div class="form-group">
                            <select name="status" id="status" class="form-control">
                                <option value="i">Izin</option>
                                <option value="s">Sakit</option>
                                <option value="c">Cuti</option>
                                <option value="d">Dinas</option>
                            </select>
                        </div>

                        <div class="custom-file-upload" id="fileUpload1" style="height: 100px !important">
                            <input type="file" name="sid" id="fileuploadInput" accept=".png, .jpg, .jpeg, .pdf">
                            <label for="fileuploadInput">
                                <span>
                                    <strong>
                                        <ion-icon name="cloud-upload-outline" role="img" class="md hydrated"
                                        aria-label="cloud upload outline"></ion-icon>
                                        <i>Tap to upload SID</i>
                                    </strong>
                                </span>
                            </label>
                        </div>

                        </div>
                        <div class="form-group">
                            <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control" style="margin-top: 15px;" placeholder="Keterangan"></textarea>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary w-100">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('myscript')
    <script>
        var currYear = (new Date()).getFullYear();

        $(document).ready(function() {
            $(".datepicker").datepicker({

                format: "yyyy-mm-dd"
            });


            function loadjumlahhari(){
                var dari = $("#tgl_izin_dari").val();
                var sampai = $("#tgl_izin_sampai").val();
                var date1 = new Date(dari);
                var date2 = new Date(sampai);

                // to calculate the time differences of two dates
                var Difference_In_Time = date2.getTime() - date1.getTime();

                // to calculate the no. of days between two dates
                var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);

                if(dari == "" || sampai == ""){
                    var jmlhari = 0;
                }
                else{
                    var jmlhari = Difference_In_Days + 1;
                }
                // to display the final no. of days (result)
                $("#jml_hari").val(jmlhari + " Hari");
            }
            $("#tgl_izin_dari, #tgl_izin_sampai").change(function(e){
                loadjumlahhari();
            })


            // $("#tgl_izin").change(function(e) {
            //     var tgl_izin = $(this).val();
            //     $.ajax({
            //         type: 'POST',
            //         url: '/presensi/cekpengajuanizin',
            //         data: {
            //             _token: "{{ csrf_token() }}",
            //             tgl_izin: tgl_izin
            //         },
            //         cache: false,
            //         success: function(respond) {
            //             if (respond == 1) {
            //                 Swal.fire({
            //                     title: 'Oopss!',
            //                     text: 'Anda sudah melakukan pengajuan pada tanggal tersebut!!',
            //                     icon: 'warning'
            //                 }).then((result) => {
            //                     // Setelah user mengklik OK pada alert, kosongkan input tanggal
            //                     $("#tgl_izin").val("");
            //                 });
            //             }
            //         }
            //     });
            // });



            $("#frmIzin").submit(function() {
                var tgl_izin_dari = $("#tgl_izin_dari").val();
                var tgl_izin_sampai = $("#tgl_izin_sampai").val();
                var status = $("#status").val();
                var keterangan = $("#keterangan").val();
                if (tgl_izin_dari == "" || tgl_izin_sampai == "") {
                    Swal.fire({
                        title: 'Oopss !',
                        text: 'Tanggal Harus Diisi',
                        icon: 'warning'
                    });
                    return false;
                } else if (status == "") {
                    Swal.fire({
                        title: 'Oopss !',
                        text: 'Status Harus Diisi',
                        icon: 'warning'
                    });
                    return false;
                } else if (keterangan == "") {
                    Swal.fire({
                        title: 'Oopss !',
                        text: 'Keterangan Harus Diisi',
                        icon: 'warning'
                    });
                    return false;
                }
            });
        });
    </script>
@endpush
