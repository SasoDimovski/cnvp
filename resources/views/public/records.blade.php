@extends('public/master')
<?php
$lang = Request::segment(1);
$id_menu= Request::segment(3);

?>
@section('head')
    <!-- start head -->
    <title>{{ (!empty($menu_by_id->title))? $menu_by_id->title.": " : '' }}{{trans('properties.public.index.title')}}</title>
    <meta content="{{ (!empty($menu_by_id->title))? $menu_by_id->title.": " : '' }}" name="description">
    @if(isset($menu_by_id->title))
    <meta content="@if ($menu_by_id->title != "") @foreach(explode(' ', str_replace(',', ' ', $menu_by_id->title)) as $keyword) {{$keyword}},@endforeach {{trans('properties.public.index.keywords')}} @endif" name="keywords">
    @endif
    <!--  Essential META Tags -->
    <meta property="og:title" content="{{ (!empty($menu_by_id->title))? $menu_by_id->title : '' }}">
    <meta property="og:type" content="website" />
    <meta property="og:image" content="{{trans('properties.public.index.url')}}{{trans('properties.public.index.og-image')}}">
    @if(isset($menu_by_id->id))
    <meta property="og:url" content="{{trans('properties.public.index.url').$lang.'/records/'.$menu_by_id->id.'/'.$menu_by_id->slug }}'">
    @endif
    <meta name="twitter:card" content="summary_large_image">

    <!--  Non-Essential, But Recommended -->
    <meta property="og:description" content="{{ (!empty($menu_by_id->title))? $menu_by_id->title.": " : '' }}">
    <meta property="og:site_name" content="{{trans('properties.public.index.title')}}">
    <meta name="twitter:image:alt" content="{{trans('properties.public.index.title')}}: {{ (!empty($menu_by_id->title))? $menu_by_id->title : '' }}">

    <!--  Non-Essential, But Required for Analytics
    <meta property="fb:app_id" content="your_app_id" />
    <meta name="twitter:site" content="@website-username"> -->
    <!-- end head -->
@endsection
@section('content')
    <div id="main-content">
        <!-- master-custom -->
        <section class="master-custom">
            <div class="container">
                <div class="">
                    <div class="row master-home2-section-custom-4">
                        <div class="col-lg-8">



                                @if(isset($menu_by_id->title))
{{--                                <h1 class="imekategorija">{{$menu_by_id->title}}</h1>--}}
                                <h1>{{$menu_by_id->title}}</h1>

                                @elseif($id_menu == 9999)
                                <h1>{{trans("properties.public.menu.name23")}}</h1>
                                @endif
                                    {{--=================================================================================================--}}
                                    @if($id_menu == 29)
                                        {{--Edukacija ==========================================================--}}
                                        @if(count($education) > 0)
                                            <div class="kompletvest table-responsive">
                                                <table class="table table-striped mal_tekst">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">од</th>
                                                        <th scope="col">собир</th>
                                                        <th scope="col">организатор</th>
                                                        <th scope="col">тема</th>
                                                        <th scope="col">бодови на предавач</th>
                                                        <th scope="col">бодови на слушател</th>
                                                        <th scope="col">лице за контакт</th>
                                                        <th scope="col">телефон</th>
                                                        <th scope="col">место</th>
                                                    </tr>
                                                    </thead>

                                                    @foreach($education as $education_)
                                                        <tr>
                                                            <td>{{date('d.m', strtotime($education_->from))}}<br>{{date('Y', strtotime($education_->from))}}
                                                                @if(date('d.m.Y', strtotime($education_->from))<>date('d.m.Y', strtotime($education_->to)))  {{' - '.date('d.m', strtotime($education_->to))}}<br>{{date('Y', strtotime($education_->to))}} @endif</td>
                                                            <td>{{$education_->type}}</td>
                                                            <td>{{$education_->organizer}}</td>
                                                            <td>{{$education_->topic}}</td>
                                                            <td style="text-align: center">{{$education_->points}}</td>
                                                            <td style="text-align: center">{{$education_->points_to_person}}</td>
                                                            <td>{{$education_->contact}}</td>
                                                            <td>{{$education_->phone}}</td>
                                                            <td>{{$education_->place}}</td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                            <!-- Page ============================================================ -->
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    {{trans('properties.global.show_from')}}
                                                    <strong> <span
                                                            class="badge badge-warning">{{ $education->firstItem() }}</span></strong>
                                                    {{trans('properties.global.to')}}
                                                    <strong> <span
                                                            class="badge badge-warning">{{$education->lastItem() }}</span></strong>
                                                    ({{trans('properties.global.sum')}}
                                                    <strong> <span
                                                            class="badge badge-danger">{{ $education->total() }}</span></strong>
                                                    {{trans('properties.global.records')}})
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="pagination pagination-sm float-right">
                                                    {{ $education->appends(request()->query())->links() }}
                                                </div>
                                            </div>
                                            <!-- Page end ====================================================== -->

                                        @else
                                            {{trans('properties.global.no_records')}}
                                        @endif
                                        {{--=== kraj edukacija =====================================================--}}
                                    @elseif($id_menu == 40)
                                        {{-- Vox medici ==========================================================--}}
                                        @include('public._vox')
                                        @if(count($records) > 0)
                                            @foreach($records as $record)
                                                @if(count($record->children) > 0)
                                                    @foreach($record->children as $children)
                                                        <div
                                                            style="display: none">{{$link='/upload/records/'. $record->id.'/'. $children->file}}</div>
                                                    @endforeach


                                                @else
                                                    <div style="display: none">{{$link='#'}}</div>
                                                @endif

                                                {{--                                            <div class="row">--}}
                                                <div class="col-xs-6 col-md-3 vox-thum-article">
                                                    <div class="entry-thum vox-slika"
                                                         style="background-image: url('/upload/records/{{$record->id}}/tn_{{$record->picture_file}}'); "
                                                         onclick="window.open('{{ asset($link) }}','_blank');">
                                                        {{--                                                        <p>--}}
                                                        {{--                                                            <a href="{{ url($lang.'/records/'.$record->id_menu.'/'.$record->menu_slug) }}" class="sub-category" target="_blank">{{$record->menu_title}}</a>--}}
                                                        {{--                                                        </p>--}}
                                                    </div>
                                                    <h2>
                                                        <a href="{{ asset($link) }}"
                                                           target="_blank">{{$record->title}}</a>
                                                    </h2>
                                                    <p>{{$record->intro}}</p>

                                                </div>
                                                {{--                                            </div>--}}

                                            @endforeach
                                        <!-- Page ======================================================== -->

                                            <div class="row">
                                                <div class="pagination pagination-sm float-right">
                                                    {{ $records->appends(request()->query())->links() }}
                                                </div>
                                            </div><br><br>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        {{trans('properties.global.show_from')}}
                                                        <strong> <span
                                                                    class="badge badge-warning">{{ $records->firstItem() }}</span></strong>
                                                        {{trans('properties.global.to')}}
                                                        <strong> <span
                                                                    class="badge badge-warning">{{$records->lastItem() }}</span></strong>
                                                        ({{trans('properties.global.sum')}}
                                                        <strong> <span
                                                                    class="badge badge-danger">{{ $records->total() }}</span></strong>
                                                        {{trans('properties.global.records')}})
                                                    </div>
                                                </div>
                                            <!-- Page end =============================================================================================== -->
                                        @else
                                            {{trans('properties.global.no_records')}}
                                        @endif

                                        {{--=== kraj Vox medici ================================================--}}
                                    @elseif($id_menu == 55)

                                        @include('public._povolnosti')
                                        {{--Povolnosti ==========================================================--}}
                                        @if(count($records_povolnosti) > 0)
                                            @foreach($records_povolnosti as $records_povolnost)
                                                <div class="row">
                                                    <div class="col-xs-12 master-thum-article">

                                                        <div class="entry-thum" id="entry-thum{{$records_povolnost->id}}"
                                                             style="background-image: url('/upload/records/{{$records_povolnost->id}}/tn_{{$records_povolnost->picture_file}}'); "
                                                             onclick="window.open('{{ url($lang.'/record/'.$records_povolnost->id_menu.'/'.$records_povolnost->id.'/'.$records_povolnost->slug) }}','_self');">
                                                            <p>
                                                                <a href="{{ url($lang.'/records/'.$records_povolnost->id_menu.'/'.$records_povolnost->menu_slug) }}"
                                                                   class="sub-category">{{$records_povolnost->menu_title}}</a>
                                                            </p>
                                                        </div>
                                                        @if(!$records_povolnost->picture_file)
                                                            <style>
                                                                #entry-thum{{$records_povolnost->id}}    {
                                                                    width: 10px;
                                                                    height: 20px;
                                                                }

                                                                #entry-content{{$records_povolnost->id}}    {
                                                                    float: right;
                                                                    width: 100%;
                                                                    margin-left: 0;
                                                                }
                                                            </style>
                                                        @endif
                                                        <div class="entry-content" id="entry-content{{$records_povolnost->id}}">
                                                            @if($records_povolnost->id_menu >46& $records_povolnost->id_menu<55)

                                                            @else
                                                                <div
                                                                    class="pull-right datum">{{date('d.m.Y', strtotime($records_povolnost->created_at))}}</div>
                                                            @endif
                                                            @if($records_povolnost->subtitle)
                                                                <h4>{{$records_povolnost->subtitle}}</h4>

                                                            @endif
                                                            <h2>
                                                                <a href="{{ url($lang.'/record/'.$records_povolnost->id_menu.'/'.$records_povolnost->id.'/'.$records_povolnost->slug) }}">{{$records_povolnost->title}}</a>
                                                            </h2>
                                                            <p>{{$records_povolnost->intro}}</p>
                                                            <!--<p> {//!! html_entity_decode($record->intro, ENT_QUOTES, 'UTF-8') !!}</p>-->
                                                        </div>
                                                    </div>
                                                </div>

                                            @endforeach
                                        <!-- Page =============================================================================================== -->
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    {{trans('properties.global.show_from')}}
                                                    <strong> <span
                                                            class="badge badge-warning">{{ $records_povolnosti->firstItem() }}</span></strong>
                                                    {{trans('properties.global.to')}}
                                                    <strong> <span
                                                            class="badge badge-warning">{{$records_povolnosti->lastItem() }}</span></strong>
                                                    ({{trans('properties.global.sum')}}
                                                    <strong> <span
                                                            class="badge badge-danger">{{ $records_povolnosti->total() }}</span></strong>
                                                    {{trans('properties.global.records')}})
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="pagination pagination-sm float-right">
                                                    {{ $records_povolnosti->appends(request()->query())->links() }}
                                                </div>
                                            </div>
                                            <!-- Page end =============================================================================================== -->
                                        @else
                                            {{trans('properties.global.no_records')}}
                                        @endif
                                        {{--=== kraj povolnosti =====================================================--}}
                                    @else
                                        {{--==== obicni records ===================================================--}}
                                        @if(count($records) > 0)
                                            @foreach($records as $record)
                                                <h2><a href="{{ url($lang.'/record/'.$record->id_menu.'/'.$record->id.'/'.$record->slug) }}">{!! $record->title !!}</a></h2>
                                                <div class="row">
                                                    @if($record->picture_file)
                                                        @php($stil = "col-md-7")
                                                    <div class="col-md-5">
                                                        <a href="{{ url($lang.'/record/'.$record->id_menu.'/'.$record->id.'/'.$record->slug) }}">
                                                            <img class="img-responsive img-hover" src="/upload/records/{{$record->id}}/tn_{{$record->picture_file}}" alt="">
                                                        </a>
                                                    </div>
                                                        @else @php($stil = "col-md-12")
                                                    @endif
                                                    <div class="{{$stil}}">
                                                        <p><i class="fa fa-fw fa-clock-o"></i> објавено на {{date('d.m.Y', strtotime($record->created_at))}}</p>
                                                        <p>{!! $record->intro !!}</p>
                                                        <a class="btn btn-primary" href="{{ url($lang.'/record/'.$record->id_menu.'/'.$record->id.'/'.$record->slug) }}">повеќе <i class="fa fa-angle-right"></i></a>
                                                    </div>
                                                </div>
                                                <hr>
                                            @endforeach
                                        <!-- Page =============================================================================================== -->
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    {{trans('properties.global.show_from')}}
                                                    <strong> <span
                                                            class="badge badge-warning">{{ $records->firstItem() }}</span></strong>
                                                    {{trans('properties.global.to')}}
                                                    <strong> <span
                                                            class="badge badge-warning">{{$records->lastItem() }}</span></strong>
                                                    ({{trans('properties.global.sum')}}
                                                    <strong> <span
                                                            class="badge badge-danger">{{ $records->total() }}</span></strong>
                                                    {{trans('properties.global.records')}})
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="pagination pagination-sm float-right">
                                                    {{ $records->appends(request()->query())->links() }}
                                                </div>
                                            </div>
                                            <!-- Page end =============================================================================================== -->
                                        @else
                                            {{trans('properties.global.no_records')}}
                                        @endif
                                        {{--==== kraj obicni records ===============================================--}}
                                    @endif
{{--=================================================================================================--}}

{{--=================================================================================================--}}






</div>

@include('public._desna_kolona')
</div>
</div>
</div>
</section>
</div>
<!-- end main-content -->
@endsection
