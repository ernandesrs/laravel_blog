<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! $seo ?? null ? $seo->render() : null !!}

    {!! \App\Helpers\GoogleAdsense::script() !!}

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/front/styles.css') }}">

    @yield('styles')

</head>

<body>

    <div class="wrap">

        <div class="left-side">
            <div class="container-fluid">

                <header class="header">
                    <a class="logo" href="{{ route('front.home') }}" title="Página inicial">
                        <h1 class="sr-only">{{ config('app.name') }}</h1>
                        <span>{{ config('app.name') }}</span>
                    </a>
                    <button class="btn-menu-toggler {{ icon_class('list') }} jsBtnToggler"></button>
                </header>

                <div class="sidebar">
                    {{-- search --}}
                    <div class="sidebar-elem">
                        <div class="search-bar">
                            <form action="{{ route('front.search') }}" method="get">
                                <input class="form-control text-center" type="search" name="s"
                                    value="{{ input_value($_GET ?? null, 's') }}" placeholder="Buscar...">
                            </form>
                        </div>
                    </div>

                    <div class="sidebar-elem">
                        @include('front.includes.ads', ['adsType' => 'block'])
                    </div>

                    {{-- categories --}}
                    @php
                        $categories = \App\Models\Category::all();
                    @endphp
                    <div class="sidebar-elem categories">
                        <h2 class="title mb-0">Categorias</h2>
                        <nav class="nav">
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

                    {{-- mais vistos --}}
                    @php
                        $visited = \App\Models\AccessRegister::where('class', 'App\Models\Article')
                            ->orderBy('weekly_access', 'DESC')
                            ->limit(5)
                            ->get();
                    @endphp
                    <div class="sidebar-elem articles-most viewed">
                        <h2 class="title mb-0">Mais visitados</h2>
                        <nav class="nav flex-column">
                            @foreach ($visited as $v)
                                @php
                                    $article = $v->monitored();
                                @endphp
                                <a class="nav-link d-flex align-items-start px-0" href="">
                                    <img class="img-fluid img-thumbnail mr-2"
                                        src="{{ m_article_cover_thumb($article, [50, 35]) }}" alt="">
                                    <small>
                                        {{ substr($article->title, 0, 50) . (strlen($article->title) > 50 ? '...' : null) }}
                                    </small>
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
                    @include('includes.message')
                    @yield('content')
                </main>

            </div>
            <footer class="footer text-center">
                <div class="container-fluid">
                    <hr>
                    <p class="mb-0">
                        <small>
                            Direitos reservados à {{ config('app.name') }} &copy; {{ date('Y') }}
                        </small>
                    </p>
                    <p class="mb-0">
                        <small>
                            <a href="{{ route('front.dinamicPage', ['slug' => 'politicas-de-privacidade']) }}">Termos
                                de
                                privacidade</a>
                            <span class="mx-1">|</span>
                            <a href="{{ route('front.dinamicPage', ['slug' => 'termos-de-uso']) }}">Termos de
                                uso</a>
                        </small>
                    </p>
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
