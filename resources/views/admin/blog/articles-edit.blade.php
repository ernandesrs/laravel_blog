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

    <script>
        /*
         * TRADUÇÃO PT-BR PARA O SUMMERNOTE
         */
        (function($) {
            $.extend(true, $.summernote.lang, {
                'pt-BR': {
                    font: {
                        bold: 'Negrito',
                        italic: 'Itálico',
                        underline: 'Sublinhado',
                        clear: 'Remover estilo da fonte',
                        height: 'Altura da linha',
                        name: 'Fonte',
                        strikethrough: 'Riscado',
                        subscript: 'Subscrito',
                        superscript: 'Sobrescrito',
                        size: 'Tamanho da fonte',
                    },
                    image: {
                        image: 'Imagem',
                        insert: 'Inserir imagem',
                        resizeFull: 'Redimensionar Completamente',
                        resizeHalf: 'Redimensionar pela Metade',
                        resizeQuarter: 'Redimensionar a um Quarto',
                        floatLeft: 'Flutuar para Esquerda',
                        floatRight: 'Flutuar para Direita',
                        floatNone: 'Não Flutuar',
                        shapeRounded: 'Forma: Arredondado',
                        shapeCircle: 'Forma: Círculo',
                        shapeThumbnail: 'Forma: Miniatura',
                        shapeNone: 'Forma: Nenhum',
                        dragImageHere: 'Arraste Imagem ou Texto para cá',
                        dropImage: 'Solte Imagem ou Texto',
                        selectFromFiles: 'Selecione a partir dos arquivos',
                        maximumFileSize: 'Tamanho máximo do arquivo',
                        maximumFileSizeError: 'Tamanho máximo do arquivo excedido.',
                        url: 'URL da imagem',
                        remove: 'Remover Imagem',
                        original: 'Original',
                    },
                    video: {
                        video: 'Vídeo',
                        videoLink: 'Link para vídeo',
                        insert: 'Inserir vídeo',
                        url: 'URL do vídeo?',
                        providers: '(YouTube, Google Drive, Vimeo, Vine, Instagram, DailyMotion or Youku)',
                    },
                    link: {
                        link: 'Link',
                        insert: 'Inserir link',
                        unlink: 'Remover link',
                        edit: 'Editar',
                        textToDisplay: 'Texto para exibir',
                        url: 'Para qual URL este link leva?',
                        openInNewWindow: 'Abrir em uma nova janela',
                    },
                    table: {
                        table: 'Tabela',
                        addRowAbove: 'Adicionar linha acima',
                        addRowBelow: 'Adicionar linha abaixo',
                        addColLeft: 'Adicionar coluna à esquerda',
                        addColRight: 'Adicionar coluna à direita',
                        delRow: 'Excluir linha',
                        delCol: 'Excluir coluna',
                        delTable: 'Excluir tabela',
                    },
                    hr: {
                        insert: 'Linha horizontal',
                    },
                    style: {
                        style: 'Estilo',
                        p: 'Normal',
                        blockquote: 'Citação',
                        pre: 'Código',
                        h1: 'Título 1',
                        h2: 'Título 2',
                        h3: 'Título 3',
                        h4: 'Título 4',
                        h5: 'Título 5',
                        h6: 'Título 6',
                    },
                    lists: {
                        unordered: 'Lista com marcadores',
                        ordered: 'Lista numerada',
                    },
                    options: {
                        help: 'Ajuda',
                        fullscreen: 'Tela cheia',
                        codeview: 'Ver código-fonte',
                    },
                    paragraph: {
                        paragraph: 'Parágrafo',
                        outdent: 'Menor tabulação',
                        indent: 'Maior tabulação',
                        left: 'Alinhar à esquerda',
                        center: 'Alinhar ao centro',
                        right: 'Alinha à direita',
                        justify: 'Justificado',
                    },
                    color: {
                        recent: 'Cor recente',
                        more: 'Mais cores',
                        background: 'Fundo',
                        foreground: 'Fonte',
                        transparent: 'Transparente',
                        setTransparent: 'Fundo transparente',
                        reset: 'Restaurar',
                        resetToDefault: 'Restaurar padrão',
                        cpSelect: 'Selecionar',
                    },
                    shortcut: {
                        shortcuts: 'Atalhos do teclado',
                        close: 'Fechar',
                        textFormatting: 'Formatação de texto',
                        action: 'Ação',
                        paragraphFormatting: 'Formatação de parágrafo',
                        documentStyle: 'Estilo de documento',
                        extraKeys: 'Extra keys',
                    },
                    help: {
                        'insertParagraph': 'Inserir Parágrafo',
                        'undo': 'Desfazer o último comando',
                        'redo': 'Refazer o último comando',
                        'tab': 'Tab',
                        'untab': 'Desfazer tab',
                        'bold': 'Colocar em negrito',
                        'italic': 'Colocar em itálico',
                        'underline': 'Sublinhado',
                        'strikethrough': 'Tachado',
                        'removeFormat': 'Remover estilo',
                        'justifyLeft': 'Alinhar à esquerda',
                        'justifyCenter': 'Centralizar',
                        'justifyRight': 'Alinhar à esquerda',
                        'justifyFull': 'Justificar',
                        'insertUnorderedList': 'Lista não ordenada',
                        'insertOrderedList': 'Lista ordenada',
                        'outdent': 'Recuar parágrafo atual',
                        'indent': 'Avançar parágrafo atual',
                        'formatPara': 'Alterar formato do bloco para parágrafo(tag P)',
                        'formatH1': 'Alterar formato do bloco para H1',
                        'formatH2': 'Alterar formato do bloco para H2',
                        'formatH3': 'Alterar formato do bloco para H3',
                        'formatH4': 'Alterar formato do bloco para H4',
                        'formatH5': 'Alterar formato do bloco para H5',
                        'formatH6': 'Alterar formato do bloco para H6',
                        'insertHorizontalRule': 'Inserir Régua horizontal',
                        'linkDialog.show': 'Inserir um Hiperlink',
                    },
                    history: {
                        undo: 'Desfazer',
                        redo: 'Refazer',
                    },
                    specialChar: {
                        specialChar: 'CARACTERES ESPECIAIS',
                        select: 'Selecionar Caracteres Especiais',
                    },
                },
            });
        })(jQuery);

        /*
         * INICIALIZANDO O SUMMERNOTE
         */
        $(document).ready(function() {
            $("#summernoteContent").summernote({
                placeholder: 'Escreva seu artigo',
                tabsize: 2,
                minHeight: 275,
                maxHeight: 575,
                lang: 'pt-BR',

                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'InsertImageCustomButton', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],

                buttons: {
                    InsertImageCustomButton: InsertImageCustomButton
                },

                styleTags: [
                    'p',
                    {
                        title: 'Blockquote',
                        tag: 'blockquote',
                        className: 'blockquote',
                        value: 'blockquote'
                    },
                    'pre', 'h2', 'h3', 'h4', 'h5', 'h6'
                ],
            });
        });

        /*
         * CRIANDO UM BOTÃO DE INSERIR IMAGEM PARA A BARRA DE FERRAMENTAS DO SUMMERNOTE
         */
        var InsertImageCustomButton = function(context) {
            var ui = $.summernote.ui;

            // create button
            var button = ui.button({
                contents: '<i class="note-icon-picture"/>',
                tooltip: 'Escolher da lista de imagens',

                click: function() {
                    let modal = $("#jsImageToolsModal");
                    let cursorPosition = $('#summernoteContent').summernote('editor.getLastRange');
                    let image = document.createElement("p");

                    $(document).on("click", ".jsInsertImage", function(e) {
                        e.preventDefault();
                        let insertButton = $(this);

                        image.style.cssText =
                            'text-align: center';
                        image.innerHTML =
                            `<img class="img-fluid px-3" src="${insertButton.parent().find("#image-url").val()}" alt="${insertButton.parent().find("#image-name").val()}">`;

                        cursorPosition.insertNode(image);

                        modal.modal("hide");
                    });

                    modal.modal();
                }
            });

            return button.render(); // return button as jquery object
        }

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
