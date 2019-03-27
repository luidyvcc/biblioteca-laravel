<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    private $author;
    private $totalPage;

    public function __construct(Author $author)
    {
        $this->author = $author;
        $this->totalPage = 4;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Lista de autores';

        $authors = $this->author->paginate($this->totalPage);

        return view('authors.index', compact('title','authors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Novo autor';

        return view('authors.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $author = $this->author->create($data);

        return  $author ?
            redirect()->route('authors.index')->with('success', 'Sucesso ao cadastrar') :
            redirect()->back()->with('error', 'Falha ao cadastrar')->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $author = $this->author->find($id);

        if (!$author) return redirect()->back()->with('error', 'Falha ao exibir');

        $title = "Editar autor '{$author->name} {$author->surname}'";

        return view('authors.show', compact('title', 'author'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $author = $this->author->find($id);

        if (!$author) return redirect()->back()->with('error', 'Falha ao exibir');

        $title = "Editar autor '{$author->name} {$author->surname}'";

        return view('authors.edit', compact('title', 'author'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $author = $this->author->find($id);

        if (!$author) return redirect()->back()->with('error', 'Falha ao atualizar!');

        $update = $author->update($request->all());

        if($update){
            return redirect()
                ->route('authors.index')
                ->with('success', 'Atualizado com sucesso!');
        }else{
            return redirect()
                ->back()
                ->with('error', 'Falha ao atualizar!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = false;
        $author = $this->author->find($id);

        if($author){
            $author->books()->detach();
            $result = $author->delete();
        }

        return $result ?
            redirect()->route('authors.index')->with('success', 'Deletado com sucesso!') :
            redirect()->back()->with('error', 'Falha ao deletar')->withInput();
    }
}
