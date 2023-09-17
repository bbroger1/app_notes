<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Http\Requests\CategorieRequest;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $categories = Categorie::where('user_id', Auth::user()->id)
                ->paginate(10);
            return view('categories.index', compact(['categories']));
        } catch (\Throwable $e) {
            // Adiciona mensagem flash à sessão
            session()->flash('error', 'Sistema inoperante.');
            return view('categories.index', compact(['categories']));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $isEdit = false;
        return view('categories.create', compact(['isEdit']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategorieRequest $request)
    {
        try {
            $categorie = $request->validated();
            $categorie['user_id'] = Auth::user()->id;
            Categorie::create($categorie);

            // Adiciona mensagem flash à sessão
            session()->flash('success', 'Categoria criada com sucesso.');

            return redirect()->route('categories.index');
        } catch (\Throwable $e) {
            session()->flash('error', 'Categoria não pode ser criada.');
            return redirect()->route('categories.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function show(Categorie $category)
    {
        return view('categories.show', compact(['category']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function edit(Categorie $category)
    {
        $isEdit = true;
        return view('categories.create', compact(['isEdit', 'category']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function update(CategorieRequest $request, Categorie $category)
    {
        try {
            $data = $request->validated();
            $data['user_id'] = Auth::user()->id;
            $category->update($data);

            // Adiciona mensagem flash à sessão
            session()->flash('success', 'Categoria editada com sucesso.');

            return redirect()->route('categories.index');
        } catch (\Throwable $e) {
            session()->flash('error', 'Categoria não pode ser editada.');
            return redirect()->route('categories.create');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categorie $category)
    {
        try {
            $category->destroy($category->id);
            // Adiciona mensagem flash à sessão
            session()->flash('success', 'Categoria excluída com sucesso.');
            return redirect()->route('categories.index');
        } catch (\Throwable $e) {
            session()->flash('error', 'Categoria não excluída.');
            return redirect()->route('categories.index');
        }
    }
}
