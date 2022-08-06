@extends('layouts.front')

@section('content')
    {{-- article featured --}}
    @if (count($articles ?? []))
        <div class="row mb-4">
            <div class="col-12">
                <div class="card card-body article-summary featured-article">
                    @include('front.includes.article-summary', [
                        'article' => $articles[0],
                    ])
                </div>
            </div>
        </div>

        {{-- articles list --}}
        <div class="row">
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
    @else
        <div class="row">
            <div class="col-12">
                <p class="h5 mb-0 border text-center py-3 text-muted">
                    Nenhum artigo :(
                </p>
            </div>
        </div>
    @endif
@endsection
