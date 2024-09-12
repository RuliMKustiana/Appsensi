<?php

function hitunghari($tanggal_mulai, $tanggal_akhir){
$tanggal_1 = date_create($tanggal_mulai);
$tanggal_2= date_create($tanggal_akhir);
$diff = date_diff($tanggal_1, $tanggal_2);

return $diff->days+1;
}
 
function buatkode($nomor_terakhir, $kunci, $jumlah_karakter = 0)
{
    /* mencari nomor baru dengan memecah nomor terakhir dan menambahkan 1
    string nomor baru dibawah ini harus dengan format XXX000000
    untuk penggunaan dalam format lain anda harus menyesuaikan sendiri */
    $nomor_baru = intval(substr($nomor_terakhir, strlen($kunci))) + 1;
    //    menambahkan nol didepan nomor baru sesuai panjang jumlah karakter
    $nomor_baru_plus_nol = str_pad($nomor_baru, $jumlah_karakter, "0", STR_PAD_LEFT);
    //    menyusun kunci dan nomor baru
    $kode = $kunci . $nomor_baru_plus_nol;
    return $kode;
}


function selisih($jam_masuk, $jam_pulang)
{
    // Check if both inputs have the correct format
    if (strpos($jam_masuk, ':') === false || strpos($jam_pulang, ':') === false) {
        return 'Invalid time format';
    }

    // Ensure the time strings are split correctly
    $waktuMasuk = explode(':', $jam_masuk);
    $waktuPulang = explode(':', $jam_pulang);

    // Validate that both times have hour, minute, and second components
    if (count($waktuMasuk) < 3 || count($waktuPulang) < 3) {
        return 'Incomplete time data';
    }

    [$h1, $m1, $s1] = $waktuMasuk;
    [$h2, $m2, $s2] = $waktuPulang;

    // Convert to timestamps
    $dtAwal = mktime($h1, $m1, $s1, 1, 1, 1);
    $dtAkhir = mktime($h2, $m2, $s2, 1, 1, 1);

    // Calculate the difference in seconds
    $dtSelisih = $dtAkhir - $dtAwal;

    // Convert to minutes
    $totalmenit = $dtSelisih / 60;
    $jam = floor($totalmenit / 60);
    $sisamenit = $totalmenit % 60;

    // Return the difference in 'hours:minutes' format
    return $jam . ':' . round($sisamenit);
}

