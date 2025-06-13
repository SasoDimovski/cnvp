<?php

$id = $project->id ?? '';
$name = $project->name ?? old('name');
$description = $project->description ?? old('description');
$code = $project->code  ?? old('code');

$start_date = (isset($project->start_date)) ? date("d.m.Y H:i:s", strtotime($project->start_date)) : old('start_date');
$end_date = (isset($project->end_date)) ? date("d.m.Y H:i:s", strtotime($project->end_date)) : old('end_date');

$dateinserted = (isset($project->dateinserted)) ? date("d.m.Y H:i:s", strtotime($project->dateinserted)) : '';
$dateupdated = (isset($project->dateupdated)) ? date("d.m.Y H:i:s", strtotime($project->dateupdated)) : '';

$isExpired = isset($project->end_date) && \Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($project->end_date));

$insertedby = $project->insertedby ?? old('insertedby');
$updatedby = $project->updatedby ?? old('updatedby');

$active = $project->active ?? '';
$type = $project->type ?? '';
?>
<div class="col-12">
    <div class="row invoice-info">
        <div class="col-sm-12 invoice-col" >
            <div class="timeline">
                <!-- timeline time label -->

                <!--   ================================================================================-->
                <div class="time-label">
                    @if($active==0)
                        <span class="bg-gradient-red">{{ __('global.deactivated') }}</span>
                    @else
                        <span class="bg-gradient-success">{{ __('global.active') }}</span>
                    @endif

                        @if($isExpired)
                            <span class="bg-gradient-red">{{ __('global.expired') }}</span>
                        @else
                            <span class="bg-gradient-success">{{ __('global.expired_no') }}</span>
                        @endif

                        @if($type==1)
                            <span class="bg-gradient-info">{{ __('projects.type') }}</span>
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
                            <strong>{{__('projects.name')}}</strong>: {{$name}}
                            <div class="row" style="height: 7px"></div>
                            <strong>{{__('projects.code')}}</strong>: {{$code}}
                            <div class="row" style="height: 7px"></div>
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
                              <strong>{{__('projects.description')}}</strong> <i class="fas fa-comment text-info"></i> :
                            <div class="row" style="height: 7px"></div>
                            {{$description}}
                        </div>
                    </div>
                </div>
                <!--   ================================================================================-->
                <div>
                    <i class="fas fa-list bg-gradient-warning"></i>
                    <div class="timeline-item">
                        <div class="timeline-header">
                            <strong>{{__('projects.activities')}}</strong>:<br><br>
                            @if(count($activitiesAss) > 0)
                                <ul>
                                    @foreach($activitiesAss as $activity)
                                        <li>
                                            <span>{{$activity->name}} </span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
                <!--   ================================================================================-->
                <div>
                    <i class="fas fa-list bg-gradient-warning"></i>
                    <div class="timeline-item">
                        <div class="timeline-header">
                            <strong>{{__('projects.assignments')}}</strong>:<br><br>
                            @if(count($assignments) > 0)
                                <ul>
                                    @foreach($assignments as $assignment)
                                        <li>
                                            <span>{{$assignment->name}} </span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
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




