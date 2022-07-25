<div class="form-row">
    <div class="col-12 col-md-4">
        <div class="form-row">
            @if ($page ?? null)
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Capa atual:</label>
                        <img class="img-fluid img-thumbnail" src="{{ m_page_cover_thumb($page, 'normal') }}"
                            alt="{{ $page->title }}">
                    </div>
                </div>
            @endif

            <div class="col-12">
                <div class="form-group">
                    <label for="cover">Capa:</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="cover" id="cover"
                            lang="{{ config('app.locale') }}">
                        <label class="custom-file-label" for="cover">Escolher capa</label>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                <div class="form-group">
                    <label for="content_type">Tipo de conteúdo:</label>
                    <select class="form-control" name="content_type" id="content_type"
                        {{ input_value($page ?? null, 'protection') == \App\Models\Page::PROTECTION_SYSTEM ? 'disabled' : null }}>
                        @foreach (m_page_content_types() as $content_type)
                            <option value="{{ $content_type }}"
                                {{ input_value($page ?? null, 'content_type') == $content_type ? 'selected' : null }}>
                                {{ ucfirst(__('terms.page_content_types.' . $content_type)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                <div class="form-group">
                    <label for="status">Salvar como:</label>
                    <select class="form-control" name="status" id="status"
                        {{ input_value($page ?? null, 'protection') == \App\Models\Page::PROTECTION_SYSTEM ? 'disabled' : null }}>
                        @foreach (m_page_status() as $status)
                            <option value="{{ $status }}"
                                {{ input_value($page ?? null, 'status') == $status ? 'selected' : null }}>
                                {{ ucfirst(__('terms.page_status.' . $status)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div
                class="col-12 {{ $page ?? null ? ($page->status !== \App\Models\Page::STATUS_SCHEDULED ? 'd-none' : null) : 'd-none' }} jsScheduleField">
                <div class="form-group">
                    <label for="scheduled_to">Agendar para:</label>
                    @php
                        $scheduledTo = input_value($page ?? null, 'scheduled_to');
                    @endphp
                    <input class="form-control" type="date" name="scheduled_to" id="scheduled_to"
                        value="{{ $scheduledTo ? date('Y-m-d', strtotime($scheduledTo)) : null }}">
                </div>
            </div>

            {{-- view path if exists --}}
            <div
                class="col-12 {{ $page ?? null ? ($page->content_type !== \App\Models\Page::CONTENT_TYPE_VIEW ? 'd-none' : null) : 'd-none' }} jsViewPathField">
                <div class="form-group">
                    <label for="view_path">Caminho para a página customizada:</label>
                    @php
                        $content = json_decode($page->content ?? '');
                    @endphp
                    <input class="form-control" type="text" name="view_path" id="view_path"
                        value="{{ $content && ($content->view_path ?? null) ? $content->view_path : null }}"
                        {{ input_value($page ?? null, 'protection') == \App\Models\Page::PROTECTION_SYSTEM ? 'disabled' : null }}>
                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="follow" name="follow"
                            {{ input_value($page ?? null, 'follow') ? 'checked' : null }}>
                        <label class="custom-control-label" for="follow">
                            Permitir que buscadores encontre esta página
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-8">
        <div class="form-row">
            <div class="col-12 col-md-8 col-xl-10">
                <div class="form-group">
                    <label for="title">Título:</label>
                    <input class="form-control" type="text" name="title" id="title"
                        value="{{ input_value($page ?? null, 'title') }}">
                </div>
            </div>

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
                                {{ input_value($page ?? null, 'lang') == $locale ? 'selected' : null }}>
                                {{ str_replace('_', '-', strtoupper($locale)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            @if ($page ?? null)
                @php
                    $slugs = $page->slugs();
                    $slug = $slugs->slug($page->lang);
                @endphp
            @endif
            <div class="col-12 d-none">
                <div class="form-group">
                    <label for="slug">Slug:</label>
                    <input class="form-control" type="text" name="slug" id="slug"
                        value="{{ $page ?? null ? $slug : null }}">
                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <label for="description">Descrição:</label>
                    <textarea class="form-control" name="description" id="description">{{ input_value($page ?? null, 'description') }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        $("#content_type").on("change", function() {

            if ($(this).val() == "view") {
                $(".jsViewPathField").removeClass("d-none").hide().show("blind");
            } else if (!$(".jsViewPathField").hasClass("d-none")) {
                $(".jsViewPathField").hide("blind", function() {
                    $(this).addClass("d-none");
                });
            }

        });


        $("#status").on("change", function() {

            if ($(this).val() == "scheduled") {
                $(".jsScheduleField").removeClass("d-none").hide().show("blind");
            } else if (!$(".jsScheduleField").hasClass("d-none")) {
                $(".jsScheduleField").hide("blind", function() {
                    $(this).addClass("d-none");
                });
            }

        });
    </script>
@endsection
