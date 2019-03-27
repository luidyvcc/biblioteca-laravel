@extends('layouts.app')

@section('content')

<div class="container">

    <h2>{{ $title ? $title : 'Erro no titulo' }}</h2>


    <div class="content-din">

        @include('includes.errors')

        <form action="{{ route('authors.store') }}" method="POST">

            {{ csrf_field() }}

            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" class="form-control">
            </div>

            <div class="form-group">
                <label for="surname">Sobrenome</label>
                <input type="text" name="surname" class="form-control">
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-success btn-sm" value="Gravar">
            </div>

        </form>

    </div><!--Content Dinâmico-->

</div>

@endsection
