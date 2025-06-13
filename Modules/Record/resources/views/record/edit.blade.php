@extends('admin/master')
@section('content')

    @php
        $id_module = $module->id ?? '';
        $lang = request()->segment(2);
        $query = request()->getQueryString();

        $id = $record->id ?? '';
        $id_user_logged = Auth::id();
        $id_user = $record->id_user ?? '';
        $id_module = $record->id_module ?? '';
        $title = $record->title ?? old('title');
        $slug = $record->slug ?? old('slug');
        $subtitle = $record->subtitle ?? old('subtitle');
        $intro = $record->intro ?? old('intro');
        $text = $record->text ?? old('text');
        $picture = $record->picture ?? old('picture_file');
        $created_at = (isset($record->created_at)) ? date("d.m.Y  H:i:s", strtotime($record->created_at)) : '';
        $updated_at = (isset($record->updated_at)) ? date("d.m.Y  H:i:s", strtotime($record->updated_at)) : '';
        $active = $record->active ?? '';
        $main= $record->main ?? '';
        $cover = $record->cover ?? '';

        $url = url('admin/' . $lang . '/' . $module->link);

        $url_base= 'admin/'.$lang.'/'.$id_module.'/record/';

        $url_store= url($url_base. 'store/');
        $url_update = url($url_base . 'update/' . $id);
        $url_action= (isset($id)) ? $url_update : $url_store;

        $url_return = url($url_base . 'edit/' . $id);

        $url_store_doc = url($url_base. 'store_doc/'.$id);
        $url_update_doc = url($url_base . 'update_doc/'.$id);
        $url_delete_doc = url($url_base. 'delete_doc/'.$id);
        $url_show_doc = url($url_base . 'show_doc/'.$id);


        $path_upload = 'uploads/records/';

        $message_error= (isset($id)) ? __('global.update_error'): __('global.save_error');
        $message_success= (isset($id)) ? __('global.update_success'): __('global.save_success');


    @endphp

    {{--    <div>--}}
    {{--        <h1>Record Details</h1>--}}
    {{--        <p><strong>$id_user_logged:</strong> {{ $id_user_logged }}</p>--}}
    {{--        <p><strong>Title:</strong> {{ $title }}</p>--}}
    {{--        <p><strong>Slug:</strong> {{ $slug }}</p>--}}
    {{--        <p><strong>Subtitle:</strong> {{ $subtitle }}</p>--}}
    {{--        <p><strong>Intro:</strong> {{ $intro }}</p>--}}
    {{--        <p><strong>Text:</strong> {{ $text }}</p>--}}
    {{--        <p><strong>Picture:</strong> {{ $picture }}</p>--}}
    {{--        <p><strong>Created At:</strong> {{ $created_at }}</p>--}}
    {{--        <p><strong>Updated At:</strong> {{ $updated_at }}</p>--}}
    {{--        <p><strong>Active:</strong> {{ $active }}</p>--}}
    {{--    </div>--}}
    {{--    @php--}}
    {{--    dd();--}}
    {{--    @endphp--}}

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                @include('admin._flash-message')
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
            </div><!-- /.container-fluid -->
        </section>


        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @include('flash::message')

                <form class="needs-validation" role="form" id="form_edit" name="form_edit"
                      action="{{ "{$url_action}" }}" method="POST"
                      enctype="multipart/form-data">
                    <input type="hidden" id="url_return" name="url_return" value="{{ $url_return }}">
                    <input type="hidden" id="query" name="query" value="{{$query}}">
                    <input type="hidden" id="message_error" name="message_error" value="{{ $message_error }}">
                    <input type="hidden" id="message_success" name="message_success" value="{{ $message_success }}">

                    <input type="hidden" id="id_user_logged" name="id_user_logged" value="{{ $id_user_logged}}">
                    <input type="hidden" id="id_user" name="id_user" value="{{ $id_user}}">
                    <input type="hidden" id="id_module" name="id_module" value="{{ $id_module}}">

                    {{csrf_field()}}
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <!-- Errors ---------->
                            @if (count($errors) > 0)
                                <div id="toast-container" class="toast-top-full-width" onclick="closeErrorWindow(this)">
                                    <div class="toast toast-error" aria-live="assertive" style="">
                                        <div class="toast-progress" style="width:100%;"></div>
                                        <button type="button" class="close" data-dismiss="toast-top-full-width"
                                                role="button" onclick="closeErrorWindow(this)">×
                                        </button>
                                        <div class="toast-message">
                                            <p><strong>{!!__('global.error_not')!!}</strong>
                                            </p>
                                            @foreach ($errors->all() as $error)
                                                <div class="callout callout-danger"
                                                     style="color: #0a0a0a!important;padding: 10px!important;">
                                                    {!! $error !!}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif


                            <div class="card card">

                                <div class="card-header">
                                    @if($active==0)
                                        &nbsp;<i class="fas fa-lock text-danger" title="{{__('global.deactivated')}}"></i>
                                    @endif
                                        <h3 class="card-title">  @if(isset($id)) id: {{$id}} @endif</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    {{--=========================================================--}}
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="active"
                                                           name="active" value="1"
                                                           @if($active==1||$active=='')
                                                               {{'checked'}}
                                                           @endif disabled>
                                                    <label for="active"
                                                           class="custom-control-label"
                                                           id="active">{{__('record.active')}} </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="main"
                                                           name="main" value="1"
                                                    @if($main==1||$main=='')
                                                        {{'checked'}}
                                                        @endif disabled>
                                                    <label for="main"
                                                           class="custom-control-label"
                                                           id="main">{{__('record.main')}} </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="cover"
                                                           name="cover" value="1"
                                                    @if($cover==1||$cover=='')
                                                        {{'checked'}}
                                                        @endif disabled>
                                                    <label for="cover"
                                                           class="custom-control-label"
                                                           id="cover">{{__('record.cover')}} </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{--=========================================================--}}
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label
                                                    for="title">{{__('record.title')}}</label>
                                                <input type="text" id="title" name="title" class="form-control"
                                                       placeholder="{{__('record.title')}}"
                                                       value="{{ $title }}"
                                                       maxlength="200">
                                            </div>
                                        </div>
                                    </div>
                                    {{--=========================================================--}}
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label
                                                    for="slug">{{__('record.slug')}}</label>
                                                <input type="text" id="slug" name="slug" class="form-control"
                                                       placeholder="{{__('record.slug')}}"
                                                       value="{{ $slug }}"
                                                       readonly>
                                            </div>
                                        </div>
                                    </div>
                                    {{--=========================================================--}}
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label
                                                    for="subtitle">{{__('record.subtitle')}}</label>
                                                <input type="text" id="subtitle" name="subtitle" class="form-control"
                                                       placeholder="{{__('record.subtitle')}}"
                                                       value="{{ $subtitle }}"
                                                       maxlength="200">
                                            </div>
                                        </div>
                                    </div>
                                    {{--=========================================================--}}
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group"><i class="fas fa-comment text-info"></i>
                                                <label>{{__('record.intro')}}</label>
                                                <textarea class="form-control" id="intro" name="intro" rows="3"
                                                          placeholder="">{{$intro}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    {{--=========================================================--}}
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group"><i class="fas fa-comment text-warning "></i>
                                                <label>{{__('record.text')}}</label>
                                                <textarea class="textarea" id="text" name="text"
                                                          style="width: 100%; height: 400px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{$text}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    {{--=========================================================--}}
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group"><i class="fas fa-clock text-warning"></i>
                                                <label
                                                    for="inputName">{{__('record.created_at')}}</label>
                                                <input type="text" id="created_at" name="created_at"
                                                       class="form-control"
                                                       value="{{ $created_at }}"
                                                       readonly
                                                >
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group"><i class="fas fa-clock text-warning "></i>
                                                <label
                                                    for="inputName">{{__('record.updated_at')}}</label>
                                                <div class="input-group">
                                                    <input type="text" id="updated_at" name="updated_at"
                                                           class="form-control"
                                                           value="{{ $updated_at }}"
                                                           readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{--=========================================================--}}

                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="button" onclick="form_edit.submit();"
                                            class="btn btn-success float-right">{{__('global.save')}}</button>
                                </div>


                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col-md-6 -->


                        <div class="col-md-6">
                            <div class="row">

                                <!--   Image ================================================================================-->
                                <div class="col-md-12">
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
                                                <label>{!! __('record.edit.image.attach')!!}</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="picture"
                                                               name="picture"
                                                               onchange="checkImage(this,'{!! __('record.edit.image.title_res')!!}','{!! __('record.edit.image.type')!!}','{!! __('record.edit.image.size',['size'=>config('config.allowed_image_size')])!!}','{!! config('config.allowed_image_size')!!}','{!! __('record.edit.image.save_warning')!!}','{!!$picture!!}')"

                                                               autocomplete="off">
                                                        <label class="custom-file-label" id="custom-file-label"></label>


                                                    </div>
                                                </div>
                                            </div>
                                            <!--   ================================================================================-->
                                            @php
                                                $css = empty($picture) ? 'display: none' : '';
                                                $src = !empty($picture) ? $path_upload . $id . '/' . $picture : '';
                                                $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443 ? "https://" : "http://";
                                                $domain = $protocol . $_SERVER['HTTP_HOST'];
                                            @endphp
                                            <input type="hidden" id="file_name_hidden" name="file_name_hidden"
                                                   value="{{$picture}}" autocomplete="off">
                                            <div class="form-group" id="picture_content" name="picture_content"
                                                 style=" {{$css}}">
                                                <div class="time-label">
                                                    <img id="upload_image"
                                                         class="img-circle img-bordered-sm modal_image"
                                                         data-target="#ModalImage"
                                                         width="70px" height="70px" alt="image" data-toggle="modal"
                                                         src="{{asset($src)}}"
                                                         data-url="{{$domain}}/{{$path_upload}}{{$id}}/{{ $picture}}"
                                                         data-title="{{$picture}}"
                                                         title="{{ $picture}}"
                                                         style="cursor: pointer">
                                                    <a href="#" class="btn btn-outline-danger"
                                                       onclick="delPhoto('{!! __('record.edit.image.delete_warning')!!}','{{$picture}}')"
                                                       title="{{__('record.edit.image.detach')}}">
                                                        <i class="fa fa-file-archive"></i>
                                                    </a>
                                                    <div class="timeline-item" id="file_name_"
                                                         title="{{$picture}}">{{$picture}}</div>
                                                </div>
                                            </div>
                                            <div class="timeline-item text-red" id="warning_message"></div>

                                            <!--   ================================================================================-->


                                        </div>
                                    </div>
                                </div>
                                <!--   End Image ================================================================================-->

                                <!--   Documents ================================================================================-->
                                <div class="col-md-12">
                                    <div class="card card">

                                        <div class="card-header">
                                            <h3 class="card-title">{{__('record.edit.document.title')}}
                                            </h3>
                                            <button type="button" class="btn btn-tool">
                                                @if (!empty($id))
                                                    <a href="#" class="btn btn-warning btn-xs open_document"
                                                       data-toggle="modal" data-target="#ModalDocument"

                                                       data-css="needs-validation"

                                                       data-title="{{__('record.edit.document.attach')}}"
                                                       data-id=""
                                                       data-id_record="{{$id}}"
                                                       data-id_user="{{Auth::id()}}"
                                                       data-id_module="{{$id_module}}"

                                                       data-url="{{$url_store_doc}}"
                                                       data-url_return="{{$url_return}}"
                                                       data-query="{{$query}}"
                                                       data-success="{{__('record.edit.document.attach_success')}}"
                                                       data-error="{{__('record.edit.document.attach_error')}}"

                                                       data-active="1"
                                                       data-name=""
                                                       data-name_des="{{__('record.edit.document.name_des')}}"

                                                       data-file=""
                                                       data-file_name=""
                                                       data-file_name_desc="{{__('record.edit.document.file_des')}}"
                                                       data-comment=""

                                                       title="{{__('record.edit.document.attach')}}"><i
                                                            class="fa fa-plus"></i></a>
                                                @endif
                                            </button>

                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                                        data-toggle="tooltip" title="Collapse">
                                                    <i class="fas fa-minus"></i></button>
                                            </div>
                                        </div>

                                        @if(count($documents) > 0)
                                            <div class="card-body p-0 scrollmenu">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th>{{__('record.edit.document.id')}}</th>
                                                        <th>{{__('record.edit.document.name')}}</th>
                                                        <th>{{__('record.edit.document.file')}}</th>
                                                        <th><i class="fas fa-lock"
                                                               title="{{__('record.edit.document.active_status')}}"></i></th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($documents as $document)
                                                            @php
                                                            $document_id = $document->id ?? '';
                                                            $document_name = $document->name ?? '';
                                                            $document_file = $document->file ?? '';
                                                            $document_active = $document->active ?? '';
                                                            $document_comment = $document->comment ?? '';
                                                            $extension = strtolower(pathinfo($document_file, PATHINFO_EXTENSION));
                                                            $styleMap = [
                                                                'pdf' => 'fa-file-pdf',
                                                                'doc' => 'fa-file-word',
                                                                'docx' => 'fa-file-word',
                                                                'xls' => 'fa-file-excel',
                                                                'xlsx' => 'fa-file-excel',
                                                            ];
                                                            $style = $styleMap[$extension] ?? 'fa-file';
                                                            @endphp
                                                        <tr>
                                                            <td>{{ $document_id}}</td>
                                                            <td title="{{ $document_name}}">
                                                                {{
                                                                     strlen($document_name) > 40
                                                                         ? (strpos($document_name, ' ', 40) !== false
                                                                             ? substr($document_name, 0, strpos($document_name, ' ', 40)) . '...'
                                                                             : substr($document_name, 0, 40) . '...')
                                                                         : $document_name
                                                                 }}
                                                            </td>
                                                            <td>
                                                                <a href="{{ asset($path_upload. $id.'/'. $document_file)}}"
                                                                   class="btn-link text-secondary"><i
                                                                        class="far fa-fw {{ $style}}"></i>{{ $document->file}}
                                                                </a>
                                                            </td>
                                                            <td>
                                                                @if($document_active == 1)
                                                                    <i class="fas fa-check-square"
                                                                       title="{{trans('record.edit.document.active')}}"></i>
                                                                @endif
                                                            </td>
                                                            <td class="text-right py-0 align-middle">
                                                                <div class="btn-group btn-group-sm">

                                                                    <button class="btn btn-info" type="button"
{{--                                                                            onclick="getContentID('{{ $document_id}}','{{ $lang }}','{{ $id_module }}','ModalShow','{{ $module->title}}','documents')">--}}
                                                                        onclick="getContentID('{{$url_show_doc.'/'. $document_id }}','ModalShow','{{__('record.edit.document')}}')">
                                                                        <i class="fas fa-eye"
                                                                           title="{{__('global.show_hint')}}"></i></button>

                                                                    <a href="#" class="btn btn-success open_document"
                                                                       data-toggle="modal" data-target="#ModalDocument"

                                                                       data-css="needs-validation"

                                                                       data-title="{{__('record.edit.document.attach')}}"

                                                                       data-id="{{$document_id}}"
                                                                       data-id_record="{{$id}}"
                                                                       data-id_user="{{Auth::id()}}"
                                                                       data-id_module="{{$id_module}}"

                                                                       data-url="{{$url_update_doc.'/'.$document_id}}"
                                                                       data-url_return="{{$url_return}}"
                                                                       data-query="{{$query}}"
                                                                       data-success="{{__('record.edit.document.attach_success')}}"
                                                                       data-error="{{__('record.edit.document.attach_error')}}"

                                                                       data-active="{{$document_active}}"
                                                                       data-name="{{$document_name}}"
                                                                       data-name_des="{{__('record.edit.document.name_des')}}"

                                                                       data-file=""
                                                                       data-file_name="{{$document_file}}"
                                                                       data-file_name_desc="{{__('record.edit.document.file_des')}}"
                                                                       data-comment="{{$document_comment}}"
                                                                       title="{{__('global.edit_hint')}}"><i
                                                                            class="fa fa-edit"></i></a>

                                                                    <a href="#" class="btn btn-danger modal_warning"
                                                                       data-toggle="modal"
                                                                       data-target="#ModalWarning"

                                                                       data-title="{{__('global.delete_record')}}"
                                                                       data-url="{{$url_delete_doc}}/{{$document->id}}"

                                                                       data-content_l="id: {{$document->id}}, "
                                                                       data-content_b="{{ $document->name}},"
                                                                       data-content_sub_l="{{ $document->file}}"
                                                                       data-content_sub_b=""

                                                                       data-query="{{$query}}"
                                                                       data-url_return="{{$url_return}}"
                                                                       data-success="{{__('global.delete_success')}}"
                                                                       data-error="{{__('global.delete_error')}}"

                                                                       data-method="DELETE"

                                                                       title="{{__('global.delete_hint')}}">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>


                                                                </div>
                                                            </td>

                                                    @endforeach
                                                    </tbody>
                                                </table>

                                            </div>
                                        @else
                                            <div class="card-body">
                                                @if(!empty($id))
                                                    {{__('record.edit.document.no_documents')}}
                                                @else
                                                    {{trans('record.edit.document.no_documents_no_record')}}
                                                @endif
                                            </div>
                                        @endif

                                        <!--   ================================================================================-->


                                    </div>
                                </div>
                                <!--  End Documents================================================================================-->

                            </div>
                            <!-- /.row-->
                        </div>
                        <!-- /.col-md-6 -->
                    </div>
                    <!-- /.row-->

                </form>

            </div>
            <!-- /.container-fluid -->

        </section>
        <!-- /.content -->

    </div>

@endsection

@section('additional_css')
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ url('LTE/plugins/toastr/toastr.min.css')}}">
@endsection

@section('additional_js')
    <script src="{{url('app_admin/js/ckeditor/ckeditor.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            //CKEDITOR.config.contentsCss = '/public_design/css/ckeditor.css';
            CKEDITOR.replace('text', {
                //filebrowserBrowseUrl :'/browser?Connector=/app_admin/js/ckeditor/filemanager/connectors/php/connector.php',
                //filebrowserUploadUrl: '/browser?command=QuickUpload&type=Files',
                filebrowserImageBrowseUrl: '/browser?Connector=/app_admin/js/ckeditor/filemanager/connectors/php/connector.php&type=Image',
            });

        });
    </script>


@endsection
