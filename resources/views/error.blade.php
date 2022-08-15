<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Error</title>

    <link rel="stylesheet" href="{{ asset('assets/css/front/styles.css') }}">
</head>

<body>
    <div style="width:100%;min-height:100vh;display:flex;justify-content:center;align-items:center;">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">
                <h1 class="text-center">
                    Ooops, <span class="text-dark-light">houve um erro ao acessar o link solicitado!</span>
                </h1>
                <p class="h5 text-muted text-center">
                    Isso aconteceu pois você acessou um link de uma página que foi movida, renomeada ou que talvez não
                    exista.
                </p>
                <div class="text-center py-3">
                    <a class="btn btn-primary" href="{{ route('front.home') }}">
                        Página inicial
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
