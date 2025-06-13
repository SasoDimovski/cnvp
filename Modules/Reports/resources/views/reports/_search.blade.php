<form class="form-horizontal" name="form_search" id="form_search" method="get" action=""
      accept-charset="UTF-8">
    <input type="hidden" id="page" name="page" value="{{ app('request')->input('page') }}">
    <input type="hidden" id="type" name="type" value="{{ request()->input('type', 1) }}">
    <!-- card card-red card-outline =============================================================================================== -->
    <div class="card card-warning card-outline">
        <div class="card-body">

            <div class="row">
                <div class="col-sm-6 col-md-5 col-lg-4 col-xl-3">
                    @php
                        $queryParams = [];

                        if (!empty($query)) {
                            parse_str($query, $queryParams);
                        }

                        // Генерирање на query string за двата типа
                        $query_detail = http_build_query(array_merge($queryParams, ['type' => 1]));
                        $query_group = http_build_query(array_merge($queryParams, ['type' => 2]));
                    @endphp

                    <a class="btn btn-info btn "
                       href="{{'?'.$query_detail}}"
                       title="{{__('reports.type_detail')}}"><i
                            class="fa fa-list-alt"></i> {{__('reports.type_detail')}}
                    </a>

                    <a class="btn btn-success btn "
                       href="{{'?'.$query_group}}"
                       title="{{__('reports.type_group')}}"><i
                            class="fa fa-life-ring"></i> {{__('reports.type_group')}}
                    </a>
{{--                    <?php--}}
{{--                    $name = 'type';--}}
{{--                    $desc = __('reports.type');--}}
{{--                    $options = [--}}
{{--//                                        '' => ' ',--}}
{{--                        1 => __('reports.type_detail'),--}}
{{--                        2 => __('reports.type_group'),--}}
{{--                    ];--}}
{{--                    ?>--}}
{{--                    <label class="control-label">{{ $desc }}</label>--}}
{{--                    <select id="{{ $name }}" name="{{ $name }}" class="form-control form-control-sm" onchange="this.form.submit()">--}}
{{--                        @foreach($options as $value => $label)--}}
{{--                            <option value="{!! $value !!}"--}}
{{--                                {{ app('request')->input($name)==$value ? 'selected' : '' }}>--}}
{{--                                {{ $label }}--}}
{{--                            </option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}


                </div>



            </div>
<hr>

            <div class="row">



                <div class="col-sm-12 col-md-4 col-lg-5 col-xl-3">
                    <?php
                    $name = 'id_user';
                    $desc = __('reports.id_user');

                    $value = app('request')->input($name) ? app('request')->input($name) : null;
                    $style = app('request')->input($name) ? $global_style : null;
                    $x = app('request')->input($name) ? ('    x') : null;
                    ?>
                    <label class="control-label">{{$desc}}
                        <b onclick="deleteSearchInput('{{$name}}','{{$query}}')" style="{{$style}}"
                           title="{{__('global.delete_search_field_des')}}">{{$x}}</b>
                    </label>
                    <select class="select2bs4"
                            id="{{$name}}" name="{{$name}}" onchange="this.form.submit()"
                            style="width: 100%">
                        <option value="">&nbsp;</option>
                        @if(count($users) > 0)
                            @foreach($users as $user)
                                <option
                                    value="{{$user->id}}"  {{ ((app('request')->input($name))==$user->id)? 'selected' : '' }}>
                                    {{$user->name}} {{$user->surname}} / {{$user->username}}
                                </option>
                            @endforeach
                        @endif
{{--                        <option value="all" {{ app('request')->input($name)=='all'? 'selected' : '' }}>All</option>--}}
                    </select>
                </div>


                <div class="col-sm-12 col-md-4 col-lg-5 col-xl-3">
                    <?php
                    $name = 'id_country';
                    $desc = __('reports.id_country');

                    $value = app('request')->input($name) ? app('request')->input($name) : null;
                    $style = app('request')->input($name) ? $global_style : null;
                    $x = app('request')->input($name) ? ('    x') : null;
                    ?>
                    <label class="control-label">{{$desc}}
                        <b onclick="deleteSearchInput('{{$name}}','{{$query}}')" style="{{$style}}"
                           title="{{__('global.delete_search_field_des')}}">{{$x}}</b>
                    </label>
                    <select class="select2bs4"
                            id="{{$name}}" name="{{$name}}" onchange="this.form.submit()"
                            style="width: 100%">
                        <option value="">&nbsp;</option>
                        @if(count($countries) > 0)
                            @foreach($countries as $country)
                                <option
                                    value="{{$country->id}}"  {{ ((app('request')->input($name))==$country->id)? 'selected' : '' }}>
                                    {{$country->name}}
                                </option>
                            @endforeach
                        @endif
{{--                        <option value="all" {{ app('request')->input($name)=='all'? 'selected' : '' }}>All</option>--}}
                    </select>
                </div>


            </div>
            <div class="row" style="height: 7px"></div>
            <div class="row">
                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                    <?php
                    $name = 'year';
                    $desc = __('reports.year');

                    $value = app('request')->input($name) ? app('request')->input($name) : null;
                    $style = app('request')->input($name) ? $global_style : null;
                    $x = app('request')->input($name) ? ('    x') : null;
                    ?>
                    <label class="control-label">{{$desc}}
                        <b onclick="deleteSearchInput('{{$name}}','{{$query}}')" style="{{$style}}"
                           title="{{__('global.delete_search_field_des')}}">{{$x}}</b>
                    </label>

                    <select class="select2bs4"
                            id="{{$name}}" name="{{$name}}"  onchange="this.form.submit()"
                            style="width: 100%">
                        @if(count($years) > 0)
                            <option value="">&nbsp;</option>
                            @foreach($years as $year)
                                <option value="{{$year}}"
                                    {{ app('request')->input($name)==$year? 'selected' : '' }}>{{$year}}
                                </option>
                            @endforeach
                        @endif
                        {{--                        <option value="all" {{ app('request')->input($name)=='all'? 'selected' : '' }}>All</option>--}}
                    </select>
                </div>

                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                    <?php
                    $name = 'month';
                    $desc = __('reports.month');

                    $value = app('request')->input($name) ? app('request')->input($name) : null;
                    $style = app('request')->input($name) ? $global_style : null;
                    $x = app('request')->input($name) ? ('    x') : null;
                    ?>
                    <label class="control-label">{{$desc}}
                        <b onclick="deleteSearchInput('{{$name}}','{{$query}}')" style="{{$style}}"
                           title="{{__('global.delete_search_field_des')}}">{{$x}}</b>
                    </label>

                    <select class="select2bs4  form-control-sm"
                            id="{{$name}}" name="{{$name}}" onchange="this.form.submit()"
                            style="width: 100%">
                        <option value="" >&nbsp;</option>
                        <option value="1" {{ (app('request')->input($name))==1 ? 'selected' : '' }}>January</option>
                        <option value="2" {{ (app('request')->input($name))==2 ? 'selected' : '' }}>February</option>
                        <option value="3" {{ (app('request')->input($name))==3 ? 'selected' : '' }}>March</option>
                        <option value="4" {{ (app('request')->input($name))==4 ? 'selected' : '' }}>April</option>
                        <option value="5" {{ (app('request')->input($name))==5 ? 'selected' : '' }}>May</option>
                        <option value="6" {{ (app('request')->input($name))==6 ? 'selected' : '' }}>June</option>
                        <option value="7" {{ (app('request')->input($name))==7 ? 'selected' : '' }}>July</option>
                        <option value="8" {{ (app('request')->input($name))==8 ? 'selected' : '' }}>August</option>
                        <option value="9" {{ (app('request')->input($name))==9 ? 'selected' : '' }}>September</option>
                        <option value="10" {{ (app('request')->input($name))==10 ? 'selected' : '' }}>October</option>
                        <option value="11" {{ (app('request')->input($name))==11 ? 'selected' : '' }}>November</option>
                        <option value="12" {{ (app('request')->input($name))==12 ? 'selected' : '' }}>December</option>
{{--                        <option value="all" {{ (app('request')->input($name))=='all'? 'selected' : '' }}>All</option>--}}

                    </select>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                    <?php
                    $name = 'date_from';
                    $desc = __('reports.date_from');
                    $maxlength = 100;

                    $value = app('request')->input($name) ? app('request')->input($name) : null;
                    $style = app('request')->input($name) ? $global_style : null;
                    $x = app('request')->input($name) ? ('    x') : null;
                    ?>
                    <label class="control-label">{{$desc}}
                        <b onclick="deleteSearchInput('{{$name}}','{{$query}}')" style="{{$style}}"
                           title="{{__('global.delete_search_field_des')}}">{{$x}}</b>
                    </label>
                    <input type="text" id="{{$name}}" name="{{$name}}"
                           class="form-control"
                           readonly
                           value="{{app('request')->input($name)}}"
                           placeholder="{{$desc}}" maxlength="{{$maxlength}}">

                </div>

                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">

                    <?php
                    $name = 'date_to';
                    $desc = __('reports.date_to');
                    $maxlength = 100;

                    $value = app('request')->input($name) ? app('request')->input($name) : null;
                    $style = app('request')->input($name) ? $global_style : null;
                    $x = app('request')->input($name) ? ('    x') : null;
                    ?>
                    <label class="control-label">{{$desc}}
                        <b onclick="deleteSearchInput('{{$name}}','{{$query}}')" style="{{$style}}"
                           title="{{__('global.delete_search_field_des')}}">{{$x}}</b>
                    </label>
                    <input type="text" id="{{$name}}" name="{{$name}}"
                           class="form-control"
                           readonly
                           value="{{app('request')->input($name)}}"
                           placeholder="{{$desc}}" maxlength="{{$maxlength}}">

                </div>



            </div>

            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-5 col-xl-3">
                    <?php
                    $name = 'id_project[]';
                    $desc = __('reports.project');

                    $value =(!empty(app('request')->input(str_replace('[]', '', $name)))) ? app('request')->input($name) : null;
                    $style = (!empty(app('request')->input(str_replace('[]', '', $name)))) ? $global_style : null;
                    $x = (!empty(app('request')->input(str_replace('[]', '', $name)))) ? ' x' : null;
                    ?>
                    <label class="control-label">{{$desc}}
                        <b onclick="deleteSearchInput('{{ str_replace('[]', '', $name) }}','{{$query}}')" style="{{$style}}"
                           title="{{__('global.delete_search_field_des')}}">{{$x}}</b>
                    </label>
                    <select class="select2bs4" multiple="multiple"
                            id="id_project" name="{{$name}}"  onchange="this.form.submit()"
                            style="width: 100%">
{{--                        <option value="">&nbsp</option>--}}
                        @if(count($projects) > 0)
                            @foreach($projects as $project)
                                <option
                                    value="{{$project->id}}"
                                    {{ (is_array(app('request')->input('id_project')) && in_array($project->id, app('request')->input('id_project'))) ? 'selected' : '' }}>
                                    {{$project->name}} ({{$project->code}}, {{$project->id}})
                                </option>
                            @endforeach
                        @endif
{{--                        <option value="all" {{ app('request')->input($name)=='all'? 'selected' : '' }}>All</option>--}}
                    </select>
                </div>

                <div class="col-sm-12 col-md-4 col-lg-5 col-xl-3">
                    <?php
                    $name = 'id_assignment';
                    $desc = __('reports.assignment');

                    $value = app('request')->input($name) ? app('request')->input($name) : null;
                    $style = app('request')->input($name) ? $global_style : null;
                    $x = app('request')->input($name) ? ('    x') : null;
                    ?>
                    <label class="control-label">{{$desc}}
                        <b onclick="deleteSearchInput('{{$name}}','{{$query}}')" style="{{$style}}"
                           title="{{__('global.delete_search_field_des')}}">{{$x}}</b>
                    </label>
                    <select class="select2bs4"
                            id="{{$name}}" name="{{$name}}" onchange="this.form.submit()"
                            style="width: 100%">
                        <option value="">&nbsp;</option>
                        @if(count($assignments) > 0)
                            @foreach($assignments as $assignment)
                                <option
                                    value="{{$assignment->id}}"  {{ ((app('request')->input($name))==$assignment->id)? 'selected' : '' }}>
                                    {{$assignment->name}} ({{ $assignment->projects->name ?? 'N/A' }})
                                </option>
                            @endforeach
                        @endif
{{--                        <option value="all" {{ app('request')->input($name)=='all'? 'selected' : '' }}>All</option>--}}
                    </select>
                </div>


                <div class="col-sm-12 col-md-4 col-lg-5 col-xl-3">
                    <?php
                    $name = 'id_activity';
                    $desc = __('reports.activity');

                    $value = app('request')->input($name) ? app('request')->input($name) : null;
                    $style = app('request')->input($name) ? $global_style : null;
                    $x = app('request')->input($name) ? ('    x') : null;
                    ?>
                    <label class="control-label">{{$desc}}
                        <b onclick="deleteSearchInput('{{$name}}','{{$query}}')" style="{{$style}}"
                           title="{{__('global.delete_search_field_des')}}">{{$x}}</b>
                    </label>
                    <select class="select2bs4"
                            id="{{$name}}" name="{{$name}}" onchange="this.form.submit()"
                            style="width: 100%">
                        <option value="">&nbsp;</option>
                        @if(count($activities) > 0)
                            @foreach($activities as $activity)
                                <option
                                    value="{{$activity->id}}"  {{ ((app('request')->input($name))==$activity->id)? 'selected' : '' }}>
                                    {{$activity->name}}
                                </option>
                            @endforeach
                        @endif
{{--                        <option value="all" {{ app('request')->input($name)=='all'? 'selected' : '' }}>All</option>--}}
                    </select>
                </div>
            </div>
            <div class="row">


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
                        1000 => '1000',
                        5000 => '5000',
                        /* 'a' => __('global.all'),*/
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
                            onClick="window.open('{{ $url }}{{ request()->input('type') ? '?type=' . request()->input('type') : '?type=1' }}', '_self');"> {{__('global.reset_button')}}
                    </button>
                </div>

                <div class="col-sm-6 col-md-2  col-lg-2 col-xl-2">
                    <label class="control-label"> &nbsp;</label>
                    <button type="submit"
                            class="form-control form-control-sm btn btn-danger btn-sm"
                            title="{{__('global.search_button')}} ">{{__('global.search_button')}}
                    </button>


                </div>
            </div>


        </div>
    </div>
</form>
