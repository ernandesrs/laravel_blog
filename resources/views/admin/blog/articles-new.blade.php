@extends('layouts.admin', [
    'mainBar' => [
        'title' => $pageTitle,
        'buttons' => [t_button_link_data('btn btn-primary', 'Voltar', route('admin.blog.articles.index'), icon_class('arrowLeft'), null, null)],
    ],
])

@section('content')
    <form class="jsFormSubmit" action="{{ route('admin.blog.articles.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            @include('admin.blog.includes.articles-form-fields')
        </div>
    </form>
@endsection
