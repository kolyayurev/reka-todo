@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @forelse ($boards as $board)
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    {{ $board->name }}
                </div>
                <div class="card-body">
                    <a href="{{ route('todo.board',$board->id) }}" class="btn btn-primary">Открыть</a>
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
