@extends('layouts.app')

@section('content')
<div class="container">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item active" aria-current="page">Доски</li>
        </ol>
    </nav>
    <h2> Мои доски</h2>
    <hr>
    <div class="row">
        @forelse ($boards as $board)
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    {{ $board->name }}
                </div>
                <div class="card-body">
                    <a href="{{ route('todo.board',$board->id) }}" class="btn btn-primary mb-1 me-1">Открыть</a>
                    <a href="{{ route('todo.board.permissions',$board->id) }}" class="btn btn-warning mb-1 me-1"><i class="bi bi-gear"></i> Разрешения</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-4">

        </div>
        @endforelse
      
    </div>
</div>
@endsection
