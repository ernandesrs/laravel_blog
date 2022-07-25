@extends('layouts.admin', [
    'mainBar' => [
        'title' => $pageTitle,
        'buttons' => [t_button_data('Nova tag', 'success', icon_class('plusLg'), route('admin.blog.tags.store'), 'jsBtnNewTag')],
    ],
])

@section('content')
    <div class="table-responsive">
        <table class="table table-hover table-borderless">
            <tbody>
                @php
                    /** @var \App\Models\Category $tag */
                @endphp

                @foreach ($tags ?? [] as $tag)
                    <tr>
                        <td class="align-middle">
                        </td>
                        <td class="align-middle text-right">
                            @include('includes.button-confirmation', [
                                'btnAction' => route('admin.tags.destroy', ['page' => $tag->id]),
                                'btnClass' => 'btn-sm btn-outline-danger',
                                'btnIcon' => icon_class('trash'),
                                'btnType' => 'danger',
                                'btnMessage' =>
                                    'Você está excluindo <strong>"' .
                                    $tag->title .
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
                {{ $tags->onEachSide(2)->links() }}
            </div>
        @endif
    </div>
@endsection

@section('modals')
    @include('includes.modal-confirmation')
@endsection
