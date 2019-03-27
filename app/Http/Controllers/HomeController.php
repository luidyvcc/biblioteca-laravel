<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Book;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Book $book)
    {
        $this->middleware('auth');
        $this->book = $book;
        $this->totalPage = 4;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = 'Lista de livros';

        $books = $this->book->paginate($this->totalPage);
        $authors = Author::get();

        return view('books.index', compact('title','books','authors'));
    }
}
