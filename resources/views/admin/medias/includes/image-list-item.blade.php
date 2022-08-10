<div class="col-6 col-sm-4 col-md-6 col-lg-4 mb-4 images-list-item">
    <img class="img-fluid" src=""
        alt="" data-toggle="tooltip" title="">
    <div class="pt-2 text-center">
        <input type="hidden" name="image-name" id="image-name" value="">
        <input type="hidden" name="image-id" id="image-id" value="">
        <input type="hidden" name="image-thumb" id="image-thumb" value="">
        <input type="hidden" name="image-url" id="image-url" value="">
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
