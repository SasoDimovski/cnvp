@extends('admin/master')

@section('content')

    <?php
    $id_module = $module->id ?? '';
    $lang = request()->segment(2);
    $query = request()->getQueryString();
    $listing = app('request')->input('listing', config('users.pagination'));

    $global_style = "cursor: pointer; color: #BD362F";
    $global_style_search = "background-color: #BD362F; color: #fff";

    $year_current = date('Y');
    $year_selected = app('request')->input('year') ? app('request')->input('year') : date('Y');

    $month_current = date('m');
    $month_selected = app('request')->input('month') ? app('request')->input('month') : date('m');



    $url = url('admin/' . $lang . '/' . $module->link); //admin/mk/14/records

    $url_table = $url.'/index-records-table/'.$user->id;
    $url_box = $url.'/'.$user->id;

    $url_create = $url .'/create-record-table/'.$year_selected.'/'.$user->id.'?'.$query;

    $url_edit = $url.'/edit-record-table';
    $url_show = $url.'/show-record-table';
    $url_delete = $url.'/delete-record-table';

    $url_return =$url_table;


    $total = 0;
    $message_error = __('global.update_error');
    $message_success = __('global.update_success');
    ?>
    @include('users::users._include-functions.function-highlight-search')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>
                            <i class="fa {{$module->design->icon}}"></i> {{$module->title}}
                            <a class="btn btn-success btn-sm" href="{{$url_box}}">{{__('records.box')}}</a>
                            <a class="btn btn-warning btn-sm" href="{{$url_table}}">{{__('records.table')}}</a>
                           @if($isYearLocked == 0)
                            <a class="btn btn-danger btn-sm" href="#" onclick="getContentID('{{$url_create}}','ModalShow','{{ __('records.title_working_hours',['date'=>$year_selected]) }}')">{{__('global.new_record')}}</a></h1>
                           @endif
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
                    <input type="hidden" id="page" name="page" value="{{ app('request')->input('page') }}">
                    <!-- card card-red card-outline =============================================================================================== -->
                    <div class="card card-warning card-outline">
                        <div class="card-body">


                            <div class="row">

                                <div class="col-sm-12 col-md-4 col-lg-5 col-xl-3">
                                    <?php
                                    $name = 'id_country';
                                    $desc = __('records.id_country');

                                    // Наоѓање на селектираната земја од request или првата земја од assignCountries
                                    $id_country = app('request')->input($name) ?? 'all';

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
                                        <option value="all" {{ $id_country=='all'? 'selected' : '' }}>All</option>
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
                            </div>
                            <div class="row" style="height: 7px"></div>
                            <div class="row">

                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3">
                                    <?php
                                    $name = 'date_from';
                                    $desc = __('records.date_from');
                                    $maxlength = 100;

                                    $value = app('request')->input($name) ? app('request')->input($name) : null;
                                    $style = app('request')->input($name) ? $global_style : null;
                                    $x = app('request')->input($name) ? ('    x') : null;
                                    ?>
                                    <label class="control-label">{{$desc}}
                                        <b onclick="deleteSearchInput('{{$name}}','{{$query}}')" style="{{$style}}"
                                           title="{{__('global.delete_search_field')}}">{{$x}}</b>
                                    </label>
                                    <input type="text" id="{{$name}}" name="{{$name}}"
                                           class="form-control form-control-sm"
                                           value="{{$value}}"
                                           placeholder="{{$desc}}" maxlength="{{$maxlength}}">
                                </div>

                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">

                                    <?php
                                    $name = 'date_to';
                                    $desc = __('records.date_to');
                                    $maxlength = 100;

                                    $value = app('request')->input($name) ? app('request')->input($name) : null;
                                    $style = app('request')->input($name) ? $global_style : null;
                                    $x = app('request')->input($name) ? ('    x') : null;
                                    ?>
                                    <label class="control-label">{{$desc}}
                                        <b onclick="deleteSearchInput('{{$name}}','{{$query}}')" style="{{$style}}"
                                           title="{{__('global.delete_search_field')}}">{{$x}}</b>
                                    </label>
                                    <input type="text" id="{{$name}}" name="{{$name}}"
                                           class="form-control form-control-sm"
                                           value="{{$value}}"
                                           placeholder="{{$desc}}" maxlength="{{$maxlength}}">
                                </div>

                                <div class="col-sm-6 col-md-2  col-lg-2 col-xl-2">
                                    <label class="control-label"> &nbsp;</label>
                                    <button type="button"
                                            class="form-control form-control-sm btn btn-outline-secondary btn-sm"
                                            title="{{__('global.reset_button_des')}}"
                                            onClick="window.open('{{$user->id}}','_self');"> {{__('global.reset_button')}}
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
                @include('admin._flash-message')
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
                <!-- Table =============================================================================================== -->
                <div class="card card-warning card-outline">

                    <div class="card-body scrollmenu">

                        @if(count($records) > 0)
                                <?php
                                $order = request()->query('order');
                                $sort = (request()->query('sort') == 'asc') ? 'desc' : 'asc';
                                ?>
                            <div class="dataTables_wrapper dt-bootstrap4">

                                <!-- Page =============================================================================================== -->
                                                                <div class="row">
                                                                    <div class="col-sm-12 col-md-5">
                                                                        {{__('global.show_from')}}
                                                                        <strong> <span
                                                                                class="badge badge-warning">{{ $records->firstItem() }}</span></strong>
                                                                        {{__('global.to')}}
                                                                        <strong> <span
                                                                                class="badge badge-warning">{{$records->lastItem() }}</span></strong>
                                                                        ({{__('global.sum')}}
                                                                        <strong> <span
                                                                                class="badge badge-danger">{{ $records->total() }}</span></strong>
                                                                        {{__('global.records')}})
                                                                    </div>
                                                                </div>
                                <!-- Page end =============================================================================================== -->

                                    <div class="row">
                                        <div class="col-sm-12">

                                            <table id="example2" class="table_grid">
                                                <thead>


                                                <tr>
                                                    {{-- ========================================================================--}}
                                                        <?php
                                                        $column_name = 'id';
                                                        $column_desc = __('records.id');
                                                        $query_sort = request()->query('sort');
                                                        $style_acs_desc = match (true) {
                                                            $query_sort == 'asc' && $order == $column_name => 'asc',
                                                            $query_sort == 'desc' && $order == $column_name => 'desc',
                                                            $query_sort == '' => 'desc',
                                                            default => $style_acs_desc = '',
                                                        };
                                                        ?>
                                                    <th class="sortable {{$style_acs_desc}}"
                                                        style="white-space: nowrap; width: 1px;"
                                                        onclick="orderBy('id','{{$sort}}')">{{$column_desc}}&nbsp;&nbsp;&nbsp;&nbsp;
                                                    </th>
                                                    {{-- ========================================================================--}}
                                                    <th style="white-space: nowrap; width: 1px;" class="target-cell"></th>
                                                    {{-- ========================================================================--}}


                                                        <?php
                                                        $column_name = 'id_country';
                                                        $column_desc = __('records.id_country');
                                                        $query_sort = request()->query('sort');
                                                        $style_acs_desc = match (true) {
                                                            $query_sort == 'asc' && $order == $column_name => 'asc',
                                                            $query_sort == 'desc' && $order == $column_name => 'desc',
                                                            default => $style_acs_desc = '',
                                                        };
                                                        ?>
                                                    <th class="sortable {{$style_acs_desc}}"
                                                        style="white-space: nowrap; width: 1px;"
                                                        onclick="orderBy('{{$column_name}}','{{$sort}}')">{{$column_desc}}
                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                    </th>
                                                    {{-- ========================================================================--}}
                                                        <?php
                                                        $column_name = 'year';
                                                        $column_desc = __('records.year');
                                                        $query_sort = request()->query('sort');
                                                        $style_acs_desc = match (true) {
                                                            $query_sort == 'asc' && $order == $column_name => 'asc',
                                                            $query_sort == 'desc' && $order == $column_name => 'desc',
                                                            default => $style_acs_desc = '',
                                                        };
                                                        ?>
                                                    <th class="sortable {{$style_acs_desc}}"
                                                        style="white-space: nowrap; width: 1px;"
                                                        onclick="orderBy('{{$column_name}}','{{$sort}}')">{{$column_desc}}
                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                    </th>
                                                    {{-- ========================================================================--}}
                                                        <?php
                                                        $column_name = 'date';
                                                        $column_desc = __('records.date');
                                                        $query_sort = request()->query('sort');
                                                        $style_acs_desc = match (true) {
                                                            $query_sort == 'asc' && $order == $column_name => 'asc',
                                                            $query_sort == 'desc' && $order == $column_name => 'desc',
                                                            default => $style_acs_desc = '',
                                                        };
                                                        ?>
                                                    <th class="sortable {{$style_acs_desc}}"
                                                        style="white-space: nowrap; width: 1px;"
                                                        onclick="orderBy('{{$column_name}}','{{$sort}}')">{{$column_desc}}
                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                    </th>
                                                    {{-- ========================================================================--}}
                                                        <?php
                                                        $column_name = 'project';
                                                        $column_desc = __('records.project');
                                                        $query_sort = request()->query('sort');
                                                        $style_acs_desc = match (true) {
                                                            $query_sort == 'asc' && $order == $column_name => 'asc',
                                                            $query_sort == 'desc' && $order == $column_name => 'desc',
                                                            default => $style_acs_desc = '',
                                                        };
                                                        ?>
                                                    <th class="sortable {{$style_acs_desc}}"
                                                        onclick="orderBy('{{$column_name}}','{{$sort}}')">{{$column_desc}}
                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                    </th>
                                                    {{-- ========================================================================--}}
                                                        <?php
                                                        $column_name = 'assignment';
                                                        $column_desc = __('records.assignment');
                                                        $query_sort = request()->query('sort');
                                                        $style_acs_desc = match (true) {
                                                            $query_sort == 'asc' && $order == $column_name => 'asc',
                                                            $query_sort == 'desc' && $order == $column_name => 'desc',
                                                            default => $style_acs_desc = '',
                                                        };
                                                        ?>
                                                    <th class="sortable {{$style_acs_desc}}"
                                                        onclick="orderBy('{{$column_name}}','{{$sort}}')">{{$column_desc}}
                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                    </th>
                                                    {{-- ========================================================================--}}
                                                        <?php
                                                        $column_name = 'activity';
                                                        $column_desc = __('records.activity');
                                                        $query_sort = request()->query('sort');
                                                        $style_acs_desc = match (true) {
                                                            $query_sort == 'asc' && $order == $column_name => 'asc',
                                                            $query_sort == 'desc' && $order == $column_name => 'desc',
                                                            default => $style_acs_desc = '',
                                                        };
                                                        ?>
                                                    <th class="sortable {{$style_acs_desc}}"
                                                        onclick="orderBy('{{$column_name}}','{{$sort}}')">{{$column_desc}}
                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                    </th>
                                                    {{-- ========================================================================--}}
                                                        <?php
                                                        $column_name = 'duration';
                                                        $column_desc = __('records.duration_s');
                                                        $query_sort = request()->query('sort');
                                                        $style_acs_desc = match (true) {
                                                            $query_sort == 'asc' && $order == $column_name => 'asc',
                                                            $query_sort == 'desc' && $order == $column_name => 'desc',
                                                            default => $style_acs_desc = '',
                                                        };
                                                        ?>
                                                    <th class="sortable {{$style_acs_desc}}"
                                                        style="white-space: nowrap; width: 1px;"
                                                        onclick="orderBy('{{$column_name}}','{{$sort}}')">{{$column_desc}}
                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                    </th>
                                                    {{-- ========================================================================--}}
                                                    <th style="white-space: nowrap; width: 1px;" ><i class="fas fa-lock"></i> {{__('records.projects')}}</th>
                                                    {{-- ========================================================================--}}
                                                    <th style="white-space: nowrap; width: 1px;"><i class="fas fa-lock"></i> {{__('records.year')}}</th>
                                                    {{-- ========================================================================--}}
                                                    <th style="white-space: nowrap; width: 1px;"><i class="fas fa-lock"></i> {{__('records.record')}}</th>
                                                    {{-- ========================================================================--}}
                                                    <th style="white-space: nowrap; width: 1px;">{{__('records.approved')}}</th>
                                                    {{-- ========================================================================--}}
                                                    <th style="white-space: nowrap; width: 1px;" class="source-cell"></th>
                                                    {{-- ========================================================================--}}
                                                </tr>

                                                </thead>
                                                <tbody>
                                                @foreach($records as $record)
                                                    @php $total = $total+$record->duration; @endphp
                                                    <tr  @if($record->lockrecord== 1||$record->locket_year== 1||$record->projects->active== 0) style="color: #cccccc" @endif>
                                                        <td>{!! $record->id !!}</td>
                                                        <td  class="target-cell"> </td>
                                                        <td>{!! $record->countries->name !!}</td>
                                                        <td class="text-center">{!!$record->year !!}</td>
                                                        <td class="text-center">{!! date("d.m.Y", strtotime($record->date))!!}</td>
                                                        <td>{!! highlightSearch( $record->projects->name, 'project', $global_style_search) !!}</td>
                                                        <td>{!! highlightSearch( $record->assignments->name, 'assignment', $global_style_search) !!}</td>
                                                        <td>{!! highlightSearch( $record->activities->name, 'activity', $global_style_search) !!}
                                                            @if($record->note )
                                                                &nbsp;<i class="fas fa-comment text-warning" title="{{$record->note}}"></i>

                                                            @endif
                                                            </td>
                                                        <td class="text-center">{!!$record->duration !!}</td>

                                                        <td class="text-center">
                                                            @if($record->projects->active== 0)
                                                                <i class="fas fa-lock"
                                                                   title="{{__('records.locked_project')}}"></i>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if($record->locket_year== 1)
                                                                <i class="fas fa-lock"
                                                                   title="{{__('records.locked_year')}}"></i>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if($record->lockrecord== 1)
                                                                <i class="fas fa-lock"
                                                                   title="{{__('records.locked_record')}}"></i>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if($record->approvedby)
                                                                <i class="fas fa-check"
                                                                   title="{{__('records.approved')}}: {{$record->approvedByUser->name }} {{$record->approvedByUser->surname }}, id: {{$record->approvedByUser->id}}"></i>
                                                            @endif
                                                        </td>
                                                        <td  class="source-cell">
                                                            <div class="btn-group btn-group-sm">

                                                                {{-------------------------------------------------------------------------------------------------------}}
                                                                <button class="btn btn-info"
                                                                        type="button"
                                                                        onclick="getContentID('{{$url_show.'/'. $record->id.'/'.$user->id}}','ModalShow','{{ __('records.records') }}')">
                                                                    <i class="fas fa-eye"
                                                                       title="{{__('global.show_hint')}}"></i></button>
                                                                {{-------------------------------------------------------------------------------------------------------}}
                                                                @if($record->lockrecord== 0&&$record->locket_year== 0&&$record->projects->active==1)
                                                                {{-------------------------------------------------------------------------------------------------------}}
                                                                <a href="#"
                                                                   class="btn btn-success"
                                                                   onclick="getContentID('{{$url_edit.'/'.date("Y", strtotime($record->date)).'/'.$record->id.'/'.$user->id.'?'.$query}}','ModalShow','{{ __('records.records') }}')"
                                                                ><i
                                                                        class="fa fa-edit"
                                                                        title="{{__('global.edit_hint')}}"></i></a>
                                                                {{-------------------------------------------------------------------------------------------------------}}

                                                                {{-------------------------------------------------------------------------------------------------------}}
                                                                <a href="#" class="btn btn-danger modal_warning"
                                                                   data-toggle="modal"
                                                                   data-target="#ModalWarning"

                                                                   data-title="{{__('global.delete_record')}}"
                                                                   data-url="{{$url_delete.'/'.$record->id.'/'.$user->id.'?'.$query }}"

                                                                   data-content_l="id: <strong class='text-red'>{{$record->id}}</strong>, "
                                                                   data-content_b="{{ $record->projects->name}}, "
                                                                   data-content_sub_l="{{$record->assignments->name}},"
                                                                   data-content_sub_b="{{$record->activities->name}}"

                                                                   data-query="{{$query}}"
                                                                   data-url_return="{{$url_return}}"
                                                                   data-success="{{__('global.delete_success')}}"
                                                                   data-error="{{__('global.delete_error')}}"

                                                                   data-method="DELETE"

                                                                   title="{{__('global.delete_hint')}}">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                                {{-------------------------------------------------------------------------------------------------------}}
                                                                @endif

                                                            </div>

                                                        </td>

                                                    </tr>

                                                @endforeach
                                                <tr>

                                                    <td colspan="7" class="text-right">
                                                        <strong>{{__('records.total')}}:</strong></td>
                                                    <td class="text-center text-danger"><strong>{{ $total }}</strong>
                                                    </td>
                                                    <td colspan="5"></td>
                                                </tr>
                                                </tbody>


                                            </table>
                                        </div>
                                    </div>

                                <div class="col-sm-12 col-md-12">
                                    <div class="pagination pagination-sm float-right">
                                        {{ $records->withQueryString()->links('pagination::bootstrap-4')  }}
                                    </div>

                                </div>


                                <!-- Page end =============================================================================================== -->
                            </div>
                        @else
                            {{__('global.no_records')}}
                        @endif
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <!-- Table end =============================================================================================== -->


            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->


    </div>

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
        .target-cell {
            display: none;
        }

        @media (max-width: 1400px) {
            .source-cell {
                display: none;
            }

            .target-cell {
                display: table-cell;
            }
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

            // Конфигурација за Date Range Picker
            const datePickerConfig = {
                singleDatePicker: true,
                autoUpdateInput: false,
                showDropdowns: true,
                minYear: 2012,  // Минимална година
                maxYear: parseInt(moment().format('YYYY'), 10) + 1,  // Максимална година (тековна + 1)

                locale: {
                    format: "DD.MM.YYYY",
                    separator: " - ",
                    // applyLabel: "Внеси",
                    // cancelLabel: "Бриши",
                    fromLabel: "From",
                    toLabel: "To",
                    customRangeLabel: "Custom",
                    weekLabel: "W",
                    daysOfWeek: ["Не", "По", "Вт", "Ср", "Че", "Пе", "Са"],
                    // monthNames: [
                    //     "Јануари", "Февруари", "Март", "Април", "Мај", "Јуни",
                    //     "Јули", "Август", "Септември", "Октомври", "Ноември", "Декември"
                    // ],
                    firstDay: 1
                }
            };

            // Функција за иницијализација на Date Range Picker за дадено поле
            function initializeDatePicker(selector) {
                const inputField = $(selector);

                inputField.daterangepicker(datePickerConfig);

                inputField.on('apply.daterangepicker', function (ev, picker) {
                    $(this).val(picker.startDate.format('DD.MM.YYYY'));
                });

                inputField.on('cancel.daterangepicker', function () {
                    $(this).val('');
                });
            }

            // Иницијализација за `start_date` и `end_date`
            initializeDatePicker('input[name="date_from"]');
            initializeDatePicker('input[name="date_to"]');
        });

        $(function () {
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
@endsection
