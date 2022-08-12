@php
$keys = array_fill_keys(m_user_levels(), null);
foreach ($keys as $key => $value) {
    $keys[$key] = ucfirst(__('terms.user_level.' . $key));
}
@endphp

@extends('layouts.admin', [
    'mainBar' => [
        'title' => $pageTitle,
        'filterFormAction' => route('admin.pages.index'),
        'filterFormFields' => [
            [
                'name' => 'status',
                'label' => 'Status',
                'type' => 'select',
                'options' => [
                    'published' => 'Publicado',
                    'draft' => 'Rascunho',
                    'scheduled' => 'Agendado',
                ],
            ],
        ],
        'buttons' => [t_button_link_data('btn btn-outline-success', 'Nova página', route('admin.pages.create'), icon_class('plusLg'))],
    ],
])

@section('content')
    <div class="table-responsive">
        <table class="table table-hover table-borderless">
            <tbody>
                @php
                    /** @var \App\Models\Page $page */
                @endphp
                @foreach ($pages as $page)
                    @php
                        /** @var \App\Models\User $author */
                        $author = $page->author();
                        
                        /** @var \App\Models\Slug $slugs */
                        $slugs = $page->slugs()->first();
                        
                        $slug = $slugs->slug($page->lang);
                    @endphp
                    <tr>
                        <td class="align-middle">
                            <div class="d-flex align-items-center">
                                <img class="img-fluid img-thumbnail mr-2" src="{{ m_page_cover_thumb($page, 'small') }}"
                                    alt="{{ $page->name }}" style="width: 125px; height: 75px;">
                                <div class="d-flex flex-column">
                                    <span>
                                        @if ($slug == 'inicio')
                                            <a href="{{ route('front.home') }}" target="_blank">
                                                {{ $page->title }}
                                            </a>
                                        @else
                                            <a href="{{ route('front.dinamicPage', ['slug' => $slug]) }}" target="_blank">
                                                {{ $page->title }}
                                            </a>
                                        @endif
                                    </span>
                                    <span class="pb-1">
                                        <small>
                                            {{ substr($page->description, 0, 125) }}...
                                        </small>
                                    </span>
                                    <div class="d-flex flex-wrap">
                                        <span class="badge badge-dark-light">
                                            {{ icon_elem('user') }}
                                            {{ $author ? substr($author->name, 0, 12) : null }}
                                            {{ strlen($author->name) > 12 ? '...' : null }}
                                        </span>
                                        <span class="mx-1"></span>
                                        <span class="badge badge-light-dark" data-toggle="tooltip" data-placement="top"
                                            title="{{ ucfirst(__('terms.page_status.' . $page->status)) }}">
                                            @if ($page->scheduled_to)
                                                {{ icon_elem('calendarEvent') }}
                                                {{ date('d/m/Y H:i:s', strtotime($page->scheduled_to)) }}
                                            @elseif($page->published_at)
                                                {{ icon_elem('calendarCheck') }}
                                                {{ date('d/m/Y H:i:s', strtotime($page->published_at)) }}
                                            @else
                                                {{ icon_elem('calendarX') }}
                                                {{ date('d/m/Y H:i:s', strtotime($page->created_at)) }}
                                            @endif
                                        </span>
                                        <span class="mx-1"></span>
                                        <span class="badge badge-light">
                                            {{ $page->content_type == m_page_content_view() ? 'Página customizada' : 'Texto' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle text-right">
                            <a class="btn btn-info {{ icon_class('pencilSquare') }}"
                                href="{{ route('admin.pages.edit', ['page' => $page->id]) }}"></a>

                            @include('includes.button-confirmation', [
                                'button' => t_button_confirmation_data(
                                    'danger',
                                    'btn btn-outline-danger',
                                    'Você está excluindo uma página permanentemente e isso não pode ser desfeito.',
                                    route('admin.pages.destroy', ['page' => $page->id]),
                                    null,
                                    icon_class('trash')
                                ),
                            ])
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-end align-items-center py-2">
            {{ $pages->onEachSide(2)->links() }}
        </div>
    </div>
@endsection

@section('modals')
    @include('includes.modal-confirmation')
@endsection
