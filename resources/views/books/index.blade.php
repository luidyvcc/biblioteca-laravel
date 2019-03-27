@extends('layouts.app')

@section('content')

<div class="container">

    <h2>{{ $title ? $title : 'Erro no titulo' }}</h2>

    <div class="messenges">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
    </div>

    <div class="class-btn-insert">
        @if(auth()->user()->role == 1000)
            <a href="{{ route('books.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i>
                Cadastrar
            </a>
        @endif
    </div>

    <br>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Imagem</th>
                <th scope="col">Titulo</th>
                <th scope="col">Descrição</th>
                {{-- <th scope="col">Autor</th> --}}
                <th scope="col">Ações</th>
            </tr>
        </thead>

        <tbody>

            @forelse ($books as $book)
                <tr>
                    <td class="center"  width="10%">
                        <img src="/images/books/{{ $book->image ? $book->image : 'genericBook.jpg' }}" width="50%" />
                    </td>
                    <td>
                        <a href="{{ route('books.show', $book->id) }}" class="show">{{ $book->title }}</a>
                    </td>
                    <td>
                        {{ $book->description }}
                    </td>
                    {{-- <td>
                        @forelse ($authors as $author)
                            {{ $author->name }}
                        @empty
                            Não cadastrado
                        @endforelse
                    </td> --}}
                    <td>
                        @if(auth()->user()->role == 1000)
                            {{-- Edit --}}
                            <a href="{{ route('books.edit', $book->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                        @endif

                        <a href="{{ route('books.addCart', $book->id) }}" class="btn btn-success btn-sm">
                                <i class="fas fa-cart-plus  "></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="200">Nenhum cadastro!</td>
                </tr>
            @endforelse

        </tbody>

    </table>

    @if(isset($searchForm))
        {!! $books->appends($searchForm)->links() !!}
    @else
        {!! $books->links() !!}
    @endif

</div><!--Content Dinâmico-->

@endsection
