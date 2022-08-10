<form class="jsFormSubmit" action="{{ route('admin.images.store', $params ?? []) }}" method="post"
    enctype="multipart/form-data">
    @csrf

    <div class="form-row">
        <div class="col-12">
            @include('includes.message')
        </div>

        <div class="col-12">
            <div class="form-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="image_file" name="image_file">
                    <label class="custom-file-label" for="image_file">Escolher arquivo</label>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="form-group">
                <label for="tags">Tags:</label>
                <input class="form-control text-center" type="text" name="tags" id="tags">
                <small id="passwordHelpBlock" class="form-text text-muted">
                    Palavras simples que remetem a esta imagem separadas por vírgulas.
                </small>
            </div>
        </div>

        <div class="col-12">
            <div class="form-group">
                <label for="name">Nome:</label>
                <input class="form-control text-center" type="text" name="name" id="name">
            </div>
        </div>

        <div class="col-12 text-center">
            <div class="form-group">
                <button class="btn btn-primary {{ icon_class('checkLg') }}"
                    data-active-icon="{{ icon_class('checkLg') }}" data-alt-icon="{{ icon_class('loading') }}">
                    Enviar imagem
                </button>
            </div>
        </div>
    </div>
</form>
