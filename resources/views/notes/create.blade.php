@extends('layouts.app')

@section('content')
@include('../includes/navbar')
@include('../includes/messages')
@include('../modals/modals')
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
                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $isEdit ? $note->title : old('title') }}" required autocomplete="title" autofocus>
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="deadline" class="col-md-4 col-form-label text-md-end">{{ __('Prazo Final') }}</label>
                        <div class="col-md-6">
                            <input id="deadline" type="date" class="form-control @error('deadline') is-invalid @enderror" name="deadline" value="{{ $isEdit ? $note->deadline : old('deadline') }}" required autocomplete="deadline" autofocus>
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
                            <select name="priority" class="form-select @error('priority') is-invalid @enderror" required>
                                @if (!$isEdit)
                                <option selected>Selecione</option>
                                <option value="1">Muito Alta
                                </option>
                                <option value="2">Alta</option>
                                <option value="3">Média</option>
                                <option value="2">Baixa</option>
                                <option value="3">Muito Baixa
                                </option>
                                @else
                                <option {{ $note->priority == 1 ? 'selected' : ' ' }} value="1">Muito Alta
                                </option>
                                <option {{ $note->priority == 2 ? 'selected' : ' ' }} value="2">Alta</option>
                                <option {{ $note->priority == 3 ? 'selected' : ' ' }} value="3">Média</option>
                                <option {{ $note->priority == 4 ? 'selected' : ' ' }} value="4">Baixa</option>
                                <option {{ $note->priority == 5 ? 'selected' : ' ' }} value="5">Muito Baixa
                                </option>
                                @endif
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
                            <select name="category_id" class="form-select @error('category') is-invalid @enderror" required>
                                @if (!$isEdit)
                                <option selected>Selecione</option>
                                @foreach ($categories as $categorie)
                                <option value="{{ $categorie->id }}">{{ $categorie->title }}</option>
                                @endforeach
                                @else
                                @foreach ($categories as $categorie)
                                <option {{ $note->category_id == $categorie->id ? 'selected' : ' ' }} value="{{ $categorie->id }}">{{ $categorie->title }}</option>
                                @endforeach
                                @endif

                            </select>
                            @error('category')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Descrição') }}</label>
                        <div class="col-md-6">
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required>{{ $isEdit ? $note->description : old('description') }}</textarea>

                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    @if($isEdit)
                    <div class="row mb-3">
                        <label for="shared" class="col-md-4 col-form-label text-md-end">{{ __('Compartilhado com:') }}</label>
                        <div class="col-md-6 d-flex align-items-center">
                            @foreach ($note->shared as $shared)
                            <div class="position-relative me-2" onclick="removeUserNote(event, {{ $note->id }}, {{ $shared->id }})">
                                <img title="{{ $shared->first_name }}" src="{{ $shared->image != "user.png" ? asset("storage/img/profile/" . $shared->id . "/" . $shared->image) : asset("img/user.png")}}" alt=" {{ $shared->first_name }}" class="rounded-circle me-2" id="user_image_show">

                                <span class="remove-icon" title="Descompartilhar">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                </span>
                            </div>
                            @endforeach
                            <img title="Compartilhar" src="{{ asset('img/adicionar.png') }}" alt="adicionar" class="rounded-circle" onclick="addUserNote(event, 'edit', {{ $note->id }})">
                        </div>
                    </div>
                    @endif

                    <div class="row">
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                                    <path d="M11 2H9v3h2V2Z" />
                                    <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0ZM1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5Zm3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4v4.5ZM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5V15Z" />
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
