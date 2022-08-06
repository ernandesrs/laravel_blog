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

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/front/styles.css') }}">

    @yield('styles')

</head>

<body>

    <div class="wrap">

        <div class="left-side">
            <div class="container-fluid">

                <header class="header">
                    <h1 class="h5 mb-0">{{ config('app.name') }}</h1>
                    <button class="btn-menu-toggler {{ icon_class('list') }} jsBtnToggler"></button>
                </header>

                <div class="sidebar">
                    <div class="sidebar-elem">
                        <nav class="nav flex-column">
                            @php
                                $categories = \App\Models\Category::all();
                            @endphp
                            @foreach ($categories as $category)
                                @php
                                    $slugs = $category->slugs()->first();
                                @endphp
                                <a class="nav-link"
                                    href="{{ route('front.category', ['slug' => $slugs->slug(app()->getLocale())]) }}"
                                    title="Ver artigos em {{ $category->title }}">
                                    {{ $category->title }}
                                </a>
                            @endforeach
                        </nav>
                    </div>
                </div>

            </div>
        </div>

        <div class="right-side">
            <div class="container-fluid">
                <main class="main">
                    <div class="search-bar pb-4">
                        <form action="{{ route('front.search') }}" method="get">
                            <input class="form-control text-center" type="search" name="s"
                                value="{{ input_value($_GET ?? null, 's') }}" placeholder="Pesquise por um artigo">
                        </form>
                    </div>
                    @include('includes.message')
                    @yield('content')
                </main>

            </div>

            <footer class="footer text-center">
                <div class="container-fluid">
                    <small>
                        Direitos reservados à {{ config('app.name') }} &copy; {{ date('Y') }}
                    </small>
                </div>
            </footer>
        </div>

    </div>

    @yield('modals')

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/boostrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.min.js') }}"></script>
    <script src="{{ asset('assets/js/front/scripts.js') }}"></script>
    @yield('scripts')
</body>

</html>
