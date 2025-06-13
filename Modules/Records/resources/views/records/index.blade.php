@extends('admin/master')

@section('content')

    <?php
    $lang = request()->segment(2);
    $query = request()->getQueryString();

    $year_selected = app('request')->input('year') ? app('request')->input('year') : date('Y');
    $month_selected = app('request')->input('month') ? app('request')->input('month') : date('m');
    $url = 'admin/' . $lang . '/' . $module->link;

    $url_index_table= url($url . '/index-records-table/'.$user->id);
    ?>
        <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fa {{$module->design->icon}}"></i> {{$module->title}}
                            <a class="btn btn-success btn-sm" href="{{url($url.'/'.$user->id)}}">{{__('records.box')}}</a>
                            <a class="btn btn-warning btn-sm" href="{{$url_index_table.'?'.$query}}">{{__('records.table')}}</a>
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{url($url)}}">{{$module->title}}</a>
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

                                    // Наоѓање на селектираната земја од request или првата земја од assignCountries
                                    $id_country = app('request')->input($name) ?? optional($assignCountries->first())->id;

                                    // Наоѓање на името на селектираната земја
                                    $selectedCountry = $assignCountries->where('id', $id_country)->first();
                                    $country_name = optional($selectedCountry)->name ?? optional($assignCountries->first())->name;
                                    ?>
                                    <label class="control-label">{{$desc}}</label>
                                    <select class="select2bs4"
                                            id="{{$name}}" name="{{$name}}" onchange="this.form.submit()"
                                            style="width: 100%">
                                        @if(count($assignCountries) > 0)
                                            @foreach($assignCountries as $country)
                                                <option
                                                    value="{{$country->id}}" {{ ($id_country == $country->id) ? 'selected' : '' }}>
                                                    {{$country->name}} ({{$country->id}})
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                                    <?php
                                    $name = 'year';
                                    $desc = __('records.year');
                                    ?>
                                    <label class="control-label">{{$desc}}
                                    </label>

                                    <select class="select2bs4"
                                            id="{{$name}}" name="{{$name}}" onchange="this.form.submit()"
                                            style="width: 100%">
                                        @if(count($years) > 0)

                                            @foreach($years as $year)
                                                <option value="{{$year}}"
                                                    {{ ($year_selected==$year)? 'selected' : '' }}>{{$year}}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                                    <?php
                                    $name = 'month';
                                    $desc = __('records.month');
                                    ?>
                                    <label class="control-label">{{$desc}}
                                    </label>

                                    <select class="select2bs4"
                                            id="{{$name}}" name="{{$name}}" onchange="this.form.submit()"
                                            style="width: 100%">
                                        <option value="1" {{ $month_selected==1 ? 'selected' : '' }}>January</option>
                                        <option value="2" {{ $month_selected==2 ? 'selected' : '' }}>February</option>
                                        <option value="3" {{ $month_selected==3 ? 'selected' : '' }}>March</option>
                                        <option value="4" {{ $month_selected==4 ? 'selected' : '' }}>April</option>
                                        <option value="5" {{ $month_selected==5 ? 'selected' : '' }}>May</option>
                                        <option value="6" {{ $month_selected==6 ? 'selected' : '' }}>June</option>
                                        <option value="7" {{ $month_selected==7 ? 'selected' : '' }}>July</option>
                                        <option value="8" {{ $month_selected==8 ? 'selected' : '' }}>August</option>
                                        <option value="9" {{ $month_selected==9 ? 'selected' : '' }}>September</option>
                                        <option value="10" {{ $month_selected==10 ? 'selected' : '' }}>October</option>
                                        <option value="11" {{ $month_selected==11 ? 'selected' : '' }}>November</option>
                                        <option value="12" {{ $month_selected==12 ? 'selected' : '' }}>December</option>
                                        <option value="all" {{ $month_selected=='all'? 'selected' : '' }}>All</option>

                                    </select>
                                </div>

                                <div class="col-sm-6 col-md-2  col-lg-2 col-xl-2">
                                    <label class="control-label"> &nbsp;</label>
                                    <button type="button"
                                            class="form-control form-control-sm btn btn-outline-secondary btn-sm"
                                            title="{{__('global.reset_button_des')}}"
                                            onClick="window.open('{{ url($url)}}','_self');"> {{__('global.reset_button')}}
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

                <div id="index-container">

                    @include('Records::records._index')
                </div>






        </section>
        <!-- /.content -->


    </div>

@endsection
@section('additional_css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ url('LTE/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{ url('LTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <style>


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
            // $('.select2').select2()
        })
    </script>
@endsection
