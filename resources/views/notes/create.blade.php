@extends('layouts.app')

@section('content')
    @include('../includes/navbar')
    @include('../includes/messages')
    <div class="container">
        <div class="row mt-4">
            <div class="card">
                <div class="card-header">{{ $isEdit ? __('Editar Nota') : __('Cadastrar Nota') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ $isEdit ? route('notes.update', $note->id) : route('notes.store') }}">
                        @csrf

                        @if ($isEdit)
                            @method('PUT')
                        @endif

                        <div class="row mb-3">
                            <label for="title" class="col-md-4 col-form-label text-md-end">{{ __('Título') }}</label>
                            <div class="col-md-6">
                                <input id="title" type="text"
                                    class="form-control @error('title') is-invalid @enderror" name="title"
                                    value="{{ $isEdit ? $note->title : old('title') }}" required autocomplete="title"
                                    autofocus>
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="deadline"
                                class="col-md-4 col-form-label text-md-end">{{ __('Prazo Final') }}</label>
                            <div class="col-md-6">
                                <input id="deadline" type="date"
                                    class="form-control @error('deadline') is-invalid @enderror" name="deadline"
                                    value="{{ $isEdit ? $note->deadline : old('deadline') }}" required
                                    autocomplete="deadline" autofocus>
                                @error('deadline')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="priority" class="col-md-4 col-form-label text-md-end">{{ __('Prioridade') }}</label>
                            <div class="col-md-6">
                                <select name="priority" class="form-select @error('priority') is-invalid @enderror"
                                    required>
                                    @if (!$isEdit)
                                        <option selected>Selecione</option>
                                    @endif
                                    <option {{ $note->priority == 1 ? 'selected' : ' ' }} value="1">Muito Alta</option>
                                    <option {{ $note->priority == 2 ? 'selected' : ' ' }} value="2">Alta</option>
                                    <option {{ $note->priority == 3 ? 'selected' : ' ' }} value="3">Média</option>
                                    <option {{ $note->priority == 4 ? 'selected' : ' ' }} value="2">Baixa</option>
                                    <option {{ $note->priority == 5 ? 'selected' : ' ' }} value="3">Muito Baixa
                                    </option>
                                </select>
                                @error('priority')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="category" class="col-md-4 col-form-label text-md-end">{{ __('Categoria') }}</label>
                            <div class="col-md-6">
                                <select name="category_id" class="form-select @error('category') is-invalid @enderror"
                                    required>
                                    @if (!$isEdit)
                                        <option selected>Selecione</option>
                                    @endif
                                    @foreach ($categories as $categorie)
                                        <option {{ $note->category_id == $categorie->id ? 'selected' : ' ' }}
                                            value="{{ $categorie->id }}">{{ $categorie->title }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="description"
                                class="col-md-4 col-form-label text-md-end">{{ __('Descrição') }}</label>
                            <div class="col-md-6">
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required>{{ $isEdit ? $note->description : old('description') }}</textarea>

                                @error('description')
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
