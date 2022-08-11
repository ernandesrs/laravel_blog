<div id="jsImageToolsModal" class="modal fade modal-image-tools">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">

                <div class="row">
                    <div class="col-12 col-md-5 col-lg-4 order-md-12">
                        <h5 class="mb-0">Novo upload</h5>
                        <hr>
                        @include('admin.medias.includes.image-form-fields', [
                            'params' => [
                                'redirect' => false,
                            ],
                        ])
                    </div>

                    <div class="col-12 col-md-7 col-lg-8 order-md-1">
                        <h5 class="mb-0">Imagem existente</h5>
                        <hr>
                        <div class="form-row">
                            <div class="col-12">
                                <form method="POST" class="jsImageToolsModalSearchFormSubmit" action="{{ route('admin.images.get') }}">
                                    @csrf
                                    <div class="form-row justify-content-center">
                                        <input type="hidden" name="filter" value="1">
                                        <div class="col-12">
                                            <div class="form-group d-flex">
                                                <label for="search" class="sr-only">Buscar</label>
                                                <input class="form-control text-center" type="search" name="search"
                                                    id="search">
                                                <button
                                                    class="btn btn-primary {{ icon_class('search') }} ml-2">Buscar</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-12">
                                @include('includes.message')
                            </div>
                        </div>

                        <div class="row images-list" data-action="{{ route('admin.images.get') }}">
                            <div class="model d-none">
                                @include('admin.medias.includes.image-list-item', ['image' => null])
                            </div>
                            <div class="col-12">
                                <div class="row justify-content list"></div>
                            </div>
                            <div class="col-12 images-pagination"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
