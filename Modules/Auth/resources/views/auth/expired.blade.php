@extends('auth::master')

@section('content')
                <div class="hr-top" >
                    <div class="hr-top-label" >{!! __('auth.expired.lending')!!}</div>
                </div>
                <label for="tab-1" class="tab">{{config('app.TITLE')}}</label>
                <form action="{{ url('/expired-post') }}" method="post">
                    @csrf
                    <input type="hidden" id="hash" name="hash" value="{{$hash}}">
                    <div class="group" >
                        <label for="password" class="label">{{__('auth.expired.old_password')}}</label>
                        <input type="password" class="input" id="password" name="password" maxlength="30" placeholder="">
                    </div>
                    <div class="group" >
                        <label for="new-password" class="label">{{__('auth.expired.new_password')}}</label>
                        <input type="password" class="input" id="new-password" name="new-password" maxlength="30" placeholder="">
                    </div>
                    <div class="group" >
                        <label for="confirm-password" class="label">{{__('auth.expired.confirm_new_password')}}</label>
                        <input type="password" class="input" id="confirm-password" name="confirm-password" maxlength="30">
                        <div class="label" style="width: 100%;text-align: right;" id="toggle_img"><img
                                src="/auth/images/eye-close.png" style="cursor: pointer;" id="toggle"
                                onclick="toggleSwap()"
                                title="{{__('auth.expired.toggle')}}"
                            ></div>
                    </div>
                    <div class="group" style="margin-bottom: 0!important;">
                        <input type="submit" class="button" value="{{__('auth.expired.enter')}}">
                    </div>

                    <div class="hr" style="height: 85px">

                    @include('auth::_flash-message')
                    @if (count($errors) > 0)
                            @foreach($errors->get('password') as $error)
                                <div class="alert alert-danger alert-dismissible show error_massage" role="alert" >
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    {!!$error !!}
                                </div>
                            @endforeach
                        @foreach($errors->get('new-password') as $error)
                            <div class="alert alert-danger alert-dismissible show error_massage" role="alert" >
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {!!$error !!}
                            </div>
                        @endforeach
                        @foreach($errors->get('confirm-password') as $error)
                            <div class="alert alert-danger alert-dismissible show error_massage" role="alert" >
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {!!$error !!}
                            </div>
                @endforeach
                @endif
                    </div>
                    <div class="footer">
                        {{__('global.developed_by')}}
                        <a href="{{config('app.DEVELOPED_LINK')}}" target="_blank"
                           class="footer_link">{{config('app.DEVELOPED')}}</a>
                            <?php
                            echo " (v. " . phpversion().")" ; ?>
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
    const passwordEle1 = document.getElementById('new-password');
    const passwordEle2 = document.getElementById('confirm-password');
    const toggleEle = document.getElementById('toggle');
    toggleEle.addEventListener('click', function () {
        const type = passwordEle.getAttribute('type');
        passwordEle.setAttribute(
            'type',
            type === 'password' ? 'text' : 'password'
        );
        const type1 = passwordEle1.getAttribute('type');
        passwordEle1.setAttribute(
            'type',
            type1 === 'password' ? 'text' : 'password'
        );
        const type2 = passwordEle2.getAttribute('type');
        passwordEle2.setAttribute(
            'type',
            type2 === 'password' ? 'text' : 'password'
        );
    });
    ////////////////////////////////////////////////////////////////////////
    window.setInterval('refresh()', 100000); 	// Call a function every 10000 milliseconds (OR 10 seconds).
    // Refresh or reload page.
    function refresh() {
        window .location.reload();
    }
    ////////////////////////////////////////////////////////////////////////
</script>
@endsection
