<!DOCTYPE html>
<?php
$lang = Request::segment(1);
?>
<html lang="{{$lang}}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('head')
    <!-- Favicons -->
    @include('public._header_css')
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-5756323-17"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-5756323-17');
    </script>
</head>
<body>
@include('public._header')


<div class="wrapper">

    <!-- =============================================== -->
{{--@include('admin._header')--}}
{{--@include('admin._menu')--}}
<!-- =============================================== -->


@yield('content')


</div>
<!-- ./wrapper -->
@include('public._footer')
@include('public._header_js')


</body>
</html>
