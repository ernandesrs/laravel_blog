@extends('layouts.admin', [
    'mainBar' => [
        'title' => $pageTitle,
        'buttons' => [t_button_data('Nova categoria', 'success', icon_class('plusLg'), route('admin.blog.categories.store'), null, 'jsBtnNewCategory')],
    ],
])

@section('content')
    <div class="table-responsive">
        <table class="table table-hover table-borderless">
            <tbody>
                @php
                    /** @var \App\Models\Category $category */
                @endphp
                @foreach ($categories ?? [] as $category)
                    <tr>
                        <td class="align-middle">
                        </td>
                        <td class="align-middle text-right">
                            @include('includes.button-confirmation', [
                                'btnAction' => route('admin.categories.destroy', ['page' => $category->id]),
                                'btnClass' => 'btn-sm btn-outline-danger',
                                'btnIcon' => icon_class('trash'),
                                'btnType' => 'danger',
                                'btnMessage' =>
                                    'Você está excluindo <strong>"' .
                                    $category->title .
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
                {{ $categories->onEachSide(2)->links() }}
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        let modal = $("#jsNewCategoryModal");

        $(".jsBtnNewCategory").on("click", function() {
            let action = $(this).attr("data-action");

            modalCreate();
            modal.find("form").attr("action", action);

            modal.modal('show');
        });

        function modalCreate() {
            modal.find(".btn").removeClass("btn-info").addClass("btn-success").text("Salvar");
        }

        function modalUpdate() {
            modal.find(".btn").removeClass("btn-success").addClass("btn-info").text("Atualizar");
        }
    </script>
@endsection

@section('modals')
    @include('includes.modal-confirmation')

    @include('admin.blog.includes.modal-category')
@endsection
