<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <link rel="stylesheet" type="text/css" href="{{ url('app_admin/css/auth/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ url('app_admin/css/auth/style.css')}}">

    <script type="text/javascript" src="{{url('app_admin/js/auth/jquery-3.4.1.min.js')}}"></script>
    <script type="text/javascript" src="{{url('app_admin/js/auth/bootstrap.min.js')}}"></script>

</head>
<body>

    <div>
        <p>{{__('auth.mail-success.hi')}} <strong>{{$name}} {{$surname}}</strong>, </p>
        <p>{{__('auth.mail-success.made')}}</p>
        <p>{{__('auth.mail-success.regards')}}<br><strong>{{config('app.TITLE')}}</strong></p>
        <p><a href="{{config('app.URL')}}">{{config('app.URL')}}</a></p>
    </div>
</body>
</html>
