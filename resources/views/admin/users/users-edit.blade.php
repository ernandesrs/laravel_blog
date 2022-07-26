@extends('layouts.admin', [
    'mainBar' => [
        'title' => $pageTitle,
        'buttons' => [t_button_link_data('btn btn-primary', 'Voltar', route('admin.users.index'), icon_class('arrowLeft')), t_button_link_data('btn btn-outline-success', 'Novo usuário', route('admin.users.create'), icon_class('plusLg'))],
    ],
])

@section('content')
    <div class="row justify-content-center py-4 section-user-edit">
        <div class="col-8 col-sm-6 col-md-5 col-lg-4 mb-4 mb-md-0 text-center">
            <img class="avatar img-fluid rounded-circle img-thumbnail" src="{{ m_user_photo_thumb($user, 'normal') }}"
                alt="{{ $user->name }}">
            <div class="py-2">
                @if ($user->photo)
                    @include('includes.button-confirmation', [
                        'button' => t_button_confirmation_data(
                            'danger',
                            'btn btn-outline-danger',
                            'Você está excluindo a foto deste usuário permanentemente e isso não pode ser desfeito.',
                            route('admin.users.photoRemove', ['user' => $user->id]),
                            'Excluir foto',
                            icon_class('trash')
                        ),
                    ])
                    <hr>
                @endif
                <small>
                    <p class="mb-0">
                        Registrado em: {{ $user->created_at->format('d/m/Y H:i') }}
                    </p>
                    <p class="mb-0">
                        @if ($user->email_verified_at)
                            Verificado em: {{ $user->email_verified_at->format('d/m/Y H:i') }}
                        @else
                            Aguardando verificação
                        @endif
                    </p>
                </small>
            </div>
        </div>

        <div class="col-12 col-md-7 col-lg-8">
            <div class="card card-body">
                <form class="jsFormSubmit" action="{{ route('admin.users.update', ['user' => $user->id]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf

                    @include('admin.users.includes.users-form-fields')

                    <button class="btn btn-primary {{ icon_class('checkLg') }}"
                        data-active-icon="{{ icon_class('checkLg') }}" data-alt-icon="{{ icon_class('loading') }}"
                        type="submit">
                        Atualizar
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @include('includes.modal-confirmation')
@endsection
