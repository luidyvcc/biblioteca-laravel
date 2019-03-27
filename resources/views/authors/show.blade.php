@extends('layouts.app')

@section('content')

<div class="container">

        <h2>{{ $title ? $title : 'Erro no titulo' }}</h2>

    <div class="content-din">

        <div class="messenges"> @include('includes.alerts') </div>

        <ul>
            <li>Id: <strong>{{ $author->id }}</strong></li>
        </ul>

        <ul>
            <li>Nome: <strong>{{ $author->name }}</strong></li>
        </ul>


        <ul>
            <li>Sobrenome: <strong>{{ $author->surname }}</strong></li>
        </ul>

        @if(auth()->user()->role == 1000)
            <form action="{{ route('authors.destroy', $author->id) }}" method="POST">

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
