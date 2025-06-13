<!-- Form-->

@php
    //    echo '<pre>';
    //    print_r($record);
    //    echo '</pre>';
            $lang = request()->segment(2);
            $id_module= request()->segment(3);
            $query = request()->getQueryString();

@endphp
<form class="needs-validation" role="form" id="form_edit" name="form_edit" action="{{ $url_store.'/'. Auth::id() }}{{ !empty($query) ? '?' . $query : '' }}" method="POST" enctype="multipart/form-data">

    <input type="hidden" id="url_update" name="url_update" value="{{$url_update}}">
    <input type="hidden" id="url_store" name="url_store" value="{{$url_store}}">
    <input type="hidden" id="url_fill_dropdown" name="url_fill_dropdown" value="{{$url_fill_dropdown}}">

    <input type="hidden" id="insertedby" name="insertedby" value="{{$insertedby}}">
    <input type="hidden" id="id_country" name="id_country" value="{{$id_country}}">
    <input type="hidden" id="date" name="date" value="{{$date}}">

    <input type="hidden" id="container" name="container" value="edit-record-day-container">
    <input type="hidden" id="refresh-container" name="refresh-container" value="index-container">
    <input type="hidden" id="refresh-route" name="refresh-route" value="{{ route('refresh-index', ['lang' => $lang,'id_module' => $id_module,'id' => $insertedby]) }}{{ !empty($query) ? '?' . $query : '' }}">

    <input type="hidden" id="query" name="query" value="{{$query}}">


    {{csrf_field()}}
    @method('POST')

    <div class="row">
        <div class="col-md-12  {{ $isHoliday== 1 ? 'nonworking' : 'working' }}">


{{--            <div class="card card card-success card-outline">--}}

{{--                <div class="card-body">--}}
                    {{--=========================================================--}}
                    <div class="row">
                        <div class="col-sm-12 col-md-4 col-lg-5 col-xl-10">
                            <?php
                            $name = 'id_project';
                            $desc = __('records.projects');
                            ?>
                            <label class="text-success" for="{{$name}}" >{{$desc}} *</label>
                            <select class="form-control"
                                    id="{{$name}}" name="{{$name}}"
                                    onchange="fillDropdown('{{ $url_fill_dropdown }}/get-activities/'+encodeURIComponent(this.value)+'/'+{{ Auth::id() }}, 'activities_dropdown');fillDropdown('{{ $url_fill_dropdown }}/get-assignments/'+encodeURIComponent(this.value)+'/{{ Auth::id() }}{{ isset($date) ? '?type=day&date=' . urlencode($date) : '' }}', 'assignments_dropdown')"
                                    style="width: 100%" required>
                                @if(count($projects) > 0)
                                    <option value="">&nbsp;</option>
                                    @foreach($projects as $project)
                                        <option
                                            value="{{$project->id}}"
                                            @if($project->active==0) disabled @endif
                                            style="@if($project->active==0) color: #a0a0a0; @endif"
                                        >{{$project->name}} ({{$project->id}})</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <?php
                            $name = 'duration';
                            $desc = __('records.duration');
                            ?>
                            <div class="form-group">
                                <label for="{{$name}}" class="text-success">{{$desc}} *</label>
                                <select class="form-control" style="width:100%;" id="{{$name}}" name="{{$name}}" required>
                                    <option value="">&nbsp;</option>
                                    @for($i = 1; $i <= 16; $i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    {{--=========================================================--}}
                    <div class="row">
                        <div class="col-sm-12 col-md-4 col-lg-5 col-xl-5">
                            <?php
                            $name = 'id_assignment';
                            $desc = __('records.assignments');
                            ?>
                            <label class="text-success" for="{{$name}}">{{$desc}} *</label>
                            <div id="assignments_dropdown">
                                <select class="form-control" id="{{$name}}" name="{{$name}}" style="width: 100%" required>
                                    @if(count($assignments) > 0)
                                        <option value="">&nbsp;</option>
                                        @foreach($assignments as $assignment)
                                            <option
                                                value="{{$assignment->id}}">{{$assignment->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4 col-lg-5 col-xl-5">
                            <?php
                            $name = 'id_activity';
                            $desc = __('records.activities');
                            ?>
                            <label class="text-success" for="{{$name}}" >{{$desc}} *</label>
                            <div id="activities_dropdown">
                                <select class="form-control"
                                        id="{{$name}}" name="{{$name}}"
                                        style="width: 100%" required>
                                    @if(count($activities) > 0)
                                        <option value="">&nbsp;</option>
                                        @foreach($activities as $activity)
                                            <option
                                                value="{{$activity->id}}">{{$activity->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                    </div>


                    {{--=========================================================--}}
                    <div class="row">
                        <div class="col-sm-10">
                            <?php
                            $name = 'note';
                            $desc = __('records.note');
                            ?>
                            <div class="form-group">
                                <label for="{{$name}}">{{$desc}}</label>
                                <textarea class="form-control" id="{{$name}}" name="{{$name}}" rows="2"
                                          placeholder=""></textarea>
                            </div>
                        </div>
                        <div class="col-sm-2 d-flex justify-content-end align-items-end">
                            <button type="submit"
                                    class="btn btn-submit ajax btn-success float-right mb-3">{{__('records.add_new_record')}}</button>
                        </div>
                    </div>
                    {{--=========================================================--}}

   {{--             </div>
                <!-- /.card-body -->


            </div>
            <!-- /.card -->--}}

        </div>
        <!-- /.col-md-12 -->
    </div>
    <!-- /.row-->
</form>
<!-- /.form -->


@foreach($records as $record)

 {{--   <strong> {{__('records.id_group')}}: </strong> --}}<span class="text-white">{{$record->id_group}}</span>
    @if($record->lockrecord== 1)
        <i class="fas fa-lock text-red"
           title="{{__('records.locked')}}"></i>
    @endif
    <!-- Form-->
    <form class="needs-validation" role="form" id="form_edit" name="form_edit" action="{{$url_update.'/'. $record->id .'/'.Auth::id()}}{{ !empty($query) ? '?' . $query : '' }}" method="POST" enctype="multipart/form-data">


        <input type="hidden" id="url_update" name="url_update" value="{{$url_update}}">
        <input type="hidden" id="url_store" name="url_store" value="{{$url_store}}">
        <input type="hidden" id="url_fill_dropdown" name="url_fill_dropdown" value="{{$url_fill_dropdown}}">

        <input type="hidden" id="insertedby" name="insertedby" value="{{$insertedby}}">
        <input type="hidden" id="id_country" name="id_country" value="{{$id_country}}">
        <input type="hidden" id="date" name="date" value="{{$date}}">

        <input type="hidden" name="container" value="edit-record-day-container">
        <input type="hidden" id="refresh-container" value="index-container">
        <input type="hidden" id="refresh-route" value="{{ route('refresh-index', ['lang' => $lang,'id_module' => $id_module,'id' => $insertedby]) }}{{ !empty($query) ? '?' . $query : '' }}">

        {{csrf_field()}}
        @method('POST')

        <div class="row">
            <div class="col-md-12   {{ $isHoliday== 1 ? 'nonworking' : 'working' }}">

                        {{--=========================================================--}}
                        <div class="row">
                            <div class="col-sm-12 col-md-4 col-lg-5 col-xl-10">
                                    <?php
                                    $name = 'id_project';
                                    $desc = __('records.projects');
                                    ?>
                                <label class="text-red" for="{{$name}}" >{{$desc}} *</label>
                                <select class="form-control"
                                        id="{{$name}}" name="{{$name}}"   @if($record->lockrecord == 1) disabled  @endif
                                        onchange="fillDropdown('{{ $url_fill_dropdown }}/get-activities/'+encodeURIComponent(this.value)+'/'+{{ Auth::id() }}, 'activities_dropdown_{{$record->id }}');
                                    fillDropdown('{{ $url_fill_dropdown }}/get-assignments/'+encodeURIComponent(this.value)+'/'+{{ Auth::id() }}, 'assignments_dropdown_{{$record->id}}')"
                                        style="width: 100%" required>
                                    @if(count($projects) > 0)

                                        @foreach($projects as $project)
                                            <option
                                                value="{{$project->id}}" {{ ($project->id==$record->projects->id)? 'selected' : '' }}
                                            @if($project->active==0) disabled @endif
                                                style="@if($project->active==0) color: #a0a0a0; @endif">
                                            {{$project->name}} {{--({{$project->id}})--}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-sm-2">
                                    <?php
                                    $name = 'duration';
                                    $desc = __('records.duration');
                                    ?>
                                <div class="form-group">
                                    <label for="{{$name}}" class="text-red">{{$desc}} *</label>
                                    <select class="form-control" style="width:100%;" id="{{$name}}" name="{{$name}}" @if($record->lockrecord == 1) disabled  @endif>
                                        <option value=""></option>
                                        <option value="1" {{ ($record->duration==1)? 'selected' : '' }}>1</option>
                                        <option value="2" {{ ($record->duration==2)? 'selected' : '' }}>2</option>
                                        <option value="3" {{ ($record->duration==3)? 'selected' : '' }}>3</option>
                                        <option value="4" {{ ($record->duration==4)? 'selected' : '' }}>4</option>
                                        <option value="5" {{ ($record->duration==5)? 'selected' : '' }}>5</option>
                                        <option value="6" {{ ($record->duration==6)? 'selected' : '' }}>6</option>
                                        <option value="7" {{ ($record->duration==7)? 'selected' : '' }}>7</option>
                                        <option value="8" {{ ($record->duration==8)? 'selected' : '' }}>8</option>
                                        <option value="9" {{ ($record->duration==9)? 'selected' : '' }}>9</option>
                                        <option value="10" {{ ($record->duration==10)? 'selected' : '' }}>10</option>
                                        <option value="11" {{ ($record->duration==11)? 'selected' : '' }}>11</option>
                                        <option value="12" {{ ($record->duration==12)? 'selected' : '' }}>12</option>
                                        <option value="13" {{ ($record->duration==13)? 'selected' : '' }}>13</option>
                                        <option value="14" {{ ($record->duration==14)? 'selected' : '' }}>14</option>
                                        <option value="15" {{ ($record->duration==15)? 'selected' : '' }}>15</option>
                                        <option value="16" {{ ($record->duration==16)? 'selected' : '' }}>16</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{--=========================================================--}}
                        <div class="row">
                            <div class="col-sm-12 col-md-4 col-lg-5 col-xl-5">
                                    <?php
                                    $name = 'id_assignment';
                                    $desc = __('records.assignments');
                                    ?>
                                <label class="text-red" for="{{$name}}">{{$desc}} *</label>
                                <div id="assignments_dropdown_{{$record->id }}">

                                    <select class="form-control" style="width:100%;" id="id_assignment" name="id_assignment" required @if($record->lockrecord == 1) disabled  @endif>

                                        @if(count($record->projects->assignments) > 0)
                                            <option value="">&nbsp;</option>
                                            @foreach($record->projects->assignments as $assignment)
                                                <option value="{{$assignment->id}}" {{ ($assignment->id==$record->assignments->id)? 'selected' : '' }}>
                                                    {{$assignment->name}} ({{$assignment->id}})
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-4 col-lg-5 col-xl-5">
                                    <?php
                                    $name = 'id_activity';
                                    $desc = __('records.activities');
                                    ?>
                                <label class="text-red" for="{{$name}}" >{{$desc}} *</label>
                                <div id="activities_dropdown_{{$record->id }}">
                                    <select class="form-control" @if($record->lockrecord == 1) disabled  @endif
                                            id="{{$name}}" name="{{$name}}"
                                            style="width: 100%" required>
                                        @if(count($record->projects->activities) > 0)
                                            <option value="">&nbsp;</option>
                                            @foreach($record->projects->activities as $activity)
                                                <option
                                                    value="{{$activity->id}}" {{ ($activity->id==$record->activities->id)? 'selected' : '' }}>{{$activity->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                        </div>


                        {{--=========================================================--}}
                        <div class="row">
                            <div class="col-sm-10">
                                    <?php
                                    $name = 'note';
                                    $desc = __('records.note');
                                    ?>
                                <div class="form-group">
                                    <label for="{{$name}}">{{$desc}}</label>
                                    <textarea class="form-control" id="{{$name}}" name="{{$name}}" rows="2" @if($record->lockrecord == 1) readonly  @endif
                                              placeholder="">{{ $record->note }}</textarea>
                                    @if($record->lockrecord == 0)
                                    {!! __('records.notice')!!}
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-2 d-flex justify-content-end align-items-end">
                                @if($record->lockrecord == 0)

                                    <button type="submit"
                                            class="btn btn-submit ajax btn-danger float-right  mb-3">{{__('global.update')}}</button>

                                @endif
                            </div>
                        </div>


                        {{--=========================================================--}}


            </div>
            <!-- /.col-md-12 -->
        </div>
        <!-- /.row-->
    </form>



@endforeach
<style>

    .nonworking {
        background-color: #fbfbd2;
    }

    .working {
        background-color: #f9f9f9;
    }

</style>
