@extends('layouts.admin', [
    'mainBar' => [
        'filterFormAction' => route('admin.blog.articles.index'),
        'filterFormFields' => [
            [
                'name' => 'status',
                'label' => 'Status',
                'type' => 'select',
                'options' => [
                    'draft' => 'Rascunho',
                    'published' => 'Publicado',
                    'scheduled' => 'Agendado',
                ],
            ],
            [
                'name' => 'order',
                'label' => 'Ordem',
                'type' => 'select',
                'options' => [
                    'asc' => 'Mais antigo',
                    'desc' => 'Mais recente',
                ],
            ],
        ],
        'title' => $pageTitle,
        'buttons' => [t_button_link_data('btn btn-outline-success', 'Novo artigo', route('admin.blog.articles.create'), icon_class('plusLg'), null, null)],
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
                            <div class="d-flex align-items-center">
                                <img class="img-fluid img-thumbnail mr-2 d-none d-sm-block"
                                    src="{{ m_article_cover_thumb($article, 'small') }}" alt="">

                                <div class="d-flex flex-column">
                                    <span class="font-weight-bold">
                                        @if ($article->status == 'published')
                                            <a href="{{ route('front.article', ['slug' => $article->slugs()->first()->slug($article->lang)]) }}"
                                                title="Ver {{ $article->title }}" target="_blank">
                                                {{ $article->title }}
                                            </a>
                                        @else
                                            {{ $article->title }}
                                        @endif
                                    </span>
                                    <p class="text-muted mb-0 d-none d-sm-block">
                                        <small>
                                            {{ substr($article->description, 0, 150) . '' . (strlen($article->description) > 150 ? '...' : null) }}
                                        </small>
                                    </p>
                                    <p class="mb-0">
                                        @php
                                            $author = $article->author();
                                            $categories = $article->categories()->get();
                                            
                                            $categoriesShow = $categories->map(function ($item) {
                                                return $item->title;
                                            });
                                        @endphp
                                        <span class="badge badge-dark-light">
                                            {{ icon_elem('userFill') }}
                                            {{ substr($author->name, 0, 12) . (strlen($author->name) > 12 ? '...' : null) }}
                                        </span>
                                        <span class="badge badge-secondary" data-toggle="tooltip"
                                            title="Todas categorias: {{ $categoriesShow->join(', ') }}">
                                            {{ icon_elem('folderFill') }}
                                            {{ $categoriesShow->slice(0, 2)->join(', ') }}
                                        </span>
                                        @php
                                            if ($article->status == 'published') {
                                                $statusTitle = 'Publicado em: ' . date('d/m/Y H:i:s', strtotime($article->published_at));
                                            } elseif ($article->status == 'scheduled') {
                                                $statusTitle = 'Agendado para: ' . date('d/m/Y H:i:s', strtotime($article->scheduled_to));
                                            } else {
                                                $statusTitle = 'Criado em: ' . date('d/m/Y H:i:s', strtotime($article->created_at));
                                            }
                                            
                                        @endphp
                                        <span
                                            class="badge badge-{{ $article->status == 'published' ? 'success' : ($article->status == 'scheduled' ? 'info' : 'light') }}"
                                            data-toggle="tooltip" title="{{ $statusTitle }}">
                                            {{ icon_elem('calendarFill') }}
                                            @if ($article->status == 'published')
                                                {{ date('d/m/Y', strtotime($article->published_at)) }}
                                            @elseif($article->status == 'scheduled')
                                                {{ date('d/m/Y', strtotime($article->scheduled_to)) }}
                                            @else
                                                {{ date('d/m/Y', strtotime($article->created_at)) }}
                                            @endif
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle text-right">
                            <div class="d-flex flex-row">
                                <a class="btn btn-primary {{ icon_class('pencilSquare') }} mb-xl-0"
                                    href="{{ route('admin.blog.articles.edit', ['article' => $article->id]) }}"></a>
                                <span class="mx-1"></span>
                                @include('includes.button-confirmation', [
                                    'button' => t_button_confirmation_data(
                                        'danger',
                                        'btn btn-outline-danger',
                                        'Você está excluindo este artigo permanentemente e isso não pode ser desfeito.',
                                        route('admin.blog.articles.destroy', [
                                            'article' => $article->id,
                                        ]),
                                        null,
                                        icon_class('trash')
                                    ),
                                ])
                            </div>
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
