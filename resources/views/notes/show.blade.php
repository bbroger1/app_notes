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
                        <input id="title" type="text" class="form-control" name="title" value="{{ $note->title }}" readonly required autofocus>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="deadline" class="col-md-4 col-form-label text-md-end">{{ __('Prazo Final') }}</label>
                    <div class="col-md-6">
                        <input id="deadline" type="date" class="form-control" name="deadline" value="{{ $note->deadline }}" readonly required autocomplete="deadline">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="priority" class="col-md-4 col-form-label text-md-end">{{ __('Prioridade') }}</label>
                    <div class="col-md-6">
                        <select name="priority" class="form-select @error('priority') is-invalid @enderror" readonly required>
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

                <div class="row mb-3">
                    <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Compartilhado com:') }}</label>
                    <div class="col-md-6 d-flex align-items-center">
                        @foreach ($note->shared as $shared)
                        <img title="{{ $shared->first_name }}" src="{{ $shared->image != "user.png" ? asset("storage/img/profile/" . $shared->id . "/" . $shared->image) : asset("img/user.png")}}" alt=" {{ $shared->first_name }}" class="rounded-circle me-2" id="user_image_show">
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row card-footer">
                <div class="d-flex justify-content-center">
                    @canEdit($note)
                    <div class="me-3">
                        <a href="{{ route('notes.edit', $note->id) }}" class="btn btn-sm btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                            </svg> Editar
                        </a>
                    </div>
                    @endcanEdit
                    @canDestroy($note)
                    <div>
                        <form action="{{ route('notes.destroy', $note->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Excluir">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z">
                                    </path>
                                </svg> Excluir
                            </button>
                        </form>
                    </div>
                    @endcanDestroy

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
