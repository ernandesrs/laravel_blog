{{-- left side --}}
<div class="col-12 col-md-8 col-lg-9">
    <div class="form-row">
        <div class="col-12">
            <div class="form-group">
                <label for="title">Título:</label>
                <input class="form-control" type="text" name="title" id="title"
                    value="{{ input_value($article ?? null, 'title') }}">
            </div>
        </div>

        <div class="col-12">
            <div class="form-group">
                <label for="description">Descrição:</label>
                <textarea class="form-control" name="description" id="description">{{ input_value($article ?? null, 'description') }}</textarea>
            </div>
        </div>

        <div class="col-12">
            <div class="form-group">
                <label for="content">Conteúdo:</label>
                <textarea id="summernoteContent" name="content"></textarea>
            </div>
        </div>
    </div>
</div>

{{-- right side --}}
<div class="col-12 col-md-4 col-lg-3">
    <div class="form-row">
        <div class="col-12">
            <div class="form-group">
                <div class="d-flex justify-content-center pb-4">
                    <div class="d-flex justify-content-center align-items-center border cover-preview"
                        style="width:250px;height:125px;">
                        @if (($article ?? null) && $article->cover)
                            <img src="" alt="{{ input_value($article ?? null, 'title') }} Cover">
                        @else
                            <p class="mb-0 text-muted text-center">
                                Cover preview
                            </p>
                        @endif
                    </div>
                </div>

                <label for="cover">Capa:</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="cover" name="cover">
                    <label class="custom-file-label" for="cover">Escolher arquivo</label>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="form-group">
                <input type="hidden" name="categories" value="">
                <label for="categories_list">Categorias:</label>
                <select class="form-control selectpicker" name="categories_list" id="categories_list" multiple
                    title="Escolha categorias" data-live-search="true" data-actions-box="true">
                    @if ($categories->count())
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    @else
                        <option value="none">Sem categorias cadastradas</option>
                    @endif
                </select>
            </div>
        </div>

        <div class="col-12">
            <div class="form-group">
                <label for="status">Salvar como:</label>
                <select class="form-control" name="status" id="status">
                    @foreach (\App\Models\Article::STATUS as $status)
                        <option value="{{ $status }}"
                            {{ input_value($article ?? null, 'status') == $status ? 'selected' : null }}>
                            {{ ucfirst(__('terms.page_status.' . $status)) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-12 d-none">
            <div class="form-group">
                <label for="schedule_to">Agendar para:</label>
                <input class="form-control" type="date" name="schedule_to" id="schedule_to"
                    value="{{ $article ?? null ? date('d/m/Y', strtotime(input_value($article, 'scheduled_to'))) : null }}">
            </div>
        </div>

        <div class="col-12">
            <div class="form-group text-center">
                <button class="btn btn-primary {{ icon_class('checkLg') }}"
                    data-active-icon="{{ icon_class('checkLg') }}" data-alt-icon="{{ icon_class('loading') }}"
                    type="submit">
                    Salvar artigo
                </button>
            </div>
        </div>
    </div>
</div>

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

    <script>
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

        $(document).ready(function() {
            $("#summernoteContent").summernote({
                placeholder: 'Escreva seu artigo',
                tabsize: 2,
                minHeight: 275,
                maxHeight: 575,
                lang: 'pt-BR',

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

        $('.select').selectpicker();
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

        $("#status").on("change", function() {
            let select = $(this);
            let option = select.val();

            if (option == "scheduled") {
                $("#schedule_to").parent().parent().removeClass("d-none").hide().show("blind", function() {
                    select.parents().eq(3).find("button[type=submit]").text("Agendar artigo");
                });
            } else {
                $("#schedule_to").parent().parent().hide("blind", function() {
                    $(this).addClass("d-none");
                    select.parents().eq(3).find("button[type=submit]").text("Salvar artigo");
                });
            }
        });
    </script>
@endsection
