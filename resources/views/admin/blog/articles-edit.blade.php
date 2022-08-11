@php

$buttons = [t_button_link_data('btn btn-primary', 'Voltar', route('admin.blog.articles.index'), icon_class('arrowLeft'), null, null)];
$formAction = route('admin.blog.articles.store');

if ($article ?? null) {
    $buttons = array_merge($buttons, [t_button_link_data('btn btn-outline-success', 'Novo artigo', route('admin.blog.articles.create'), icon_class('plusLg'), null, null)]);
    $formAction = route('admin.blog.articles.update', ['article' => $article->id]);
}
@endphp

@extends('layouts.admin', [
    'mainBar' => [
        'title' => $pageTitle,
        'buttons' => $buttons,
    ],
])

@section('content')
    <form class="jsFormSubmit" action="{{ $formAction }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            @include('admin.blog.includes.articles-form-fields')
        </div>
    </form>
@endsection

@section('modals')
    @include('admin.medias.includes.modal-image-tools')
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script src="{{ asset('assets/js/admin/my.summernote.script.js') }}"></script>

    <script>
        /*
         * INICIALIZANDO O SELECTPICKER
         */
        $('.select').selectpicker();

        /*
         * OBTENDO/REMOVENDO OPÇÕES SELECIONADAS COM O SELECTPICKER
         */
        $('.selectpicker').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
            let categories = [];
            let value = $(this).find("option").eq(clickedIndex).val();

            if (categoriesStr = $("input[name=categories]").val()) {
                categories = categoriesStr.split(",");
            }

            if (isSelected) {
                // adicionar o valor no array categories
                categories.push(value);
            } else {
                // encontra e remove o valor no array categories
                let index = categories.indexOf(value);

                if (index > -1) {
                    categories.splice(index, 1);
                }
            }

            $("input[name=categories]").val(categories.join(","));
        });

        /*
         * MOSTRA/OCULTA CAMPO DE DATA 
         */
        $("#status").on("change", function() {
            let select = $(this);
            let option = select.val();

            if (option == "scheduled") {
                $("#scheduled_to").parent().parent().removeClass("d-none").hide().show("blind", function() {
                    select.parents().eq(3).find("button[type=submit]").text("Agendar artigo");
                });
            } else {
                $("#scheduled_to").parent().parent().hide("blind", function() {
                    $(this).addClass("d-none");
                    select.parents().eq(3).find("button[type=submit]").text("Salvar artigo");
                });
            }
        });

        /*
         * ABRE MODAL DE IMAGENS E MONITORA INSERÇÃO DE IMAGEMS
         */
        $("#jsButtonInsertCover").on("click", function(e) {
            e.preventDefault();

            $("#jsImageToolsModal").modal();

            $(document).on("click", ".jsInsertImage", function(e) {
                e.preventDefault();
                let modal = $("#jsImageToolsModal");
                let imageData = $(this).parent();

                let image = $(`<img class="img-fluid img-thumbnail" src="" alt="Cover preview">`).attr(
                    "src", imageData.find("#image-thumb").val());

                $(".cover-preview").html(image)
                $("#cover").val(imageData.find("#image-id").val());

                modal.modal("hide");
            });
        });
    </script>
@endsection
