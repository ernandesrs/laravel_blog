@extends('layouts.front')

@section('content')
    @php
    $image = asset('assets/post-cover.png');
    $articles = null;
    // $articles = [
    //     (object) [
    //         'title' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit',
    //         'description' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Consequatur iure quisquam ipsam assumenda nihil? Ullam reiciendis molestias tempore possimus doloribus!',
    //         'image' => $image,
    //         'created_at' => '2022-12-22 10:21:33',
    //         'author' => (object) [
    //             'name' => 'Ernandes Rosa de Souza',
    //         ],
    //         'tags' => [(object) ['title' => 'Tag1'], (object) ['title' => 'Tag2'], (object) ['title' => 'Tag3']],
    //         'categories' => [(object) ['title' => 'Category1'], (object) ['title' => 'Category2'], (object) ['title' => 'Category3']],
    //     ],

    //     (object) [
    //         'title' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit',
    //         'description' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Consequatur iure quisquam ipsam assumenda nihil? Ullam reiciendis molestias tempore possimus doloribus!',
    //         'image' => $image,
    //         'created_at' => '2022-12-22 10:21:33',
    //         'author' => (object) [
    //             'name' => 'Ernandes Rosa de Souza',
    //         ],
    //         'tags' => [(object) ['title' => 'Tag1'], (object) ['title' => 'Tag2'], (object) ['title' => 'Tag3']],
    //         'categories' => [(object) ['title' => 'Category1'], (object) ['title' => 'Category2'], (object) ['title' => 'Category3']],
    //     ],
    //     (object) [
    //         'title' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit',
    //         'description' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Consequatur iure quisquam ipsam assumenda nihil? Ullam reiciendis molestias tempore possimus doloribus!',
    //         'image' => $image,
    //         'created_at' => '2022-12-22 10:21:33',
    //         'author' => (object) [
    //             'name' => 'Ernandes Rosa de Souza',
    //         ],
    //         'tags' => [(object) ['title' => 'Tag1'], (object) ['title' => 'Tag2'], (object) ['title' => 'Tag3']],
    //         'categories' => [(object) ['title' => 'Category1'], (object) ['title' => 'Category2'], (object) ['title' => 'Category3']],
    //     ],
    //     (object) [
    //         'title' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit',
    //         'description' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Consequatur iure quisquam ipsam assumenda nihil? Ullam reiciendis molestias tempore possimus doloribus!',
    //         'image' => $image,
    //         'created_at' => '2022-12-22 10:21:33',
    //         'author' => (object) [
    //             'name' => 'Ernandes Rosa de Souza',
    //         ],
    //         'tags' => [(object) ['title' => 'Tag1'], (object) ['title' => 'Tag2'], (object) ['title' => 'Tag3']],
    //         'categories' => [(object) ['title' => 'Category1'], (object) ['title' => 'Category2'], (object) ['title' => 'Category3']],
    //     ],
    //     (object) [
    //         'title' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit',
    //         'description' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Consequatur iure quisquam ipsam assumenda nihil? Ullam reiciendis molestias tempore possimus doloribus!',
    //         'image' => $image,
    //         'created_at' => '2022-12-22 10:21:33',
    //         'author' => (object) [
    //             'name' => 'Ernandes Rosa de Souza',
    //         ],
    //         'tags' => [(object) ['title' => 'Tag1'], (object) ['title' => 'Tag2'], (object) ['title' => 'Tag3']],
    //         'categories' => [(object) ['title' => 'Category1'], (object) ['title' => 'Category2'], (object) ['title' => 'Category3']],
    //     ],
    //     (object) [
    //         'title' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit',
    //         'description' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Consequatur iure quisquam ipsam assumenda nihil? Ullam reiciendis molestias tempore possimus doloribus!',
    //         'image' => $image,
    //         'created_at' => '2022-12-22 10:21:33',
    //         'author' => (object) [
    //             'name' => 'Ernandes Rosa de Souza',
    //         ],
    //         'tags' => [(object) ['title' => 'Tag1'], (object) ['title' => 'Tag2'], (object) ['title' => 'Tag3']],
    //         'categories' => [(object) ['title' => 'Category1'], (object) ['title' => 'Category2'], (object) ['title' => 'Category3']],
    //     ],
    //     (object) [
    //         'title' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit',
    //         'description' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Consequatur iure quisquam ipsam assumenda nihil? Ullam reiciendis molestias tempore possimus doloribus!',
    //         'image' => $image,
    //         'created_at' => '2022-12-22 10:21:33',
    //         'author' => (object) [
    //             'name' => 'Ernandes Rosa de Souza',
    //         ],
    //         'tags' => [(object) ['title' => 'Tag1'], (object) ['title' => 'Tag2'], (object) ['title' => 'Tag3']],
    //         'categories' => [(object) ['title' => 'Category1'], (object) ['title' => 'Category2'], (object) ['title' => 'Category3']],
    //     ],
    //     (object) [
    //         'title' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit',
    //         'description' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Consequatur iure quisquam ipsam assumenda nihil? Ullam reiciendis molestias tempore possimus doloribus!',
    //         'image' => $image,
    //         'created_at' => '2022-12-22 10:21:33',
    //         'author' => (object) [
    //             'name' => 'Ernandes Rosa de Souza',
    //         ],
    //         'tags' => [(object) ['title' => 'Tag1'], (object) ['title' => 'Tag2'], (object) ['title' => 'Tag3']],
    //         'categories' => [(object) ['title' => 'Category1'], (object) ['title' => 'Category2'], (object) ['title' => 'Category3']],
    //     ],
    //     (object) [
    //         'title' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit',
    //         'description' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Consequatur iure quisquam ipsam assumenda nihil? Ullam reiciendis molestias tempore possimus doloribus!',
    //         'image' => $image,
    //         'created_at' => '2022-12-22 10:21:33',
    //         'author' => (object) [
    //             'name' => 'Ernandes Rosa de Souza',
    //         ],
    //         'tags' => [(object) ['title' => 'Tag1'], (object) ['title' => 'Tag2'], (object) ['title' => 'Tag3']],
    //         'categories' => [(object) ['title' => 'Category1'], (object) ['title' => 'Category2'], (object) ['title' => 'Category3']],
    //     ],
    //     (object) [
    //         'title' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit',
    //         'description' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Consequatur iure quisquam ipsam assumenda nihil? Ullam reiciendis molestias tempore possimus doloribus!',
    //         'image' => $image,
    //         'created_at' => '2022-12-22 10:21:33',
    //         'author' => (object) [
    //             'name' => 'Ernandes Rosa de Souza',
    //         ],
    //         'tags' => [(object) ['title' => 'Tag1'], (object) ['title' => 'Tag2'], (object) ['title' => 'Tag3']],
    //         'categories' => [(object) ['title' => 'Category1'], (object) ['title' => 'Category2'], (object) ['title' => 'Category3']],
    //     ],
    //     (object) [
    //         'title' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit',
    //         'description' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Consequatur iure quisquam ipsam assumenda nihil? Ullam reiciendis molestias tempore possimus doloribus!',
    //         'image' => $image,
    //         'created_at' => '2022-12-22 10:21:33',
    //         'author' => (object) [
    //             'name' => 'Ernandes Rosa de Souza',
    //         ],
    //         'tags' => [(object) ['title' => 'Tag1'], (object) ['title' => 'Tag2'], (object) ['title' => 'Tag3']],
    //         'categories' => [(object) ['title' => 'Category1'], (object) ['title' => 'Category2'], (object) ['title' => 'Category3']],
    //     ],
    // ];
    @endphp

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
