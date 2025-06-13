<?php

$id = $assignment->id ?? '';
$name = $assignment->name ?? old('name');
$description = $assignment->description ?? old('description');
$code = $assignment->code  ?? old('code');

$start_date = (isset($assignment->start_date)) ? date("d.m.Y H:i:s", strtotime($assignment->start_date)) : old('start_date');
$end_date = (isset($assignment->end_date)) ? date("d.m.Y H:i:s", strtotime($assignment->end_date)) : old('end_date');

$dateinserted = (isset($assignment->dateinserted)) ? date("d.m.Y H:i:s", strtotime($assignment->dateinserted)) : '';
$dateupdated = (isset($assignment->dateupdated)) ? date("d.m.Y H:i:s", strtotime($assignment->dateupdated)) : '';

$insertedby = $assignment->insertedby ?? old('insertedby');
$updatedby = $assignment->updatedby ?? old('updatedby');

    $isExpired = isset($assignment->end_date) && \Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($assignment->end_date));

?>
<div class="col-12">
    <div class="row invoice-info">
        <div class="col-sm-12 invoice-col" >
            <div class="timeline">
                <!-- timeline time label -->

                <!--   ================================================================================-->
                <div class="time-label">
                    @if($isExpired)
                        <span class="bg-gradient-red">{{ __('global.expired') }}</span>
                    @else
                        <span class="bg-gradient-success">{{ __('global.expired_no') }}</span>
                    @endif

                    <br>
                    <span class="bg-gradient-gray" style="margin-top: 3px">  <i class="fas fa-circle text-warning"></i> <strong>{{__('projects.id')}}</strong>: {{ $id }}</span>
                    <span class="bg-gradient-gray" style="margin-top: 3px"><i class="fas fa-clock text-warning"></i> <strong>{{__('projects.dateinserted')}}</strong>: {{ $dateinserted}}</span>
                    <span class="bg-gradient-gray" style="margin-top: 3px"> <i class="fas fa-clock text-warning "></i></i> <strong> {{__('projects.dateupdated')}}</strong>: {{ $dateupdated }}</span>
                </div>
                <!--   ================================================================================-->
                <div>
                    <i class="fas fa-info bg-info"></i>
                    <div class="timeline-item">
                        <div class="timeline-header">
                            <strong>{{__('projects.assignments_title')}}</strong>: {{$name}}
                            <div class="row" style="height: 7px"></div>
                            <strong>{{__('projects.code')}}</strong>: {{$code}}
                            <div class="row" style="height: 7px"></div>
                            <strong>{{__('projects.start_date')}}</strong>:
                            <strong>{{__('projects.start_date')}}</strong> <i class="fas fa-calendar text-info"></i> :
                            {{--            @php
                                            $dateParts = explode(' ', $start_date);
                                            $date = $dateParts[0];
                                            $time = $dateParts[1] ?? '';
                                        @endphp--}}
                            {{--     <span><strong class="text-danger">{{ $date }}</strong> {{ $time }}</span>--}}
                            <span>{{ $start_date }}</span>
                            <div class="row" style="height: 7px"></div>
                            <strong>{{__('projects.end_date')}}</strong> <i class="fas fa-calendar text-info"></i> :
                            {{--         @php
                                         $dateParts = explode(' ', $end_date);
                                         $date = $dateParts[0];
                                         $time = $dateParts[1] ?? '';
                                     @endphp--}}
                            {{--  <span><strong class="text-danger">{{ $date }}</strong> {{ $time }}</span>--}}
                            <span>{{ $end_date }}</span>
                            <div class="row" style="height: 7px"></div>
                            <strong>{{__('projects.description')}}</strong> <i class="fas fa-comment text-info"></i> : <br>
                            {{$description}}
                        </div>
                    </div>
                </div>
                <!--   ================================================================================-->
                <div>
                    <i class="fas fa-info-circle bg-gradient-success"></i>
                    <div class="timeline-item">
                        <div class="timeline-header">
                            <i class="fas fa-user text-success"></i> <strong>{{__('projects.insertedby')}}</strong>: {{$insertedby_}} , id: {{$insertedby}}<br>
                            <div class="row" style="height: 7px"></div>
                            <i class="fas fa-user text-success"></i> <strong>{{__('projects.updatedby')}}</strong>: {{$updatedby_}} , id: {{$updatedby}}

                        </div>
                    </div>
                </div>

                <!--   ================================================================================-->
            </div>
        </div>
    </div>
</div>




