@extends('layouts.app')

@section('content')
    @include('../includes/navbar')
    @include('../includes/messages')
    <div class="container">
        <div class="row mt-5">
            <div class="card">
                <div class="card-header">{{ $isEdit ? __('Editar Categoria') : __('Cadastrar Categoria') }}</div>

                <div class="card-body">
                    <form method="POST"
                        action="{{ $isEdit ? route('categories.update', $category->id) : route('categories.store') }}">
                        @csrf

                        @if ($isEdit)
                            @method('PUT')
                        @endif

                        <div class="row mb-3 d-flex justify-content-center">
                            <div class="col-md-8">
                                <input id="title" type="text"
                                    class="form-control @error('title') is-invalid @enderror" name="title"
                                    value="{{ $isEdit ? $category->title : old('title') }}" required autofocus
                                    placeholder="Digite o título da categoria">

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">{{ __('Salvar') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
