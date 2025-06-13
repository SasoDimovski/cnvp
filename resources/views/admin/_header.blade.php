
<?php
$lang = Request::segment(2);
?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-cyan navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">

            <a href="{{ url('admin/'.$lang.'/main/') }}" class="nav-link">{{trans('global.header.home')}}</a>
        </li>
        @if(count($languages) > 0)
            @foreach($languages as $language)
                @if($language->lang != $lang)
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ url('admin/'.$language->lang.'/main/') }}" class="nav-link">{{$language->lang}}</a>
        </li>
                @endif
            @endforeach
        @endif
{{--        <li class="nav-item d-none d-sm-inline-block">--}}
{{--            <a href="#" class="nav-link">Contact</a>--}}
{{--        </li>--}}
    </ul>

    <!-- SEARCH FORM -->
{{--    <form class="form-inline ml-3">--}}
{{--        <div class="input-group input-group-sm">--}}
{{--            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">--}}
{{--            <div class="input-group-append">--}}
{{--                <button class="btn btn-navbar" type="submit">--}}
{{--                    <i class="fas fa-search"></i>--}}
{{--                </button>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </form>--}}

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
{{--                <i class="far fa-comments"></i>--}}
{{--                <span class="badge badge-danger navbar-badge">3</span>--}}
                <i class="fa fa-user text-danger"></i>
                <span class="hidden-xs"><small>{{trans('global.header.user')}}: </small> <strong>{{ Auth::user()->name}} {{ Auth::user()->surname}} </strong></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right ">
                <div class="dropdown-item">
                    <!-- Message Start -->
                    <small>ID: </small><strong>{{ Auth::user()->id}}</strong>
                    <br>
                    <small>{{trans('global.header.username')}}: </small><strong>{{ Auth::user()->username}}</strong>
                    <br>
                    <small>{{trans('global.header.name')}}: </small><strong>{{ Auth::user()->name}} {{ Auth::user()->surname}}</strong>
                    <br>
                    <small>{{trans('global.header.email')}}: </small><strong>{{ Auth::user()->email}}</strong>
                    <!-- Message End -->
                </div>


                <div class="dropdown-divider"></div>
                <a href="{{ url('/logout') }}" > <button type="button" class="btn btn-block btn-danger btn-sm"> {{trans('global.header.logout')}}</button></a>






            </div>
        </li>
        <!-- Notifications Dropdown Menu -->
{{--        <li class="nav-item dropdown">--}}
{{--            <a class="nav-link" data-toggle="dropdown" href="#">--}}
{{--                <i class="far fa-bell"></i>--}}
{{--                <span class="badge badge-warning navbar-badge">15</span>--}}
{{--            </a>--}}
{{--            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">--}}
{{--                <span class="dropdown-item dropdown-header">15 Notifications</span>--}}
{{--                <div class="dropdown-divider"></div>--}}
{{--                <a href="#" class="dropdown-item">--}}
{{--                    <i class="fas fa-envelope mr-2"></i> 4 new messages--}}
{{--                    <span class="float-right text-muted text-sm">3 mins</span>--}}
{{--                </a>--}}
{{--                <div class="dropdown-divider"></div>--}}
{{--                <a href="#" class="dropdown-item">--}}
{{--                    <i class="fas fa-users mr-2"></i> 8 friend requests--}}
{{--                    <span class="float-right text-muted text-sm">12 hours</span>--}}
{{--                </a>--}}
{{--                <div class="dropdown-divider"></div>--}}
{{--                <a href="#" class="dropdown-item">--}}
{{--                    <i class="fas fa-file mr-2"></i> 3 new reports--}}
{{--                    <span class="float-right text-muted text-sm">2 days</span>--}}
{{--                </a>--}}
{{--                <div class="dropdown-divider"></div>--}}
{{--                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>--}}
{{--            </div>--}}
{{--        </li>--}}
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">--}}
{{--                <i class="fas fa-th-large"></i>--}}
{{--            </a>--}}
{{--        </li>--}}
    </ul>
</nav>
<!-- /.navbar -->
