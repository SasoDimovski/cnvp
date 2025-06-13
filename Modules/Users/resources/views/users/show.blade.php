<?php
$id_module = $module->id ?? '';
$lang = request()->segment(2);
$query = request()->getQueryString();

$id = $user->id ?? '';
$name = $user->name ?? '';
$surname = $user->surname ?? '';
$id_country = optional($user->country)->name ?? '';
$address = $user->address ?? '';
$phone = $user->phone ?? '';
$picture = $user->picture ?? '';
$email = $user->email ?? '';
$email_verified_at = $user->email_verified_at ?? '';
$username = $user->username ?? '';
$user_type = $user->user_type ?? '';
$password = $user->password ?? '';
$password_reset_hash = $user->password_reset_hash ?? '';
$id_expiration_time = optional($user->expirationTime)->name ?? '';
$active = $user->active ?? '';
$deleted = $user->deleted ?? '';
$created_at = (isset($user->created_at)) ? date("d.m.Y  H:i:s", strtotime($user->created_at)) : '';
$updated_at = (isset($user->updated_at)) ? date("d.m.Y  H:i:s", strtotime($user->updated_at)) : '';

$path_upload = 'uploads/users/';
?>
<div class="col-12">
    <div class="row invoice-info">
        <div class="col-sm-12 invoice-col" >
            <div class="timeline">
                <!-- timeline time label -->

                <!--   ================================================================================-->
                <div class="time-label">
                    @if($active==0)
                        <span class="bg-gradient-red">{{ __('global.deactivated') }}</span>
                    @else
                        <span class="bg-gradient-success">{{ __('users.active') }}</span>
                    @endif

                    <br>
                    <span class="bg-gradient-gray" style="margin-top: 3px">  <i class="fas fa-circle text-warning"></i> <strong>{{__('users.id')}}</strong>: {{ $id }}</span>
                    <span class="bg-gradient-gray" style="margin-top: 3px"><i class="fas fa-clock text-warning"></i> <strong>{{__('users.created_at')}}</strong>: {{ $created_at}}</span>
                    <span class="bg-gradient-gray" style="margin-top: 3px"> <i class="fas fa-clock text-warning "></i></i> <strong> {{__('users.updated_at')}}</strong>: {{ $updated_at }}</span>
                </div>
                <!--   ================================================================================-->
                <div>
                    <i class="fas fa-user bg-info"></i>
                    <div class="timeline-item">
                        <div class="timeline-header">
                            <strong>{{__('users.name')}}</strong>: {{$name}}
                            <div class="row" style="height: 7px"></div>
                            <strong>{{__('users.surname')}}</strong>: {{$surname}}
                            <div class="row" style="height: 7px"></div>
                            <strong>{{__('users.username')}}</strong>: {{$username}}
                            <div class="row" style="height: 7px"></div>
                            <strong>{{__('users.email')}}</strong>: {{$email}}
                            <div class="row" style="height: 7px"></div>
                            <strong>{{__('users.phone')}}</strong>: {{$phone}}
                        </div>
                    </div>
                </div>
                <!--   ================================================================================-->
                <div>
                    <i class="fas fa-id-badge bg-gradient-success"></i>
                    <div class="timeline-item">
                        <div class="timeline-header">
                            <strong>{{__('users.address')}}</strong>: {{$address}}
                            <hr>
                            <strong>{{__('users.id_country')}}</strong>: <br><br>
                            @if(count($assignCountries) > 0)
                                <ul>
                                    @foreach($assignCountries as $country)
                                        <li>
                                            <span>{{$country->name}} ({{$country->id}})</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                        </div>
                    </div>
                </div>
                <!--   ================================================================================-->
                <div>
                    <i class="fas fa-book-open bg-gradient-red"></i>
                    <div class="timeline-item">
                        <div class="timeline-header">
                            <strong>{{__('users.user_type')}}</strong>:
                            <strong class="text-red">
                                {{ collect(config('users.user_type'))->where('value', $user_type)->first()['name'] ?? '' }}
                            </strong>
                            <div class="row" style="height: 7px"></div>
                            <strong>{{__('users.id_expiration_time_des')}}</strong>: <strong class="text-red">{{$id_expiration_time}}</strong>


                        </div>
                    </div>
                </div>
                <!--   ================================================================================-->
                {{--                @if(count($documents) > 0)--}}
                {{--                <div class="time-label">--}}
                {{--                    <i class="fas fa-book-open bg-success"></i>--}}
                {{--                    <div class="timeline-item">--}}
                {{--                        <div class="timeline-header"> <strong>{{trans('properties.records.index.table_documents')}}</strong><br></div>--}}
                {{--                        <div class="timeline-body">--}}
                {{--                            <ul class="list-unstyled">--}}
                {{--                                @foreach($documents as $document)--}}
                {{--                                    <?php--}}
                {{--                                    $array = explode('.',$document->file);--}}
                {{--                                    $extension = end($array);--}}
                {{--                                   // echo $extension;--}}
                {{--                                    if ($extension=='pdf'||$extension=='PDF'){ $style='fa-file-pdf';}--}}
                {{--                                    elseif ($extension=='doc'||$extension=='DOC'||$extension=='docx'||$extension=='DOCX'){ $style='fa-file-word';}--}}
                {{--                                    elseif ($extension=='xls'||$extension=='XLS'||$extension=='xlsx'||$extension=='XLSX'){ $style='fa-file-excel';}--}}
                {{--                                    else { $style='fa-file';}--}}
                {{--                                    ?>--}}
                {{--                                <li>--}}
                {{--                                    <a href="{{ asset('upload/records/'. $user->id.'/'. $document->file)}}" class="btn-link text-secondary"><i class="far fa-fw {{ $style}}"></i>{{ $document->name}}</a>--}}
                {{--                                </li>--}}
                {{--                                @endforeach--}}
                {{--                            </ul>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                {{--                @endif--}}
                @if(!empty($picture))
                    <!--   ================================================================================-->
                    @php
                        $css = empty($picture) ? 'display: none' : '';
                        $src = !empty($picture) ? $path_upload . $id . '/' . $picture : '';
                        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443 ? "https://" : "http://";
                        $domain = $protocol . $_SERVER['HTTP_HOST'];
                    @endphp
                    <div class="time-label">
                        <img id="upload_image" class="img-circle img-bordered-sm modal_image"
                             data-target="#ModalImage"
                             width="70px" height="70px" alt="image" data-toggle="modal"
                             src="{{asset($src)}}"
                             data-url="{{$domain}}/{{$path_upload}}{{$id}}/{{ $picture}}"
                             data-title="{{$picture}}"
                             title="{{ $picture}}"
                             style="cursor: pointer">
                        <strong>{{$picture}}</strong>

                    </div>

                @endif
                <!--   ================================================================================-->


            </div>
        </div>
    </div>
</div>




