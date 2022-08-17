@extends('layouts.admin')

@section('content')
    {{-- admim home cards --}}
    <div class="row justify-content-center cards-list">
        <div class="col-12 col-sm-6 col-md-4 col-lg-6 col-xl-4 mb-4">
            <div class="card card-body d-flex flex-row align-items-center cards-list-item">
                {{ icon_elem('users') }}
                <div class="card-item-content">
                    <h5 class="h3 mb-0">
                        ({{ \App\Models\User::all()->count() }}) Usuários
                    </h5>
                    <div>
                        <small>
                            <a href="{{ route('admin.users.index', ['filter' => true, 'status' => 'unverified']) }}">
                                ({{ \App\Models\User::whereNull('email_verified_at')->count() }}) Não verificados
                            </a>
                            <span class="mx-1">|</span>
                            <a href="{{ route('admin.users.index', ['filter' => true, 'status' => 'verified']) }}">
                                ({{ \App\Models\User::whereNotNull('email_verified_at')->count() }}) Verificados
                            </a>
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-4 col-lg-6 col-xl-4 mb-4">
            <div class="card card-body d-flex flex-row align-items-center cards-list-item">
                {{ icon_elem('pageEarmarkText') }}
                <div class="card-item-content">
                    <h5 class="h3 mb-0">
                        ({{ \App\Models\Article::all()->count() }}) Artigos
                    </h5>
                    <div>
                        <small>
                            <a href="{{ route('admin.blog.articles.index', ['filter' => true, 'status' => 'published']) }}">({{ \App\Models\Article::where('status', \App\Models\Article::STATUS_PUBLISHED)->count() }})
                                Publicados</a>
                            <span class="mx-1">|</span>
                            <a
                                href="{{ route('admin.blog.articles.index', ['filter' => true, 'status' => 'scheduled']) }}">({{ \App\Models\Article::where('status', \App\Models\Article::STATUS_SCHEDULED)->count() }})
                                Agendados</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-4 col-lg-6 col-xl-4 mb-4">
            <div class="card card-body d-flex flex-row align-items-center cards-list-item">
                {{ icon_elem('pageEarmarkText') }}
                <div class="card-item-content">
                    <h5 class="h3 mb-0">
                        ({{ \App\Models\Page::all()->count() }}) Páginas
                    </h5>
                    <div>
                        <small>
                            <a href="{{ route('admin.pages.index', ['filter' => true, 'status' => 'published']) }}">
                                ({{ \App\Models\Page::where('status', 'published')->count() }}) Publicadas
                            </a>
                            <span class="mx-1">|</span>
                            <a href="{{ route('admin.pages.index', ['filter' => true, 'status' => 'scheduled']) }}">
                                ({{ \App\Models\Page::where('status', 'scheduled')->count() }}) Agendadas
                            </a>
                            <span class="mx-1">|</span>
                            <a href="{{ route('admin.pages.index', ['filter' => true, 'status' => 'draft']) }}">
                                ({{ \App\Models\Page::where('status', 'draft')->count() }}) Rascunho
                            </a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- mais acessados --}}
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card card-body">
                <h2 class="mb-0">Mais acessados</h2>
                <p class="mb-0">
                    <small>
                        O registro semanal é resetado toda semana.
                    </small>
                </p>
                <hr>
                <div class="table-responsive">
                    <table class="table table-sm table-hover table-borderless">
                        <thead>
                            <tr>
                                <th class="text-center">Acessos</th>
                                <th class="text-center">Esta semana</th>
                                <th class="text-center">Hoje</th>
                                <th>URL</th>
                                <th>Último acesso</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($access->count())
                                @foreach ($access as $ac)
                                    @php
                                        $url = route($ac->name, (array) json_decode($ac->params));
                                        $monitored = $ac->monitored();
                                        $access = (array) json_decode($ac->daily_access_register);
                                        
                                        $dailyAccess = $access[strtolower(date('D'))];
                                        $weeklyAccess = $ac->weekly_access;
                                    @endphp

                                    <tr>
                                        <td class="text-center align-middle">
                                            {{ $ac->access }}
                                        </td>
                                        <td class="text-center align-middle">
                                            {{ $weeklyAccess }}
                                        </td>
                                        <td class="text-center align-middle">
                                            {{ $dailyAccess }}
                                        </td>
                                        <td class="align-middle">
                                            <a href="{{ $url }}" target="_blank">
                                                {{ substr($monitored->title, 0, 35) . (strlen($monitored->title) > 35 ? '...' : null) }}
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
