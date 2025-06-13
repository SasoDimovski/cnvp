@if (Session::has('success'))
<div class="alert alert-success alert-dismissible show error_massage" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
 {!! Session::get('success') !!}
</div>
@endif

{{--@if (Session::has('error'))--}}
{{--<div class="alert alert-danger alert-dismissible show error_massage" role="alert" >--}}
{{--    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>--}}
{{-- {!! Session::get('error') !!}--}}
{{--</div>--}}
{{--@endif--}}

@if (Session::has('error'))
    <div class="alert alert-danger alert-dismissible show error_massage" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        @if (is_array(Session::get('error')))
                @foreach (Session::get('error') as $message)
                    {!! $message !!}<br>
                @endforeach
        @else
            {!! Session::get('error') !!}
        @endif
    </div>
@endif


@if (Session::has('warning'))
<div class="alert alert-warning alert-dismissible show error_massage" role="alert" >
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
 {!! Session::get('warning') !!}
</div>
@endif

@if (Session::has('info'))
    <div class="alert alert-info alert-dismissible show error_massage" role="alert" >
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
     {!! Session::get('info') !!}
    </div>
@endif

