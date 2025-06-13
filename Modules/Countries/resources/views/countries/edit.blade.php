@extends('admin/master')
@section('content')

    <?php
    $id_module = $module->id ?? '';
    $lang = request()->segment(2);
    $query = request()->getQueryString();


    $id = $country->id ?? '';
    $name = $country->name ?? old('name');
    $code_s = $country->code_s ?? old('code_s');
    $code_l= $country->code_l ?? old('code_l');

    $created_at = (isset($country->created_at)) ? date("d.m.Y  H:i:s", strtotime($country->created_at)) : '';
    $updated_at = (isset($country->updated_at)) ? date("d.m.Y  H:i:s", strtotime($country->updated_at)) : '';


    $url = url('admin/' . $lang . '/' . $module->link);
    $url_store = url('admin/' . $lang . '/' . $id_module . '/countries/store/');
    $url_update = url('admin/' . $lang . '/' . $id_module . '/countries/update/' . $id);
    $url_action = !empty($id) ? $url_update : $url_store;
    $url_return = url('admin/' . $lang . '/' . $id_module . '/countries/edit/' . $id);

    $message_error = (!empty($id)) ? __('global.update_error') : __('global.save_error');
    $message_success = (!empty($id)) ? __('global.update_success') : __('global.save_success');


    ?>


        <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fa {{$module->design->icon}}"></i> {{$module->title }} </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{$url}}">{{$module->title }}</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- / Content Header (Page header) -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @include('admin._flash-message')

                <!-- Form-->
                <form class="needs-validation" role="form" id="form_edit" name="form_edit"
                      action="{{ "{$url_action}" }}" method="POST" enctype="multipart/form-data">

                    <input type="hidden" id="url_return" name="url_return" value="{{ $url_return }}">
                    <input type="hidden" id="query" name="query" value="{{$query}}">
                    <input type="hidden" id="message_error" name="message_error" value="{{ $message_error }}">
                    <input type="hidden" id="message_success" name="message_success" value="{{ $message_success }}">

                    <input type="hidden" id="id" name="id" value="{{ $id}}">
                    <input type="hidden" id="id_module" name="id_module" value="{{ $id_module}}">
                    {{csrf_field()}}
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">

                            <!-- Errors ---------->
                            @if (count($errors) > 0)
                                <div id="toast-container" class="toast-top-full-width" onclick="closeErrorWindow(this)"
                                     style="width:100%" ;>

                                    <div class="toast toast-error" aria-live="assertive" style="width:100%" ;>
                                        <div class="toast-progress" style="width:100%;"></div>
                                        <button type="button" class="close" data-dismiss="toast-top-full-width"
                                                role="button" onclick="closeErrorWindow(this)">×
                                        </button>
                                        <p><strong>{{__('global.error_not')}}</strong></p>
                                        <div class="toast-message">
                                            @foreach ($errors->all() as $error)
                                                <div class="callout callout-danger"
                                                     style="color: #0a0a0a!important;padding: 5px!important;">
                                                    {!! $error !!}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <!-- ./Errors ---------->

                            <div class="card card">

                                <div class="card-header">
                                    <h3 class="card-title">  @if(isset($id)&&!empty($id)) id: {{$id}}@else {{__('global.new_record')}} @endif</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    {{--=========================================================--}}
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <?php
                                            $input_value = $name;
                                            $input_name = 'name';
                                            $input_desc = __('countries.name');
                                            $input_maxlength = 200;
                                            $input_readonly= '';
                                            $input_css= 'text-red';
                                            ?>
                                            <div class="form-group">
                                                <label for="{{$input_name}}" class="{{$input_css}}">{{$input_desc}}</label>
                                                <input type="text" id="{{$input_name}}" name="{{$input_name}}" class="form-control" value="{{$input_value}}"
                                                       maxlength="{{$input_maxlength}}" {{$input_readonly}}>
                                            </div>
                                        </div>

                                    </div>
                                    {{--=========================================================--}}
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <?php
                                            $input_value = $code_s;
                                            $input_name = 'code_s';
                                            $input_desc = __('countries.code_s');
                                            $input_maxlength = 2;
                                            $input_readonly= '';
                                            $input_css= '';
                                            ?>
                                            <div class="form-group">
                                                <label for="{{$input_name}}" class="{{$input_css}}">{{$input_desc}}</label>
                                                <input type="text" id="{{$input_name}}" name="{{$input_name}}" class="form-control" value="{{$input_value}}"
                                                       maxlength="{{$input_maxlength}}" {{$input_readonly}}>
                                            </div>
                                        </div>

                                    </div>
                                    {{--=========================================================--}}
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <?php
                                            $input_value = $code_l;
                                            $input_name = 'code_l';
                                            $input_desc = __('countries.code_l');
                                            $input_maxlength = 3;
                                            $input_readonly= '';
                                            $input_css= '';
                                            ?>
                                            <div class="form-group">
                                                <label for="{{$input_name}}" class="{{$input_css}}">{{$input_desc}}</label>
                                                <input type="text" id="{{$input_name}}" name="{{$input_name}}" class="form-control" value="{{$input_value}}"
                                                       maxlength="{{$input_maxlength}}" {{$input_readonly}}>
                                            </div>
                                        </div>

                                    </div>
                                    {{--=========================================================--}}
                                    @if(isset($country))
                                        <div class="row">
                                            <div class="col-sm-6">
                                                    <?php
                                                    $input_value = $created_at;
                                                    $input_name = 'created_at';
                                                    $input_desc = __('countries.created_at');
                                                    $input_maxlength = 100;
                                                    $input_readonly= 'readonly';
                                                    $input_css= 'text';
                                                    ?>
                                                <div class="form-group">
                                                    <label for="{{$input_name}}" class="{{$input_css}}">{{$input_desc}}</label>
                                                    <input type="text" id="{{$input_name}}" name="{{$input_name}}" class="form-control" value="{{$input_value}}"
                                                           maxlength="{{$input_maxlength}}" {{$input_readonly}}>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                    <?php
                                                    $input_value = $updated_at;
                                                    $input_name = 'updated_at';
                                                    $input_desc = __('countries.updated_at');
                                                    $input_maxlength = 100;
                                                    $input_readonly= 'readonly';
                                                    $input_css= 'text';
                                                    ?>
                                                <div class="form-group">
                                                    <label for="{{$input_name}}" class="{{$input_css}}">{{$input_desc}}</label>
                                                    <input type="text" id="{{$input_name}}" name="{{$input_name}}" class="form-control" value="{{$input_value}}"
                                                           maxlength="{{$input_maxlength}}" {{$input_readonly}}>
                                                </div>
                                            </div>

                                        </div>
                                    @endif
                                    {{--=========================================================--}}

                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="button" onclick="form_edit.submit();"
                                            class="btn btn-success float-right">{{__('global.save')}}</button>
                                </div>
                                <!-- /.card-footer -->
                            </div>
                            <!-- /.card -->

                        </div>
                        <!-- /.col-md-12 -->
                    </div>
                    <!-- /.row-->
                </form>
                <!-- /.form -->


            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.Main content -->


    </div>
    <!-- /.Content Wrapper. Contains page content -->
@endsection

@section('additional_css')

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ url('LTE/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{ url('LTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <!-- date-range-picker -->
    <link rel="stylesheet" href="{{ url('LTE/plugins/daterangepicker/daterangepicker.css')}}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ url('LTE/plugins/toastr/toastr.min.css')}}">


    <style>
        .daterangepicker.single .drp-buttons {
            display: block !important;
        }
    </style>
@endsection

@section('additional_js')

    <!-- Select2 -->
    <script src="{{url('LTE/plugins/select2/js/select2.full.min.js')}}"></script>

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

    <script>

        $(document).ready(function () {
            // Иницијализација на bsCustomFileInput
            bsCustomFileInput.init();

            // Конфигурација за Date Range Picker со вклучено време
            const dateTimePickerConfig = {
                singleDatePicker: true,
                autoUpdateInput: false,
                timePicker: true, // Овозможете време
                timePicker24Hour: true, // 24-часовен формат
                timePickerSeconds: true, // Вклучете секунди
                showDropdowns: true,
                locale: {
                    format: "DD.MM.YYYY HH:mm:ss", // Формат за датум и време
                    applyLabel: "Внеси",
                    cancelLabel: "Бриши",
                    fromLabel: "From",
                    toLabel: "To",
                    customRangeLabel: "Custom",
                    weekLabel: "W",
                    daysOfWeek: ["Не", "По", "Вт", "Ср", "Че", "Пе", "Са"],
                    monthNames: [
                        "Јануари", "Февруари", "Март", "Април", "Мај", "Јуни",
                        "Јули", "Август", "Септември", "Октомври", "Ноември", "Декември"
                    ],
                    firstDay: 1
                }
            };

            // Функција за иницијализација на Date Range Picker за дадено поле
            function initializeDateTimePicker(selector) {
                const inputField = $(selector);

                inputField.daterangepicker(dateTimePickerConfig);

                inputField.on('apply.daterangepicker', function (ev, picker) {
                    // Поставување на датум и време во формат "DD.MM.YYYY HH:mm:ss"
                    $(this).val(picker.startDate.format('DD.MM.YYYY HH:mm:ss'));
                });

                inputField.on('cancel.daterangepicker', function () {
                    $(this).val('');
                });
            }

            // Иницијализација за `start_date`
            initializeDateTimePicker('input[name="start_date"]');
            // Иницијализација за `end_date` (ако е потребно)
            initializeDateTimePicker('input[name="end_date"]');
        });



        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })


    </script>

@endsection
