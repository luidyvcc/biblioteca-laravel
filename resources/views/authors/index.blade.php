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
            <a href="{{ route('authors.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i>
                Cadastrar
            </a>
        @endif
    </div>

    <br>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Nome</th>
                <th scope="col">Sobrenome</th>
                @if(auth()->user()->role == 1000)
                    <th scope="col"><i class="fas fa-cog"></i></th>
                @endif
            </tr>
        </thead>

        <tbody>

            @forelse ($authors as $author)
                <tr>

                    <td>
                        {{ $author->id }}
                    </td>

                    <td>
                        <a href="{{ route('authors.show', $author->id) }}" class="show">{{ $author->name }}</a>
                    </td>

                    <td>
                        {{ $author->surname }}
                    </td>

                    @if(auth()->user()->role == 1000)
                        <td>
                            {{-- Edit --}}
                            <a href="{{ route('authors.edit', $author->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                        </td>
                    @endif

                </tr>

            @empty
                <tr>
                    <td colspan="200">Nenhum cadastro!</td>
                </tr>
            @endforelse

        </tbody>

    </table>

    @if(isset($searchForm))
        {!! $authors->appends($searchForm)->links() !!}
    @else
        {!! $authors->links() !!}
    @endif

</div><!--Content Dinâmico-->

@endsection
