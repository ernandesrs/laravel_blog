@extends('layouts.auth')

@section('content')
    <div class="col-10 col-md-8 col-lg-6 col-xl-4">
        <form action="{{ route('password.update') }}" method="POST">
            @csrf

            @include('includes.message')

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label for="email">Email:</label>
                <input class="form-control" type="text" name="email" id="email">
            </div>

            <div class="form-group">
                <label for="password">Nova senha:</label>
                <input class="form-control" type="password" name="password" id="password">
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmar nova senha:</label>
                <input class="form-control" type="password" name="password_confirmation" id="password_confirmation">
            </div>

            <div class="form-group">
                <button class="btn btn-primary">Atualizar senha</button>
            </div>
        </form>
    </div>
@endsection
