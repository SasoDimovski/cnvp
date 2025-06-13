<!DOCTYPE html>
<html>


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{config('app.TITLE_HEADER')}}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="/uploads/_images/favicon.png">
    <link rel="icon" type="image/png" href="/uploads/_images/favicon.png" />
    @include('admin._header_css')
    @yield('additional_css')
</head>



<body class="hold-transition sidebar-mini layout-fixed text-sm">

<!-- ModalWarning =============================================================================================================================== -->
@include('admin._include-modals.modal-warning')
<!-- ModalRestrictions=============================================================================================================================== -->
@include('admin._include-modals.modal-restrictions')
<!-- ModalRestrictions=============================================================================================================================== -->
@include('admin._include-modals.modal-show')
<!-- ModalRestrictions=============================================================================================================================== -->
@include('admin._include-modals.modal-image')
<!-- ModalDocuments=============================================================================================================================== -->
@include('admin._include-modals.modal-document')

<div class="wrapper">

<!-- =============================================== -->
@include('admin._header')
@include('admin._modules')
<!-- =============================================== -->


@yield('content')


<!-- =============================================== -->
@include('admin._footer')
<!-- =============================================== -->


</div>
<!-- ./wrapper -->

@include('admin._header_js')
@yield('additional_js')

</body>
</html>
