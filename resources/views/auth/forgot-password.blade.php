@extends('layouts.auth')

@section('content')
    <div class="col-10 col-md-8 col-lg-6">
        <form action="{{ route('password.email') }}" method="POST">
            @csrf

            @include('includes.message')

            <div class="form-group">
                <label for="email">E-mail:</label>
                <input class="form-control" type="text" name="email" id="email">
            </div>

            <div class="form-group d-flex justify-content-center align-items-center">
                <button class="btn btn-primary">Solicitar link de recuperação</button>
            </div>
        </form>
    </div>
@endsection

