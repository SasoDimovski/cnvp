@extends('auth::master')
@section('content')

    <div class="hr-top">
        <div class="hr-top-label"></div>
    </div>
    <label for="tab-1" class="tab">{{config('app.TITLE')}}</label>
    <form action="{{ url('/login-post') }}" method="post">
        @csrf
        <div class="group">
            <label for="username" class="label">{{__('auth.login.username')}}

            </label>
            <input id="username" name="username" type="text" class="input" value="{{ old('username')}}" maxlength="50">
        </div>
        <div class="group">
            <label for="password" class="label">{{__('auth.login.password')}}
            </label>
            <input id="password" name="password" type="password" class="input" data-type="password" maxlength="50">
            <div class="label" style="width: 100%;text-align: right;" id="toggle_img"><img
                    src="/auth/images/eye-close.png" style="cursor: pointer;" id="toggle"
                    onclick="toggleSwap()"
                    title="{{__('auth.login.toggle')}}"
                ></div>
        </div>
        <div class="group">
            <input type="submit" class="button" value="{{__('auth.login.login')}}">
        </div>

        <div class="hr">
            <div class="foot-lnk">
                <a href="{{ url('/forgotten-email') }}">{{__('auth.login.forget')}}</a>
            </div>
            @include('auth::_flash-message')
            @if (count($errors) > 0)
                @foreach($errors->get('username') as $error)
                    <div class="alert alert-danger alert-dismissible show error_massage" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {!!$error !!}
                    </div>
                @endforeach
                @foreach($errors->get('password') as $error)
                    <div class="alert alert-danger alert-dismissible show error_massage" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {!! $error !!}
                    </div>
                @endforeach
            @endif
        </div>
        <div class="footer">
            {{__('global.developed_by')}}
            <a href="{{config('app.DEVELOPED_LINK')}}" target="_blank"
               class="footer_link">{{config('app.DEVELOPED')}}</a>
            <?php
            echo " (v. " . phpversion() . ")"; ?>
        </div>
    </form>

@endsection

@section('additional_css')

@endsection

@section('additional_js')

    <script>
        ////////////////////////////////////////////////////////////////////////
        $(document).ready(function () {
            // show the alert
            setTimeout(function () {
                $(".alert").alert('close');
            }, 5000);
        });
        ////////////////////////////////////////////////////////////////////////
        // Query the elements
        const passwordEle = document.getElementById('password');
        const toggleEle = document.getElementById('toggle');

        toggleEle.addEventListener('click', function () {
            const type = passwordEle.getAttribute('type');

            passwordEle.setAttribute(
                'type',
                // Switch it to a text field if it's a password field
                // currently, and vice versa
                type === 'password' ? 'text' : 'password'
            );
        });
        ////////////////////////////////////////////////////////////////////////
        window.setInterval('refresh()', 100000); 	// Call a function every 10000 milliseconds (OR 10 seconds).
        // Refresh or reload page.
        function refresh() {
            window.location.reload();
        }

        ////////////////////////////////////////////////////////////////////////
    </script>
@endsection
