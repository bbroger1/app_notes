@extends('layouts.app')

@section('content')
@include('../includes/navbar')
@include('../includes/messages')
@include('../modals/modals')
<div class="container ">
    <div class="row">
        <div class="d-flex justify-content-end mt-2 mb-2">
            <a class="btn btn-sm btn-info" href="/notes/create">Criar Nota</a>
        </div>
        @if (count($notes) === 0)
        <div class="text-center">
            <h3>Você ainda não cadastrou nenhuma nota.</h3>
        </div>
        @else
        @foreach ($notes as $note)
        <div class="col-md-3 mb-3">
            <div class="card shadow border-0">
                <div id="card-{{ $note->id }}" class="card-header priority-{{ $note->priority }} text-center">
                    {{ $note->title }}</div>

                <div class="card-body">
                    {{ $note->description }}
                </div>

                <div class="card-footer">
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-md-6" title="Vencimento">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="rgba(var(--bs-link-color-rgb),var(--bs-link-opacity,1))" class="bi bi-calendar-event me-2" viewBox="0 0 16 16">
                                <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z" />
                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                            </svg>
                            <span class="deadline">{{ $note->formattedDeadline }}</span>
                        </div>

                        <div class="col-md-6 d-flex align-items-center">
                            <div class="me-3">
                                <a href="{{ route('notes.show', $note->id) }}" title="Detalhes">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                    </svg>
                                </a>
                            </div>
                            @canEdit($note)
                            <div class="me-3">
                                <a href="#" title="Concluir" onclick="toggleSVG(event, {{ $note->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16" style="display:{{ $note->status == 1 ? 'inline' : 'none' }}">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                        <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16" style="display:{{ $note->status == 1 ? 'none' : 'inline' }}">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                    </svg>
                                </a>
                            </div>
                            <div class="me-3">
                                <a href="{{ route('notes.edit', $note->id) }}" title="Editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                    </svg>
                                </a>
                            </div>
                            @endcanEdit
                            @canDestroy($note)
                            <div>
                                <form action="{{ route('notes.destroy', $note->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="custom-button" title="Excluir">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                            <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z">
                                            </path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            @endcanDestroy
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row justify-content-center">
                        <img title="{{ $note->user->first_name }}" src="{{ $note->user->image != "user.png" ? asset("storage/img/profile/" . $note->user->id . "/" . $note->user->image) : asset("img/user.png")}}" alt="{{ $note->user->first_name }}" class="rounded-circle me-2 mb-2" id="user_image">

                        @foreach ($note->shared as $shared)
                        <img title="{{ $shared->first_name }}" src="{{ $shared->image != "user.png" ? asset("storage/img/profile/" . $shared->id . "/" . $shared->image) : asset("img/user.png")}}" alt=" {{ $shared->first_name }}" class="rounded-circle me-2" id="user_image">
                        @endforeach

                        @canEdit($note)
                        <img title="Compartilhar" src="{{ asset('img/adicionar.png') }}" alt="adicionar" class="rounded-circle me-2" id="add_image" onclick="addUserNote(event, 'index', {{ $note->id }})">
                        @endcanEdit
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <div class="d-flex justify-content-center">
            {{ $notes->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
