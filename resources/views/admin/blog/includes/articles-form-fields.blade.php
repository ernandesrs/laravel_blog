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
    </div>
</div>

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
                <label for="categories">Categorias:</label>
                <select class="form-control" name="categories" id="categories" multiple>
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
    </div>
</div>

@section('scripts')
    <script>
        $("#status").on("change", function() {
            let option = $(this).val();

            if (option == "scheduled") {
                $("#schedule_to").parent().parent().removeClass("d-none").hide().show("blind");
            } else {
                $("#schedule_to").parent().parent().hide("blind", function() {
                    $(this).addClass("d-none");
                });
            }
        });
    </script>
@endsection
