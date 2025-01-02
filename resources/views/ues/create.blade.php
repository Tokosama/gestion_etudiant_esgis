@extends('layouts.app')

@section('content')
<div class="container mx-auto py-4">
    <h1 class="text-2xl font-bold mb-4">Créer une UE</h1>
    <form action="{{ route('ues.store') }}" method="POST" class="bg-white shadow-md rounded px-8 py-6">
        @csrf
        @include('ues.form')
    </form>
</div>
@endsection
