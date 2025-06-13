@extends('admin/master')
@section('content')

    <?php
    $id_module = $module->id ?? '';
    $lang = request()->segment(2);
    $query = request()->getQueryString();

    $id = $user->id ?? '';
    $id_user_logged = Auth::id();
    $name = $user->name ?? old('name');
    $surname = $user->surname ?? old('surname');
    $id_country = $user->id_country ?? old('id_country');
    $address = $user->address ?? old('address');
    $phone = $user->phone ?? old('phone');
    $picture = $user->picture ?? old('photo');
    $email = $user->email ?? old('email');
    $email_verified_at = $user->email_verified_at ?? old('email_verified_at');
    $username = $user->username ?? old('username');
    $user_type = $user->user_type ?? old('user_type');
    $password = $user->password ?? '';
    $password_reset_hash = $user->password_reset_hash ?? old('password_reset_hash');
    $id_expiration_time = $user->id_expiration_time ?? old('id_expiration_time');
    $edb = $user->edb ?? old('edb');
    $active = $user->active ?? '';

    $created_at = (isset($user->created_at)) ? date("d.m.Y  H:i:s", strtotime($user->created_at)) : '';
    $updated_at = (isset($user->updated_at)) ? date("d.m.Y  H:i:s", strtotime($user->updated_at)) : '';


    $url = url('admin/' . $lang . '/' . $module->link);

    $url_store = url('admin/' . $lang . '/' . $id_module . '/users/store/');
    $url_update = url('admin/' . $lang . '/' . $id_module . '/users/update/' . $id);
    $url_action = !empty($id) ? $url_update : $url_store;

    $url_return = url('admin/' . $lang . '/' . $id_module . '/users/edit/' . $id);
    $url_send_email = url('admin/' . $lang . '/' . $id_module . '/users/send-email-reg/' . $id);

    $url_store_doc = url('admin/' . $lang . '/' . $id_module . '/users/store_doc/' . $id);
    $url_update_doc = url('admin/' . $lang . '/' . $id_module . '/users/update_doc/' . $id);
    $url_delete_doc = url('admin/' . $lang . '/' . $id_module . '/users/delete_doc/' . $id);


    $path_upload = 'uploads/users/';

    $message_error = (isset($id)) ? __('global.update_error') : __('global.save_error');
    $message_success = (isset($id)) ? __('global.update_success') : __('global.save_success');

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

                    <input type="hidden" id="id_user_logged" name="id_user_logged" value="{{ $id_user_logged}}">
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
                                    @if($active==0) &nbsp;<i class="fas fa-lock text-danger" title="{{__('global.deactivated')}}"></i>@endif
                                    <h3 class="card-title">  @if(isset($user)) id: {{$id}}@else {{__('global.new_record')}} @endif</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    {{--=========================================================--}}
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="active"
                                                           name="active"
                                                           value="1" @if($active==1||$active=='')
                                                        {{'checked'}}
                                                        @endif >
                                                    <label for="active"
                                                           class="custom-control-label"
                                                           id="active">{{__('users.active')}} </label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    {{--=========================================================--}}
                                    <div class="row">

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label
                                                    for="name" class="text-red">{{__('users.name')}}</label>
                                                <input type="text" id="name" name="name" class="form-control"
                                                       value="{{$name}}"
                                                       maxlength="100">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label
                                                    for="surname" class="text-red">{{__('users.surname')}}</label>
                                                <input type="text" id="surname" name="surname" class="form-control"
                                                       value="{{$surname}}"
                                                       maxlength="100">
                                            </div>
                                        </div>

                                    </div>
                                    {{--=========================================================--}}
                                    <div class="row">

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label
                                                    for="username" class="text-red">{{__('users.username')}}</label>
                                                <input type="text" id="username" name="username" class="form-control"
                                                       value="{{$username}}"
                                                       maxlength="100">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label
                                                    for="email" class="text-red">{{__('users.email')}}</label>
                                                <input type="text" id="email" name="email" class="form-control"
                                                       value="{{$email}}"
                                                       maxlength="100">
                                            </div>
                                        </div>

                                    </div>
                                    {{--=========================================================--}}
                                    <div class="row">

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label
                                                    for="address">{{__('users.address')}}</label>
                                                <input type="text" id="address" name="address" class="form-control"
                                                       value="{{$address}}"
                                                       maxlength="100">
                                            </div>
                                        </div>


{{--                                        <div class="col-sm-6">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label--}}
{{--                                                    for="id_country">{{__('users.id_country')}}</label>--}}
{{--                                                <select class="select2bs4" style="width:100%;" id="id_country"--}}
{{--                                                        name="id_country">--}}
{{--                                                    @if(count($countries) > 0)--}}
{{--                                                        <option value="">&nbsp;</option>--}}
{{--                                                        @foreach($countries as $country)--}}
{{--                                                            <option--}}
{{--                                                                value="{{$country->id}}" {{ ($id_country==$country->id)? 'selected' : '' }}>{{$country->name}}</option>--}}
{{--                                                        @endforeach--}}
{{--                                                    @endif--}}
{{--                                                </select>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

                                        <div class="col-sm-6">
                                            <?php
                                            $myArray = json_decode(json_encode($assignCountries), true);

                                            $input_value = $id_country;
                                            $input_name = 'id_country[]';
                                            $input_desc = __('users.id_country');
                                            $input_readonly = '';
                                            $input_css = 'text-red';
                                            ?>

                                            <div class="form-group">
                                                <label class="{{ $input_css }}">{{ $input_desc }}</label>
                                                <select class="select2bs4" style="width: 100%" multiple="multiple"
                                                        id="{{ $input_name }}"
                                                        name="{{ $input_name }}"
                                                        autocomplete="off" {{ $input_readonly }}>
                                                    @if (count($countries) > 0)
                                                        @foreach ($countries as $country)
                                                            <option
                                                                value="{{ $country->id }}"
                                                                {{ in_array($country->id, old('id_country', array_column($myArray, 'id'))) ? 'selected' : '' }}>
                                                                {{ $country->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    {{--=========================================================--}}
                                    <div class="row">

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label
                                                    for="phone">{{__('users.phone')}}</label>
                                                <input type="text" id="phone" name="phone" class="form-control"
                                                       value="{{$phone}}"
                                                       maxlength="100">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label
                                                    for="id_expiration_time"
                                                    class="text-red">{{__('users.id_expiration_time_des')}}</label>
                                                <select class="select2bs4" style="width:100%;" id="id_expiration_time"
                                                        name="id_expiration_time">
                                                    @if(count($expiration_time) > 0)
                                                        <option value="">&nbsp;</option>
                                                        @foreach($expiration_time as $expiration_time_)
                                                            <option
                                                                value="{{$expiration_time_->id}}" {{ ($id_expiration_time==$expiration_time_->id)? 'selected' : '' }}>{{$expiration_time_->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    {{--=========================================================--}}
                                    <div class="row">

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label
                                                    for="user_type'"
                                                    class="text-red">{{trans('users.user_type')}}</label>
                                                <select class="select2bs4" style="width:100%;" id="user_type" name="user_type" required>
                                                    <option value="">&nbsp;</option>
                                                    @foreach(config('users.user_type') as $key => $type)
                                                        <option value="{{ $type['value'] }}" {{ ($user_type == $type['value']) ? 'selected' : '' }}>
                                                            {{ $type['name'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    {{--=========================================================--}}
                                    {{--// FUNCTIONALITY ENABLE PASSWORD ///////////////////////////////////////////////--}}
                                    @if ((!isset($user) && config('users.users_enable_pass_new') == 1) ||
                                        (isset($user) && config('users.users_enable_pass_edit') == 1))

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label
                                                        for="password">{{__('users.password')}}</label>
                                                    <input type="password" id="password" name="password"
                                                           class="form-control"
                                                           value=""
                                                           maxlength="20">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label
                                                        for="confirm-password">{{__('users.password_confirm')}}</label>
                                                    <input type="password" id="confirm-password" name="confirm-password"
                                                           class="form-control"
                                                           value=""
                                                           maxlength="20">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="label" style="width: 100%;text-align: right;"
                                                     id="toggle_img">
                                                    <img src="/app_admin/images/eye-close.png"
                                                         style="cursor: pointer;" id="toggle" onclick="toggleSwap()"
                                                         title="{{__('global.toggle')}}">
                                                </div>
                                            </div>

                                        </div>
                                    @endif
                                    {{--=========================================================--}}
                                    @if(isset($user))
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group"><i class="fas fa-clock text-warning"></i>
                                                    <label
                                                        for="created_at">{{__('users.created_at')}}</label>
                                                    <input type="text" id="created_at" class="form-control"
                                                           value="{{ $created_at }}"
                                                           readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group"><i class="fas fa-clock text-warning "></i>
                                                    <label
                                                        for="updated_at">{{__('users.updated_at')}}</label>
                                                    <div class="input-group">
                                                        <input type="text" id="updated_at" class="form-control"
                                                               value="{{ $updated_at }}"
                                                               readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    {{--=========================================================--}}

                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    @if (isset($user))
                                        <a href="#" class="btn btn-danger modal_warning"
                                           data-toggle="modal"
                                           data-target="#ModalWarning"

                                           data-title="{!!__('users.edit.send_email_title')!!}"
                                           data-url="{!!$url_send_email!!}"

                                           data-content_l="{!! __('users.edit.send_email_description')!!}"
                                           data-content_b=""

                                           data-query="{{$query}}"
                                           data-url_return="{{$url_return}}"
                                           data-success="{{__('users.edit.send_email_success')}}"
                                           data-error="{{__('users.edit.send_email_error')}}"

                                           title="{{__('users.edit.send_email_hint')}}">
                                            <i class="fa fa-mail-bulk"></i>
                                        </a>
                                    @endif
                                    <button type="button" onclick="form_edit.submit();"
                                            class="btn btn-success float-right">{{__('global.save')}}</button>
                                </div>
                                <!-- /.card-footer -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col-md-6 -->

                        <!--   Image ================================================================================-->
                        <div class="col-md-6">
                            <div class="card card">

                                <div class="card-header">
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                                data-toggle="tooltip" title="Collapse">
                                            <i class="fas fa-minus"></i></button>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="form-group">
                                        <label>{!! __('users.edit.image.attach')!!}</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="picture" name="picture"
                                                       onchange="checkImage(this,'{!! __('users.edit.image.title_res')!!}','{!! __('users.edit.image.type')!!}','{!! __('users.edit.image.size',['size'=>config('users.allowed_image_size')])!!}','{!! config('users.allowed_image_size')!!}','{!! __('users.edit.image.save_warning')!!}','{!!$picture!!}')"

                                                       autocomplete="off">
                                                <label class="custom-file-label" id="custom-file-label"></label>
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        $css = empty($picture) ? 'display: none' : '';
                                        $src = !empty($picture) ? $path_upload . $id . '/' . $picture : '';
                                        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443 ? "https://" : "http://";
                                        $domain = $protocol . $_SERVER['HTTP_HOST'];
                                    @endphp
                                    <input type="hidden" id="file_name_hidden" name="file_name_hidden"
                                           value="{{$picture}}" autocomplete="off">
                                    <div class="form-group" id="picture_content" name="picture_content"
                                         style="{{$css}}">

                                        <div class="time-label">
                                            <img id="upload_image" class="img-circle img-bordered-sm modal_image"
                                                 data-target="#ModalImage"
                                                 width="70px" height="70px" alt="image" data-toggle="modal"
                                                 src="{{asset($src)}}"
                                                 data-url="{{$domain}}/{{$path_upload}}{{$id}}/{{ $picture}}"
                                                 data-title="{{$picture}}"
                                                 title="{{ $picture}}"
                                                 style="cursor: pointer">
                                            <a href="#" class="btn btn-outline-danger"
                                               onclick="delPhoto('{!! __('users.edit.image.delete_warning')!!}','{{$picture}}')"
                                               title="{{__('users.edit.image.detach')}}">
                                                <i class="fa fa-file-archive"></i>
                                            </a>
                                            <div class="timeline-item" id="file_name_"
                                                 title="{{$picture}}">{{$picture}}</div>
                                        </div>
                                    </div>
                                    <div class="timeline-item text-red" id="warning_message"></div>
                                </div>

                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col-md-6 -->
                        <!--   End Image ================================================================================-->

                    </div>

                </form>
                <!-- /.form -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.Main content -->

{{--        @if(Auth::id()==1&&isset($user))--}}
{{--            <!-- Content Header (Page header) -->--}}
{{--            <section class="content-header">--}}
{{--                <div class="container-fluid">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-md-12">--}}
{{--                            <div class="card card">--}}
{{--                                <div class="card-header">--}}
{{--                                    <div class="card-tools">--}}
{{--                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"--}}
{{--                                                data-toggle="tooltip" title="Collapse">--}}
{{--                                            <i class="fas fa-minus"></i></button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="card-body">--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-lg-2 col-2">--}}
{{--                                            <p><strong>Доделени модули (Модули и Групи)</strong></p>--}}

{{--                                            <ul>--}}
{{--                                                @if(count($assignedModulesAll) > 0)--}}
{{--                                                    @foreach($assignedModulesAll as $module)--}}

{{--                                                        @if($module['id_modules_type'] == 2)--}}
{{--                                                            {{$css_modules_type ='text-red'}}--}}
{{--                                                        @else--}}
{{--                                                            {{$css_modules_type =''}}--}}
{{--                                                        @endif--}}
{{--                                                        <li class="{{$css_modules_type}}">--}}
{{--                                                            {{ $module['id'] }}. {{ $module['title'] }}--}}
{{--                                                            (<strong>{{ $module['type'] }}</strong>)--}}

{{--                                                            @if(!empty($module['children']))--}}
{{--                                                                @include('Users::users.tree-item', ['children' => $module['children']])--}}
{{--                                                            @endif--}}
{{--                                                        </li>--}}

{{--                                                    @endforeach--}}
{{--                                                @endif--}}

{{--                                            </ul>--}}

{{--                                        </div>--}}
{{--                                        <div class="col-lg-2 col-2">--}}
{{--                                            <p><strong>Доделени модули (Модули)</strong></p>--}}

{{--                                            <ul>--}}
{{--                                                @if(count($assignedModulesModules) > 0)--}}
{{--                                                    @foreach($assignedModulesModules as $module)--}}
{{--                                                        <li>--}}
{{--                                                            {{ $module['id'] }}. {{ $module['title'] }}--}}
{{--                                                            (<strong>{{ $module['type'] }}</strong>)--}}
{{--                                                            @if(!empty($module['children']))--}}
{{--                                                                @include('Users::users.tree-item', ['children' => $module['children']])--}}
{{--                                                            @endif--}}
{{--                                                        </li>--}}
{{--                                                    @endforeach--}}
{{--                                                @endif--}}

{{--                                            </ul>--}}

{{--                                        </div>--}}
{{--                                        <div class="col-lg-2 col-2">--}}
{{--                                            <p><strong>Недоделени модули (Модули)</strong></p>--}}
{{--                                            <ul>--}}
{{--                                                @if(count($unassignedModulesModules) > 0)--}}
{{--                                                    @foreach($unassignedModulesModules as $module)--}}

{{--                                                        <li class="@if($module['id_modules_type'] == 2) {{$css_modules_type ='text-red'}} @else {{$css_modules_type =''}} @endif">--}}
{{--                                                            {{ $module['id'] }}. {{ $module['title'] }}--}}
{{--                                                            (<strong>{{ $module['type'] }}</strong>)--}}
{{--                                                            <a href="#" class="modal_warning"--}}
{{--                                                               data-toggle="modal"--}}
{{--                                                               data-target="#ModalWarning"--}}
{{--                                                               data-title="Додели модул на корисник"--}}
{{--                                                               data-url="/admin/main/{{ Auth::id()}}/{{ $module['id'] }}"--}}
{{--                                                               data-content_l="Корисник: {{ Auth::user()->username}} ({{ Auth::id()}})"--}}
{{--                                                               data-content_b="Модул: {{ $module['id'] }}. {{ $module['title'] }}"--}}
{{--                                                               title="Додели модул на корисник">--}}
{{--                                                                <---}}
{{--                                                            </a>--}}
{{--                                                            @if(!empty($module['children']))--}}
{{--                                                                @include('Users::users.tree-item', ['children' => $module['children']])--}}
{{--                                                            @endif--}}
{{--                                                        </li>--}}
{{--                                                    @endforeach--}}
{{--                                                @endif--}}

{{--                                            </ul>--}}

{{--                                        </div>--}}
{{--                                        <div class="col-lg-2 col-2">--}}
{{--                                            <p><strong>Доделени групи</strong></p>--}}
{{--                                            @if(count($assignedGroups) > 0)--}}

{{--                                                @foreach($assignedGroups as $assignedGroup)--}}
{{--                                                    {{$assignedGroup->id}}, {{$assignedGroup->title}}--}}
{{--                                                    <a href="#" class="modal_warning"--}}
{{--                                                       data-toggle="modal"--}}
{{--                                                       data-target="#ModalWarning"--}}
{{--                                                       data-title="Додели модул на корисник"--}}
{{--                                                       data-url="/admin/{{$lang}}/{{$id_module}}/users/remove/{{$id}}/{{$assignedGroup->id}}"--}}
{{--                                                       data-url-return="/admin/{{$lang}}/{{$id_module}}/users/edit/{{$id}}"--}}
{{--                                                       data-query="{{$query}}"--}}
{{--                                                       data-method=""--}}
{{--                                                       data-success="{{__('global.update_success')}}"--}}
{{--                                                       data-error="{{__('global.update_error')}}"--}}
{{--                                                       data-content_l="Корисник: {{ Auth::user()->username}} ({{ Auth::id()}})"--}}
{{--                                                       data-content_b="Модул: . "--}}
{{--                                                       title="Додели група на корисник">--}}
{{--                                                        ->--}}
{{--                                                    </a>--}}
{{--                                                    <br>--}}


{{--                                                    @if($assignedGroup->modules->isEmpty())--}}
{{--                                                        <p>Нема модули поврзани со оваа група.</p>--}}
{{--                                                    @else--}}
{{--                                                        <ul>--}}
{{--                                                            @foreach($assignedGroup->modules as $module)--}}
{{--                                                                <li>--}}
{{--                                                                    {{ $module['id'] }}. {{ $module['title'] }}--}}
{{--                                                                    (<strong>{{ $module['type'] }}</strong>)--}}
{{--                                                                    @if(!empty($module['children']))--}}
{{--                                                                        @include('Users::users.tree-group', ['children' => $module['children']])--}}
{{--                                                                    @endif--}}
{{--                                                                </li>--}}
{{--                                                            @endforeach--}}
{{--                                                        </ul>--}}
{{--                                                    @endif--}}

{{--                                                @endforeach--}}

{{--                                            @endif--}}
{{--                                        </div>--}}
{{--                                        <div class="col-lg-2 col-2">--}}
{{--                                            <p><strong>Недоделени групи</strong></p>--}}
{{--                                            @if(count($unassignedGroups ) > 0)--}}
{{--                                                @foreach($unassignedGroups as $unassignedGroups)--}}
{{--                                                    {{$unassignedGroups->id}}, {{$unassignedGroups->title}}--}}
{{--                                                    <a href="#" class="modal_warning"--}}
{{--                                                       data-toggle="modal"--}}
{{--                                                       data-target="#ModalWarning"--}}
{{--                                                       data-title="Додели модул на корисник"--}}
{{--                                                       data-url="/admin/{{$lang}}/{{$id_module}}/users/add/{{$id}}/{{$unassignedGroups->id}}"--}}
{{--                                                       data-url-return="/admin/{{$lang}}/{{$id_module}}/users/edit/{{$id}}"--}}
{{--                                                       data-query="{{$query}}"--}}
{{--                                                       data-method=""--}}
{{--                                                       data-success="{{__('global.update_success')}}"--}}
{{--                                                       data-error="{{__('global.update_error')}}"--}}
{{--                                                       data-content_l="Корисник: {{ Auth::user()->username}} ({{ Auth::id()}})"--}}
{{--                                                       data-content_b="Модул: . "--}}
{{--                                                       title="Додели група на корисник">--}}
{{--                                                        <---}}
{{--                                                    </a>--}}
{{--                                                    <br>--}}
{{--                                                    @if($unassignedGroups->modules->isEmpty())--}}
{{--                                                        <p>Нема модули поврзани со оваа група.</p>--}}
{{--                                                    @else--}}
{{--                                                        <ul>--}}
{{--                                                            @foreach($unassignedGroups->modules as $module)--}}
{{--                                                                <li>--}}
{{--                                                                    {{ $module['id'] }}. {{ $module['title'] }}--}}
{{--                                                                    (<strong>{{ $module['type'] }}</strong>)--}}
{{--                                                                    @if(!empty($module['children']))--}}
{{--                                                                        @include('Users::users.tree-group', ['children' => $module['children']])--}}
{{--                                                                    @endif--}}
{{--                                                                </li>--}}
{{--                                                            @endforeach--}}
{{--                                                        </ul>--}}
{{--                                                    @endif--}}

{{--                                                @endforeach--}}
{{--                                            @endif--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <div class="row">--}}
{{--                                        <div class="col-lg-3 col-3">--}}
{{--                                            <p><strong>Модули </strong></p>--}}
{{--                                            <ul>--}}
{{--                                                @if(count($modules) > 0)--}}
{{--                                                    @foreach($modules as $module)--}}

{{--                                                        <li class="@if($module['id_modules_type'] == 2) {{$css_modules_type ='text-red'}} @else {{$css_modules_type =''}} @endif">--}}
{{--                                                            {{ $module['id'] }}. {{ $module['title'] }}--}}
{{--                                                            (<strong>{{ $module['type'] }}</strong>)--}}

{{--                                                            @if(!empty($module['children']))--}}
{{--                                                                @include('Users::users.tree-item', ['children' => $module['children']])--}}
{{--                                                            @endif--}}
{{--                                                        </li>--}}

{{--                                                    @endforeach--}}
{{--                                                @endif--}}
{{--                                            </ul>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-lg-3 col-3">--}}
{{--                                            <p><strong>Групи</strong></p>--}}


{{--                                            @foreach($groups as $group)--}}
{{--                                                <p>{{ $group->id }}. {{ $group->title }}</p>--}}
{{--                                                @if($group->modules->isEmpty())--}}
{{--                                                    <p>Нема модули поврзани со оваа група.</p>--}}
{{--                                                @else--}}
{{--                                                    <ul>--}}
{{--                                                        @foreach($group->modules as $module)--}}
{{--                                                            <li>--}}
{{--                                                                {{ $module['id'] }}. {{ $module['title'] }}--}}
{{--                                                                (<strong>{{ $module['type'] }}</strong>)--}}
{{--                                                                @if(!empty($module['children']))--}}
{{--                                                                    @include('Users::users.tree-group', ['children' => $module['children']])--}}
{{--                                                                @endif--}}
{{--                                                            </li>--}}
{{--                                                        @endforeach--}}
{{--                                                    </ul>--}}
{{--                                                @endif--}}
{{--                                            @endforeach--}}


{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                            </div>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <!-- /.container-fluid -->--}}
{{--            </section>--}}
{{--            <!-- /.Main content -->--}}
{{--        @endif--}}

    </div>
    <!-- /.Content Wrapper. Contains page content -->
@endsection

@section('additional_css')

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ url('LTE/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{ url('LTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ url('LTE/plugins/toastr/toastr.min.css')}}">
@endsection

@section('additional_js')

    <!-- Select2 -->
    <script src="{{url('LTE/plugins/select2/js/select2.full.min.js')}}"></script>

    <style>
        .daterangepicker.single .drp-buttons {
            display: block !important;
        }
    </style>
    <script>
        ////////////////////////////////////////////////////////////////////////
        // Query the elements

        const passwordEle = document.getElementById('password');
        const passwordEle1 = document.getElementById('confirm-password');
        const toggleEle = document.getElementById('toggle');
        if (passwordEle && passwordEle1 && toggleEle) {
            toggleEle.addEventListener('click', function () {
                const type = passwordEle.getAttribute('type');
                passwordEle.setAttribute(
                    'type',
                    type === 'password' ? 'text' : 'password'
                );
                const type1 = passwordEle1.getAttribute('type');
                passwordEle1.setAttribute(
                    'type',
                    type1 === 'password' ? 'text' : 'password'
                );
            });
        }
        ////////////////////////////////////////////////////////////////////////

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })


    </script>

@endsection
