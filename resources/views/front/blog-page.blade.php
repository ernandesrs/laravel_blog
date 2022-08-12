@extends('layouts.front')

@php
$isArticle = $article ?? null ? true : false;
$isCategory = $category ?? null ? true : false;
$isSearchResult = empty($_GET['s']) ? false : true;
@endphp

@section('content')
    <article class="blog-page {{ $isArticle ? 'article-page' : 'page-page' }}">
        {{-- header --}}
        <header class="text-center jumbotron">
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
                    <div class="col-12 col-sm-6 col-lg-12 col-xl-6 mb-4">
                        <div class="card card-body article-summary">
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
        @endif

    </article>
@endsection
