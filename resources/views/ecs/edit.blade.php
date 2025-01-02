@extends('layouts.app')

@section('content')
<div class="container mx-auto py-4">
    <h1 class="text-2xl font-bold mb-4">Modifier un EC</h1>
    <form action="{{ route('ecs.update', $ec->id) }}" method="POST" class="bg-white shadow-md rounded px-8 py-6">
        @csrf
        @method('PUT')
        @include('ecs.form')
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Mettre à jour</button>
    </form>
</div>
@endsection
