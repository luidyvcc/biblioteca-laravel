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

    {{-- <div class="class-btn-insert">
        <a href="{{ route('lendings.create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus"></i>
            Cadastrar
        </a>
    </div> --}}

    <br>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Nº do emprestimo</th>
                <th scope="col">Nº do usuário</th>
                <th scope="col">Nome do usuário</th>
                <th scope="col">Quantidade de livros</th>
                <th scope="col">Data do emprestimo</th>
                <th scope="col">Data para entrega</th>
                <th scope="col">Data da entrega</th>
                <th scope="col">Entrega</th>
            </tr>
        </thead>

        <tbody>

            @forelse ($lendings as $lending)
                <tr>

                    <td>
                        {{ $lending->id }}
                    </td>

                    <td>
                        {{ $lending->user_id }}
                    </td>

                    <td>
                        {{ $lending->user->name }}
                    </td>

                    <td>
                        {{ $lending->books->count() }}
                    </td>

                    <td>
                        {{ $lending->date_start ? \Carbon\Carbon::parse($lending->date_start)->format('d/m/Y') : '' }}
                    </td>

                    <td>
                        {{ $lending->date_end ? \Carbon\Carbon::parse($lending->date_end)->format('d/m/Y') : '' }}
                    </td>

                    <td>
                        {{ $lending->date_finish ? \Carbon\Carbon::parse($lending->date_finish)->format('d/m/Y') : '' }}
                    </td>

                    <td>
                        @if(!$lending->date_finish)
                            @if(auth()->user()->id == $lending->user_id || auth()->user()->role == 1000)
                                <a href="{{ route('lendings.finish', $lending->id) }}" class="btn btn-success btn-sm" title="Entregar">
                                    {{-- <i class="fas fa-check-double"></i> --}}
                                    Devolder
                                </a>
                            @endif
                        @else
                            Finalizado
                        @endif
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
        {!! $lendings->appends($searchForm)->links() !!}
    @else
        {!! $lendings->links() !!}
    @endif

</div><!--Content Dinâmico-->

@endsection
