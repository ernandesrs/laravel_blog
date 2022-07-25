<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} Admin - {{ $pageTitle }}</title>

    <link rel="stylesheet" href="{{ asset('assets/css/admin/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-icons.min.css') }}">
    @yield('styles')
</head>

<body>

    <header class="header d-flex align-items-center">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <div class="d-flex align-items-center left">
                    <h1 class="mb-0 d-none d-lg-block logo">{{ strtoupper(config('app.name')) }}</h1>
                    <button class="ml-auto d-lg-none {{ icon_class('list') }} btn-menu-toggler"
                        data-active-icon="{{ icon_class('list') }}" data-alt-icon="{{ icon_class('x') }}"></button>
                </div>

                <nav class="nav ml-auto">
                    <a class="text-danger {{ icon_class('logout') }}" href="{{ route('auth.logout') }}">
                        Sair
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <div class="d-flex wrapp">
        <aside class="sidebar accordion d-none d-lg-flex" id="sidebar">
            <div class="container-fluid d-flex flex-column py-3">
                @php
                    $items = config('panel-admin')['sidebar'];
                    $croute = Route::currentRouteName();
                @endphp

                <nav class="nav flex-column">
                    @foreach ($items as $key => $item)
                        @if ($item['items'] ?? null)
                            @php
                                $active = in_array($croute, $item['activeIn']) ? 'active' : null;
                            @endphp
                            <a class="nav-link {{ $active }}" href="#" data-toggle="collapse"
                                data-target="#item{{ $key }}">
                                <i class="icon {{ $item['icon'] }}"></i> {{ $item['text'] }}
                            </a>
                            <div class="subnav collapse {{ $active ? 'show' : null }}"
                                id="item{{ $key }}" data-parent="#sidebar">
                                @foreach ($item['items'] as $i)
                                    @if ($i['visibleIn'] ?? null)
                                        @if (in_array(Route::currentRouteName(), $i['visibleIn'] ?? []))
                                            <a class="nav-link {{ in_array($croute, $i['activeIn']) ? 'active' : null }}"
                                                href="{{ $i['route'] ?? null ? route($i['route']) : null }}"
                                                target="{{ $item['target'] }}">
                                                <i class="icon {{ $i['icon'] }}"></i> {{ $i['text'] }}
                                            </a>
                                        @endif
                                    @else
                                        <a class="nav-link {{ in_array($croute, $i['activeIn']) ? 'active' : null }}"
                                            href="{{ $i['route'] ?? null ? route($i['route']) : null }}"
                                            target="{{ $item['target'] }}">
                                            <i class="icon {{ $i['icon'] }}"></i> {{ $i['text'] }}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <a class="nav-link {{ in_array($croute, $item['activeIn']) ? 'active' : null }}"
                                href="{{ $item['route'] ?? null ? route($item['route']) : null }}"
                                target="{{ $item['target'] }}">
                                <i class="icon {{ $item['icon'] }}"></i> {{ $item['text'] }}
                            </a>
                        @endif
                    @endforeach
                </nav>
            </div>
        </aside>

        <div class="container-fluid d-flex flex-column w-100">
            <main class="main h-100">
                @include('includes.message')

                {{-- MAIN BAR --}}
                @if ($mainBar ?? false)
                    @php
                        $mainBar = (object) $mainBar;
                    @endphp
                    <div class="row justify-content-start align-items-center py-3">
                        {{-- MAIN TITLE --}}
                        <div class="col-12 col-md-4 col-xl-7">
                            <h1 class="h5 pb-2 pb-md-0">{{ $mainBar->title }}</h1>
                        </div>

                        {{-- MAIN FILTER --}}
                        @if ($mainBar->filterFormAction ?? false)
                            <div class="filter col-12 col-md-8 col-xl-5">
                                <form action="{{ $mainBar->filterFormAction }}" method="get">
                                    {{-- EXTRAS INPUT FILTERS --}}
                                    <div class="collapse" id="moreFilters">
                                        <div class="card card-body bg-transparent p-0 border-0">
                                            <div class="row justify-content-start">
                                                @if ($mainBar->filterFormFields ?? false)
                                                    @foreach ($mainBar->filterFormFields as $field)
                                                        <div class="col-12 col-sm-6 col-md-4 mb-3 mb-0">
                                                            @php
                                                                $field = (object) $field;
                                                            @endphp
                                                            <label class="sr-only"
                                                                for="{{ $field->name }}">{{ $field->label }}:</label>
                                                            @if ($field->type == 'input')
                                                                <input class="form-control text-center" type="text"
                                                                    name="{{ $field->name }}"
                                                                    id="{{ $field->name }}"
                                                                    placeholder="{{ $field->placeholder ?? $field->label }}"
                                                                    value="{{ input_value($_GET ?? null, $field->name) }}">
                                                            @elseif($field->type == 'select')
                                                                <select class="form-control text-center"
                                                                    name="{{ $field->name }}"
                                                                    id="{{ $field->name }}">
                                                                    <option value="none">{{ $field->label }}
                                                                    </option>
                                                                    @foreach ($field->options as $keyOpt => $valueOpt)
                                                                        <option value="{{ $keyOpt }}"
                                                                            {{ input_value($_GET ?? null, $field->name) == $keyOpt ? 'selected' : null }}>
                                                                            {{ $valueOpt }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="col-12">
                                                        <p class="mb-0 text-center">Não há mais filtros</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- DEFAULT INPUT --}}
                                    <div class="mt-2 mt-md-0">
                                        <div class="form-group mb-0 d-flex">
                                            <label class="sr-only" for="search">Buscar por:</label>
                                            <input class="form-control text-center" type="text" name="search"
                                                id="search" placeholder="Buscar por..."
                                                value="{{ input_value($_GET ?? null, 'search') }}">

                                            <input type="hidden" name="filter" id="filter" value="1">

                                            <button
                                                class="btn bg-transparent {{ icon_class('caretDownFill') }} ml-2 jsShowMoreFilters"
                                                type="button" data-active-icon="{{ icon_class('caretDownFill') }}"
                                                data-alt-icon="{{ icon_class('caretUpFill') }}"
                                                data-toggle="collapse" data-target="#moreFilters">
                                            </button>

                                            <button class="btn bg-light {{ icon_class('filter') }} ml-1"
                                                type="submit" data-active-icon="{{ icon_class('filter') }}"
                                                data-alt-icon="{{ icon_class('loading') }}"></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                @endif

                @yield('content')
            </main>

            <footer class="footer">
                <p class="mb-0 text-center">
                    <small>{{ config('app.name') }} com {{ icon_elem('heartFill') }} para você</small>
                </p>
            </footer>
        </div>
    </div>

    @yield('modals')

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/boostrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.min.js') }}"></script>
    <script src="{{ asset('assets/js/admin/scripts.js') }}"></script>

    @yield('scripts')
</body>

</html>
