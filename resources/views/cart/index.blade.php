@extends('layouts.app')

@section('content')

<div class="container">
    <h2>{{ $title }}</h2>

    <div class="messenges"> @include('includes.alerts') </div>

    <div>

        <form action="{{ route('lendings.store') }}" method="POST">
            @csrf
            <input type="submit" value="Emprestar" class="btn btn-success btn-sm">
        </form>

    </div>

    <br>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Titulo</th>
                <th scope="col">Descrição</th>
                <th scope="col">Autor</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>

        <tbody>

            @forelse ($books_cart as $book_cart)
                <tr>
                    <td>
                        <a href="{{ route('books.show', $book_cart->id) }}" class="show">{{ $book_cart->title }}</a>
                    </td>
                    <td>
                        {{ $book_cart->description }}
                    </td>
                    <td>
                        @forelse ($authors as $author)
                            {{ $author->name }}
                        @empty
                            Não cadastrado
                        @endforelse
                    </td>
                    <td>
                        <a href="{{ route('books.rmCart', $book_cart->id) }}" class="btn btn-danger btn-sm">
                            Remover
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="200">Carrinho vazio!</td>
                </tr>
            @endforelse

        </tbody>

    </table>

    {{-- @if(isset($searchForm))
        {!! $books->appends($searchForm)->links() !!}
    @else
        {!! $books->links() !!}
    @endif --}}

</div><!--Content Dinâmico-->

@endsection
