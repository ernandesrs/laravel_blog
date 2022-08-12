@extends('layouts.admin')

@section('content')
    {{-- admim home cards --}}
    <div class="row justify-content-center cards-list">
        <div class="col-12 col-sm-6 col-md-4 col-lg-6 col-xl-4 mb-4">
            <div class="card card-body d-flex flex-row align-items-center cards-list-item">
                {{ icon_elem('users') }}
                <div class="card-item-content">
                    <h5 class="h3 mb-0">Usuários</h5>
                    <div>
                        <small>
                            <a href="{{ route('admin.users.index', ['filter' => true, 'status' => 'unverified']) }}">Não
                                verificados</a>
                            <span class="mx-1">|</span>
                            <a
                                href="{{ route('admin.users.index', ['filter' => true, 'status' => 'verified']) }}">Verificados</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-4 col-lg-6 col-xl-4 mb-4">
            <div class="card card-body d-flex flex-row align-items-center cards-list-item">
                {{ icon_elem('pageEarmarkText') }}
                <div class="card-item-content">
                    <h5 class="h3 mb-0">Páginas</h5>
                    <div>
                        <small>
                            <a
                                href="{{ route('admin.pages.index', ['filter' => true, 'status' => 'published']) }}">Publicadas</a>
                            <span class="mx-1">|</span>
                            <a
                                href="{{ route('admin.pages.index', ['filter' => true, 'status' => 'scheduled']) }}">Agendadas</a>
                            <span class="mx-1">|</span>
                            <a href="{{ route('admin.pages.index', ['filter' => true, 'status' => 'draft']) }}">Rascunho</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-4 col-lg-6 col-xl-4 mb-4">
            <div class="card card-body d-flex flex-row align-items-center cards-list-item">
                {{ icon_elem('appIndicator') }}
                <div class="card-item-content">
                    <h5 class="h3 mb-0">Example</h5>
                    <div>
                        <small>
                            <a href="">Example #1</a>
                            <span class="mx-1">|</span>
                            <a href="">Example #2</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card card-body">
                <h2 class="mb-0">Mais acessados</h2>
                <hr>
                <div class="table-responsive">
                    <table class="table table-sm table-hover table-borderless">
                        <thead>
                            <tr>
                                <th class="text-center">Acessos</th>
                                <th>URL</th>
                                <th>Último acesso</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($access->count())
                                @foreach ($access as $ac)
                                    <tr>
                                        <td class="text-center align-middle">
                                            {{ $ac->access }}
                                        </td>
                                        <td class="align-middle">
                                            <a href="{{ route($ac->name, (array) json_decode($ac->params)) }}"
                                                target="_blank">
                                                {{ substr($ac->path, 0, 50) . (strlen($ac->path) > 50 ? '...' : null) }}
                                            </a>
                                        </td>
                                        <td class="align-middle">
                                            {{ date('d/m/Y H:i:s', strtotime($ac->updated_at)) }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
