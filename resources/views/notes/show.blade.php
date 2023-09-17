@extends('layouts.app')

@section('content')
    @include('../includes/navbar')
    @include('../includes/messages')
    <div class="container">
        <div class="row mt-4">
            <div class="card">
                <div class="card-header mb-3">{{ __('Nota') }}</div>

                <div class="card-body">
                    <div class="row mb-3">
                        <label for="title" class="col-md-4 col-form-label text-md-end">{{ __('Título') }}</label>
                        <div class="col-md-6">
                            <input id="title" type="text" class="form-control" name="title"
                                value="{{ $note->title }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="deadline" class="col-md-4 col-form-label text-md-end">{{ __('Prazo Final') }}</label>
                        <div class="col-md-6">
                            <input id="deadline" type="date" class="form-control" name="deadline"
                                value="{{ $note->deadline }}" readonly required autocomplete="deadline" autofocus>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="priority" class="col-md-4 col-form-label text-md-end">{{ __('Prioridade') }}</label>
                        <div class="col-md-6">
                            <select name="priority" class="form-select @error('priority') is-invalid @enderror" readonly
                                required>
                                <option value="{{ $note->priority_id }}">{{ $note->priority }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="category" class="col-md-4 col-form-label text-md-end">{{ __('Categoria') }}</label>
                        <div class="col-md-6">
                            <select name="category_id" class="form-select" readonly required>
                                <option value="{{ $note->category_id }}">{{ $note->category_title }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Descrição') }}</label>
                        <div class="col-md-6">
                            <textarea id="description" type="text" class="form-control" name="description" readonly>{{ $note->description }}
                            </textarea>
                        </div>
                    </div>
                </div>
                <div class="row card-footer">
                    <div class="d-flex justify-content-center">
                        <div class="me-3">
                            <a href="{{ route('notes.edit', $note->id) }}" class="btn btn-sm btn-primary">
                                Editar
                            </a>
                        </div>
                        <div>
                            <form action="{{ route('notes.destroy', $note->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
