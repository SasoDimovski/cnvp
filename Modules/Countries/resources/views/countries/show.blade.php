<?php

$id = $country->id ?? '';
$name = $country->name ?? '';
$code_s = $country->code_s ?? '';
$code_l= $country->code_l ?? '';

$created_at = (isset($country->created_at)) ? date("d.m.Y  H:i:s", strtotime($country->created_at)) : '';
$updated_at = (isset($country->updated_at)) ? date("d.m.Y  H:i:s", strtotime($country->updated_at)) : '';

?>
<div class="col-12">
    <div class="row invoice-info">
        <div class="col-sm-12 invoice-col" >
            <div class="timeline">
                <!-- timeline time label -->

                <!--   ================================================================================-->
                <div class="time-label">
                    <span class="bg-gradient-gray" style="margin-top: 3px">  <i class="fas fa-circle text-warning"></i> <strong>{{__('countries.id')}}</strong>: {{ $id }}</span>
                    <span class="bg-gradient-gray" style="margin-top: 3px"><i class="fas fa-clock text-warning"></i> <strong>{{__('countries.created_at')}}</strong>: {{ $created_at}}</span>
                    <span class="bg-gradient-gray" style="margin-top: 3px"> <i class="fas fa-clock text-warning "></i></i> <strong> {{__('countries.updated_at')}}</strong>: {{ $updated_at }}</span>
                </div>
                <!--   ================================================================================-->
                <div>
                    <i class="fas fa-user bg-info"></i>
                    <div class="timeline-item">
                        <div class="timeline-header">
                            <strong>{{__('countries.name')}}</strong>: {{$name}}


                        </div>
                    </div>
                </div>
                <!--   ================================================================================-->
                <div>
                    <i class="fas fa-id-badge bg-gradient-success"></i>
                    <div class="timeline-item">
                        <div class="timeline-header">
                            <strong>{{__('countries.code_s')}}</strong>: {{$code_s}}<br>
                            <hr>
                            <strong>{{__('countries.code_l')}}</strong>: {{$code_l}}<br>

                        </div>
                    </div>
                </div>
                <!--   ================================================================================-->
                @if(count($country->users) > 0)
                <div>
                    <i class="fas fa-users bg-gradient-red"></i>
                    <div class="timeline-item">
                        <div class="timeline-header">
                            <strong>{{__('countries.users')}}</strong>:<br><br>

                                <ul>
                                    @foreach($country->users as $country_)
                                        <li>
                                            <span><strong>{{$country_->name}} {{$country_->surname}}</strong>, id:{{$country_->id}} </span>
                                        </li>
                                    @endforeach
                                </ul>

                        </div>
                    </div>
                </div>
                @endif
                <!--   ================================================================================-->

            </div>
        </div>
    </div>
</div>




