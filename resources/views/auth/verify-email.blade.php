@extends('layouts.auth')

@section('content')
    <div class="col-10 col-md-8 col-lg-6 col-xl-4">
        @include('includes.message')

        <p class="h5 text-center">
            Uma mensagem com um link de verificação foi enviada para o endereço de email informado, clique sobre ele para
            confirmar a criação da sua conta.
        </p>

        <div class="text-center">
            <form action="{{ route('verification.send') }}" method="POST">
                @csrf
                <button class="btn btn-link" type="submit">Reenviar link</button>
            </form>
        </div>
    </div>
@endsection
