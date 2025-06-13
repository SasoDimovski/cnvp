<!DOCTYPE html>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <title>{{config('app.TITLE_HEADER')}}</title>
    <link rel="shortcut icon" type="image/png" href="/uploads/_images/favicon.png">
    <link rel="icon" type="image/png" href="/uploads/_images/favicon.png" />
    @include('auth::_header_css')
    @yield('additional_css')
</head>

<body>

<div class="login-wrap">
    <div class="login-html">
        <div class="login-form">
            <div class="sign-in-htm">




@yield('content')




            </div>
        </div>
    </div>
</div>

@include('auth::_header_js')
@yield('additional_js')

</body>
</html>
