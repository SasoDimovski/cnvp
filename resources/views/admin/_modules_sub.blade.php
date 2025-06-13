@foreach($children as $child)

    <ul class="nav nav-treeview">
        @php
            $child['children'] = collect($child['children'])->toArray();
        @endphp
        {{--        @if(empty($child['children']))--}}
        {{--            <li class="nav-item">--}}
        {{--                <a href="{{ url('admin/'.$lang.'/'.$child['link'])}}"--}}
        {{--                   class="nav-link {{ $child['button_color'] }} @if($id_module ==$child['id']) {{'active'}} @endif">--}}
        {{--                        <i class="nav-icon {{ $child['icon'] }}"></i>--}}
        {{--                        <p class="{{ $child['text_color'] }}" >{{ $child['title'] }}</p>--}}
        {{--                </a>--}}
        {{--            </li>--}}

        {{--        @else--}}
            <?php
            $array = json_decode(json_encode($child['children']), true);
            $key = App\Models\Modules::search_in_multidimensional_array($id_module, $array, array('$'));
//            print_r('$key:'.$key.'<br>' );
//            print_r('[children]:'.!empty($child['children']).'<br>'  );
//            print_r('[id_parent]:'.!empty($child['id_parent']) );
            ?>
        <li class="nav-item @if(!empty($child['children']))  {{'has-treeview'}} @endif @if($key) {{'menu-open'}} @endif">
            <a href="#"
               class="nav-link {{ $child['button_color'] }} @if($id_module ==$child['id']) {{'active'}} @endif">
                <i class="nav-icon {{ $child['icon'] }}"></i>
                <p class="{{ $child['text_color'] }}">{{ $child['title'] }}<i
                        class="@if(!empty($child['children'])) {{'right fas fa-angle-left'}} @endif"></i></p>
            </a>

            @if(count($child['children']))
                @include('admin._modules_sub',['children' => $child['children']])
            @endif
        </li>
        {{--        @endif--}}
    </ul>
@endforeach


