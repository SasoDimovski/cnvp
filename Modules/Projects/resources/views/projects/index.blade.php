@extends('admin/master')

@section('content')

    <?php
    $id_module = $module->id ?? '';
    $lang = request()->segment(2);
    $query = request()->getQueryString();
    $listing = app('request')->input('listing', config('projects.pagination'));

    $global_style = "cursor: pointer; color: #BD362F";
    $global_style_search = "background-color: #BD362F; color: #fff";

    $url = url('admin/' . $lang . '/' . $module->link);

    $url_base= 'admin/'.$lang.'/'.$id_module.'/projects/';

    $url_create= url($url_base.'create/');
    $url_edit = url($url_base.'edit/');
    $url_show = url($url_base.'show/');
    $url_delete = url($url_base.'delete/');

    $url_excel = url(request()->segment(3)."/excel/".$query);
    $url_pdf = url(request()->segment(3)."/pdf/".$query);

    ?>
    @include('projects::projects._include-functions.function-highlight-search')
        <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fa {{$module->design->icon}}"></i> {{$module->title}} <a class="btn btn-danger btn-sm" href="{{$url_create}}">{{__('global.new_record')}}</a></h1>
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
                    <div class="card card-red card-outline">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                    <?php
                                    $name = 'id';
                                    $desc = __('projects.id');
                                    $maxlength = 10;

                                    $value = app('request')->input($name) ? app('request')->input($name) : null;
                                    $style = app('request')->input($name) ? $global_style : null;
                                    $x = app('request')->input($name) ? ('    x') : null;
                                    ?>
                                    <label class="control-label">{{$desc}}
                                        <b onclick="deleteSearchInput('{{$name}}','{{$query}}')" style="{{$style}}"
                                           title="{{__('global.delete_search_field_des')}}">{{$x}}</b>
                                    </label>
                                    <input type="text" id="{{$name}}" name="{{$name}}"
                                           class="form-control form-control-sm"
                                           value="{{$value}}"
                                           placeholder="{{$desc}}" maxlength="{{$maxlength}}">
                                </div>
                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3">
                                    <?php
                                    $name = 'name';
                                    $desc = __('projects.name');
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
                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3">
                                    <?php
                                    $name = 'code';
                                    $desc = __('projects.code');
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

                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3">
                                    <?php
                                    $name = 'start_date';
                                    $desc = __('projects.start_date');
                                    $maxlength = 100;

                                    $value = app('request')->input($name) ? app('request')->input($name) : null;
                                    $style = app('request')->input($name) ? $global_style : null;
                                    $x = app('request')->input($name) ? ('    x') : null;
                                    ?>
                                    <i class="fas fa-calendar text-success"></i> <label class="control-label">{{$desc}}
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
                                    $name = 'end_date';
                                    $desc = __('projects.end_date');
                                    $maxlength = 100;

                                    $value = app('request')->input($name) ? app('request')->input($name) : null;
                                    $style = app('request')->input($name) ? $global_style : null;
                                    $x = app('request')->input($name) ? ('    x') : null;
                                    ?>
                                        <i class="fas fa-calendar text-success"></i> <label class="control-label">{{$desc}}
                                        <b onclick="deleteSearchInput('{{$name}}','{{$query}}')" style="{{$style}}"
                                           title="{{__('global.delete_search_field')}}">{{$x}}</b>
                                    </label>
                                    <input type="text" id="{{$name}}" name="{{$name}}"
                                           class="form-control form-control-sm"
                                           value="{{$value}}"
                                           placeholder="{{$desc}}" maxlength="{{$maxlength}}">
                                </div>
                            </div>

                            <div class="row" style="height: 7px"></div>

                            <div class="row">

                                <div class="col-sm-6 col-md-2 col-lg-3 col-xl-2">
                                    <div class="row" style="height: 17px"></div>
                                    <div class="custom-control custom-checkbox">
                                        <?php
                                        $name = 'active';
                                        $desc = __('global.active');
                                        ?>
                                        <input class="custom-control-input" type="checkbox" id="{{$name}}"
                                               name="{{$name}}" value="1"
                                               {{ ((app('request')->input($name))!='')? 'checked' : '' }}  onchange="this.form.submit()">
                                        <label for="{{$name}}"
                                               class="custom-control-label"
                                               id="{{$name}}">{{$desc}}</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <?php
                                        $name = 'deactivated';
                                        $desc = __('global.deactivated');
                                        ?>
                                        <input class="custom-control-input" type="checkbox" id="{{$name}}"
                                               name="{{$name}}" value="1"
                                               {{ ((app('request')->input($name))!='')? 'checked' : '' }}  onchange="this.form.submit()">
                                        <label for="{{$name}}"
                                               class="custom-control-label"
                                               id="{{$name}}">{{$desc}}</label>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-2 col-lg-3 col-xl-2">
                                    <div class="row" style="height: 17px"></div>
                                    <div class="custom-control custom-checkbox">
                                        <?php
                                        $name = 'expired';
                                        $desc = __('global.expired');
                                        ?>
                                        <input class="custom-control-input" type="checkbox" id="{{$name}}"
                                               name="{{$name}}" value="1"
                                               {{ ((app('request')->input($name))!='')? 'checked' : '' }}  onchange="this.form.submit()">
                                        <label for="{{$name}}"
                                               class="custom-control-label"
                                               id="{{$name}}">{{$desc}}</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <?php
                                        $name = 'expired_no';
                                        $desc = __('global.expired_no');
                                        ?>
                                        <input class="custom-control-input" type="checkbox" id="{{$name}}"
                                               name="{{$name}}" value="1"
                                               {{ ((app('request')->input($name))!='')? 'checked' : '' }}  onchange="this.form.submit()">
                                        <label for="{{$name}}"
                                               class="custom-control-label"
                                               id="{{$name}}">{{$desc}}</label>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-2 col-lg-1 col-xl-1">
                                    <?php
                                    $name = 'listing';
                                    $desc = __('global.listing');
                                    $options = [
                                        1 => '1',
                                        15 => '15',
                                        50 => '50',
                                        100 => '100',
                                        200 => '200',
                                        'a' => __('global.all'),
                                    ];
                                    ?>
                                    <label class="control-label">{{ $desc }}</label>
                                    <select id="{{ $name }}" name="{{ $name }}" class="form-control form-control-sm" onchange="this.form.submit()">
                                        @foreach($options as $value => $label)
                                            <option value="{{ $value }}"
                                                {{ $listing == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
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
                @include('admin._flash-message')
                <!-- Table =============================================================================================== -->
                <div class="card card-gray card-outline">

                    <div class="card-body scrollmenu">
                        @include('flash::message')
                        @if(count($projects) > 0)
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
                                                class="badge badge-warning">{{ $projects->firstItem() }}</span></strong>
                                        {{__('global.to')}}
                                        <strong> <span
                                                class="badge badge-warning">{{$projects->lastItem() }}</span></strong>
                                        ({{__('global.sum')}}
                                        <strong> <span
                                                class="badge badge-danger">{{ $projects->total() }}</span></strong>
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
                                                    $column_desc = __('projects.id');
                                                    $query_sort = request()->query('sort');
                                                    $style_acs_desc = match(true) {
                                                        $query_sort == 'asc' && $order == $column_name => 'asc',
                                                        $query_sort == 'desc' && $order == $column_name => 'desc',
                                                        $query_sort == '' => 'desc',
                                                        default => $style_acs_desc='',
                                                    };
                                                    ?>
                                                <th class="sortable {{$style_acs_desc}}" style="white-space: nowrap; width: 1px;"
                                                    onclick="orderBy('id','{{$sort}}')">{{$column_desc}}&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                {{-- ========================================================================--}}
                                                <th style="white-space: nowrap; width: 1px;" class="target-cell"></th>
                                                {{-- ========================================================================--}}
                                                    <?php
                                                    $column_name = 'name';
                                                    $column_desc = __('projects.name');
                                                    $query_sort = request()->query('sort');
                                                    $style_acs_desc = match(true) {
                                                        $query_sort == 'asc' && $order == $column_name => 'asc',
                                                        $query_sort == 'desc' && $order == $column_name => 'desc',
                                                        default => $style_acs_desc='',
                                                    };
                                                    ?>
                                                <th class="sortable {{$style_acs_desc}}"
                                                    onclick="orderBy('{{$column_name}}','{{$sort}}')">{{$column_desc}}&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                {{-- ========================================================================--}}
                                                    <?php
                                                    $column_name = 'code';
                                                    $column_desc = __('projects.code');
                                                    $query_sort = request()->query('sort');
                                                    $style_acs_desc = match(true) {
                                                        $query_sort == 'asc' && $order == $column_name => 'asc',
                                                        $query_sort == 'desc' && $order == $column_name => 'desc',
                                                        default => $style_acs_desc='',
                                                    };
                                                    ?>
                                                <th class="sortable {{$style_acs_desc}}" style="white-space: nowrap; width: 1px;"
                                                    onclick="orderBy('{{$column_name}}','{{$sort}}')">{{$column_desc}}&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                {{-- ========================================================================--}}
                                                    <?php
                                                    $column_name = 'start_date';
                                                    $column_desc = __('projects.start_date');
                                                    $query_sort = request()->query('sort');
                                                    $style_acs_desc = match(true) {
                                                        $query_sort == 'asc' && $order == $column_name => 'asc',
                                                        $query_sort == 'desc' && $order == $column_name => 'desc',
                                                        default => $style_acs_desc='',
                                                    };
                                                    ?>
                                                <th class="sortable {{$style_acs_desc}}" style="white-space: nowrap; width: 1px;"
                                                    onclick="orderBy('{{$column_name}}','{{$sort}}')"><i class="fas fa-calendar"></i> {{$column_desc}}&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                {{-- ========================================================================--}}
                                                    <?php
                                                    $column_name = 'end_date';
                                                    $column_desc = __('projects.end_date');
                                                    $query_sort = request()->query('sort');
                                                    $style_acs_desc = match(true) {
                                                        $query_sort == 'asc' && $order == $column_name => 'asc',
                                                        $query_sort == 'desc' && $order == $column_name => 'desc',
                                                        default => $style_acs_desc='',
                                                    };
                                                    ?>
                                                <th class="sortable {{$style_acs_desc}}" style="white-space: nowrap; width: 1px;"
                                                    onclick="orderBy('{{$column_name}}','{{$sort}}')"><i class="fas fa-calendar"></i> {{$column_desc}}&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                {{-- ========================================================================--}}

{{--                                                    <?php--}}
{{--                                                    $column_name = 'type';--}}
{{--                                                    $column_desc = __('projects.type');--}}
{{--                                                    $query_sort = request()->query('sort');--}}
{{--                                                    $style_acs_desc = match(true) {--}}
{{--                                                        $query_sort == 'asc' && $order == $column_name => 'asc',--}}
{{--                                                        $query_sort == 'desc' && $order == $column_name => 'desc',--}}
{{--                                                        default => $style_acs_desc='',--}}
{{--                                                    };--}}
{{--                                                    ?>--}}
{{--                                                <th class="sortable {{$style_acs_desc}}" style="white-space: nowrap; width: 1px;"--}}
{{--                                                    onclick="orderBy('{{$column_name}}','{{$sort}}')">{{$column_desc}}&nbsp;&nbsp;&nbsp;&nbsp;</th>--}}
                                                {{-- ========================================================================--}}
                                                    <?php
                                                    $column_name = 'assignments';
                                                    $column_desc = __('projects.assignments');
                                                    $query_sort = request()->query('sort');
                                                    $style_acs_desc = match(true) {
                                                        $query_sort == 'asc' && $order == $column_name => 'asc',
                                                        $query_sort == 'desc' && $order == $column_name => 'desc',
                                                        default => $style_acs_desc='',
                                                    };
                                                    ?>
                                                <th class="sortable {{$style_acs_desc}}" style="white-space: nowrap; width: 1px;"
                                                    onclick="orderBy('{{$column_name}}','{{$sort}}')">{{$column_desc}}&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                {{-- ========================================================================--}}
                                                    <?php
                                                    $column_name = 'activities';
                                                    $column_desc = __('projects.activities');
                                                    $query_sort = request()->query('sort');
                                                    $style_acs_desc = match(true) {
                                                        $query_sort == 'asc' && $order == $column_name => 'asc',
                                                        $query_sort == 'desc' && $order == $column_name => 'desc',
                                                        default => $style_acs_desc='',
                                                    };
                                                    ?>
                                                <th class="sortable {{$style_acs_desc}}" style="white-space: nowrap; width: 1px;"
                                                    onclick="orderBy('{{$column_name}}','{{$sort}}')">{{$column_desc}}&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                {{-- ========================================================================--}}
                                                    <?php
                                                    $column_name = 'records';
                                                    $column_desc = __('projects.records');
                                                    $query_sort = request()->query('sort');
                                                    $style_acs_desc = match(true) {
                                                        $query_sort == 'asc' && $order == $column_name => 'asc',
                                                        $query_sort == 'desc' && $order == $column_name => 'desc',
                                                        default => $style_acs_desc='',
                                                    };
                                                    ?>
                                                <th class="sortable {{$style_acs_desc}}" style="white-space: nowrap; width: 1px;"
                                                    onclick="orderBy('{{$column_name}}','{{$sort}}')">{{$column_desc}}&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                {{-- ========================================================================--}}
                                                <th style="white-space: nowrap; width: 1px;"><i class="fas fa-lock"  title="{{__('global.active_status')}}"></i>
                                                </th>
                                                {{-- ========================================================================--}}
                                                <th style="white-space: nowrap; width: 1px;"><i class="fas fa-archive"  title="{{__('global.expired_status')}}"></i>
                                                </th>
                                                {{-- ========================================================================--}}
                                                <th style="white-space: nowrap; width: 1px;" class="source-cell"></th>
                                                {{-- ========================================================================--}}
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($projects as $project)
                                                    @php
                                                        $isExpired = isset($project->end_date) && \Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($project->end_date));
                                                    @endphp
                                                <tr @if($isExpired) style="color: #BD362F" @elseif($project->active == 0) style="color: #cccccc"  @endif >

                                                    <td class="text-center">{!! highlightSearch($project->id, 'id', $global_style_search) !!}</td>
                                                    <td  class="target-cell"> </td>
                                                    <td>{!! highlightSearch($project->name, 'name', $global_style_search) !!}</td>
                                                    <td>{!! highlightSearch($project->code, 'code', $global_style_search) !!}</td>
                                                    <td class="text-center" title="{!! date("d.m.Y  H:i:s", strtotime($project->start_date )) !!}">{!!  highlightSearch(date("d.m.Y", strtotime($project->start_date )), 'start_date', $global_style_search)  !!}</td>
                                                    <td class="text-center" title="{!! date("d.m.Y  H:i:s", strtotime($project->end_date )) !!}">{!! date("d.m.Y", strtotime($project->end_date )) !!}</td>
{{--                                                    <td class="text-center">--}}
{{--                                                        @if($project->type== 1)--}}
{{--                                                            <i class="fas fa-check text-gray"></i>--}}
{{--                                                        @endif--}}

{{--                                                    </td>--}}
                                                    <td class="text-center">{{ $project->assignments_count   }}</td>
                                                    <td class="text-center">{{ $project->activities_count    }}</td>
                                                    <td class="text-center">{{ $project->records_count    }}</td>

                                                    <td>
                                                        @if($project->active == 0)
                                                            <i class="fas fa-lock"
                                                               title="{{__('global.deactivated')}}"></i>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($isExpired)
                                                            <i class="fas fa fa-archive text-red"
                                                               title="{{__('global.expired')}}"></i>
                                                        @endif
                                                    </td>
                                                    <td  class="source-cell">
                                                        <div class="btn-group btn-group-sm">
                                                            {{-------------------------------------------------------------------------------------------------------}}
                                                            <button class="btn btn-info"
                                                                    onclick="getContentID('{{$url_show.'/'. $project->id }}','ModalShow','{{ $module->title}}')">
                                                                <i class="fas fa-eye"
                                                                   title="{{__('global.show_hint')}}"></i></button>
                                                            {{-------------------------------------------------------------------------------------------------------}}

                                                                {{-------------------------------------------------------------------------------------------------------}}
                                                                <a href="{{$url_edit.'/'.$project->id.'?'.$query }}"
                                                                   class="btn btn-success"><i
                                                                        class="fa fa-edit"
                                                                        title="{{__('global.edit_hint')}}"></i></a>
                                                                {{-------------------------------------------------------------------------------------------------------}}
                                                                <a href="#" class="btn btn-danger modal_warning"
                                                                   data-toggle="modal"
                                                                   data-target="#ModalWarning"

                                                                   data-title="{{__('global.delete_record')}}"
                                                                   data-url="{{$url_delete.'/'.$project->id.'?'.$query }}"

                                                                   data-content_l="id: {{$project->id}}, "
                                                                   data-content_b="{{ $project->name}}, "
                                                                   data-content_sub_l="{{ $project->code}}"
                                                                   data-content_sub_b=""

                                                                   data-query="{{$query}}"
                                                                   data-url_return="{{$url}}"
                                                                   data-success="{{__('global.delete_success')}}"
                                                                   data-error="{{__('global.delete_error')}}"

                                                                   data-method="DELETE"

                                                                   title="{{__('global.delete_hint')}}">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                                {{-------------------------------------------------------------------------------------------------------}}


                                                        </div>

                                                    </td>
                                                </tr>


                                            </tbody>
                                            @endforeach

                                        </table>
                                    </div>
                                </div>

                                <!-- Page =============================================================================================== -->

                                <div class="row">
                                    <div class="col-sm-6 col-md-6">

                                            <?php
                                            $query = request()->getQueryString();
                                            if (empty($query)) {
                                                $query = 'r';
                                            }
                                            ?>
{{--                                        <a class="btn btn-default btn-sm"
                                           href="{{ $url_pdf}}"
                                           title="{{__('global.export_pdf')}}"><i
                                                class="fa fa-print"></i> {{__('global.export_pdf')}}
                                        </a>
                                        <a class="btn btn-default btn-sm"
                                           href="{{$url_excel}}"
                                           title="{{__('global.export_csv')}}"><i
                                                class="fa fa-print"></i> {{__('global.export_csv')}}
                                        </a>--}}
                                    </div>


                                    <div class="col-sm-6 col-md-6">
                                        <div class="pagination pagination-sm float-right">
                                            {{ $projects->withQueryString()->links('pagination::bootstrap-4')  }}
                                        </div>

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
            initializeDatePicker('input[name="start_date"]');
            initializeDatePicker('input[name="end_date"]');
        });


        $(function () {
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
            //Initialize Select2 Elements
            $('.select2').select2()
        })
    </script>
@endsection
