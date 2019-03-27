@extends('layouts.app')

@section('content')

<div class="container">

    <h2>{{ $title ? $title : 'Erro no titulo' }}</h2>


    <div class="content-din">

        @include('includes.errors')

        <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">

            @method('PUT')

            @csrf

            <div class="form-group">
                <label for="title">Titulo</label>
                <input type="text" name="title" class="form-control" value="{{ $book->title }}">
            </div>

            <div class="form-group">
                <label for="description">Descrção</label>
                <input type="text" name="description" class="form-control" value="{{ $book->description }}">
            </div>

            <div class="form-group">
                <label for="authors">Autores</label>
                <select name="authors[]" class="form-control selectpicker" multiple size="3" data-live-search="true" title="Categorias">
                    @foreach($authors as $author)
                        <option value="{{ $author->id }}" {{ in_array($author->id, $authors_book) ? "selected" : ""  }} >
                            {{ $author->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="image">Imagem</label>
                <input type="file" class="form-control-file" name="image">
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-success btn-sm" value="Gravar">
            </div>

        </form>

    </div><!--Content Dinâmico-->

</div>

@endsection
