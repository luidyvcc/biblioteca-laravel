<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    private $book;
    private $totalPage;
    private $path;

    public function __construct(Book $book)
    {
        $this->book = $book;
        $this->totalPage = 4;
        $this->path = 'images/books';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Lista de livros';

        $books = $this->book->paginate($this->totalPage);

        $authors = Author::get();

        return view('books.index', compact('title','books','authors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Novo livro';

        $authors = Author::all();

        return view('books.create', compact('title', 'authors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nameFile = 'genericBook.jpg';

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $nameFile = uniqid(date('HisYmd')).'.'.$request->image->extension();
            if (!$request->image->storeAs('books', $nameFile)){
                return redirect()->back()->with('error', 'Falha ao fazer upload')->withInput();
            }else{
                $request->file('image')->move($this->path, $nameFile);
            }
        }

        $data = $request->all();
        $data['image'] = $nameFile;

        $book = $this->book->create($data);

        $book->authors()->attach($request->input('authors'));

        return  $book ?
            redirect()->route('books.index')->with('success', 'Sucesso ao cadastrar') :
            redirect()->back()->with('error', 'Falha ao cadastrar')->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = $this->book->with('authors')->find($id);

        if (!$book) return redirect()->back();

        $title = "Editar livro '{$book->title}'";

        return view('books.show', compact('title', 'book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = $this->book->find($id);

        if (!$book) return redirect()->back();

        $title = "Editar {$book->title}";

        $authors = Author::all();

        $authors_book = $book->authors()->pluck('id')->all();

        return view('books.edit', compact('title', 'book', 'authors', 'authors_book'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $book = $this->book->find($id);
        if (!$book) return redirect()->back()->with('error', 'Falha ao atualizar!');

        $nameFile = 'genericBook.jpg';

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $nameFile = uniqid(date('HisYmd')).'.'.$request->image->extension();
            if (!$request->image->storeAs('books', $nameFile)){
                return redirect()->back()->with('error', 'Falha ao fazer upload')->withInput();
            }else{
                $request->file('image')->move($this->path, $nameFile);
            }
        }

        $data = $request->all();
        $data['image'] = $nameFile;

        $update = $book->update($data);

        if($update){
            $book->authors()->sync($request->input('authors'));
            return redirect()
                ->route('books.index')
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
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = $this->book->find($id);

        if($book){
            // $images = BookImage::where('product_id', $book->id)->get();
            // if(!empty($images)){
            //     foreach ($images as $row) {
            //         if(file_exists($this->path . '/' . $row->image)){
            //             unlink($this->path . '/' . $row->image);
            //         }
            //     }
            // }
            $book->authors()->detach();
            //$book->images()->delete();
            $result = $book->delete();
        }

        return redirect()->route('books.index')->with('success', 'Livro deletado com sucesso!');
    }

    public function addCart($id)
    {
        if(!session()->has('cart')) session(['cart' => []]);

        if(!in_array($id, session('cart'))) session()->push('cart', $id);

        return redirect()->back();
    }

    public function rmCart($id)
    {

        if(in_array($id, session('cart'))){
            $key = array_search($id, session('cart'));
            $cart = session()->pull('cart');
            unset($cart[$key]);
            session(['cart' => $cart]);
        }

        return (!in_array($id, session('cart'))) ?
            redirect()
                ->route('books.openCart')
                ->with('success', 'Livro removido do carrinho!'):
            redirect()
                ->back()
                ->with('error', 'Falha ao remover livro!');
    }

    public function openCart()
    {
        $books_cart = null;
        $authors = null;

        $title = "Reservas para emprestimo";

        if(session()->has('cart')){
            $books_cart = Book::whereIn('id', session('cart'))->get();
            $authors = Author::get();
        }

        return view('cart.index', compact('books_cart','title','authors'));
    }

}
