<div id="jsImageToolsModal" class="modal fade modal-image-tools">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                @php
                    $images = [];
                    $images = \App\Models\Media\Image::whereNotNull('id')->orderBy("created_at", "DESC")->paginate(12);
                @endphp

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
                                <form method="POST" class="jsFormSubmit" action="#">
                                    @csrf
                                    <div class="form-row justify-content-center">
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

                        <div class="row justify-content image-list">
                            <div class="model d-none">
                                @include('admin.medias.includes.image-list-item', ['image' => null])
                            </div>
                            @foreach ($images as $image)
                                @include('admin.medias.includes.image-list-item', ['image' => $image])
                            @endforeach
                            <div class="col-12 image-pagination">
                                {{ $images->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
