@extends('admin/master')

@section('content')
    <?php
    $lang = request()->segment(2);
    ?>
    <!-- Content Wrapper. Contains page content -->
    <section class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{trans('main.index.welcome')}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/'.$lang.'/main/') }}">{{trans('global.header.home')}}</a></li>
{{--                            <li class="breadcrumb-item active"></li>--}}
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="card card-info card-outline">
                            {{--                <div class="card-header">--}}
                            {{--                    <h3 class="card-title">Icons</h3>--}}
                            {{--                </div> <!-- /.card-body -->--}}
                            <div class="card-body">

                                <p> {{trans('main.index.intro1')}} <strong>„{{config('app.TITLE')}}“</strong> {{trans('main.index.intro2')}} .<br>
                                    {{trans('main.index.intro3')}}  </p>
                                @include('admin._flash-message')


                                @if(Auth::id()==1)


{{--                                <div class="row">--}}


{{--                                    <div class="col-lg-2 col-2">--}}
{{--                                        <p><strong>Доделени модули (Модули и Групи)</strong></p>--}}

{{--                                            <ul >--}}
{{--                                                @if(count($assignedModulesAll) > 0)--}}
{{--                                                    @foreach($assignedModulesAll as $module)--}}

{{--                                                        @if($module['id_modules_type'] == 2) {{$css_modules_type ='text-red'}}@else {{$css_modules_type =''}} @endif--}}
{{--                                                            <li class="{{$css_modules_type}}">--}}
{{--                                                                {{ $module['id'] }}. {{ $module['title'] }}--}}
{{--                                                                (<strong>{{ $module['type'] }}</strong>)--}}

{{--                                                                @if(!empty($module['children']))--}}
{{--                                                                    @include('Main::main.tree-item', ['children' => $module['children']])--}}
{{--                                                                @endif--}}
{{--                                                            </li>--}}

{{--                                                    @endforeach--}}
{{--                                                @endif--}}

{{--                                            </ul>--}}

{{--                                    </div>--}}

{{--                                    <div class="col-lg-2 col-2">--}}
{{--                                        <p><strong>Доделени модули (Модули)</strong></p>--}}

{{--                                        <ul>--}}
{{--                                            @if(count($assignedModulesModules) > 0)--}}
{{--                                                @foreach($assignedModulesModules as $module)--}}
{{--                                                    <li>--}}
{{--                                                        {{ $module['id'] }}. {{ $module['title'] }} (<strong>{{ $module['type'] }}</strong>)--}}
{{--                                                        @if(!empty($module['children']))--}}
{{--                                                            @include('Main::main.tree-item', ['children' => $module['children']])--}}
{{--                                                        @endif--}}
{{--                                                    </li>--}}
{{--                                                @endforeach--}}
{{--                                            @endif--}}

{{--                                        </ul>--}}

{{--                                    </div>--}}
{{--                                    <div class="col-lg-3 col-3">--}}
{{--                                        <p><strong>Недоделени модули (Модули)</strong></p>--}}
{{--                                        <ul>--}}
{{--                                            @if(count($unassignedModulesModules) > 0)--}}
{{--                                                @foreach($unassignedModulesModules as $module)--}}

{{--                                                    <li class="@if($module['id_modules_type'] == 2) {{$css_modules_type ='text-red'}} @else {{$css_modules_type =''}} @endif">--}}
{{--                                                        {{ $module['id'] }}. {{ $module['title'] }} (<strong>{{ $module['type'] }}</strong>)--}}
{{--                                                        <a href="#" class="modal_warning"--}}
{{--                                                           data-toggle="modal"--}}
{{--                                                           data-target="#ModalWarning"--}}
{{--                                                           data-title="Додели модул на корисник"--}}
{{--                                                           data-url="/admin/main/{{ Auth::id()}}/{{ $module['id'] }}"--}}
{{--                                                           data-content_l="Корисник: {{ Auth::user()->username}} ({{ Auth::id()}})"--}}
{{--                                                           data-content_b="Модул: {{ $module['id'] }}. {{ $module['title'] }}"--}}
{{--                                                           title="Додели модул на корисник">--}}
{{--                                                        <---}}
{{--                                                        </a>--}}
{{--                                                        @if(!empty($module['children']))--}}
{{--                                                            @include('Main::main.tree-item', ['children' => $module['children']])--}}
{{--                                                        @endif--}}
{{--                                                    </li>--}}
{{--                                                @endforeach--}}
{{--                                            @endif--}}

{{--                                        </ul>--}}

{{--                                    </div>--}}

{{--                                    <div class="col-lg-2 col-2">--}}
{{--                                        <p> <strong>Доделени групи</strong> </p>--}}
{{--                                        @if(count($assignedGroups) > 0)--}}
{{--                                            @foreach($assignedGroups as $assignedGroup)--}}
{{--                                                {{$assignedGroup->id}}, {{$assignedGroup->title}} <br>--}}
{{--                                                @if($assignedGroup->modules->isEmpty())--}}
{{--                                                    <p>Нема модули поврзани со оваа група.</p>--}}
{{--                                                @else--}}

{{--                                                    @foreach($assignedGroup->modules as $module)--}}
{{--                                                        {{$module->id}}, {{ $module->title }} <br>--}}
{{--                                                    @endforeach--}}

{{--                                                @endif--}}
{{--                                            @endforeach--}}
{{--                                        @endif--}}
{{--                                    </div>--}}
{{--                                    <div class="col-lg-2 col-2">--}}
{{--                                        <p> <strong>Недоделени групи</strong> </p>--}}
{{--                                        @if(count($unassignedGroups ) > 0)--}}
{{--                                            @foreach($unassignedGroups as $unassignedGroups_)--}}
{{--                                                {{$unassignedGroups_->id}}, {{$unassignedGroups_->title}} <br>--}}
{{--                                            @endforeach--}}
{{--                                        @endif--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <div class="row" style="margin-top: 0px">--}}
{{--                                    <div class="col-lg-2 col-2">--}}
{{--                                        <p> <strong>Модули </strong> </p>--}}
{{--                                        @if(count($modules) > 0)--}}
{{--                                            @foreach($modules as $module)--}}
{{--                                                <li>--}}
{{--                                                    {{ $module['id'] }}. {{ $module['title'] }} (<strong>{{ $module['type'] }}</strong>)--}}
{{--                                                    @if(!empty($module['children']))--}}
{{--                                                        @include('Main::main.tree-item', ['children' => $module['children']])--}}
{{--                                                    @endif--}}
{{--                                                </li>--}}
{{--                                            @endforeach--}}
{{--                                        @endif--}}
{{--                                    </div>--}}
{{--                                    <div class="col-lg-2 col-2">--}}
{{--                                        <p> <strong>Групи</strong> </p>--}}
{{--                                        @foreach($groups as $group)--}}
{{--                                            <p style="margin-top: 20px">{{ $group['title']}}</p>--}}

{{--                                            @if($group['modules']->isEmpty())--}}
{{--                                                <p>Нема модули поврзани со оваа група.</p>--}}
{{--                                            @else--}}

{{--                                                    @foreach($group->modules as $module)--}}
{{--                                                       {{$module->id}}, {{ $module->title }} <br>--}}
{{--                                                    @endforeach--}}

{{--                                            @endif--}}


{{--                                        @endforeach--}}
{{--                                    </div>--}}
{{--                                    <div class="col-lg-2 col-2">--}}
{{--                                        <p><strong>Групи</strong></p>--}}
{{--                                        @foreach($groups as $group)--}}
{{--                                            <p style="margin-top: 20px">{{ $group->title }}</p>--}}

{{--                                            @if($group->modules->isEmpty())--}}
{{--                                                <p>Нема модули поврзани со оваа група.</p>--}}
{{--                                            @else--}}
{{--                                                <ul>--}}
{{--                                                    @foreach($group->modules as $module)--}}
{{--                                                        <li>--}}
{{--                                                            {{ $module['id'] }}. {{ $module['title'] }} (<strong>{{ $module['type'] }}</strong>)--}}
{{--                                                            @if(!empty($module['children']))--}}
{{--                                                                @include('Main::main.tree-item', ['children' => $module['children']])--}}
{{--                                                            @endif--}}
{{--                                                        </li>--}}
{{--                                                    @endforeach--}}
{{--                                                </ul>--}}
{{--                                            @endif--}}
{{--                                        @endforeach--}}
{{--                                    </div>--}}
{{--                                </div>--}}

                                @endif



                            </div><!-- /.card-body -->
                        </div>
                    </div>
                </div>


            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->


    </section>



@endsection

@section('additional_css')
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ url('LTE/plugins/ionicons/ionicons.min.css')}}">
@endsection
@section('additional_js')
@endsection
