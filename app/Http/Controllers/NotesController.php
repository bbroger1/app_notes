<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Mail\SharedEmail;
use App\Models\Categorie;
use App\Services\FlashService;
use App\Http\Requests\NoteRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\SharedRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class NotesController extends Controller
{
    protected $flashService;

    public function __construct(FlashService $flashService)
    {
        $this->middleware('owner')->only('show', 'edit', 'destroy');
        $this->flashService = $flashService;
    }

    public function index()
    {
        try {
            $notesQuery = Note::with('user')
                ->orderBy('status', 'asc')
                ->orderBy('deadline', 'asc')
                ->orderBy('priority', 'desc');

            if (Auth::user()->is_admin != 1) {
                $notesQuery->where('user_id', Auth::user()->id);
            }

            $notes = $notesQuery->paginate(12);

            return view('notes.index', compact('notes'));
        } catch (\Throwable $e) {
            // Registra o erro no log
            Log::error($e);

            $this->flashService->setFlashMessage('error', 'Sistema inoperante.');
            return redirect()->route('error');
        }
    }

    public function create()
    {
        try {
            $categories = Categorie::where('user_id', Auth::user()->id)
                ->orderBy('title', 'asc')
                ->select('id', 'title')
                ->get();
            $isEdit = false;
            return view('notes.create', compact(['isEdit', 'categories']));
        } catch (\Throwable $e) {

            $this->flashService->setFlashMessage('error', 'Erro ao carregar a página.');
            return redirect()->route('notes.index');
        }
    }

    public function store(NoteRequest $request)
    {
        try {
            $note = $request->validated();
            $note['user_id'] = Auth::user()->id;

            Note::create($note);


            $this->flashService->setFlashMessage('success', 'Nota criada com sucesso.');
            return redirect()->route('notes.index');
        } catch (\Throwable $e) {
            dd($e);

            $this->flashService->setFlashMessage('error', 'Não foi possível criar a nota.');
            return redirect()->route('notes.create');
        }
    }

    public function show(Note $note)
    {
        try {
            $note = Note::join('categories', 'categories.id', '=', 'notes.category_id')
                ->leftJoin('users', function ($join) {
                    $join->on('users.id', '=', 'notes.user_id')
                        ->orWhere('users.is_admin', 1);
                })
                ->select(
                    'notes.id as id',
                    'notes.title',
                    'notes.priority as priority_id',
                    'notes.priority',
                    'notes.deadline',
                    'notes.description',
                    'categories.id as category_id',
                    'categories.title as category_title'
                )
                ->where('notes.id', $note->id)
                ->where(function ($query) {
                    $query->where('notes.user_id', Auth::user()->id)
                        ->orWhere('users.is_admin', 1);
                })
                ->first();

            switch ($note->priority) {
                case '1':
                    $note->priority = 'Muito alta';
                    break;
                case '2':
                    $note->priority = 'Alta';
                    break;
                case '3':
                    $note->priority = 'Média';
                    break;
                case '4':
                    $note->priority = 'Baixa';
                    break;
                case '5':
                    $note->priority = 'Muito baixa';
                    break;
                default:
                    return "";
            }

            return view('notes.show', compact(['note']));
        } catch (\Throwable $e) {

            $this->flashService->setFlashMessage('error', 'Erro ao carregar a página.');
            return redirect()->route('notes.index');
        }
    }

    public function edit(Note $note)
    {
        try {
            $categories = Categorie::orderBy('title', 'asc')->select('id', 'title')->get();
            $isEdit = true;
            return view('notes.create', compact(['isEdit', 'note', 'categories']));
        } catch (\Throwable $e) {

            $this->flashService->setFlashMessage('error', 'Erro ao carregar a página.');
            return redirect()->route('notes.index');
        }
    }

    public function update(NoteRequest $request, Note $note)
    {
        try {
            $data = $request->validated();
            if (Auth::user()->is_admin) {
                $data['user_id'] = $note->user_id;
            } else {
                $data['user_id'] = Auth::user()->id;
            }

            if ($note->update($data)) {

                $this->flashService->setFlashMessage('success', 'Nota editada com sucesso.');
            } else {

                $this->flashService->setFlashMessage('error', 'Nota não pode ser editada. [1]');
            };

            return redirect()->route('notes.index');
        } catch (\Throwable $e) {
            $this->flashService->setFlashMessage('error', 'Nota não pode ser editada.');
            return redirect()->route('notes.create');
        }
    }

    public function destroy(Note $note)
    {
        try {
            if ($note->destroy($note->id)) {

                $this->flashService->setFlashMessage('success', 'Nota excluída com sucesso.');
                return redirect()->route('notes.index');
            } else {

                $this->flashService->setFlashMessage('error', 'Nota não pode ser excluída. [1]');
            };
        } catch (\Throwable $e) {
            $this->flashService->setFlashMessage('error', 'Nota não pode ser excluída.');
            return redirect()->route('notes.index');
        }
    }

    public function check(Note $note)
    {
        try {
            // Atualiza o campo status
            if ($status = $note->status == 1) {
                $note->status = 2;
            } else if ($status == 2) {
                $note->status = 1;
            }

            if ($note->save()) {
                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 'error']);
            };
        } catch (\Throwable $e) {
            $this->flashService->setFlashMessage('error', 'Comando não pode ser registrado.');
            return redirect()->route('notes.index');
        }
    }

    public function shared(Note $note, SharedRequest $request)
    {
        try {
            $email = $request->user_email;
            $user = User::where('email', $email)
                ->first();

            $note_user = $note->user->name;

            if ($user) {
                return redirect()->route('notes.index');
            } else {
                $mailData = [
                    'email' => $email,
                    'user' => $note_user,
                    'link' => 'http://127.0.0.1:8000'
                ];

                Mail::to($email)->send(new SharedEmail($mailData));

                if (count(Mail::failures()) > 0) {
                    $this->flashService->setFlashMessage('error', 'Ocorreu um erro ao enviar o e-mail.');
                } else {
                    $this->flashService->setFlashMessage('warning', 'Usuário inexistente, convite enviado.');
                }

                return redirect()->route('notes.index');
            }
        } catch (\Throwable $e) {
            dd($e);
            $this->flashService->setFlashMessage('error', 'Comando não pode ser registrado.');
            return redirect()->route('notes.index');
        }
    }
}
