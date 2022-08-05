@extends('layouts.admin', [
    'mainBar' => [
        'title' => $pageTitle,
        'buttons' => [t_button_link_data('Voltar', 'primary', icon_class('arrowLeft'), route('admin.blog.articles.index'), null, null)],
    ],
])

@section('content')
    <form action="{{ route('admin.blog.articles.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            @include('admin.blog.includes.articles-form-fields')
        </div>
    </form>
@endsection
