<ul>
    @foreach($children as $child)
        <li class="@if($child['id_modules_type'] == 2) {{$css_modules_type ='text-red'}} @else {{$css_modules_type =''}} @endif">
            @if($child['type'])
                {{ $child['id'] }}. {{ $child['title'] }} (<strong>{{ $child['type'] }}</strong>)
                <a href="#" class="modal_warning"
                   data-toggle="modal"
                   data-target="#ModalWarning"
                   data-title="Додели модул на корисник"
                   data-url="/admin/main/{{ Auth::id()}}/{{ $child['id'] }}"
                   data-content_l="Корисник: {{ Auth::user()->username}} ({{ Auth::id()}})"
                   data-content_b="Модул: {{ $child['id'] }}. {{ $child['title'] }}"
                   title="Додели модул на корисник">
                    <-
                </a>
            @endif
            @if(!empty($child['children']))
                @include('Main::main.tree-item', ['children' => $child['children']])
            @endif
        </li>
    @endforeach
</ul>
