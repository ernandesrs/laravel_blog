<div id="jsNewCategoryModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card card-body border-0">
                    <h1 class="h4 modal-title"></h1>
                    <hr>
                    <form class="jsFormSubmit" action="" method="post">
                        <div class="form-row">
                            @csrf
                            <div class="col-12">
                                @include('includes.message')
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="title">Título:</label>
                                    <input class="form-control text-center" type="text" name="title" id="title"
                                        value="">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description">Descrição:</label>
                                    <textarea class="form-control" name="description" id="description"></textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group text-center">
                                    <button class="btn btn-success {{ icon_class('checkLg') }}"
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
