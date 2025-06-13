<ul>
    @foreach($children as $child)
        <li class="@if($child['id_modules_type'] == 2) {{$css_modules_type ='text-red'}} @else {{$css_modules_type =''}} @endif">
            @if($child['type'])
                {{ $child['id'] }}. {{ $child['title'] }} (<strong>{{ $child['type'] }}</strong>)
            @endif
            @if(!empty($child['children']))
                @include('Users::users.tree-group', ['children' => $child['children']])
            @endif
        </li>
    @endforeach
</ul>
