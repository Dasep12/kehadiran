<style>
    /* .nav-link {
        color: #FFF !important
    }

    .nav-item {
        color: #FFF !important
    }

    .navbar-expand-md .nav-item.active .nav-link {
        color: #FFF !important;
        border-bottom-color: #ffffff !important;
    } */
</style>
<header class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar">
            <div class="container-xl">
                <div class="row flex-column flex-md-row flex-fill align-items-center">
                    <div class="col">
                        <!-- BEGIN NAVBAR MENU -->
                        <ul class="navbar-nav">

                            @foreach(get_user_menus() as $menu)

                            @php

                            /*
                            |--------------------------------------------------------------------------
                            | CHECK ACTIVE MENU
                            |--------------------------------------------------------------------------
                            */

                            $isChildActive = false;

                            foreach($menu->children as $child){

                            // CHILD ACTIVE
                            if(
                            $child->menu_url != '#'
                            && Route::currentRouteName() == $child->menu_url
                            ){
                            $isChildActive = true;
                            }

                            // SUB CHILD ACTIVE
                            foreach($child->children as $sub){

                            if(
                            $sub->menu_url != '#'
                            && Route::currentRouteName() == $sub->menu_url
                            ){
                            $isChildActive = true;
                            }

                            }

                            }

                            $isActive =
                            Route::currentRouteName() == $menu->menu_url
                            || $isChildActive;

                            @endphp


                            {{-- ========================================================= --}}
                            {{-- MENU TANPA CHILD --}}
                            {{-- ========================================================= --}}

                            @if($menu->children->count() == 0)

                            <li class="nav-item {{ $isActive ? 'active' : '' }}">

                                <a class="nav-link {{ $isActive ? 'active' : '' }}"
                                    href="{{ $menu->menu_url != '#' ? route($menu->menu_url) : '#' }}">

                                    @if($menu->menu_icon)

                                    <span class="nav-link-icon d-md-none d-lg-inline-block">

                                        <i class="ti ti-{{ $menu->menu_icon }}"></i>

                                    </span>

                                    @endif

                                    <span class="nav-link-title">
                                        {{ $menu->menu_name }}
                                    </span>

                                </a>

                            </li>

                            @else

                            {{-- ========================================================= --}}
                            {{-- MENU DENGAN CHILD --}}
                            {{-- ========================================================= --}}

                            <li class="nav-item dropdown {{ $isActive ? 'active' : '' }}">

                                <a class="nav-link dropdown-toggle {{ $isActive ? 'active' : '' }}"
                                    href="#"
                                    data-bs-toggle="dropdown"
                                    data-bs-auto-close="outside"
                                    role="button"
                                    aria-expanded="false">

                                    @if($menu->menu_icon)

                                    <span class="nav-link-icon d-md-none d-lg-inline-block">

                                        <i class="ti ti-{{ $menu->menu_icon }}"></i>

                                    </span>

                                    @endif

                                    <span class="nav-link-title">
                                        {{ $menu->menu_name }}
                                    </span>

                                </a>

                                @php
                                $columns = $menu->children->groupBy('column_no');
                                @endphp

                                <div class="dropdown-menu">

                                    <div class="dropdown-menu-columns">

                                        @foreach($columns as $column)

                                        <div class="dropdown-menu-column">

                                            @foreach($column as $child)

                                            @php

                                            $childActive =
                                            Route::currentRouteName() == $child->menu_url;

                                            foreach($child->children as $sub){

                                            if(Route::currentRouteName() == $sub->menu_url){
                                            $childActive = true;
                                            }

                                            }

                                            @endphp


                                            {{-- ========================================================= --}}
                                            {{-- SUB MENU DENGAN CHILD --}}
                                            {{-- ========================================================= --}}

                                            @if($child->children->count())

                                            <div class="dropend">

                                                <a class="dropdown-item dropdown-toggle {{ $childActive ? 'active show' : '' }}"
                                                    href="#"
                                                    data-bs-toggle="dropdown"
                                                    data-bs-auto-close="outside"
                                                    aria-expanded="{{ $childActive ? 'true' : 'false' }}">

                                                    {{ $child->menu_name }}

                                                </a>

                                                {{-- AUTO OPEN JIKA ADA SUBMENU ACTIVE --}}
                                                <div class="dropdown-menu {{ $childActive ? 'show' : '' }}">

                                                    @foreach($child->children as $sub)

                                                    <a class="dropdown-item {{ Route::currentRouteName() == $sub->menu_url ? 'active' : '' }}"
                                                        href="{{ $sub->menu_url != '#' ? route($sub->menu_url) : '#' }}">

                                                        {{ $sub->menu_name }}

                                                    </a>

                                                    @endforeach

                                                </div>

                                            </div>

                                            @else

                                            {{-- ========================================================= --}}
                                            {{-- SUB MENU NORMAL --}}
                                            {{-- ========================================================= --}}

                                            <a class="dropdown-item {{ Route::currentRouteName() == $child->menu_url ? 'active' : '' }}"
                                                href="{{ $child->menu_url != '#' ? route($child->menu_url) : '#' }}">

                                                {{ $child->menu_name }}

                                            </a>

                                            @endif

                                            @endforeach

                                        </div>

                                        @endforeach

                                    </div>

                                </div>

                            </li>

                            @endif

                            @endforeach

                        </ul>
                        <!-- END NAVBAR MENU -->
                    </div>
                    <div class="col col-md-auto d-none">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSettings">
                                    <span class="badge badge-sm bg-red text-red-fg">New</span>
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                            <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"></path>
                                            <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                                        </svg>
                                    </span>
                                    <span class="nav-link-title"> Theme Settings </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>