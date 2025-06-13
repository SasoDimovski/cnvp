@extends('auth::master')
@section('content')
                <div class="hr-top">
                    <div class="hr-top-label"></div>
                </div>
                <label for="tab-1" class="tab">{{config('app.TITLE')}}</label>
                <form action="{{ url('/mfa-post') }}" method="post">
                    @csrf
                    <div class="group">
                        <label for="mfa_code" class="label">{{__('auth.mfa.code_verification_enter')}}</label>
                        <input type="text" class="input" id="mfa_code" name="mfa_code"
                               placeholder="{{__('auth.mfa.code_verification_enter')}}" maxlength="50" autofocus>
                    </div>
                    <div class="line"></div>
                    <div class="group">
                        <input type="submit" class="button" value="{{__('auth.mfa.enter')}}">
                    </div>
                </form>
                    <div class="hr" style="height: 252px">
                        <div class="foot-lnk">
                            <form action="{{ url('/mfa-code-post') }}" method="POST">
                                @csrf
                                <button type="submit" style="color: #aa4e01">{{ __('auth.mfa.generate_code_again') }}</button>
                            </form>
                        </div>
                        @include('auth::_flash-message')
                        @if (count($errors) > 0)
                            @foreach($errors->get('mfa_code') as $error)
                                <div class="alert alert-danger alert-dismissible show error_massage" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                        &times;
                                    </button>
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


@endsection

@section('additional_css')

@endsection

@section('additional_js')
<script>
    $(document).ready(function () {
        // show the alert
        setTimeout(function () {
            $(".alert").alert('close');
        }, 5000);
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
