<div class="col-6 col-sm-4 col-md-6 col-lg-4 mb-4 image-list-item">
    <img class="img-fluid" src="{{ $image ? thumb(Storage::path("public/{$image->path}"), 200, 125) : null }}"
        alt="">
    <div class="pt-2 text-center">
        <input type="hidden" name="image-name" id="image-name" value="{{ $image ? $image->name : null }}">
        <input type="hidden" name="image-id" id="image-id" value="{{ $image ? $image->id : null }}">
        <input type="hidden" name="image-thumb" id="image-thumb" value="{{ $image ? thumb(Storage::path("public/{$image->path}"), 200, 125) : null }}">
        <input type="hidden" name="image-url" id="image-url" value="{{ $image ? Storage::url($image->path) : null }}">
        @include('includes.button', [
            'button' => t_button_data(
                'btn btn-sm btn-outline-dark',
                'Inserir',
                null,
                icon_class('checkLg'),
                null,
                'jsInsertImage'
            ),
        ])
    </div>
</div>
