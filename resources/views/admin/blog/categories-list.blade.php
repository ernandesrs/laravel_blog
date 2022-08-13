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
        let categoryModal = $("#jsNewCategoryModal");

        /*
         * Abre modal no modo cadastro ou edição
         */
        $(".jsBtnNewCategory, .jsBtnEditCategory").on("click", function() {
            let action = $(this).attr("data-action");
            let data = null;

            if ($(this).hasClass("jsBtnNewCategory")) {
                modalCreate();
                categoryModal.find("form").attr("action", action);
                categoryModal.find(".cover-preview").html(
                    `<p class="mb-0 text-muted text-center">Cover preview</p>`);
            } else {
                let updateAction = "{{ route('admin.blog.categories.update', ['category' => '__id__']) }}";

                $.get(action, null,
                    function(data, textStatus, jqXHR) {
                        if (data.success) {
                            categoryModal.find("#title").val(data.category.title ?? null);
                            categoryModal.find("#description").val(data.category.description ?? null);
                            if (data.category.thumb)
                                categoryModal.find(".cover-preview").html(
                                    `<img class="img-fluid img-thumbnail" src="${data.category.thumb}" alt="Cover preview">`
                                );
                            else
                                categoryModal.find(".cover-preview").html(
                                    `<p class="mb-0 text-muted text-center">Cover preview</p>`);

                            categoryModal.find("form")
                                .attr("action", updateAction.replace("__id__", data.category.id));
                        } else {
                            // 
                        }
                    },
                    "json"
                );

                modalUpdate();
            }

            categoryModal.modal('show');
        });

        /*
         * ABRE MODAL DE IMAGENS E MONITORA INSERÇÃO DE IMAGEMS
         */
        $("#jsButtonInsertCover").on("click", function(e) {
            e.preventDefault();
            let imageToolsModal = $("#jsImageToolsModal")

            imageToolsModal.modal();

            imageToolsModal.on("click", ".jsInsertImage", function(e) {
                e.preventDefault();
                let imageData = $(this).parent();

                let image = $(`<img class="img-fluid img-thumbnail" src="" alt="Cover preview">`).attr(
                    "src", imageData.find("#image-thumb").val());

                $(".cover-preview").html(image)
                categoryModal.find("#cover").val(imageData.find("#image-id").val());

                imageToolsModal.modal("hide");
            });
        });

        categoryModal.on("hidden.bs.modal", function(e) {
            console.log("KKKK");
            categoryModal.find(".modal-title").html("");
            categoryModal.find(".message-area").html("");
            categoryModal.find(".title").html("");
            categoryModal.find(".description").html("");
            addFormErrors($(categoryModal.find("form")), []);
        });

        function modalCreate() {
            categoryModal.find(".modal-title").html("Nova categoria");
            categoryModal.find("button[type=submit]").removeClass("btn-info").addClass("btn-success").text("Salvar");
        }

        function modalUpdate() {
            categoryModal.find(".modal-title").html("Atualizar categoria");
            categoryModal.find("button[type=submit]").removeClass("btn-success").addClass("btn-info").text("Atualizar");
        }
    </script>
@endsection

@section('modals')
    @include('includes.modal-confirmation')
    @include('admin.blog.includes.modal-category')
    @include('admin.medias.includes.modal-image-tools')
@endsection
