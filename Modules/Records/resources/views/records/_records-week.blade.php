<!-- Form-->

@php

            $lang = request()->segment(2);
            $id_module= request()->segment(3);
            $query = request()->getQueryString();

                // Внесената дата (на пример: 29.3.2025)
                $inputDate = $date;

                // Конвертирај ја датата во timestamp
                $timestamp = strtotime($inputDate);

                // Пресметај го почетокот на неделата (понеделник)
                $startOfWeek = strtotime('last monday', $timestamp);
                if (date('N', $timestamp) == 1) { // Ако е понеделник, нема потреба од "last monday"
                    $startOfWeek = $timestamp;
                }

                // Креирај низи за деновите од неделата
                $daysOfWeek = [];
                $datesOfDaysOfWeek = [];
                $dayMonthOfDaysOfWeek = [];
                for ($i = 0; $i < 7; $i++) {
                    $currentTimestamp = strtotime("+$i day", $startOfWeek);
                    $daysOfWeek[date('D', $currentTimestamp)] = strtolower(date('D', $currentTimestamp). ' ' . date('d.m.Y', $currentTimestamp) );
                    $datesOfDaysOfWeek[date('D', $currentTimestamp)] = date('Y-m-d', $currentTimestamp) ;
                    $dayMonthOfDaysOfWeek[date('D', $currentTimestamp)] = date('d.m', $currentTimestamp) ;
                }

                // Извлечи ги променливите
                $mon = $daysOfWeek['Mon'];
                $tue = $daysOfWeek['Tue'];
                $wed = $daysOfWeek['Wed'];
                $thu = $daysOfWeek['Thu'];
                $fri = $daysOfWeek['Fri'];
                $sat = $daysOfWeek['Sat'];
                $sun = $daysOfWeek['Sun'];

                $monDate = $datesOfDaysOfWeek['Mon'];
                $tueDate  = $datesOfDaysOfWeek['Tue'];
                $wedDate  = $datesOfDaysOfWeek['Wed'];
                $thuDate  = $datesOfDaysOfWeek['Thu'];
                $friDate  = $datesOfDaysOfWeek['Fri'];
                $satDate  = $datesOfDaysOfWeek['Sat'];
                $sunDate = $datesOfDaysOfWeek['Sun'];

                $monDayMonth = $dayMonthOfDaysOfWeek['Mon'];
                $tueDayMonth  = $dayMonthOfDaysOfWeek['Tue'];
                $wedDayMonth   = $dayMonthOfDaysOfWeek['Wed'];
                $thuDayMonth  = $dayMonthOfDaysOfWeek['Thu'];
                $friDayMonth   = $dayMonthOfDaysOfWeek['Fri'];
                $satDayMonth   = $dayMonthOfDaysOfWeek['Sat'];
                $sunDayMonth  = $dayMonthOfDaysOfWeek['Sun'];

//                     echo '<pre>';
//        print_r($nonWorkingDays);
//        echo '</pre>';

@endphp
<form class="needs-validation" role="form" id="form_edit" name="form_edit" action="{{ $url_store.'/'. Auth::id() }}{{ !empty($query) ? '?' . $query : '' }}"
      method="POST" enctype="multipart/form-data">

    <input type="hidden" id="url_update" name="url_update" value="{{$url_update}}">
    <input type="hidden" id="url_store" name="url_store" value="{{$url_store}}">
    <input type="hidden" id="url_fill_dropdown" name="url_fill_dropdown" value="{{$url_fill_dropdown}}">

    <input type="hidden" id="insertedby" name="insertedby" value="{{$insertedby}}">
    <input type="hidden" id="id_country" name="id_country" value="{{$id_country}}">
    <input type="hidden" id="date" name="date" value="{{$date}}">

    <input type="hidden" name="container" value="edit-record-week-container">
    <input type="hidden" id="refresh-container" value="index-container">
    <input type="hidden" id="refresh-route"
           value="{{ route('refresh-index', ['lang' => $lang,'id_module' => $id_module,'id' => $insertedby]) }}{{ !empty($query) ? '?' . $query : '' }}">

    {{csrf_field()}}
    @method('POST')

    <div class="row">
        <div class="col-md-12">

            <div class="row">

                <div class="col-md-4">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <?php
                        $name = 'id_project';
                        $desc = __('records.projects');
                        ?>

                        <label class="text-success" for="{{$name}}">{{$desc}} *</label>
                        <select class="form-control"
                                id="{{$name}}" name="{{$name}}"
                                onchange="fillDropdown('{{ $url_fill_dropdown }}/get-activities/'+encodeURIComponent(this.value)+'/'+{{ Auth::id() }}, 'activities_dropdown');
                                    fillDropdown('{{ $url_fill_dropdown }}/get-assignments/'+encodeURIComponent(this.value)+'/{{ Auth::id() }}{{ isset($date) ? '?type=week&date=' . urlencode($date) : '' }}', 'assignments_dropdown')"
                                style="width: 100%" required placeholder="{{$desc}}">
                            @if(count($projects) > 0)
                                <option value="0">&nbsp;</option>
                                @foreach($projects as $project)
                                    <option
                                        value="{{$project->id}}"
                                        @if($project->active==0) disabled @endif
                                        style="@if($project->active==0) color: #a0a0a0; @endif">

                                        {{$project->name}}  @if($project->active==0)
                                            / {{__('records.inactive')}}
                                        @endif{{--({{$project->id}})--}}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <?php
                        $name = 'id_assignment';
                        $desc = __('records.assignments');
                        ?>
                        <label class="text-success" for="{{$name}}">{{$desc}} *</label>
                        <div id="assignments_dropdown">
                            <select class="form-control" id="{{$name}}" name="{{$name}}" style="width: 100%"
                                    required>
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
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <?php
                        $name = 'id_activity';
                        $desc = __('records.activities');
                        ?>
                        <label class="text-success" for="{{$name}}">{{$desc}} *</label>
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

                <div class="col-md-8">
                    <div class="row text-center">
                        @foreach([$monDayMonth => $monDate, $tueDayMonth => $tueDate, $wedDayMonth => $wedDate, $thuDayMonth => $thuDate, $friDayMonth => $friDate, $satDayMonth => $satDate, $sunDayMonth  => $sunDate] as $day => $date)
                            @php
                                $style = ( in_array($date, $nonWorkingDays)) ? 'nonworking' : '';
                            @endphp
                            <div class="col-lg col-1-of-7 {{$style}}">
                                <div class="form-group">
                                    <label for="{{ $date }}" class="text-success"><small>{{ $day }}</small></label>
                                    <input type="text" id="{{ $date }}" name="duration[{{ $date }}]"
                                           class="form-control duration-input"
                                           value=""
                                           maxlength="2"
                                           data-day="{{ $day }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">

                            <button type="submit" class="btn btn-submit ajax btn-success check-duration float-right">{{__('records.add_new_record')}}</button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

</form>



<div class="row" style="height: 10px"></div>

@if(count($records)>0)
<form class="needs-validation" role="form" id="form_edit" name="form_edit"
      action="{{$url_update.'/'.Auth::id()}}{{ !empty($query) ? '?' . $query : '' }}" method="POST" enctype="multipart/form-data">

    <input type="hidden" id="url_update" name="url_update" value="{{$url_update}}">
    <input type="hidden" id="url_store" name="url_store" value="{{$url_store}}">
    <input type="hidden" id="url_fill_dropdown" name="url_fill_dropdown" value="{{$url_fill_dropdown}}">

    <input type="hidden" id="insertedby" name="insertedby" value="{{$insertedby}}">
    <input type="hidden" id="id_country" name="id_country" value="{{$id_country}}">
    <input type="hidden" id="date" name="date" value="{{$date}}">

    <input type="hidden" name="container" value="edit-record-week-container">
    <input type="hidden" id="refresh-container" value="index-container">
    <input type="hidden" id="refresh-route"
           value="{{ route('refresh-index', ['lang' => $lang,'id_module' => $id_module,'id' => $insertedby]) }}{{ !empty($query) ? '?' . $query : '' }}">

    {{csrf_field()}}
    @method('POST')


    @php
        $idGroupArray =[];
    @endphp

@foreach($records as $record)
        @php
            $idGroupArray[] = $record['id_group'];
        @endphp



        <div class="row">
            <div class="col-md-12">
                <div class="row">



                    <div class="col-md-4">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <?php
                                $name = 'id_project';
                                $desc = __('records.projects');
                                ?>


                            <label class="text-red" for="{{$name}}">{{$desc}} *</label>
                            <select class="form-control"
                                    id="{{$name}}{{$record['id_group']}}" name="{{$name}}{{$record['id_group']}}"
                                    onchange="fillDropdownActivity('{{ $url_fill_dropdown }}/get-activities/'+encodeURIComponent(this.value)+'/'+{{ Auth::id() }}, 'activities_dropdown_{{$record['id_group']}}', '{{$record['id_group']}}');
                               fillDropdownAssignment('{{ $url_fill_dropdown }}/get-assignments/'+encodeURIComponent(this.value)+'/'+{{ Auth::id() }}, 'assignments_dropdown_{{$record['id_group']}}', '{{$record['id_group']}}')
                                    "
                                    style="width: 100%" required>
                                @if(count($projects) > 0)
                                    <option value="0">&nbsp;</option>
                                    @foreach($projects as $project)
                                        <option
                                            value="{{$project->id}}" {{ ($project->id==$record['id_project'])? 'selected' : '' }}>{{$project->name}}
                                            {{--                                            ({{$project->id}})--}}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <?php
                                $name = 'id_assignment';
                                $desc = __('records.assignments');
                                ?>
                            <label class="text-red" for="{{$name}}">{{$desc}} *</label>
                            <div id="assignments_dropdown_{{$record['id_group']}}">
                                <select class="form-control" id="{{$name}}{{$record['id_group']}}" name="{{$name}}{{$record['id_group']}}" style="width: 100%"
                                        required>

                                    <option value="">&nbsp;</option>
                                    @foreach($record['project_assignments'] as $assignment)
                                        <option
                                            value="{{ $assignment['id']}}" {{ ( $record['id_assignment']==$assignment['id'] )? 'selected' : '' }}>{{ $assignment['name']}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <?php
                                $name = 'id_activity';
                                $desc = __('records.activities');
                                ?>
                            <label class="text-red" for="{{$name}}">{{$desc}} *</label>
                            <div id="activities_dropdown_{{$record['id_group']}}">
                                <select class="form-control"
                                        id="{{$name}}{{$record['id_group']}}" name="{{$name}}{{$record['id_group']}}"
                                        style="width: 100%" required>

                                    <option value="">&nbsp;</option>
                                    @foreach($record['project_activities'] as $activity)
                                        <option
                                            value="{{ $activity['id']}}" {{ ( $record['id_activity']==$activity['id'] )? 'selected' : '' }}>{{$activity['name'] }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="row text-center">
                            @foreach($datesOfDaysOfWeek as $day => $dateA)
                                @php
                                    $duration='';
                                     $note = '';
                                    $dayLabel = $day. ' ' . date('d.m.Y', strtotime($dateA));
                                    $dateLocal = date('Y-m-d', strtotime($dateA));
                                @endphp
                                @foreach($record['date_durations'] as $date_durations)
                                    @php
                                        $dateDB = date('Y-m-d', strtotime($date_durations['date']));
                                         if($dateLocal===$dateDB) {
                                             $duration=$date_durations['duration'];
                                              $note = $date_durations['note'];
                                         }
                                    @endphp
                                @endforeach

                                @php
                                    $style = ( in_array($dateLocal, $nonWorkingDays)) ? 'nonworking' : '';
                                @endphp
                                <div class="col-lg col-1-of-7 {{$style}}">
                                    <div class="form-group">
                                        <label for="{{ $dateLocal }}" class="text-red"><small>{{ $day }}

                                                @if($note)
                                                    &nbsp;<i class="fas fa-comment text-warning" title="{{ $note }}"></i>
                                                @endif


                                            </small></label>
                                        <input type="text" id="{{ $dateLocal }}{{$record['id_group']}}" name="duration{{$record['id_group']}}[{{ $dateLocal }}]"
                                               class="form-control duration-input"
                                               value="{{ $duration }}"
                                               maxlength="2"
                                               data-day="{{ $dayLabel }}">
                                    </div>
                                </div>

                            @endforeach
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">

                                <span class="text-white">{{$record['id_group']}}</span>

                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>



                            {{--<div class="col-sm-12">
                                    <?php
                                    $name = 'note';
                                    $desc = __('records.note');
                                    ?>
                                <div class="form-group">
                                    <label for="{{$name}}">{{$desc}}</label>
                                    <textarea class="form-control" id="{{$name}}" name="{{$name}}" rows="2"
                                              placeholder="">{{$record['note']}}</textarea>
                                </div>
                            </div>--}}






<div class="row" style="height: 10px"></div>

@endforeach
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <input type="hidden" id="id_group" name="id_group" value="{{ implode(',', $idGroupArray) }}">

            <button type="submit"
                    class="btn btn-submit ajax btn-danger float-right">{{__('global.update')}} </button>
        </div>
    </div>
</form>
@endif

<hr>

<div class="row">
    <div class="col-md-4">

    </div>

    <div class="col-md-8">
        <div class="row text-center">
            @foreach([$monDayMonth => $monDate, $tueDayMonth => $tueDate, $wedDayMonth => $wedDate, $thuDayMonth => $thuDate, $friDayMonth => $friDate, $satDayMonth => $satDate, $sunDayMonth  => $sunDate] as $day => $date)
                @php
                    $style = ( in_array($date, $nonWorkingDays)) ? 'nonworking' : '';
                @endphp
                <div class="col-lg col-1-of-7 {{$style}}">
                    <label class="text-red"
                    ><small>{{ $day }}</small></label>
                    <div class="form-group">
                        <input type="text" id="sum_{{ $date }}" name="sum_{{ $date }}"
                               class="form-control duration-input"
                               value=""
                               maxlength="2" readonly>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


</div>
<div class="row">
    <div class="col-md-12  text-right">
         <span style="font-size: 1.5em; font-weight: bold;">
        <strong id="total" class="text-red"> </strong>
         </span>
    </div>
</div>




<style>
    .col-1-of-7 {
        flex: 0 0 14.28%;
        max-width: 14.28%;
        /*padding: 0.5rem;*/
    }

    @media (max-width: 992px) {
        .col-lg {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
    .nonworking {
       background-color: #fbfbd2;
    }

</style>
<script>
    $(document).ready(function () {
        // Ограничи го внесот само на бројки од 1 до 16
        $('.duration-input').on('input', function () {
            let value = $(this).val();

            // Ако вредноста не е бројка или не е помеѓу 1 и 16, врати ја претходната вредност
            if (value && (!/^\d+$/.test(value) || value < 1 || value > 16)) {
                $(this).val($(this).data('previousValue')); // Врати ја претходната валидна вредност
            } else {
                $(this).data('previousValue', value); // Сочувај ја тековната валидна вредност
            }
        });

    });
    $(document).ready(function () {
        // Функција за ажурирање на сумите
        function updateSums() {
            let total_total = 0; // Вкупна сума

            // Низ сите датуми (sum_*)
            $('[id^="sum_"]').each(function () {
                const date = $(this).attr('id').replace('sum_', ''); // Земете го датумот од ID
                let total = 0;

                // Пребарај ги сите соодветни duration полиња и пресметај ја сумата
                $(`input[id^="${date}"]`).each(function () {
                    const value = parseInt($(this).val());
                    if (!isNaN(value)) {
                        total += value;
                        total_total += value; // Додај ја вредноста на вкупната сума
                    }
                });

                // Ажурирај го соодветното поле за сума
                $(this).val(total > 0 ? total : ''); // Постави ја сумата или остави празно поле
            });

            // Ажурирај ја вкупната сума во елементот #total
            $('#total').text(total_total > 0 ? total_total : '0');
        }

        // Ограничи го внесот само на бројки од 1 до 16
        $('.duration-input').on('input', function () {
            let value = $(this).val();

            // Ако вредноста не е бројка или не е помеѓу 1 и 16, врати ја претходната вредност
            if (value && (!/^\d+$/.test(value) || value < 1 || value > 16)) {
                $(this).val($(this).data('previousValue')); // Врати ја претходната валидна вредност
            } else {
                $(this).data('previousValue', value); // Сочувај ја тековната валидна вредност
            }

            // Ажурирај ги сумите
            updateSums();
        });

        // Ажурирај ги сумите при вчитување на страницата
        updateSums();
    });


    // $(document).ready(function () {
    //     // Функција за пресметка на почетните суми
    //     function calculateInitialSums() {
    //         let total_total = 0;
    //
    //         // За секое поле со ID кое почнува со "sum_"
    //         $('[id^="sum_"]').each(function () {
    //             const date = $(this).attr('id').replace('sum_', ''); // Земете го датумот од ID
    //             let total = 0;
    //
    //             // Пребарај ги сите duration полиња со истиот датум
    //             $(`input[name^="duration[${date}]"]`).each(function () {
    //                 const value = parseInt($(this).val());
    //                 if (!isNaN(value)) {
    //                     total += value;
    //                     total_total += value;
    //                 }
    //             });
    //
    //             // Постави ја почетната сума во полето
    //             $(this).val(total > 0 ? total : ''); // Ако нема вредност, остави празно поле
    //         });
    //
    //         // Постави ја вкупната сума во текстуалната содржина на #total
    //         $('#total').text(total_total > 0 ? total_total : '0');
    //     }
    //
    //     // Пресметај суми само при вчитување на страницата
    //     calculateInitialSums();
    // });



</script>
