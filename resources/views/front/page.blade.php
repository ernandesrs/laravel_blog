@extends('layouts.front')

@section('content')
    <article class="article">
        <div class="jumbotron" style="background-image: url({{ m_article_cover_thumb($article, 'medium') }})">
            <h1 class="display-4 article-title">
                {{ $article->title }}
            </h1>
            <div class="d-flex flex-column py-3 article-info">
                @php
                    $author = $article->author();
                    $categories = $article->categories()->get();
                @endphp
                <div class="categories">
                    {{ icon_elem('tagsFill') }}
                    @foreach ($categories as $category)
                        <a href="{{ route('front.category', ['slug' => $category->slugs()->first()->slug($category->lang)]) }}"
                            title="Ver mais artigos em {{ $category->title }}">{{ $category->title }}</a>,
                    @endforeach
                </div>

                <div class="author-publish-date">
                    <span>{{ icon_elem('userFill') }} {{ $author->name }}</span>
                    <span class="mx-2"></span>
                    <span>{{ icon_elem('calendarCheckFill') }} {{ date('d/m/Y H:i:s', strtotime($article->created_at)) }}</span>
                </div>
            </div>

            <p class="lead article-description">
                {{ $article->description }}
            </p>
        </div>

        <div>
            {!! $article->content !!}
        </div>
    </article>
@endsection
