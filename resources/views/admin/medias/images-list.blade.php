@extends('layouts.admin', [
    'mainBar' => [
        'title' => $pageTitle,
        'buttons' => [t_button_link_data('Novo upload', 'outline-success', icon_class('plusLg'), route('admin.images.store'), null, 'jsNewUpload')],
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
                                    alt="{{ $image->name }}">
                            </div>
                            <div class="py-2 text-center">
                                <small>
                                    <p class="mb-1">
                                        <span>
                                            Nome:
                                            <span data-toggle="tooltip" data-placement="top" title="{{ $image->name }}">
                                                <a href="{{ Storage::url($image->path) }}" target="_blank">
                                                    {{ substr($image->name, 0, 12) }}...
                                                </a>
                                            </span>
                                        </span>
                                    </p>
                                    <p class="mb-0">
                                        <span>
                                            Tamanho:
                                            <span>
                                                {{ number_format($image->size / 1000000, 3, ',', ',') }} Mb
                                            </span>
                                        </span>
                                    </p>
                                </small>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12 col-sm-10 col-md-8">
                    <p class="mb-0 py-3 text-center text-muted h5">
                        Nenhuma imagem armazenada ainda
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

@include('admin.medias.includes.modal-image')

@section('scripts')
    <script>
        let modal = $("#jsImageUpload")

        $("#jsNewUpload").on("click", function(e) {
            e.preventDefault();
            let button = $(this);

            modal.find("form").attr("action", button.attr("data-action"));
            modal.find(".title").html("Upload de nova imagem");

            modal.modal();

        });
    </script>
@endsection
