<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - {{ $pageTitle }}</title>

    <link rel="stylesheet" href="{{ asset('assets/css/auth/styles.css') }}">
    @yield('styles')
</head>

<body>

    <div class="main py-5">
        <div class="container py-5">
            <div class="row justify-content-center py-5">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/boostrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.min.js') }}"></script>
    <script src="{{ asset('assets/js/auth/scripts.js') }}"></script>

    @yield('scripts')
</body>

</html>
