
<select class="form-control" style="width:100%;" id="id_assignment" name="id_assignment" required>
    <option value="">&nbsp;</option>

    @if(count($assignments) > 0)
        @foreach($assignments as $assignment)
{{--            @php--}}
{{--                $isExpired = \Carbon\Carbon::parse($assignment->end_date)->isPast();--}}
{{--            @endphp--}}
            <option value="{{$assignment->id}}"
{{--                    @if($isExpired) disabled @endif--}}
{{--                    style="@if($isExpired) color: #a0a0a0; @endif"--}}
            >
                {{$assignment->name}} {{--({{$assignment->id}}, {!! date("d.m.Y  H:i:s", strtotime($assignment->end_date))!!})--}}
{{--                @if($isExpired) {{__('records.expired')}} @endif--}}
            </option>
        @endforeach
    @endif
</select>


