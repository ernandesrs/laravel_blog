@extends('layouts.admin', [
    'mainBar' => [
        'title' => $pageTitle,
    ],
])

@section('content')
    <div class="row justify-content-center py-4">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card card-body">
                <form class="jsFormSubmit" action="{{ route('admin.users.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf

                    @include('admin.users.includes.users-form-fields')

                    <button class="btn btn-primary {{ icon_class('checkLg') }}"
                        data-active-icon="{{ icon_class('checkLg') }}" data-alt-icon="{{ icon_class('loading') }}"
                        type="submit">
                        Registrar
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
