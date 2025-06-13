@php
    $date = request()->query('date');
    $type = request()->query('type');
    $year = request()->query('year');
@endphp

<select class="form-control" style="width:100%;" id="id_assignment" name="id_assignment" required>
    <option value="">&nbsp;</option>


    @if(count($assignments) > 0)
        @foreach($assignments as $assignment)
            @php
                $endDate = \Carbon\Carbon::parse($assignment->end_date);
                $hide = false;

                if (($type === 'day' || $type === 'week') && $date) {
                    $compareDate = \Carbon\Carbon::parse($date);
                    if ($endDate->lt($compareDate)) {
                        $hide = true;
                    }
                }

                if ($type === 'day-table' && $year) {
                    $assignmentYear = $endDate->year;
                    if ($assignmentYear < intval($year)) {
                        $hide = true;
                    }
                }

                if ($hide) {
                    continue;
                }
            @endphp
            <option value="{{ $assignment->id }}">
                {{ $assignment->name }},
                {{ $endDate->format('d.m.Y') }}
            </option>
        @endforeach
        @endif








{{--    @if(count($assignments) > 0)--}}
{{--        @foreach($assignments as $assignment)--}}
{{--            @php--}}
{{--                $endDate = \Carbon\Carbon::parse($assignment->end_date);--}}
{{--                $disable = false;--}}
{{--                $style = '';--}}
{{--                $label = '';--}}

{{--                if (($type === 'day'||$type === 'week') && $date) {--}}
{{--                    $compareDate = \Carbon\Carbon::parse($date);--}}
{{--                    if ($endDate->lt($compareDate)) {--}}
{{--                        $disable = true;--}}
{{--                        $style = 'color: #a0a0a0;';--}}
{{--                        $label = __('records.expired');--}}
{{--                    }--}}
{{--                }--}}

{{--               if ($type === 'day-table' && $year) {--}}
{{--                $assignmentYear = $endDate->year;--}}
{{--                if ($assignmentYear < intval($year)) {--}}
{{--                    $disable = true;--}}
{{--                    $style = 'color: #a0a0a0;';--}}
{{--                    $label = __('records.expired');--}}
{{--                }--}}
{{--            }--}}

{{--            @endphp--}}
{{--            <option value="{{ $assignment->id }}"--}}
{{--                    @if($disable) disabled @endif--}}
{{--                    style="{{ $style }}">--}}
{{--                {{ $assignment->name }},--}}
{{--                --}}{{--                {{ $assignment->id }},--}}
{{--                {{ $endDate->format('d.m.Y') }}--}}
{{--                @if($label)--}}
{{--                    ({{ $label }})--}}
{{--                @endif--}}
{{--            </option>--}}
{{--        @endforeach--}}
{{--    @endif--}}













</select>
