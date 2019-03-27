@extends('layouts.app')

@section('content')

<div class="container">

        <h2>{{ $title ? $title : 'Erro no titulo' }}</h2>

    <div class="content-din">

        <div class="messenges"> @include('includes.alerts') </div>

        <ul>
            <li>Id: <strong>{{ $book->id }}</strong></li>
        </ul>

        <ul>
            <li>Titulo: <strong>{{ $book->title }}</strong></li>
        </ul>


        <ul>
            <li>Descrição: <strong>{{ $book->description }}</strong></li>
        </ul>


        <ul>
            <li>Autores: <strong>
                @forelse ($book->authors as $author) "{{ $author->name }}"
                @empty Não cadastrado
                @endforelse
            </strong></li>
        </ul>

        @if(auth()->user()->role == 1000)
            <form action="{{ route('books.destroy', $book->id) }}" method="POST">

                @method('DELETE')

                @csrf

                <div class="form-group">
                    <input type="submit" class="btn btn-danger btn-sm" value="Deletar">
                </div>
            </form>
        @endif

    </div><!--Content Dinâmico-->

</div>

@endsection
