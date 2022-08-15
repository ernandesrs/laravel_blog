@extends('layouts.front')

@section('content')
    {{-- article featured --}}
    @if ($articles->count())
        {{-- articles list --}}
        <div class="row">
            @foreach ($articles as $key => $article)
                <div class="col-12 {{ $key == 0 ? null : 'col-sm-6 col-md-4 col-lg-6' }} mb-4">
                    <div class="card card-body article-summary {{ $key == 0 ? 'featured-article' : 'no-featured-article border-0' }}">
                        @include('front.includes.article-summary', [
                            'article' => $article,
                            'featured' => $key == 0 ? true : false,
                        ])
                    </div>
                </div>

                @if ($key == 0)
                    <div class="col-12 pb-4">
                        @include('front.includes.ads', ['adsType' => 'horizontal'])
                    </div>
                @endif
            @endforeach
        </div>

        <div class="row justify-content-center py-2">
            <div class="col-12 d-flex justify-content-end align-items-center">
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
