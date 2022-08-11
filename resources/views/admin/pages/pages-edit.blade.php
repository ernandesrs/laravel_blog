@php
$page = $page ?? null;
$formAction = $page ? route('admin.pages.update', ['page' => $page->id]) : route('admin.pages.store');

$buttons[] = t_button_link_data('btn btn-primary', 'Voltar', route('admin.pages.index'), icon_class('arrowLeft'), null, $id = null);
if ($page) {
    $buttons[] = t_button_link_data('btn btn-outline-success', 'Nova página', route('admin.pages.create'), icon_class('plusLg'), null, $id = null);
}
@endphp

@extends('layouts.admin', [
    'mainBar' => [
        'title' => $pageTitle,

        'buttons' => $buttons,
    ],
])

@section('content')
    <div class="row justify-content-center py-4 section-page-edit">
        <div class="col-12">
            <div class="card card-body">
                <form class="jsFormSubmit" action="{{ $formAction }}" method="post" enctype="multipart/form-data">
                    @csrf

                    @include('admin.pages.includes.pages-form-fields')

                </form>
            </div>

        </div>
    </div>
@endsection

@section('modals')
    @include('admin.medias.includes.modal-image-tools')
@endsection

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script src="{{ asset('assets/js/admin/my.summernote.script.js') }}"></script>

    <script>
        /*
         * ALTERNA CAMPO DE CONTEÚDO DE ACORDO COM O TIPO DE CONTEÚDO ESCOLHIDO
         */
        $("#content_type").on("change", function() {
            if ($(this).val() == "view") {
                $(".jsViewPathField").removeClass("d-none").hide().show("blind");
                $(".jsTextField").hide("blind", function() {
                    $(this).addClass("d-none");
                });
            } else if (!$(".jsViewPathField").hasClass("d-none")) {
                $(".jsTextField").removeClass("d-none").hide().show("blind");
                $(".jsViewPathField").hide("blind", function() {
                    $(this).addClass("d-none");
                });
            }
        });

        /*
         * MOSTRA/OCULTA CAMPO DE DATA 
         */
        $("#status").on("change", function() {
            let select = $(this);
            let option = select.val();

            if (option == "scheduled") {
                $("#scheduled_to").parent().parent().removeClass("d-none").hide().show("blind", function() {
                    select.parents().eq(5).find("button[type=submit]").text("Agendar página");
                });
            } else {
                $("#scheduled_to").parent().parent().hide("blind", function() {
                    $(this).addClass("d-none");
                    select.parents().eq(5).find("button[type=submit]").text("Salvar página");
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
