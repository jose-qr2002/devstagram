@extends('layout.app')

@section('title')
    Pagina Principal
@endsection

@section('content')

    <x-listar-post :posts="$posts"/>
    {{-- 
        @forelse ($posts as $post)
        <h1>{{ $post->titulo }}</h1>
        @empty
        <p>No hay posts</p>
        @endforelse
    --}}
@endsection