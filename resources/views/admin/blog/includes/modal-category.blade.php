<div id="jsNewCategoryModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card card-body border-0">
                    <h1 class="h4 modal-title"></h1>
                    <hr>
                    <form class="jsFormSubmit" action="" method="post">
                        <div class="row">
                            @csrf
                            <div class="col-12">
                                @include('includes.message')
                            </div>

                            <div class="col-7">
                                <div class="form-row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="title">Título:</label>
                                            <input class="form-control text-center" type="text" name="title"
                                                id="title" value="">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="description">Descrição:</label>
                                            <textarea class="form-control" name="description" id="description"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-5">
                                <div class="form-row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="d-flex justify-content-center pb-4">
                                                <div class="d-flex justify-content-center align-items-center cover-preview"
                                                    style="width:200px;height:100px;">
                                                </div>
                                            </div>

                                            <label for="cover">Capa:</label>
                                            <div class="custom-file">
                                                <input type="hidden" class="custom-file-input" id="cover"
                                                    name="cover">
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
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group text-center">
                                    <button class="btn btn-success {{ icon_class('checkLg') }}" type="submit"
                                        data-active-icon="{{ icon_class('checkLg') }}"
                                        data-alt-icon="{{ icon_class('loading') }}">
                                        Atualizar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
