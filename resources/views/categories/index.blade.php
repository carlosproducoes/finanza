<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Contas</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">

                        <div class="flex mb-4">
                            <a href="{{ route('categories.create') }}" class="bg-blue-500 text-white py-1 px-3 rounded">Adicionar Categoria</a>
                        </div>
                        
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-600">Nome</th>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-600">Tipo</th>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-600">Ações</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white">
                                @foreach($categories as $category)
                                    <tr>
                                        <th class="px-4 py-2 border-b text-gray-600 text-left">{{ $category->name }}</th>
                                        <th class="px-4 py-2 border-b text-gray-600 text-left">
                                            <div class="inline @if($category->movement_type == 'entry') bg-green-500 @else bg-red-500 @endif text-white text-md w-auto py-1 px-3 rounded-full">
                                                {{ $category->movement_type == 'entry' ? 'Entrada' : 'Saída' }}
                                            </div>
                                        </th>
                                        <th class="px-4 py-2 border-b text-gray-600 text-left">
                                            <div class="flex gap-2">
                                                <a href="{{ route('categories.edit', $category->id) }}" class="bg-yellow-500 text-white py-1 px-2 rounded">Editar</a>
                                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="bg-red-500 text-white py-1 px-2 rounded"
                                                            onclick="event.preventDefault(); if (confirm('Tem certeza que quer deletar essa categoria?')) { this.form.submit() }">Deletar</button>
                                                </form>
                                            </div>
                                        </th>                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
