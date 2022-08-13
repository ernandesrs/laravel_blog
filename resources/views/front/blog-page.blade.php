@extends('layouts.front')

@php
$isArticle = $article ?? null ? true : false;
$isCategory = $category ?? null ? true : false;
$isSearchResult = empty($_GET['s']) ? false : true;
@endphp

@section('content')
    <article class="blog-page {{ $isArticle ? 'article-page' : 'page-page' }}">
        {{-- header --}}
        <header class="text-center jumbotron"
            style="background-image: url({{ thumb(Storage::path('public/' . ($isArticle ? $article->cover : ($isCategory ? $category->cover ?? '' : ''))), 1200, 800) }})">
            <h1 class="display-4">
                @if ($isArticle)
                    {{ $article->title }}
                @elseif ($isCategory)
                    Artigos para a categoria: {{ $category->title }}
                @else
                    Resultado de pesquisa
                @endif
            </h1>
            @if ($isArticle)
                @if (!empty($article->description))
                    <p class="lead">
                        {{ $article->description }}
                    </p>
                @endif
                @php
                    $articleCategories = $article->categories()->get();
                    $total = $articleCategories->count();
                    $count = 0;
                @endphp
                <div class="">
                    <p class="mb-1">
                        <span>
                            {{ icon_elem('tagsFill') }}
                            @foreach ($articleCategories as $category)
                                @php
                                    $count++;
                                @endphp
                                <a href="{{ route('front.category', ['slug' => $category->slugs()->first()->slug($category->lang)]) }}"
                                    title="Ver mais artigos em {{ $category->title }}">{{ $category->title }}</a>{{ $count < $total ? ',' : null }}
                            @endforeach
                        </span>
                    </p>
                    <p class="mb-0">
                        <span>
                            {{ icon_elem('userFill') }}
                            <span>
                                {{ $article->author()->name }}
                            </span>
                        </span>
                        <span class="mx-2"></span>
                        <span>
                            {{ icon_elem('calendarCheckFill') }}
                            <span>
                                {{ date('d/m/Y H:i:s', strtotime($article->published_at)) }}
                            </span>
                        </span>
                    </p>
                </div>
            @elseif ($isCategory)
                <p class="lead">
                    @if (empty($category->description))
                        Veja tudo o temos preparado para você sobre {{ $category->title }}
                    @else
                        {{ $category->description }}
                    @endif
                </p>
            @elseif($isSearchResult)
                <p class="lead">
                    @if ($articles->count())
                        Mostrando resultados para sua pesquisa: {{ input_value($_GET ?? null, 's') }}
                    @else
                        Sem resultados para sua pesquisa
                    @endif
                </p>
            @endif
        </header>

        <div class="pb-4">
            @include('front.includes.ads', ['adsType' => 'horizontal'])
        </div>

        @if ($isCategory || $isSearchResult)
            <div class="row justify-content">
                @foreach ($articles as $article)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-6 mb-4">
                        <div class="card card-body article-summary border-0">
                            @include('front.includes.article-summary', ['article' => $article])
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row justify-content-center py-2">
                <div class="col-12">
                    {{ $articles->links() }}
                </div>
            </div>
        @elseif($isArticle)
            <div class="">
                {!! $article->content !!}
            </div>

            @if (env('APP_DISQUS'))
                <div>
                    <hr class="py-3">
                    <div id="disqus_thread"></div>
                    <script>
                        /**
                         *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
                         *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables
                         **/

                        var disqus_config = function() {
                            this.page.url = "{{ $pageUrl }}"; // Replace PAGE_URL with your page's canonical URL variable
                            this.page.identifier =
                                {{ $article->id }}; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                        };

                        (function() { // DON'T EDIT BELOW THIS LINE
                            var d = document,
                                s = d.createElement('script');
                            s.src = "{{ env('APP_DISQUS_SCRIPT_1') }}";
                            s.setAttribute('data-timestamp', +new Date());
                            (d.head || d.body).appendChild(s);
                        })();
                    </script>
                    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments
                            powered
                            by Disqus.</a></noscript>
                </div>
            @endif
        @endif

    </article>
@endsection

@section('scripts')
    <script id="dsq-count-scr" src="{{ env('APP_DISQUS_SCRIPT_2') }}" async></script>
@endsection
