<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--  Essential META Tags -->
    <meta property="og:title" content="{{ $pageDescription }}">
    <meta property="og:type" content="article" />
    <meta property="og:image" content="{{ $pageCover }}">
    <meta property="og:url" content="{{ $pageUrl }}">
    <meta name="twitter:card" content="{{ $pageCover }}">

    <!--  Non-Essential, But Recommended -->
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:site_name" content="{{ config('app.name') }} - {{ $pageTitle }}">
    <meta name="twitter:image:alt" content="{{ $pageCover }}">

    <meta name="description" content="{{ $pageDescription }}">
    <meta name="robots" content="{{ $pageFollow ? 'index,follow' : 'noindex,nofollow' }}" />
    <link rel="canonical" href="{{ $pageUrl }}" />

    <title>{{ config('app.name') }} - {{ $pageTitle }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/front/styles.css') }}">
    @yield('styles')

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body>
    <header class="bg-light border-bottom">
        <div class="container py-2 d-flex align-items-center">
            <a href="">{{ config('app.name') }}</a>
            <nav class="nav ml-auto">
                @auth
                    @if (auth()->user()->level === 9)
                        <a class="nav-link" href="{{ route('admin.home') }}">Administração</a>
                    @endif
                    <a class="nav-link" href="{{ route('member.home') }}">Painel</a>
                    <a class="nav-link jsLogout" href="{{ route('auth.logout') }}">Sair</a>
                @else
                    <a class="nav-link" href="{{ route('auth.register') }}">Registro</a>
                    <a class="nav-link" href="{{ route('auth.login') }}">Login</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="main">
        <div class="container">
            @include('includes.message')
        </div>

        @yield('content')
    </main>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/boostrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.min.js') }}"></script>
    <script src="{{ asset('assets/js/front/scripts.js') }}"></script>
    @yield('scripts')
</body>

</html>
