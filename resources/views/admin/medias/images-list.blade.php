@extends('layouts.admin', [
    'mainBar' => [
        'filterFormAction' => route('admin.images.index'),
        'title' => $pageTitle,
        'buttons' => [t_button_link_data('btn btn-outline-success', 'Novo upload', route('admin.images.store'), icon_class('plusLg'), null, 'jsBtnOpenUploadModal')],
    ],
])

@section('content')
    <div class="pt-4">
        <div class="row justify-content-center">
            @if ($images->count())
                @foreach ($images as $image)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                        <div class="card card-body border-0 shadow">
                            <div class="">
                                <img class="img-fluid img-thumbnail"
                                    src="{{ thumb(Storage::path('public/' . $image->path), 350, 225) }}"
                                    alt="{{ $image->name }}" data-toggle="tooltip" title="Tags: {{ $image->tags }}"
                                    data-placement="bottom">
                            </div>
                            <div class="pt-2 text-center">
                                <small>
                                    <p class="mb-0">
                                        <span>
                                            Nome:
                                            <span data-toggle="tooltip" data-placement="top" title="{{ $image->name }}">
                                                <a href="{{ Storage::url($image->path) }}" target="_blank">
                                                    {{ substr($image->name, 0, 12) }}...
                                                </a>
                                            </span>
                                        </span>
                                    </p>
                                    <p class="mb-2">
                                        <span>
                                            Tamanho:
                                            <span>
                                                {{ number_format($image->size / 1000000, 3, ',', ',') }} Mb
                                            </span>
                                        </span>
                                    </p>
                                    <div>
                                        @include('includes.button', [
                                            'button' => t_button_data(
                                                'btn btn-sm btn-secondary',
                                                null,
                                                route('admin.images.show', ['image' => $image->id]),
                                                icon_class('pencilSquare'),
                                                null,
                                                'jsBtnOpenImageEditModal'
                                            ),
                                        ])
                                        @include('includes.button-confirmation', [
                                            'button' => t_button_confirmation_data(
                                                'danger',
                                                'btn btn-sm btn-outline-danger',
                                                'Você está excluindo esta imagem definitivamente e isso não pode ser desfeito.',
                                                route('admin.images.destroy', ['image' => $image->id]),
                                                null,
                                                icon_class('trash')
                                            ),
                                        ])
                                    </div>
                                </small>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12 col-sm-10 col-md-8">
                    <p class="mb-0 py-3 text-center text-muted h5">
                        @if (empty(input_value($_GET ?? null, 'filter')))
                            Nenhuma imagem armazenada ainda
                        @else
                            Sem resultados para sua busca
                        @endif
                    </p>
                </div>
            @endif
        </div>

        <div class="row justify-content-center">
            <div class="col-12">
                {{ $images->links() }}
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @include('admin.medias.includes.modal-image-upload')
    @include('includes.modal-confirmation')
    @include('admin.medias.includes.modal-image-edit')
@endsection

@section('scripts')
    <script>
        $(".jsBtnOpenUploadModal").on("click", function(e) {
            e.preventDefault();
            $("#jsImageUploadModal").modal();
        });

        $(".jsBtnOpenImageEditModal").on("click", function(e) {
            e.preventDefault();
            let modal = $("#jsImageEditModal");
            let action = $(this).attr("data-action");

            $.ajax({
                type: "POST",
                url: action,
                data: null,
                dataType: "json",
                success: function(response) {
                    modal.find("#name").val(response.image.name);
                    modal.find("#tags").val(response.image.tags);
                    modal.find("form").attr("action", response.action);
                    modal.modal();
                }
            });
        });
    </script>
@endsection
