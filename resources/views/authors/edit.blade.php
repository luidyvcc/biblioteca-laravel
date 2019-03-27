@extends('layouts.app')

@section('content')

<div class="container">

    <h2>{{ $title ? $title : 'Erro no titulo' }}</h2>


    <div class="content-din">

        @include('includes.errors')

        <form action="{{ route('authors.update', $author->id) }}" method="POST">

            @method('PUT')

            @csrf

            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" class="form-control" value="{{ $author->name }}">
            </div>

            <div class="form-group">
                <label for="surname">Sobrenome</label>
                <input type="text" name="surname" class="form-control" value="{{ $author->surname }}">
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-success btn-sm" value="Gravar">
            </div>

        </form>

    </div><!--Content Dinâmico-->

</div>

@endsection
