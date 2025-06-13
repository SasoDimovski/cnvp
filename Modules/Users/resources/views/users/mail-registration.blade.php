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
        <p>{!! __('users.mail-registration.hi')!!} <strong>{!!$name!!} {!!$surname!!}</strong>,<p>
        {!!__('users.mail-registration.made')!!} <strong>{!!config('app.TITLE')!!}</strong><br>
         {!!__('users.mail-registration.username')!!} <strong>{!!$username!!}</strong><br>
         {!!__('users.mail-registration.link')!!} <a href="{!!$url!!}">{!!$url!!}</a><p>
        <p> {!!__('users.mail-registration.note')!!}<br>
        {!!__('users.mail-registration.expire',['name'=>config('auth.registration_link')])!!}<p>
         <p>{!!__('users.mail-registration.link_app')!!} <a href="{!!config('app.URL')!!}">{!!config('app.URL')!!}</a></p>
        <p>{!!__('users.mail-registration.regards')!!}<br><strong>{!!config('app.TITLE')!!}</strong></p>

    </div>
</body>

</html>
