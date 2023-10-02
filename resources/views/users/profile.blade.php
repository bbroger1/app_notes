@extends('layouts.app')

@section('content')
@include('../includes/navbar')
@include('../includes/messages')
<div class="container profile-page mt-3">
    <div class="row">
        <div class="col-12">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="file-upload">
                @csrf
                @method("PATCH")
                <div class="row">
                    <div class="col-md-3">
                        <div class="bg-secondary-soft px-4 py-5 rounded">
                            <div class="row g-3">
                                <div class="text-center">
                                    <div class="square position-relative display-2 mb-3">
                                        @if($user->image)
                                        <img id="profileImage" name="image" src="{{ asset("storage/img/profile/$user->id/$user->image") }}" alt="{{ $user->image }}" width="200" height="200">

                                        @else
                                        <i class="fas fa-fw fa-user position-absolute top-50 start-50 translate-middle text-secondary"></i>
                                        @endif
                                    </div>
                                    <input type="file" id="customFile" name="image" hidden="">
                                    <label class="btn btn-sm btn-success" for="customFile">Upload</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="col-xxl-8">
                            <div class="bg-secondary-soft px-2 py-3 rounded">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="name" class="form-label">Nome *</label>
                                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $user->name }} ">
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Email *</label>
                                        <label type="email" class="form-control">{{ $user->email }}</label>
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Celular</label>
                                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ $user->phone }}">
                                        @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <hr>

                                    <h5>Trocar Senha</h5>

                                    <div class="col-md-4">
                                        <label for="password" class="form-label">Senha atual</label>
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="new_password" class="form-label">Nova senha</label>
                                        <input id="new_password" type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror">

                                        @error('new_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="password_confirm" class="form-label">Confirme a senha</label>
                                        <input id="password_confirm" type="password" name="password_confirm" class="form-control @error('password_confirm') is-invalid @enderror">

                                        @error('password_confirm')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gap-3 d-md-flex justify-content-md-end text-center mb-3">
                            <button type="button" class="btn btn-danger">Excluir Conta</button>
                            <button type="submit" class="btn btn-primary">Atualizar Perfil</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
