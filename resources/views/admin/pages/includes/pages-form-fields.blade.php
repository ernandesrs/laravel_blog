<div class="row">

    <div class="col-12 col-md-8 col-lg-9">
        <div class="form-row">
            {{-- título --}}
            <div class="col-12 col-md-8 col-xl-10">
                <div class="form-group">
                    <label for="title">Título:</label>
                    <input class="form-control" type="text" name="title" id="title"
                        value="{{ input_value($page, 'title') }}">
                </div>
            </div>

            {{-- idioma --}}
            <div class="col-12 col-md-4 col-xl-2">
                <div class="form-group">
                    <label for="lang">Idioma:</label>
                    @php
                        $locales = config('app.locales') ?? [config('app.locale')];
                    @endphp
                    <select class="form-control" name="lang" id="lang"
                        {{ count($locales) <= 1 ? 'disabled' : null }}>
                        @foreach ($locales as $locale)
                            <option value="{{ $locale }}"
                                {{ input_value($page, 'lang') == $locale ? 'selected' : null }}>
                                {{ str_replace('_', '-', strtoupper($locale)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            @if ($page)
                @php
                    $slugs = $page->slugs();
                    $slug = $slugs->slug($page->lang);
                @endphp
            @endif

            {{-- slug --}}
            <div class="col-12 d-none">
                <div class="form-group">
                    <label for="slug">Slug:</label>
                    <input class="form-control" type="text" name="slug" id="slug"
                        value="{{ $page ? $slug : null }}">
                </div>
            </div>

            {{-- descrição --}}
            <div class="col-12">
                <div class="form-group">
                    <label for="description">Descrição:</label>
                    <textarea class="form-control" name="description" id="description">{{ input_value($page, 'description') }}</textarea>
                </div>
            </div>

            {{-- tipo de conteúdo --}}
            <div class="col-12 col-sm-5 col-md-6">
                <div class="form-group">
                    <label for="content_type">Tipo de conteúdo:</label>
                    <select class="form-control" name="content_type" id="content_type"
                        {{ input_value($page, 'protection') == m_page_protection_system() ? 'disabled' : null }}>
                        @foreach (m_page_content_types() as $content_type)
                            <option value="{{ $content_type }}"
                                {{ input_value($page, 'content_type') == $content_type ? 'selected' : null }}>
                                {{ ucfirst(__('terms.page_content_types.' . $content_type)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- indexação --}}
            <div class="col-12 col-sm-7 col-md-6">
                <div class="form-group">
                    <label for="follow">Indexação:</label>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="follow" name="follow"
                            {{ input_value($page, 'follow') ? 'checked' : null }}>
                        <label class="custom-control-label" for="follow">
                            <small>
                                Permitir que buscadores encontre esta página
                            </small>
                        </label>
                    </div>
                </div>
            </div>

            {{-- content: view --}}
            <div
                class="col-12 {{ $page ? ($page->content_type != m_page_content_view() ? 'd-none' : null) : 'd-none' }} jsViewPathField">
                <div class="form-group">
                    <label for="view_path">Caminho para a página customizada:</label>
                    @php
                        $content = json_decode($page->content ?? '');
                    @endphp
                    <input class="form-control" type="text" name="view_path" id="view_path"
                        value="{{ $content && ($content->view_path ?? null) ? $content->view_path : null }}"
                        {{ input_value($page, 'protection') == m_page_protection_system() ? 'disabled' : null }}>
                </div>
            </div>

            {{-- content: text --}}
            <div
                class="col-12 {{ $page ? ($page->content_type != m_page_content_text() ? 'd-none' : null) : null }} jsTextField">
                <div class="form-group">
                    <label for="content">Conteúdo:</label>
                    <textarea id="summernoteContent" name="content">{{ input_value($article ?? null, 'content') }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4 col-lg-3">
        <div class="form-row">
            {{-- cover --}}
            <div class="col-12">
                <div class="form-group">
                    <div class="d-flex justify-content-center pb-4">
                        <div class="d-flex justify-content-center align-items-center cover-preview"
                            style="width:200px;height:125px;">
                            @if (($page ?? null) && $page->cover)
                                <img class="img-fluid img-thumbnail" src="{{ m_page_cover_thumb($page, 'normal') }}"
                                    alt="Cover preview">
                            @else
                                <p class="mb-0 text-muted text-center">
                                    Cover preview
                                </p>
                            @endif
                        </div>
                    </div>

                    <label for="cover">Capa:</label>
                    <div class="custom-file">
                        <input type="hidden" class="custom-file-input" id="cover" name="cover">
                        @include('includes.button', [
                            'button' => t_button_data(
                                'btn btn-primary btn-block',
                                'Inserir capa',
                                null,
                                icon_class('image'),
                                null,
                                'jsButtonInsertCover'
                            ),
                        ])
                    </div>
                </div>
            </div>

            {{-- status/save mode --}}
            <div class="col-12">
                <div class="form-group">
                    <label for="status">Salvar como:</label>
                    <select class="form-control" name="status" id="status"
                        {{ input_value($page, 'protection') == m_page_protection_system() ? 'disabled' : null }}>
                        @foreach (m_page_status() as $status)
                            <option value="{{ $status }}"
                                {{ input_value($page, 'status') == $status ? 'selected' : null }}>
                                {{ ucfirst(__('terms.page_status.' . $status)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- agendar para --}}
            <div
                class="col-12 {{ $page ? ($page->status != m_page_status_scheduled() ? 'd-none' : null) : 'd-none' }}">
                <div class="form-group">
                    <label for="scheduled_to">Agendar para:</label>
                    @php
                        $scheduledTo = input_value($page, 'scheduled_to');
                    @endphp
                    <input class="form-control" type="date" name="scheduled_to" id="scheduled_to"
                        value="{{ $scheduledTo ? date('Y-m-d', strtotime($scheduledTo)) : null }}">
                </div>
            </div>

            {{-- button submit --}}
            <div class="col-12 text-center">
                <button class="btn btn-primary {{ icon_class('checkLg') }}"
                    data-active-icon="{{ icon_class('checkLg') }}" data-alt-icon="{{ icon_class('loading') }}"
                    type="submit">
                    @if ($page)
                        Atualizar
                    @else
                        Cadastrar
                    @endif
                </button>
            </div>
        </div>
    </div>

</div>
