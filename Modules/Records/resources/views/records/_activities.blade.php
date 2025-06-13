<select class="form-control" style="width:100%;" id="id_activity" name="id_activity" required>
    <option value="">&nbsp;</option>
    @if(count($activities) > 0)

        @foreach($activities as $activity)

            <option value="{{$activity->id}}">{{$activity->name}} ({{$activity->id}})</option>
        @endforeach
    @endif
</select>
