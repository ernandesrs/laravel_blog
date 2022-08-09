{{-- left side --}}
<div class="col-12 col-md-8 col-lg-9 mb-3 mb-md-0">
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
                <textarea id="summernoteContent" name="content">{{ input_value($article ?? null, 'content') }}</textarea>
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
                    <div class="d-flex justify-content-center align-items-center cover-preview"
                        style="width:200px;height:125px;">
                        @if (($article ?? null) && $article->cover)
                            <img class="img-fluid img-thumbnail" src="{{ m_article_cover_thumb($article, 'normal') }}"
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

        @php
            $categories = \App\Models\Category::all();
            
            if ($article ?? null) {
                $articleCategories = $article->categoriesId();
            }
        @endphp
        <div class="col-12">
            <div class="form-group">
                <input type="hidden" name="categories"
                    value="{{ $article ?? null ? $articleCategories->join(',') : null }}">
                <label for="categories_list">Categorias:</label>
                <select class="form-control selectpicker" name="categories_list" id="categories_list" multiple
                    title="Escolha categorias" data-live-search="true">
                    @if ($categories->count())
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $article ?? null ? ($articleCategories->contains($category->id) ? 'selected' : null) : null }}>
                                {{ $category->title }}</option>
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

        <div
            class="col-12 {{ $article ?? null ? ($article->status == \App\Models\Article::STATUS_SCHEDULED ? '' : 'd-none') : 'd-none' }}">
            <div class="form-group">
                <label for="scheduled_to">Agendar para:</label>
                <input class="form-control" type="date" name="scheduled_to" id="scheduled_to"
                    value="{{ $article ?? null ? date('Y-m-d', strtotime(input_value($article, 'scheduled_to'))) : null }}">
            </div>
        </div>

        <div class="col-12">
            <div class="form-group text-center">
                <button class="btn btn-primary {{ icon_class('checkLg') }}"
                    data-active-icon="{{ icon_class('checkLg') }}" data-alt-icon="{{ icon_class('loading') }}"
                    type="submit">
                    @if ($article ?? null)
                        @if ($article->status == \App\Models\Article::STATUS_SCHEDULED)
                            Atualizar artigo
                        @else
                            Salvar artigo
                        @endif
                    @else
                        Salvar artigo
                    @endif
                </button>
            </div>
        </div>
    </div>
</div>
