<div id="jsImageUpload" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <h2 class="h5 title"></h2>
                <hr>
                <form class="jsFormSubmit" action="" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-row">
                        <div class="col-12">
                            @include('includes.message')
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="image" name="image">
                                    <label class="custom-file-label" for="image">Escolher arquivo</label>
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
                                    data-active-icon="{{ icon_class('checkLg') }}"
                                    data-alt-icon="{{ icon_class('loading') }}">
                                    Enviar imagem
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
