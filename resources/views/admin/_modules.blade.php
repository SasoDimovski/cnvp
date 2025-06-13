<?php
$lang = request()->segment(2);
$id_module = request()->segment(3);
?>
    <!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-info elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('admin/'.$lang.'/main/') }}" class="brand-link navbar-info">
        <b class="justify_center">{{config('app.TITLE_SHORT')}}</b>
        {{--      <span class="brand-text font-weight-light">{{trans('properties.global.app_title')}}</span>--}}
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-compact" data-widget="treeview"
                role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->

                @if(count($assignedModules) > 0)

                    @foreach($assignedModules as $module)
                        @php
                            $module['children'] = collect($module['children'])->toArray();
                        @endphp
{{--                            <?php--}}
{{--                            $array = json_decode(json_encode($module['children']), true);--}}
{{--                            $key = App\Models\Modules::search_in_multidimensional_array($id_module, $array, array('$'));--}}
{{--                            ?>--}}
{{--                        @if(empty($module['children']) AND empty($module['id_parent']))--}}
{{--                            <li class="nav-item">--}}
{{--                                <a href="#" class="nav-link {{ $module['button_color'] }}">--}}
{{--                                    <i class="nav-icon {{ $module['icon'] }}"></i>--}}
{{--                                    <p class="{{ $module['text_color'] }}">{{ $module['title'] }}</p>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        @else--}}
                                <?php
                                $array = json_decode(json_encode($module['children']), true);
                                $key = App\Models\Modules::search_in_multidimensional_array($id_module, $array, array('$'));
//                                print_r('$key:'.$key.'<br>' );
//                                print_r('[children]:'.!empty($module['children']).'<br>'  );
//                                print_r('[id_parent]:'.!empty($module['id_parent']) );
                                ?>
                            <li class="nav-item @if(!empty($module['children']))  {{'has-treeview'}} @endif @if($key) {{'menu-open'}}@endif">
                                <a href="{{ url('admin/'.$lang.'/'.$module['link'])}}"
                                   class="nav-link {{ $module['button_color'] }} @if($id_module ==$module['id']) {{'active'}} @endif">
                                    <i class="nav-icon {{ $module['icon'] }}"></i>
                                    <p class="{{ $module['text_color'] }}">{{ $module['title'] }}<i
                                            class="@if(!empty($module['children'])) {{'right fas fa-angle-left'}} @endif"></i>
                                    </p>
                                </a>
                                @if(!empty($module['children']))
                                    @include('admin._modules_sub', ['children' => $module['children']])
                                @endif
                            </li>
{{--                        @endif--}}

                    @endforeach
                @endif


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
