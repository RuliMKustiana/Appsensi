<!-- Action List Button -->

<ul class="action-button-list">
    <li>
        <a href="#" id="deletebutton" class="btn btn-list text-danger" data-dismiss="modal" data-toggle="modal" data-target="#deleteConfirm">
            <span>
                <ion-icon name="trash-outline"></ion-icon>
                Delete
            </span>
        </a>
    </li>
</ul>

<script>
    $(function(){
        $("#deletebutton").click(function(e){
            $("#hapuspengajuan").attr('href','/izin/'+'{{ $dataizin->kode_izin }}/delete');
        })
    });
</script>