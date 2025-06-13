@extends('public/master')
<?php
$lang = Request::segment(1);
?>
@section('head')
    <!-- start head -->
    <title>{{trans('properties.public.index.title')}}</title>

   <!--  Non-Essential, But Required for Analytics
    <meta property="fb:app_id" content="your_app_id" />
    <meta name="twitter:site" content="@website-username"> -->
    <!-- end head -->
@endsection
@section('content')
    {{--    @include('public._slajder')
        @include('public._ikoni')--}}

    <div id="main-content">
        <!-- master-custom -->
        <section class="master-custom">
            <div class="container">
                <div class="">
                    <div class="row master-home2-section-custom-4">

                        <div class="col-xs-12 col-sm-12 col-md-12 master-custom-left">

                            <h3><a href=""></a>Регистрирај се</h3>
                            <div class="well">
                                <div class="panel-body">
                                    <h5>Доколку сакате да се зачлените на платформата, пополнете ја формата за
                                        регистрација.
                                        По одбрение на администраторот ќе добиете email порака за најава во
                                        системот.</h5>
                                </div>
                            </div>

                            <form class="needs-validation" role="form" id="form_register" name="form_register"
                                  action="{!!url("register")!!}" method="POST">
                                @csrf
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="col-sm-3">
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                @include('public._flash-message')
                                                @if ($errors->any())
                                                    <div class="alert alert-danger">
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li>{!! $error !!} </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                                <div class="form-group"><i class="fas fa-clock text-warning"></i>
                                                    <label
                                                        for="name">Име <strong
                                                            style="color: #BD362F!important;">*</strong></label>
                                                    <input type="text" id="name" name="name" class="form-control" placeholder="Име"
                                                           value="{{ old('name') }}" maxlength="100">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group"><i class="fas fa-clock text-warning"></i>
                                                    <label
                                                        for="surname">Презиме <strong
                                                            style="color: #BD362F!important;">*</strong></label>
                                                    <input type="text" id="surname"  name="surname" class="form-control"
                                                           placeholder="Презиме"
                                                           value="{!! old('surname') !!}" maxlength="100">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group"><i class="fas fa-clock text-warning"></i>
                                                    <label
                                                        for="email">Е-пошта <strong
                                                            style="color: #BD362F!important;">*</strong></label>
                                                    <input type="text" id="email"  name="email" class="form-control"
                                                           placeholder="Е-пошта"
                                                           value="{!! old('email') !!}" maxlength="100">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group"><i class="fas fa-clock text-warning"></i>
                                                    <label
                                                        for="phone">Телефон<strong
                                                            style="color: #BD362F!important;"> *</strong></label>
                                                    <input type="text" id="phone" name="phone" class="form-control"
                                                           placeholder="Телефон"
                                                           value="{!! old('phone') !!}" maxlength="100">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group"><i class="fas fa-clock text-warning"></i>
                                                    <label
                                                        for="edb">ЕДБ<strong
                                                            style="color: #BD362F!important;"> *</strong></label>
                                                    <input type="text" id="edb" name="edb"  class="form-control"
                                                           placeholder="ЕДБ"
                                                           value="{!! old('edb') !!}" maxlength="100">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                            <button type="button" onclick="form_register.submit();"
                                                    class="btn btn-success float-left">Регистрирај се</button>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom: 30px">
                                            <div class="col-sm-12">
                                        </div>
                                        </div>
                                    </div>


                                </div>

                            </div>
                                </form>

                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- end main-content -->
@endsection
