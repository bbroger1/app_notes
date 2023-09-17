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
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                        fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                                        <path d="M11 2H9v3h2V2Z" />
                                        <path
                                            d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0ZM1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5Zm3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4v4.5ZM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5V15Z" />
                                    </svg>
                                    {{ __('Salvar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
