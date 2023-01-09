@extends('layouts.app')

@section('content')
<div class="container">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item"><a href="{{ route('todo.index') }}">Доски</a></li>
          <li class="breadcrumb-item active" aria-current="page">Разрещения для доски "{{ $board->name }}"</li>
        </ol>
    </nav>
    <div id="app" v-cloak> 
        <v-permissions></v-permissions>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const boardId = {{ $board->id }};
</script>
@endpush