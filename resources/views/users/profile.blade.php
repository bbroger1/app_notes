@extends('layouts.app')

@section('content')
@include('../includes/navbar')
@include('../includes/messages')
<div class="container profile-page mt-3">
    <div class="row">
        <div class="col-12">
            <form class="file-upload">
                <div class="row">
                    <div class="col-md-3">
                        <div class="bg-secondary-soft px-4 py-5 rounded">
                            <div class="row g-3">
                                <div class="text-center">
                                    <div class="square position-relative display-2 mb-3">
                                        @if($user->image)
                                        <img src="{{ asset("img/$user->image") }}" alt="{{ $user->image }}">
                                        @else
                                        <i class="fas fa-fw fa-user position-absolute top-50 start-50 translate-middle text-secondary"></i>
                                        @endif
                                    </div>
                                    <input type="file" id="customFile" name="file" hidden="">
                                    <label class="btn btn-success-soft btn-block" for="customFile">Upload</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="col-xxl-8 mb-2 mb-xxl-0">
                            <div class="bg-secondary-soft px-4 py-5 rounded">
                                <div class="row g-3">
                                    <label class="form-label">Nome *</label>
                                    <input type="text" name="name" class="form-control" placeholder="Nome Completo">

                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email *</label>
                                        <input type="email" class="form-control" id="email" value="exemplo@email.com">
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Whatsapp</label>
                                        <input type="text" name="phone" class="form-control" placeholder="(xx) x xxxx-xxxx">
                                    </div>

                                    <hr>
                                    <h5>Trocar Senha</h5>
                                    <div class="col-md-12">
                                        <label for="password" class="form-label">Senha atual</label>
                                        <input type="password" name="password" class="form-control" id="password">
                                    </div>

                                    <div class="col-md-12">
                                        <label for="newPassword" class="form-label">Nova senha</label>
                                        <input type="password" name="newPassword" class="form-control" id="newPassword">

                                    </div>

                                    <div class="col-md-12">
                                        <label for="confirmPassword" class="form-label">Confirme a senha</label>
                                        <input type="password" name="confirmPassword" class="form-control" id="confirmPassword">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gap-3 d-md-flex justify-content-md-end text-center">
                            <button type="button" class="btn btn-danger">Excluir</button>
                            <button type="button" class="btn btn-primary">Atualizar</button>
                        </div>
            </form>
        </div>
    </div>

</div>
@endsection
