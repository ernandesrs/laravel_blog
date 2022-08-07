@extends('layouts.admin', [
    'mainBar' => [
        'title' => $pageTitle,
        'buttons' => [t_button_link_data('btn btn-primary', 'Voltar', route('admin.blog.articles.index'), icon_class('arrowLeft'), null, null), t_button_link_data('btn btn-outline-success', 'Novo artigo', route('admin.blog.articles.create'), icon_class('plusLg'), null, null)],
    ],
])

@section('content')
    <form class="jsFormSubmit" action="{{ route('admin.blog.articles.update', ['article' => $article->id]) }}" method="post"
        enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            @include('admin.blog.includes.articles-form-fields')
        </div>
    </form>
@endsection
