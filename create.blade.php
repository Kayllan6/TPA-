@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 px-4 py-10">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Criar novo evento</h1>

        <form action="{{ route('eventos.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="titulo" class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                <input
                    type="text"
                    name="titulo"
                    id="titulo"
                    value="{{ old('titulo') }}"
                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('titulo') border-red-500 @else border-gray-300 @enderror"
                >
                @error('titulo')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="descricao" class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
                <textarea
                    name="descricao"
                    id="descricao"
                    rows="5"
                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('descricao') border-red-500 @else border-gray-300 @enderror"
                >{{ old('descricao') }}</textarea>
                @error('descricao')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <button
                type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors"
            >
                Criar evento
            </button>
        </form>
    </div>
</div>
@endsection
