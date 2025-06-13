<?php

$id = $activity->id ?? '';
$name = $activity->name ?? old('name');

$dateinserted = (isset($activity->dateinserted)) ? date("d.m.Y H:i:s", strtotime($activity->dateinserted)) : '';
$dateupdated = (isset($activity->dateupdated)) ? date("d.m.Y H:i:s", strtotime($activity->dateupdated)) : '';
$insertedby = $activity->insertedby ?? old('insertedby');
$updatedby = $activity->updatedby ?? old('updatedby');


$type = $activity->type ?? '';
?>
<div class="col-12">
    <div class="row invoice-info">
        <div class="col-sm-12 invoice-col" >
            <div class="timeline">
                <!-- timeline time label -->

                <!--   ================================================================================-->
                <div class="time-label">
                    @if($type==1)
                        <span class="bg-gradient-info">{{ __('projects.type') }}</span>
                        <br>
                    @endif

                    <span class="bg-gradient-gray" style="margin-top: 3px">  <i class="fas fa-circle text-warning"></i> <strong>{{__('activities.id')}}</strong>: {{ $id }}</span>
                    <span class="bg-gradient-gray" style="margin-top: 3px"><i class="fas fa-clock text-warning"></i> <strong>{{__('activities.dateinserted')}}</strong>: {{ $dateinserted}}</span>
                    <span class="bg-gradient-gray" style="margin-top: 3px"> <i class="fas fa-clock text-warning "></i></i> <strong> {{__('activities.dateupdated')}}</strong>: {{ $dateupdated }}</span>
                </div>
                <!--   ================================================================================-->
                <div>
                    <i class="fas fa-user bg-info"></i>
                    <div class="timeline-item">
                        <div class="timeline-header">
                            <strong>{{__('activities.name')}}</strong>: {{$name}}
                        </div>
                    </div>
                </div>
                <!--   ================================================================================-->
                @if(count($activity->projects) > 0)
                <div>
                    <i class="fas fa-book-open bg-gradient-red"></i>
                    <div class="timeline-item">
                        <div class="timeline-header">
                            <strong>{{__('activities.projects')}}</strong>:<br><br>

                                <ul>
                                    @foreach($activity->projects as $project)
                                        <li>
                                            <span><strong>{{$project->name}}</strong>, id:{{$project->id}} </span>
                                        </li>
                                    @endforeach
                                </ul>

                        </div>
                    </div>
                </div>
                @endif
                <!--   ================================================================================-->
                <div>
                    <i class="fas fa-id-badge bg-gradient-success"></i>
                    <div class="timeline-item">
                        <div class="timeline-header">
                            <strong>{{__('activities.insertedby')}}</strong>: <strong class="text-warning">{{$insertedby_}}</strong> , id: {{$insertedby}}<br>
                            <strong>{{__('activities.updatedby')}}</strong>: <strong class="text-warning">{{$updatedby_}}</strong> , id: {{$updatedby}}

                        </div>
                    </div>
                </div>

                <!--   ================================================================================-->
            </div>
        </div>
    </div>
</div>




