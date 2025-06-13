@extends('auth::master')
@section('content')
                <div class="hr-top" >
                    <div class="hr-top-label" >{!!__('auth.mfa-code.verification')!!}</div>
                </div>
                <label for="tab-1" class="tab">{{config('app.TITLE')}}</label>
                <form action="{{ url('/mfa-code-post') }}" method="post">
                    @csrf
                    <div class="group">
                        <label for="password" class="label">{{__('auth.mfa-code.email_for_verification')}}</label>
                        <input type="text" class="input" id="mfa_code" name="mfa_code" placeholder="" value="{{$email}}" maxlength="60" required disabled>
                    </div>
                    <div class="line"></div>
                    <div class="group">
                        <input type="submit" class="button" value="{{__('auth.mfa-code.generate')}}">
                    </div>

                    <div class="foot-lnk">

                    </div>

                    <div class="hr" style="height: 242px">
                        @include('auth::_flash-message')
                        @if (count($errors) > 0)
                            @foreach($errors->get('email') as $error)
                            <div class="alert alert-danger alert-dismissible show error_massage" role="alert" >
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
                        echo " (v. " . phpversion().")" ; ?>
                    </div>

                </form>

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

