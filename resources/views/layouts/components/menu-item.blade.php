@if($menu->children->count() > 0)

<div class="{{ $level == 0 ? 'dropdown-menu' : 'dropdown-menu' }}">

    @foreach($menu->children as $child)

    @if($child->children->count() > 0)

    <div class="dropend">

        <a class="dropdown-item dropdown-toggle"
            href="#"
            data-bs-toggle="dropdown"
            data-bs-auto-close="outside">

            {{ $child->menu_name }}

        </a>

        @include('layouts.components.menu-item',[
        'menu' => $child,
        'level' => $level + 1
        ])

    </div>

    @else

    <a class="dropdown-item"
        href="{{ $child->menu_url != '#' ? route($child->menu_url) : '' }}">
        {{ $child->menu_name }}
    </a>

    @endif

    @endforeach

</div>

@endif