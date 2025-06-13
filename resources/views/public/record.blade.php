@extends('public/master')
<?php
$lang = Request::segment(1);
?>
@section('head')
    <!-- start head -->
    <title>{{ (!empty($records->title))? $records->title.": " : '' }}{{trans('properties.public.index.title')}}</title>
    <meta content="{{ (!empty($records->intro))? $records->intro : '' }}" name="description">
    <meta content="@if ($records->title != "") @foreach(explode(' ', str_replace(',', ' ', $records->title)) as $keyword) {{$keyword}},@endforeach @endif" name="keywords">
    <!--  Essential META Tags -->
    <meta property="og:title" content="{{ (!empty($records->title))? $records->title : '' }}">
    <meta property="og:type" content="article" />
{{--    <meta property="og:image" content="{{trans('properties.public.index.url')}}/upload/records/{{$records->id}}/{{urlencode($records->picture_file)}}">--}}
    <meta property="og:image" content="/upload/records/{{$records->id}}/{{str_replace(" ","%20",$records->picture_file)}}">
    <meta property="og:url" content="{{trans('properties.public.index.url').$lang.'/record/'.$records->id_menu.'/'.$records->id.'/'.$records->slug }}'">
    <meta name="twitter:card" content="summary_large_image">

    <!--  Non-Essential, But Recommended -->
    <meta property="og:description" content="{{ (!empty($records->intro))? $records->intro : '' }}">
    <meta property="og:site_name" content="{{trans('properties.public.index.title')}}">
    <meta name="twitter:image:alt" content="{{ (!empty($records->title))? $records->title : '' }}">
    <!--  Non-Essential, But Required for Analytics
    <meta property="fb:app_id" content="your_app_id" />
    <meta name="twitter:site" content="@website-username"> -->
    <!-- end head -->
@endsection
@section('content')

<!-- start main-content -->
<div id="main-content">
    <!-- master-custom -->
    <section class="master-custom">
        <div class="container">
            <div class="">
                <div class="row master-home2-section-custom-4">
                    <div class="col-xs-12 col-sm-8 col-md-8 master-custom-left">
                        <div class="widget master-widget-article-category-thumb-medium">
                            <div class="row">
                                <div class="kompletvest">
                                    <div class="col-xs-12 naslovvest">
                                       @if(!$records->menu_type!=0) <!--  slika pozadi naslov samo za staticni zapisi -->
                                        <style>
                                            .naslovvest::after {
                                                background-image: url('{{ asset('upload/records/'. $records->id.'/'. $records->picture_file)}}');
                                            }
                                        </style>
                                           @else
                                           <style>
                                               .naslovvest h1, .naslovvest h4 {
                                                   position: relative;
                                               }
                                           </style>
                                        @endif

                                           @if($records->subtitle)
                                               <h4>{{$records->subtitle}}</h4>
                                           @endif
                                        <h1>{{ (!empty($records->title))? $records->title : '' }}</h1>
                                           @if($records->menu_id==9 or $records->menu_id==10)
                                               <div class="pull-right datum"><i class="fa fa-fw fa-clock-o"></i> објавено на {{ (!empty($records->created_at)&($records->menu_type!=0))? date('d.m.Y', strtotime($records->created_at)) : ''  }}</div>
                                           @endif
                                    </div>
                                    <div class="col-xs-12 vest">
                                        @if($records->picture_file) <!--  slika samo za nestaticni zapisi -->
                                        <img src="{{ asset('upload/records/'. $records->id.'/'. $records->picture_file)}}" alt="">
                                        @endif
                                        {!! html_entity_decode($records->text, ENT_QUOTES, 'UTF-8') !!}

                                    <!--  dokumenti ================================= -->
                                        @if(count($documents) > 0)
                                            <ul>
                                            @foreach($documents as $document)

                                           @if($document->publish == 1)
                                                        <li><?php
                                                $array = explode('.', $document->file);
                                                $extension = end($array);
                                                // echo $extension;
                                                if ($extension == 'pdf' || $extension == 'PDF') {
                                                    $style = 'fa-file-pdf';
                                                } elseif ($extension == 'doc' || $extension == 'DOC' || $extension == 'docx' || $extension == 'DOCX') {
                                                    $style = 'fa-file-word';
                                                } elseif ($extension == 'xls' || $extension == 'XLS' || $extension == 'xlsx' || $extension == 'XLSX') {
                                                    $style = 'fa-file-excel';
                                                } else {
                                                    $style = 'fa-file';
                                                }
                                                ?>

                                                <a href="{{ asset('upload/records/'. $records->id.'/'. $document->file)}}" target="_blank" class="btn-link text-secondary"><i
                                                        class="far fa-fw {{ $style}}"></i>{{ $document->name}}</a>
                                                        </li>
                                                    @endif
                                            @endforeach
                                            </ul>
                                        @endif
                                    <!--  dokumenti ================================= -->

                                    <!--  sliki ================================= -->


                                        @if(count($pictures) > 0)

                                                @if (!empty($galleries_title))
{{--                                                    <a href="#">{{ $galleries_title}}</a><br>--}}
                                                @endif

                                                    <div class="card-body">
                                                        <div class="row">
                                            @foreach($pictures as $picture)
                                                                <div class="col-sm-2 col-xs-3 galerija"><a href="/upload/galleries/{{ $picture->id_galleries}}/{{$picture->file}}" rel="prettyPhoto[{{$records->id}}]" title="{{$picture->description}}"><img alt="{{$picture->description}}" src="/upload/galleries/{{ $picture->id_galleries}}/tn_{{ $picture->file}}" /></a></div>

                                                            @endforeach
                                                        </div>
                                                    </div>
                                        @endif
                                    <!--  sliki ================================= -->





                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('public._desna_kolona')
                </div>
            </div>
        </div>
    </section>
</div>

<!-- end main-content -->
@endsection
