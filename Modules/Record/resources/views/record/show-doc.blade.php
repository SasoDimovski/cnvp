<?php
$id_module = $module->id ?? '';
$lang = request()->segment(2);
$query = request()->getQueryString();

$document_id = $document->id ?? '';
$document_name = $document->name ?? '';
$document_file = $document->file ?? '';
$document_size = $document->size ?? '';
$document_path = $document->path ?? '';
$document_type = $document->type ?? '';
$document_active = $document->active ?? '';
$document_comment = $document->comment ?? '';

$document_created_at = (isset($document->created_at)) ? date("d.m.Y  H:i:s", strtotime($document->created_at)) : '';
$document_updated_at = (isset($document->updated_at)) ? date("d.m.Y  H:i:s", strtotime($document->updated_at)) : '';

$path_upload = 'uploads/records/';

$id_record= request()->segment(6);

?>
<div class="col-12">
    <div class="row invoice-info">
        <div class="col-sm-12 invoice-col" >
            <div class="timeline">
                <!-- timeline time label -->

                <!--   ================================================================================-->
                <div class="time-label">
                    @if($document_active==0)
                        <span class="bg-gradient-red">{{ __('global.deactivated') }}</span>
                    @else
                        <span class="bg-gradient-success">{{ __('record.edit.document.active') }}</span>
                    @endif

                    <br>
                    <span class="bg-gradient-gray" style="margin-top: 3px">  <i class="fas fa-circle text-warning"></i> <strong>{{__('record.edit.document.id')}}</strong>: {{ $document_id }}</span>
                    <span class="bg-gradient-gray" style="margin-top: 3px"><i class="fas fa-clock text-warning"></i> <strong>{{__('record.edit.document.created_at')}}</strong>: {{ $document_created_at}}</span>
                    <span class="bg-gradient-gray" style="margin-top: 3px"> <i class="fas fa-clock text-warning "></i></i> <strong> {{__('record.edit.document.updated_at')}}</strong>: {{ $document_updated_at }}</span>
                </div>
                <!--   ================================================================================-->
                <div>
                    <i class="fas fa-file-archive bg-danger"></i>
                    <div class="timeline-item">
                        <div class="timeline-header">
                            <strong>{{__('record.edit.document.name_des')}}</strong>: {{$document_name}}
                            <hr>
                            <strong>{{__('record.edit.document.file_des')}}</strong>: <a href="{{ asset($path_upload. $id_record.'/'. $document_file)}}" class="btn-link text-secondary">{{$document_file}}</a>
                            <hr>
                            <strong>{{__('record.edit.document.size')}}</strong>: <strong class="text-danger">{{$document_size}}</strong>
                            <hr>
                            <strong>{{__('record.edit.document.path')}}</strong>: <strong  class="text-danger">{{$document_path}}</strong>
                            <a href="{{ asset($path_upload. $id_record.'/'. $document_file)}}" class="btn-link text-secondary">{{$document_file}}</a>
                            <hr>
                            <strong>{{__('record.edit.document.type')}}</strong>: <strong  class="text-danger">{{$document_type}}</strong>
                            <hr>
                            <strong>{{__('record.edit.document.comment')}}</strong>: {{$document_comment}}
                        </div>
                    </div>
                </div>
                <!--   ================================================================================-->


            </div>
        </div>
    </div>
</div>




