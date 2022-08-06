@extends('layouts.admin', [
    'mainBar' => [
        'title' => $pageTitle,
        'buttons' => [t_button_link_data('Novo artigo', 'outline-success', icon_class('plusLg'), route('admin.blog.articles.create'), null, null)],
    ],
])

@section('content')
    <div class="table-responsive">
        <table class="table table-hover table-borderless">
            <tbody>
                @php
                    /** @var \App\Models\Article $article */
                @endphp
                @foreach ($articles ?? [] as $article)
                    <tr>
                        <td class="align-middle">
                            <div class="d-flex">
                                <img class="img-fluid img-thumbnail mr-2" src="{{ m_article_cover_thumb($article, 'small') }}"
                                    alt="">

                                <div class="d-flex flex-column">
                                    <span class="font-weight-bold">
                                        {{ $article->title }}
                                    </span>
                                    <p class="text-muted mb-0">
                                        <small>
                                            {{ $article->description }}
                                        </small>
                                    </p>
                                    <p class="mb-0">
                                        @php
                                            $author = $article->author();
                                            $categories = $article->categories()->get();
                                        @endphp
                                        <span class="badge badge-light">
                                            {{ $author->name }}
                                        </span>
                                        <span class="mx-2">|</span>
                                        <span>
                                            @foreach ($categories as $category)
                                                <span class="badge badge-secondary">{{ $category->title }}</span>
                                            @endforeach
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle text-right">
                            <a class="btn btn-primary {{ icon_class('pencilSquare') }}"
                                href="{{ route('admin.blog.articles.edit', ['article' => $article->id]) }}"></a>
                            @include('includes.button-confirmation', [
                                'btnAction' => route('admin.blog.articles.destroy', [
                                    'article' => $article->id,
                                ]),
                                'btnClass' => 'btn-sm btn-outline-danger',
                                'btnIcon' => icon_class('trash'),
                                'btnType' => 'danger',
                                'btnMessage' =>
                                    'Você está excluindo <strong>"' .
                                    $article->title .
                                    '"</strong> permanentemente e isso não pode ser desfeito, confirme para continuar.',
                                'btnText' => '',
                            ])
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if ($categorias ?? null)
            <div class="d-flex justify-content-end align-items-center py-2">
                {{ $articles->onEachSide(2)->links() }}
            </div>
        @endif
    </div>
@endsection

@section('modals')
    @include('includes.modal-confirmation')
@endsection
