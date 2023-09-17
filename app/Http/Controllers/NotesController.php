<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Http\Requests\NoteRequest;
use App\Models\Categorie;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\FuncCall;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

class NotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $notesQuery = Note::orderBy('status', 'asc')
                ->orderBy('deadline', 'asc')
                ->orderBy('priority', 'desc');

            if (Auth::user()->is_admin != 1) {
                $notesQuery->where('user_id', Auth::user()->id);
            }

            $notes = $notesQuery->paginate(12);

            return view('notes.index', compact('notes'));
        } catch (\Throwable $e) {
            // Adiciona mensagem flash à sessão
            session()->flash('error', 'Sistema inoperante.');
            return view('notes.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
            // Adiciona mensagem flash à sessão
            session()->flash('error', 'Erro ao carregar a página.');
            return redirect()->route('notes.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NoteRequest $request)
    {
        try {
            $note = $request->validated();
            $note['user_id'] = Auth::user()->id;

            Note::create($note);

            // Adiciona mensagem flash à sessão
            session()->flash('success', 'Nota criada com sucesso.');

            return redirect()->route('notes.index');
        } catch (\Throwable $e) {
            dd($e);
            // Adiciona mensagem flash à sessão
            session()->flash('error', 'Não foi possível criar a nota.');
            return redirect()->route('notes.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        try {
            $note = Note::join('categories', 'categories.id', '=', 'notes.category_id')
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
            // Adiciona mensagem flash à sessão
            session()->flash('error', 'Erro ao carregar a página.');
            return redirect()->route('notes.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        try {
            $categories = Categorie::orderBy('title', 'asc')->select('id', 'title')->get();
            $isEdit = true;
            return view('notes.create', compact(['isEdit', 'note', 'categories']));
        } catch (\Throwable $e) {
            // Adiciona mensagem flash à sessão
            session()->flash('error', 'Erro ao carregar a página.');
            return redirect()->route('notes.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(NoteRequest $request, Note $note)
    {
        try {
            $data = $request->validated();
            $data['user_id'] = Auth::user()->id;
            if ($note->update($data)) {
                // Adiciona mensagem flash à sessão
                session()->flash('success', 'Nota editada com sucesso.');
            } else {
                // Adiciona mensagem flash à sessão
                session()->flash('error', 'Nota não pode ser editada. [1]');
            };

            return redirect()->route('notes.index');
        } catch (\Throwable $e) {
            session()->flash('error', 'Nota não pode ser editada.');
            return redirect()->route('notes.create');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        try {
            $note->destroy($note->id);
            // Adiciona mensagem flash à sessão
            session()->flash('success', 'Nota excluída com sucesso.');
            return redirect()->route('notes.index');
        } catch (\Throwable $e) {
            session()->flash('error', 'Nota excluída com sucesso.');
            return redirect()->route('notes.index');
        }
    }

    public function check(Note $note)
    {
        try {
            $status = $note->status;

            // Atualiza o campo status
            if ($status == 1) {
                $note->status = 2;
            } else if ($status == 2) {
                $note->status = 1;
            }

            $note->save();

            return response()->json(['status' => 'success']);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
