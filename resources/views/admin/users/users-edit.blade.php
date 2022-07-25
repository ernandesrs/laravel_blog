@extends('layouts.admin', [
    'mainBar' => [
        'title' => $pageTitle,
    ],
])

@section('content')
    <div class="row justify-content-center py-4 section-user-edit">
        <div class="col-8 col-sm-6 col-md-5 col-lg-4 mb-4 mb-md-0 text-center">
            <img class="avatar img-fluid rounded-circle img-thumbnail" src="{{ m_user_photo_thumb($user, 'normal') }}"
                alt="{{ $user->name }}">
            <div class="py-2">
                @if ($user->photo)
                    <div class="card card-body">
                        <form class="jsFormSubmit" action="{{ route('admin.users.photoRemove', ['user' => $user->id]) }}">
                            @include('includes.message')
                            @csrf
                            <button class="btn btn-link text-danger">Excluir foto</button>
                        </form>
                    </div>
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
                <form class="jsFormSubmit" action="{{ route('admin.users.update', ['user' => $user->id]) }}"
                    method="post" enctype="multipart/form-data">
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
