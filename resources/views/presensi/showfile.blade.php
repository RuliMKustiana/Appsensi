@if($presensi && $presensi->doc_sid)
    <iframe src="{{ Storage::url('uploads/sid/' . $presensi->doc_sid) }}" width="100%" height="500px"></iframe>
@else
    <p>Document ID tidak ditemukan.</p>
@endif