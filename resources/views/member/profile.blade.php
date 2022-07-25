@extends('layouts.member')

@section('content')
    <div class="profile">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="jumbotron text-center pb-5">
                    <h2 class="display-4">Olá, {{ $profile->first_name }}!</h2>
                    <p class="lead">Bem vindo ao seu perfil!</p>
                    <img class="avatar img-fluid rounded-circle img-thumbnail" src="{{ m_user_photo_thumb($profile, 'normal') }}"
                        alt="{{ $profile->name }}">
                </div>
            </div>

            <div class="profile-info col-11 col-md-9 col-lg-9 col-xl-8">
                <div class="card card-body">
                    <h5 class="mb-0">Atualizar dados</h5>
                    <hr>
                    <form class="jsFormSubmit" action="{{ route('member.profileUpdate') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="form-row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="first_name">Nome:</label>
                                    <input class="form-control" type="text" name="first_name" id="first_name"
                                        value="{{ $profile->first_name }}">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="last_name">Sobrenome:</label>
                                    <input class="form-control" type="text" name="last_name" id="last_name"
                                        value="{{ $profile->last_name }}">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input class="form-control" type="text" name="email" id="email"
                                        value="{{ $profile->email }}" readonly>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="gender">Gênero:</label>
                                    @php
                                        $genders = m_user_genders();
                                    @endphp
                                    <select class="form-control" name="gender" id="gender">
                                        @foreach ($genders as $gender)
                                            <option value="{{ $gender }}"
                                                {{ input_value($profile ?? null, 'gender') == $gender ? 'selected' : null }}>
                                                {{ ucfirst(__('terms.user_gender.' . $gender)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="photo">Foto:</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="photo" id="photo" lang="{{ config("app.locale") }}">
                                        <label class="custom-file-label" for="photo">Escolher arquivo</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="password">Senha:</label>
                                    <input class="form-control" type="text" name="password" id="password"
                                        autocomplete="new-password">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirmar senha:</label>
                                    <input class="form-control" type="password" name="password_confirmation"
                                        id="password_confirmation" autocomplete="new-password">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group text-right">
                                    <button class="btn btn-primary bi bi-check-lg" data-active-icon="bi bi-check-lg"
                                        data-alt-icon="bbi bi-arrow-clockwise">
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
@endsection
