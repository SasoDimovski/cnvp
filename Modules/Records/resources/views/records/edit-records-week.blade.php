
<?php
$lang = request()->segment(2);
$url = 'admin/' . $lang . '/' . $module->link;
$url_store = url($url . '/store-records-week');
$url_update = url($url . '/update-records-week');
$url_delete = url($url . '/delete-records-week');
$url_fill_dropdown = url($url);
//$updatedby=app('request')->input('id_user')??Auth::id();
$insertedby=Auth::id();
?>


<div id="edit-record-week-container">
    @include('Records::records._records-week', [
    'url_update' => $url_update,
    'url_store' => $url_store,
    'url_fill_dropdown' => $url_fill_dropdown,
    'insertedby' => $insertedby,
    'id_country' => $id_country,
    'record' => $records,
    'date' => $date,
    ])
</div>


<!-- toastr CSS -->
<link rel="stylesheet" href="{{ url('LTE/plugins/toastr/toastr.min.css')}}">
<!-- Select2 -->
<link rel="stylesheet" href="{{ url('LTE/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ url('LTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

<!-- Select2 -->
<script src="{{url('LTE/plugins/select2/js/select2.full.min.js')}}"></script>
<!-- toastr JS -->
<script src="{{url('LTE/plugins/toastr/toastr.min.js')}}"></script>

<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    })
</script>
