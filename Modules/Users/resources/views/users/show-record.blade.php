<?php
$id_module = $module->id ?? '';

$id =   $record->id ?? '';
$id_country = $record->countries->name?? '';
$project	 = $record->projects->name ?? '';
$assignment = $record->assignments->name ?? '';
$activity = $record->activities->name ?? '';
$duration = $record->duration ?? '';
$year = $record->year ?? '';
$date = (isset($record->date)) ? date("d.m.Y", strtotime($record->date)) : '';
$note = $record->note ?? '';


$insertedby = $record->insertedby  ?? '';
$updatedby = $record->updatedby ?? '';
$approvedby =  $record->approvedby ?? '';

$dateinserted = (isset($record->dateinserted)) ? date("d.m.Y  H:i:s", strtotime($record->dateinserted)) : '';
$dateupdated = (isset($record->dateupdated)) ? date("d.m.Y  H:i:s", strtotime($record->dateupdated)) : '';


$dateofapproval = (isset($record->dateofapproval)) ? date("d.m.Y  H:i:s", strtotime($record->dateofapproval)) : '';

$lockrecord = $record->lockrecord ?? '';
?>
<div class="col-12">
    <div class="row invoice-info">
        <div class="col-sm-12 invoice-col" >
            <div class="timeline">
                <!-- timeline time label -->

                <!--   ================================================================================-->
                <div class="time-label">
                    @if($lockrecord==1)
                        <span class="bg-gradient-red">{{ __('users.records.locked') }}</span>
                    @else
                        <span class="bg-gradient-success">{{ __('users.records.unlocked') }}</span>
                    @endif
                    @if($approvedby)
                        <span class="bg-gradient-success">{{ __('users.records.approved') }}</span>
                    @else
                        <span class="bg-gradient-warning">{{ __('users.records.unapproved') }}</span>
                    @endif

                    <br>
                    <span class="bg-gradient-gray" style="margin-top: 3px">  <i class="fas fa-circle text-warning"></i> <strong>{{__('users.id')}}</strong>: {{ $id }}</span>
                    <span class="bg-gradient-gray" style="margin-top: 3px"><i class="fas fa-clock text-warning"></i> <strong>{{__('users.created_at')}}</strong>: {{ $dateinserted}}</span>
                    <span class="bg-gradient-gray" style="margin-top: 3px"> <i class="fas fa-clock text-warning "></i></i> <strong> {{__('users.updated_at')}}</strong>: {{ $dateupdated }}</span>
                </div>
                <!--   ================================================================================-->
                <div>
                    <i class="fas fa-list bg-gradient-success"></i>
                    <div class="timeline-item">
                        <div class="timeline-header">
                            <strong>{{ __('users.records.duration')}}</strong>:<strong class="text-red"> {{$duration}}</strong>
                            <div class="row" style="height: 7px"></div>
                            <strong>{{ __('users.id_country')}}</strong>: {{$id_country}}
                            <div class="row" style="height: 7px"></div>
                            <strong>{{ __('users.records.year')}}</strong>: {{$year}}
                            <div class="row" style="height: 7px"></div>
                            <strong>{{ __('users.records.date')}}</strong> <i class="fas fa-calendar text-info"></i> : {{ $date }}
                            <div class="row" style="height: 7px"></div>

                            <strong>{{ __('users.records.project')}}</strong>: {{$project}}
                            <div class="row" style="height: 7px"></div>
                            <strong>{{ __('users.records.assignment')}}</strong>: {{$assignment}}
                            <div class="row" style="height: 7px"></div>
                            <strong>{{ __('users.records.activity')}}</strong>: {{$activity}}
                            <div class="row" style="height: 7px"></div>
                            <strong>{{ __('users.records.note')}}</strong>:<br> {{$note}}
                            <div class="row" style="height: 7px"></div>
                            <i class="fas fa-user text-success"></i> <strong>{{ __('users.records.approvedby')}}</strong>:
                            @if($approvedby)
                               {{$record->approvedByUser->name }} {{$record->approvedByUser->surname }} id: {{$record->approvedByUser->id}}
                            @endif
                            <div class="row" style="height: 7px"></div>
                            <strong>{{ __('users.records.dateofapproval')}}</strong> <i class="fas fa-calendar text-info"></i> : {{$dateofapproval}}
                            <div class="row" style="height: 7px"></div>
                            <i class="fas fa-user text-success"></i> <strong>{{ __('users.records.insertedby')}}</strong>:
                            @if($insertedby)
                                 {{$record->insertedByUser->name}} {{$record->insertedByUser->surname}}, id: {{$record->insertedByUser->id}}
                            @endif
                            <div class="row" style="height: 7px"></div>
                            <i class="fas fa-user text-success"></i> <strong>{{ __('users.records.updatedby')}}</strong>:
                            @if($updatedby)
                                {{$record->updatedByUser->name}} {{$record->updatedByUser->surname}} , id: {{$record->updatedByUser->id}}
                            @endif

                        </div>
                    </div>
                </div>

                <!--   ================================================================================-->


                <!--   ================================================================================-->


            </div>
        </div>
    </div>
</div>




