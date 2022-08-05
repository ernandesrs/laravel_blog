@extends('layouts.admin', [
    'mainBar' => [
        'title' => $pageTitle,
        'buttons' => [
            t_button_link_data('Novo artigo', 'outline-success', icon_class('plusLg'), route('admin.blog.articles.create'), null, null)
        ],
    ],
])

@section("content")
@endsection