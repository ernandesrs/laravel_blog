<div id="jsImageEditModal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <h2 class="h5 title">Editar dados da imagem</h2>
                <hr>
                <form class="jsFormSubmit" action="" method="post">
                    @csrf
                    <div class="form-row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name">Nome:</label>
                                <input class="form-control text-center" type="text" name="name" id="name">
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

                        <div class="col-12 text-center">
                            <div class="form-group">
                                <button class="btn btn-primary {{ icon_class('checkLg') }}"
                                    data-active-icon="{{ icon_class('checkLg') }}"
                                    data-alt-icon="{{ icon_class('loading') }}">
                                    Atualizar imagem
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
