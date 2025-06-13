@extends('admin/master')

@section('content')

    <?php
    $id_module = $module->id ?? '';
    $lang = request()->segment(2);
    $query = request()->getQueryString();

    $nextEnteredYears = $lastEnteredYears + 1;
    $allLocked=isset($calendar->allLocked)?$calendar->allLocked:'';

    $url = url('admin/' . $lang . '/' . $module->link);

    $url_base = 'admin/' . $lang . '/' . $id_module . '/calendar/';
    $url_new_year = url($url_base . 'new-year/');
    $url_insert_holiday = url($url_base . 'insert-holiday/');
    $url_delete_year = url($url_base . 'delete/');


    ?>
        <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fa {{$module->design->icon}}"></i> {{$module->title}}

                            @if(date('Y')>=$lastEnteredYears)

                                <a href="#" class="btn btn-danger modal_warning"
                                   data-toggle="modal"
                                   data-target="#ModalWarning"

                                   data-title="{{__('calendar.enter_year')}}"
                                   data-url="{{$url_new_year.'/'.$nextEnteredYears.'?'.$query}}"

                                   data-content_l="{{__('calendar.last_year')}} {{$lastEnteredYears}}"
                                   data-content_b="{{__('calendar.next_year')}} {{$nextEnteredYears}}"
                                   data-content_sub_l="{{__('calendar.year_warning')}}"
                                   data-content_sub_b=""

                                   data-query="{{$query}}"
                                   data-url_return="{{$url}}"
                                   data-success="{{__('global.delete_success')}}"
                                   data-error="{{__('global.delete_error')}}"

                                   title="{{__('calendar.enter_year')}}">

                                    {{__('calendar.enter_year_short')}}</a>
                            @endif

                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{$url}}">{{$module->title}}</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>


        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <!-- Search =============================================================================================== -->
                <form class="form-horizontal" name="form_search" id="form_search" method="get" action=""
                      accept-charset="UTF-8">
                    <!-- card card-red card-outline =============================================================================================== -->
                    <div class="card card-red card-outline">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-sm-12 col-md-4 col-lg-5 col-xl-3">
                                    <?php
                                    $name = 'id_country';
                                    $desc = __('calendar.id_country');
                                    ?>
                                    <label class="control-label">{{$desc}}</label>
                                    <select class="select2bs4"
                                            id="{{$name}}" name="{{$name}}" required
                                            style="width: 100%">
                                        @if(count($countries) > 0)
                                            <option value="">&nbsp;</option>
                                            @php
                                                $id_country = '';
                                                $country_name = '';
                                            @endphp
                                            @foreach($countries as $country)
                                                @php
                                                    if (app('request')->input('id_country') == $country->id) {
                                                        $id_country = $country->id;
                                                        $country_name = $country->name;
                                                    }
                                                @endphp

                                                <option
                                                    value="{{$country->id}}" {{ ((app('request')->input($name))==$country->id)? 'selected' : '' }}>{{$country->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                                    <?php
                                    $name = 'year';
                                    $desc = __('calendar.year');
                                    ?>
                                    <label class="control-label">{{$desc}}
                                    </label>

                                    <select class="select2bs4"
                                            id="{{$name}}" name="{{$name}}" required
                                            style="width: 100%">
                                        @if(count($years) > 0)
                                            <option value="">&nbsp;
                                            </option>
                                            @foreach($years as $year)
                                                <option value="{{$year}}"
                                                    {{ ((app('request')->input($name))==$year)? 'selected' : '' }}>{{$year}}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-sm-6 col-md-2  col-lg-2 col-xl-2">
                                    <label class="control-label"> &nbsp;</label>
                                    <button type="button"
                                            class="form-control form-control-sm btn btn-outline-secondary btn-sm"
                                            title="{{__('global.reset_button_des')}}"
                                            onClick="window.open('{{ $url}}','_self');"> {{__('global.reset_button')}}
                                    </button>
                                </div>

                                <div class="col-sm-6 col-md-2  col-lg-2 col-xl-2">
                                    <label class="control-label"> &nbsp;</label>
                                    <button type="submit"
                                            class="form-control form-control-sm btn btn-outline-danger btn-sm"
                                            title="{{__('global.search_button')}} ">{{__('global.search_button')}}
                                    </button>
                                </div>


                            </div>
                        </div>
                    </div>
                </form>
                <!-- card card-red card-outline  END =============================================================================================== -->
                <!-- Search end=============================================================================================== -->

                <!-- Table =============================================================================================== -->
                {{--                <div class="card card-gray card-outline">--}}
                {{--                    <div class="card-body scrollmenu">--}}
                @include('admin._flash-message')


                @if(count($calendar) > 0)

                    <form class="form-horizontal" name="form_insert" id="form_insert" method="post"
                          action="{{$url_insert_holiday}}" accept-charset="UTF-8">
                        @csrf
                        <input type="hidden" id="year" name="year" value="{{ app('request')->input('year') }}">
                        <input type="hidden" id="id_country" name="id_country"
                               value="{{ $id_country }}">
                        <input type="hidden" id="query" name="query" value="{{$query}}">
                        <input type="hidden" id="url_return" name="url_return" value="{{$url}}">

                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <h3><strong>{{app('request')->input('year')}}</strong>, {!!$country_name!!}
                                @if($allLocked== 1) <strong class="text-red">{{__('calendar.locked_year')}}</strong> @endif</h3>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="custom-control custom-checkbox">

                                <input class="custom-control-input" type="checkbox"
                                       id="lock_calendar"
                                       name="lock_calendar"
                                       value="1"
                                       onclick="selectAllLock('lock', 'lock_calendar')"
                                       @if($allLocked== 1) checked @endif
                                >
                                <label for="lock_calendar"
                                       class="custom-control-label @if($allLocked== 1) text-red @else text-success @endif">
                                    <i class="fas fa-lock text-gray" title="{{__('calendar.lock')}}"></i>&nbsp;&nbsp;
                                    @if($allLocked== 1)
                                        {!!  __('calendar.unselect_all',['year'=>app('request')->input('year')]) !!}
                                    @else
                                        {!!  __('calendar.select_all',['year'=>app('request')->input('year')]) !!}
                                    @endif
                                </label>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            {!!  __('calendar.select_all_warning',['year'=>app('request')->input('year')]) !!}
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <button type="button" onclick="form_insert.submit();"
                                    class="btn btn-success float-right">{{__('global.save')}}</button>
                        </div>
                    </div>


                    <div class="row" style="height: 7px"></div>



                        <div class="dataTables_wrapper dt-bootstrap4">

                            <div class="row">
                                <div class="col-sm-12">
                                    {{--========================================================================================================================--}}
                                    <div class="calendar-grid">

                                        @php
                                            $week = [];
                                            $currentMonth = '';
                                            $dayOrder = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
                                        @endphp

                                        @foreach($calendar as $calendar_)
                                            @php
                                                $monthName = date('F', strtotime($calendar_->date));
                                                $dayNumber = date('d', strtotime($calendar_->date));
                                                $startDay = strtolower(date('D', strtotime($calendar_->date)));
                                            @endphp

                                                <!-- Додавање на месецот ако е нов -->
                                            @if($dayNumber == 1 || $currentMonth != $monthName)
                                                @php
                                                    $currentMonth = $monthName;
                                                    $dayIndex = array_search($startDay, $dayOrder);
                                                @endphp

                                                    <!-- Додавање на месечно заглавие -->
                                                <div class="card card-green card-outline">
                                                    <div class="card-header">
                                                        <div class="row">
                                                            <h4><strong>{{ $monthName }}</strong></h4>
                                                        </div>
                                                    </div>

                                                    <div class="card-body">

                                                        <div class="grid-header">
                                                            <div>Mon</div>
                                                            <div>Tue</div>
                                                            <div>Wed</div>
                                                            <div>Thu</div>
                                                            <div>Fri</div>
                                                            <div class="gray-text">Sat</div>
                                                            <div class="gray-text">Sun</div>
                                                        </div>

                                                        <!-- Почеток на нов ред -->
                                                        <div class="grid-row">
                                                            <!-- Додавање празни места за денови од претходниот месец -->
                                                            @for($i = 0; $i < $dayIndex; $i++)
                                                                <div class="grid-item empty"></div>
                                                            @endfor
                                                            @endif

                                                            <!-- Ден во календарот -->
                                                            <div class="grid-item
                                                                @if($calendar_->day == 'sat' || $calendar_->day == 'sun') weekend @endif
                                                                @if($calendar_->is_holiday == 1) selected @endif
                                                                 @if($calendar_->lock_ == 1  ) gray-text  @endif"
                                                            >

                                                                <div class="grid-content">
                                                                    <div class="row">
                                                                        <div class="col-sm-12 text-left">
                                                                            <span class="day-label">{{ date('d', strtotime($calendar_->date)) }}</span>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <span>{!!  __('calendar.holiday') !!}</span>
                                                                            <input type="checkbox"
                                                                                   id="checkbox_{{$calendar_->id}}"
                                                                                   name="holidays[{{$calendar_->id}}]"
                                                                                   value="1"
                                                                                {{ $calendar_->is_holiday == 1 ? 'checked' : '' }}>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="lock-container">
{{--                                                                    <span>{!!  __('calendar.lock') !!}</span>--}}
                                                                    @if($calendar_->lock_ == 1)
                                                                        <i class="fas fa-lock text-gray"
                                                                           title="{{__('calendar.lock')}}"></i>&nbsp;&nbsp;
                                                                    @else
                                                                        <i class="fas fa-unlock text-success"
                                                                           title="{{__('calendar.lock')}}"></i>&nbsp;&nbsp;
                                                                    @endif
                                                                    <input type="checkbox"
                                                                           data-master="lock_calendar"
                                                                           class="lock"
                                                                           id="lock_{{$calendar_->id}}"
                                                                           name="lock[{{$calendar_->id}}]"
                                                                           value="1"
                                                                        {{ $calendar_->lock_ == 1 ? 'checked' : '' }}>
                                                                </div>
                                                            </div>

                                                            @php
                                                                $dayIndex++;
                                                                if ($dayIndex == 7) {
                                                                    $dayIndex = 0;
                                                                    echo '</div><div class="grid-row">';
                                                                }
                                                            @endphp

                                                            @if($dayNumber == date('t', strtotime($calendar_->date)))
                                                                <!-- Пополнување на крајот на месецот со празни квадрати -->
                                                                @for($i = $dayIndex; $i < 7; $i++)
                                                                    <div class="grid-item empty"></div>
                                                                @endfor
                                                        </div> <!-- Завршува редот -->
                                                    </div>
                                                </div>

                                            @endif
                                        @endforeach
                                    </div>
                                    {{--========================================================================================================================--}}
                                </div>
                            </div>

                        </div>
                    </form>

                @else
                    {{__('global.no_records')}}
                @endif



                <!-- /.card-body -->

                @if(count($calendar) > 0)
                    <div class="row">
                        <div class="col-sm-12">
                        <a href="#" class="btn btn-danger modal_warning"
                           data-toggle="modal"
                           data-target="#ModalWarning"

                           data-title="{!!__('calendar.delete_year_warning',['year'=>app('request')->input('year')])!!}"
                           data-url="{{$url_delete_year.'/'.app('request')->input('year')}}"

                           data-content_l="{!! __('calendar.delete_year_warning_des',['year'=>app('request')->input('year')])!!}"
                           data-content_b=""
                           data-content_sub_l=""
                           data-content_sub_b=""

                           data-query="{{$query}}"
                           data-url_return="{{$url}}"
                           data-success="{{__('calendar.delete_success',['year'=>app('request')->input('year')])}}"
                           data-error="{{__('calendar.delete_error',['year'=>app('request')->input('year')])}}"

                           data-method="DELETE"
                           title="{!!__('calendar.delete_year_hint',['year'=>app('request')->input('year')])!!}">
                            <i class="fa fa-trash"></i>
                        </a>
                        <button type="button" onclick="form_insert.submit();"
                                class="btn btn-success float-right">{{__('global.save')}}</button>
                        </div>
                    </div>
                    <div class="row" style="height: 17px"></div>
                    <!-- /.card-footer -->
                @endif

            </div>
            <!-- /.card -->
            <!-- Table end =============================================================================================== -->


            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->


    </div>

@endsection
@section('additional_css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ url('LTE/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{ url('LTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <style>

        .grid-header {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
            padding: 3px;
        }
        .grid-header-item {
            border:1px solid #cccccc;
        }
        .calendar-grid {
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 100%;
            margin: auto;
        }

       .grid-row {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            text-align: center;
            font-weight: bold;
        }

        .grid-item {

            display: flex;
            flex-direction: column;
            justify-content: space-between;  /* Распределување на содржина */
            position: relative;
            height: 110px;  /* Висина според дизајнот */
            border: 1px solid #ddd;
            padding: 10px;
            background-color: #f9f9f9;
        }

        .grid-item.empty {
            background-color: transparent;
            border: none;
        }

        /*.grid-item input[type="checkbox"] {*/
        /*    margin-top: 5px;*/
        /*}*/

        .weekend {
            background-color: #fbfbd2;
        }
        .non-weekend {
            background-color: #f9f9f9;
        }

        .selected {
            background-color: #fbfbd2;
        }

        .day-label {
            font-size: 12px;
            color: #555;
            padding-left: 3px;
        }
        .grid-content {
            flex-grow: 1;
        }
        .lock-container {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            position: absolute;
            bottom: 5px;
            right: 5px;
        }
        .gray-text {
            color: #a0a0a0;  /* Светло сива боја за текстот */
        }

        .gray-text input[type="checkbox"] {
            accent-color: #a0a0a0;  /* Светло сива боја на чекбоксот */
        }
    </style>
@endsection
@section('additional_js')
    <!-- Select2 -->
    <script src="{{url('LTE/plugins/select2/js/select2.full.min.js')}}"></script>

    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
            //Initialize Select2 Elements
            //$('.select2').select2()
        })
    </script>
@endsection
