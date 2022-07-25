@extends('layouts.auth')

@section('content')
    <div class="col-10 col-md-8 col-lg-6 col-xl-4">
        <div class="card card-body bg-trasparent">
            <form class="jsFormSubmit" action="{{ route('auth.authenticate') }}" method="POST">
                @csrf

                @include('includes.message')

                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input class="form-control" type="text" name="email" id="email">
                </div>

                <div class="form-group">
                    <label for="password">Senha:</label>
                    <input class="form-control" type="password" name="password" id="password">
                </div>

                <div class="form-group">
                    <div class="g-recaptcha" data-sitekey="{{ env('APP_GOOGLE_RECAPTCHAV2_SITE_KEY') }}"></div>
                </div>

                <div class="form-group d-flex align-items-center">
                    <button class="btn btn-primary">Login</button>
                    <a class="ml-auto" href="{{ route('auth.register') }}">Registrar</a>
                    <span class="mx-1">|</span>
                    <a class="" href="{{ route('password.request') }}">Recuperar senha</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection
