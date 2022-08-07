@extends('layouts.admin', [
    'mainBar' => [
        'title' => $pageTitle,
        'buttons' => [t_button_data('btn btn-success', 'Nova categoria', route('admin.blog.categories.store'), icon_class('plusLg'), null, 'jsBtnNewCategory')],
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
                            <div class="d-flex flex-column">
                                <span class="font-weight-bold">
                                    {{ $category->title }}
                                </span>
                                <p class="text-muted mb-0">
                                    <small>
                                        {{ $category->description }}
                                    </small>
                                </p>
                            </div>
                        </td>
                        <td class="align-middle text-right">
                            @include('includes.button', [
                                'button' => t_button_data(
                                    'btn btn-primary',
                                    '',
                                    route('admin.blog.categories.edit', ['category' => $category->id]),
                                    icon_class('pencilSquare'),
                                    null,
                                    'jsBtnEditCategory'
                                ),
                            ])
                            @include('includes.button-confirmation', [
                                'button' => t_button_confirmation_data(
                                    'danger',
                                    'btn btn-outline-danger',
                                    'Você está excluindo uma categoria permanentemente e isso não pode ser desfeito.',
                                    route('admin.blog.categories.destroy', ['category' => $category->id]),
                                    null,
                                    icon_class('trash')
                                ),
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

        $(".jsBtnNewCategory, .jsBtnEditCategory").on("click", function() {
            let action = $(this).attr("data-action");
            let data = null;

            if ($(this).hasClass("jsBtnNewCategory")) {
                modalCreate();
                modal.find("form").attr("action", action);
            } else {
                let updateAction = "{{ route('admin.blog.categories.update', ['category' => '__id__']) }}";

                $.get(action, null,
                    function(data, textStatus, jqXHR) {
                        if (data.success) {
                            modal.find("#title").val(data.category.title ?? null);
                            modal.find("#description").val(data.category.description ?? null);

                            modal.find("form")
                                .attr("action", updateAction.replace("__id__", data.category.id));
                        } else {
                            // 
                        }
                    },
                    "json"
                );

                modalUpdate();
            }

            modal.modal('show');
        });

        modal.on("hidden.bs.modal", function(e) {
            modal.find(".modal-title").html("");
            modal.find(".message-area").html("");
            addFormErrors($(modal.find("form")), []);
        });

        function modalCreate() {
            modal.find(".modal-title").html("Nova categoria");
            modal.find(".btn").removeClass("btn-info").addClass("btn-success").text("Salvar");
        }

        function modalUpdate() {
            modal.find(".modal-title").html("Atualizar categoria");
            modal.find(".btn").removeClass("btn-success").addClass("btn-info").text("Atualizar");
        }
    </script>
@endsection

@section('modals')
    @include('includes.modal-confirmation')

    @include('admin.blog.includes.modal-category')
@endsection
