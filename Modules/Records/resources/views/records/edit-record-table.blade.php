

<?php
$id_module = $module->id ?? '';
$lang = request()->segment(2);
$query = request()->getQueryString();

$year_current= request()->segment(6);

$id = $record->id ?? '';
$id_user = !empty($id) ? request()->segment(8) : request()->segment(7);
$id_project	 = $record->project ?? '';
$id_country	 = $record->id_country ?? '';
$id_assignment = $record->assignment ?? '';
$id_activity = $record->activity ?? '';
$duration = $record->duration ?? '';
$note = $record->note ?? '';
$date = (isset($record->date)) ? date("d.m.Y", strtotime($record->date)) : '';
$year = $record->year  ?? '';
$lockrecord = $record->lockrecord ?? '';
$approvedby =  $record->approvedby ?? '';


$url = url('admin/' . $lang . '/' . $module->link);


$url_store = $url . '/store-record-table/'. $id_user;
$url_update = $url . '/update-record-table/'.$id.'/'.$id_user;
$url_action = !empty($id) ? $url_update : $url_store;

$url_return = $url. '/index-records-table/'. $id_user;

$url_fill_dropdown = url($url);

$message_error = (!empty($id) ) ? __('global.update_error') : __('global.save_error');
$message_success = (!empty($id) ) ? __('global.update_success') : __('global.save_success');
?>






    <!-- Form-->
<form class="needs-validation" role="form" id="form_edit_record" name="form_edit_record" action="{{ $url_action}}" method="POST" enctype="multipart/form-data">

    <input type="hidden" id="url_return" name="url_return" value="{{ $url_return }}">
    <input type="hidden" id="query" name="query" value="{{$query}}">
    <input type="hidden" id="message_error" name="message_error" value="{{ $message_error }}">
    <input type="hidden" id="message_success" name="message_success" value="{{ $message_success }}">

    <input type="hidden" id="id" name="id" value="{{$id }}">
    <input type="hidden" id="id_user" name="id_user" value="{{$id_user}}">
    <input type="hidden" id="year_temp" name="year_temp" value="{{$year_current}}">



    {{csrf_field()}}
    @method('POST')

    <div class="row">
        <div class="col-md-12">


            <div class="card card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title">@if(!empty($id)) id: {{$id}}@else {{__('global.new_record')}} @endif</h3>
                </div>
                <div class="card-body">
                    {{--=========================================================--}}
                    <div class="row">
                        <div class="col-sm-12">
                        <?php
                        $name = 'id_country';
                        $desc = __('records.id_country');
                        $input_required= 'required';
                        ?>
                        <label class="control-label">{{$desc}}</label>
                        <select class="form-control"
                                id="{{$name}}" name="{{$name}}"
                                style="width: 100%"  {{$input_required}}>
                            @if(count($assignCountries) > 0)
                                @foreach($assignCountries as $country)
                                    <option
                                        value="{{$country->id}}" {{ ($id_country == $country->id) ? 'selected' : '' }}>
                                        {{$country->name}} {{--({{$country->id}})--}}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    </div>
                    {{--=========================================================--}}
                    <div class="row">
                    <div class="col-sm-12">
                        <?php
                        $input_value = $date;
                        $input_name = 'date_';
                        $input_desc = __('records.date').' *';
                        $input_maxlength = 100;
                        $input_required= 'required';
                        $input_readonly= 'readonly';
                        $input_css= 'text-red';
                        ?>
                        <div class="form-group">
                            <label for="{{$input_name}}" class="{{$input_css}}">{{$input_desc}}</label>
                            <input type="text" id="{{$input_name}}" name="{{$input_name}}" class="form-control" value="{{$input_value}}"
                                   maxlength="{{$input_maxlength}}" {{$input_readonly}}  {{$input_required}}>
                            <!-- Сокриено поле што ќе ја испрати вредноста -->
                            <input type="hidden" name="{{$input_name}}" id="{{$input_name}}_hidden" value="{{$input_value}}">
                        </div>
                    </div>
                    </div>
                    {{--=========================================================--}}
                    <div class="row">
                        <div class="col-sm-12 col-md-4 col-lg-5 col-xl-12">
                            <?php
                            $name = 'id_project';
                            $desc = __('records.project');
                            ?>
                            <label class="text-red" for="{{$name}}" >{{$desc}} *</label>
                            <select class="form-control"
                                    id="{{$name}}" name="{{$name}}"

                                    onchange="fillDropdown('{{ $url_fill_dropdown }}/get-activities/'+encodeURIComponent(this.value)+'/'+{{ Auth::id() }}, 'activities_dropdown');
                                    fillDropdown('{{ $url_fill_dropdown }}/get-assignments/'+encodeURIComponent(this.value)+'/{{ Auth::id() }}{{ isset($year_current) ? '?type=day-table&year=' . urlencode($year_current) : '' }}', 'assignments_dropdown')"

                                    style="width: 100%" required>
                                @if(count($projects) > 0)
                                    <option value="0" @if(!empty($id)  > 0) disabled @endif  >&nbsp;</option>
                                    @foreach($projects as $project)
                                        <option
                                            value="{{$project->id}}" {{ ($project->id==$id_project)? 'selected' : '' }}

                                        @if($project->active==0) disabled @endif
                                            style="@if($project->active==0) color: #a0a0a0; @endif">
                                        {{$project->name}}@if($project->active==0)
                                                / {{__('records.inactive')}}
                                            @endif, {{ date("d.m.Y", strtotime($project->end_date)) }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    {{--=========================================================--}}
                    <div class="row">
                        <div class="col-sm-12 col-md-4 col-lg-5 col-xl-5">
                            <?php
                            $name = 'id_assignment';
                            $desc = __('records.assignment');
                            ?>
                            <label class="text-red" for="{{$name}}">{{$desc}} *</label>
                            <div id="assignments_dropdown">
                                <select class="form-control" id="{{$name}}" name="{{$name}}" style="width: 100%" required>
                                    @if(count($assignments) > 0)
                                        <option value="">&nbsp;</option>
                                        @foreach($assignments as $assignment)
                                            <option
                                                value="{{$assignment->id}}" {{ ($assignment->id==$id_assignment)? 'selected' : '' }}>{{$assignment->name}} {{--({{$assignment->id}})--}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4 col-lg-5 col-xl-5">
                            <?php
                            $name = 'id_activity';
                            $desc = __('records.activity');
                            ?>
                            <label class="text-red" for="{{$name}}" >{{$desc}} *</label>
                            <div id="activities_dropdown">
                                <select class="form-control"
                                        id="{{$name}}" name="{{$name}}"
                                        style="width: 100%" required>
                                    @if(count($activities) > 0)
                                        <option value="">&nbsp;</option>
                                        @foreach($activities as $activity)
                                            <option
                                                value="{{$activity->id}}" {{ ($activity->id==$id_activity)? 'selected' : '' }}>{{$activity->name}} {{--({{$activity->id}})--}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <?php
                            $name = 'duration';
                            $desc = __('records.duration');
                            ?>
                            <div class="form-group">
                                <label for="{{$name}}" class="text-red">{{$desc}} *</label>
                                <select class="form-control" style="width:100%;" id="{{$name}}" name="{{$name}}" required>
                                    <option value="">&nbsp;</option>
                                    <option value="1" {{ ($duration==1)? 'selected' : '' }}>1</option>
                                    <option value="2" {{ ($duration==2)? 'selected' : '' }}>2</option>
                                    <option value="3" {{ ($duration==3)? 'selected' : '' }}>3</option>
                                    <option value="4" {{ ($duration==4)? 'selected' : '' }}>4</option>
                                    <option value="5" {{ ($duration==5)? 'selected' : '' }}>5</option>
                                    <option value="6" {{ ($duration==6)? 'selected' : '' }}>6</option>
                                    <option value="7" {{ ($duration==7)? 'selected' : '' }}>7</option>
                                    <option value="8" {{ ($duration==8)? 'selected' : '' }}>8</option>
                                    <option value="9" {{ ($duration==9)? 'selected' : '' }}>9</option>
                                    <option value="10" {{ ($duration==10)? 'selected' : '' }}>10</option>
                                    <option value="11" {{ ($duration==11)? 'selected' : '' }}>11</option>
                                    <option value="12" {{ ($duration==12)? 'selected' : '' }}>12</option>
                                    <option value="13" {{ ($duration==13)? 'selected' : '' }}>13</option>
                                    <option value="14" {{ ($duration==14)? 'selected' : '' }}>14</option>
                                    <option value="15" {{ ($duration==15)? 'selected' : '' }}>15</option>
                                    <option value="16" {{ ($duration==16)? 'selected' : '' }}>16</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    {{--=========================================================--}}
                    <div class="row">
                        <div class="col-sm-12">
                            <?php
                            $name = 'note';
                            $desc = __('records.note');
                            ?>
                            <div class="form-group">
                                <label for="{{$name}}">{{$desc}}</label>
                                <textarea class="form-control" id="{{$name}}" name="{{$name}}" rows="2"
                                          placeholder="">{{$note}}</textarea>
                            </div>
                        </div>
                    </div>
                    {{--=========================================================--}}
                    <button type="submit" class="btn btn-submit btn-success float-right">{{__('global.save')}}</button>
                </div>
                <!-- /.card-body -->


            </div>
            <!-- /.card -->

        </div>
        <!-- /.col-md-12 -->
    </div>
    <!-- /.row-->
</form>
<!-- /.form -->



<!-- toastr CSS -->
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ url('LTE/plugins/toastr/toastr.min.css')}}">


<!-- Select2 -->
<link rel="stylesheet" href="{{ url('LTE/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ url('LTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<!-- date-range-picker -->
<link rel="stylesheet" href="{{ url('LTE/plugins/daterangepicker/daterangepicker.css')}}">



<!-- Select2 -->
<script src="{{url('LTE/plugins/select2/js/select2.full.min.js')}}"></script>
    <!-- toastr JS -->
<script src="{{url('LTE/plugins/toastr/toastr.min.js')}}"></script>


{{--    FOR DATE INPUT FIELD////////////////////////////////////////////////////////////////////////////////////////////////////////--}}
<!-- Bootstrap4 Duallistbox -->
<script src="{{url('LTE/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')}}"></script>
<!-- InputMask -->
<script src="{{url('LTE/plugins/moment/moment.min.js')}}"></script>
<script src="{{url('LTE/plugins/inputmask/min/jquery.inputmask.bundle.min.js')}}"></script>
<!-- date-range-picker -->
<script src="{{url('LTE/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- bs-custom-file-input -->
<script src="{{url('LTE/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
{{--    .END FOR DATE INPUT FIELD////////////////////////////////////////////////////////////////////////////////////////////////////////--}}
<style>
    .daterangepicker.single .drp-buttons {
        display: block !important;
    }
    .daterangepicker {
        z-index: 1055 !important;
    }

    .daterangepicker {
        z-index: 1050 !important;  /* Осигурува дека datepicker-от е над сите елементи */
    }
    .bootstrap-datetimepicker-widget {
        z-index: 1050 !important; /* За datetimepicker */
    }
</style>


<script>
    // Пренеси ја PHP низата како JSON до JavaScript и претвори ја во правилен формат
    if (typeof lockedDays === 'undefined') {
        var lockedDays = @json($locketDays); // Првична декларација
    } else {
        lockedDays = @json($locketDays); // Ажурирај ја вредноста
    }

    // Претвори ги сите датуми во формат 'YYYY-MM-DD'
    lockedDays = Array.isArray(lockedDays) ? lockedDays.map(date => date.split(' ')[0]) : [];

    $(document).ready(function () {
        // Прочитај ја годината од hidden полето
        const selectedYear = $('#year_temp').val();

        // Постави го почетокот и крајот на годината
        const startDate = moment(`${selectedYear}-01-01`);
        const endDate = moment(`${selectedYear}-12-31`);

        // Иницијализација на bsCustomFileInput
        bsCustomFileInput.init();

        // Конфигурација за Date Picker со заклучени денови
        const dateTimePickerConfig = {
            singleDatePicker: true,
            autoUpdateInput: false,
            timePicker: false,
            timePicker24Hour: true,
            showDropdowns: false,
            minDate: startDate,
            maxDate: endDate,
            locale: {
                format: "DD.MM.YYYY",  // Формат за датум
                firstDay: 1
            },
            // Оневозможи заклучени денови
            isInvalidDate: function (date) {
                const formattedDate = date.format('YYYY-MM-DD');  // Претвори го моменталниот датум во формат YYYY-MM-DD
                return lockedDays.includes(formattedDate);  // Оневозможи ако датумот е во lockedDays
            }
        };

        // Иницијализирај DatePicker за одредено поле
        initializeDateTimePicker('#form_edit_record input[name="date_"]');

        function initializeDateTimePicker(selector) {
            const inputField = $(selector);
            inputField.daterangepicker(dateTimePickerConfig);

            inputField.on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD.MM.YYYY'));
                $('#date__hidden').val(picker.startDate.format('DD.MM.YYYY'));
            });

            inputField.on('cancel.daterangepicker', function () {
                $(this).val('');
                $('#date__hidden').val('');
            });
        }
    });

    $(function () {
        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    })
</script>
