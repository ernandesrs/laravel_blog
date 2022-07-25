<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} Membro - {{ $pageTitle }}</title>

    <link rel="stylesheet" href="{{ asset('assets/css/member/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-icons.min.css') }}">
    @yield('styles')
</head>

<body>

    <header class="header d-flex align-items-center">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <div class="d-flex align-items-center left">
                    <h1 class="mb-0 d-none d-lg-block logo">{{ strtoupper(config('app.name')) }}</h1>
                    <button class="ml-auto d-lg-none bi bi-list btn-menu-toggler" data-active-icon="bi bi-list"
                        data-alt-icon="bi bi-x-lg"></button>
                </div>

                <nav class="nav ml-auto">
                    <a class="text-danger" href="{{ route('auth.logout') }}">
                        <i class='bi bi-box-arrow-left'></i> Sair
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <div class="d-flex wrapp">
        <aside class="sidebar accordion d-none d-lg-flex" id="sidebar">
            <div class="container-fluid d-flex flex-column py-3">
                @php
                    $items = config('panel-member')['sidebar'];
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
                            <div class="subnav collapse pl-2 {{ $active ? 'show' : null }}"
                                id="item{{ $key }}" data-parent="#sidebar">
                                @foreach ($item['items'] as $i)
                                    <a class="nav-link {{ in_array($croute, $i['activeIn']) ? 'active' : null }}"
                                        href="{{ $i['route'] ?? null ? route($i['route']) : null }}"
                                        target="{{ $i['target'] }}">
                                        <i class="icon {{ $i['icon'] }}"></i> {{ $i['text'] }}
                                    </a>
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

                @yield('content')
            </main>

            <footer class="footer">
                <p class="mb-0 text-center">
                    <small>{{ config('app.name') }} com <i class='bi bi-heart-fill'></i> para você</small>
                </p>
            </footer>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/boostrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.min.js') }}"></script>
    <script src="{{ asset('assets/js/member/scripts.js') }}"></script>

    @yield('scripts')
</body>

</html>
