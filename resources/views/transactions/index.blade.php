<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Transações</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">

                        <div class="mb-4">
                            <x-dropdown align="left">
                                <x-slot name="trigger">
                                    <button class="bg-blue-500 text-white py-1 px-3 rounded">Adicionar Transação</button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('transactions.create', 'entry')">Entrada</x-dropdown-link>
                                    <x-dropdown-link :href="route('transactions.create', 'exit')">Saída</x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                        
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-center font-semibold text-gray-600">Descrição</th>
                                    <th class="px-4 py-2 text-center font-semibold text-gray-600">Valor</th>
                                    <th class="px-4 py-2 text-center font-semibold text-gray-600">Data</th>
                                    <th class="px-4 py-2 text-center font-semibold text-gray-600">Tipo</th>
                                    <th class="px-4 py-2 text-center font-semibold text-gray-600">Categoria</th>
                                    <th class="px-4 py-2 text-center font-semibold text-gray-600">Conta</th>
                                    <th class="px-4 py-2 text-center font-semibold text-gray-600">Ações</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white">
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <th class="px-4 py-2 border-b text-gray-600 text-left">{{ $transaction->description }}</th>
                                        <th class="px-4 py-2 border-b text-gray-600 text-left">{{ $transaction->amount }}</th>
                                        <th class="px-4 py-2 border-b text-gray-600 text-left">{{ $transaction->date }}</th>
                                        <th class="px-4 py-2 border-b text-gray-600 text-center">
                                            <div class="inline @if($transaction->movement_type == 'entry') bg-green-500 @else bg-red-500 @endif text-white text-md w-auto py-1 px-3 rounded-full">
                                                {{ $transaction->movement_type == 'entry' ? 'Entrada' : 'Saída' }}
                                            </div>
                                        </th>
                                        <th class="px-4 py-2 border-b text-gray-600 text-left">{{ $transaction->category->name }}</th>
                                        <th class="px-4 py-2 border-b text-gray-600 text-left">{{ $transaction->bankAccount->name }}</th>
                                        <th class="px-4 py-2 border-b text-gray-600 text-left">
                                            <div class="flex gap-2">
                                                <a href="{{ route('transactions.edit', $transaction->id) }}" class="bg-yellow-500 text-white py-1 px-2 rounded">Editar</a>
                                                <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="bg-red-500 text-white py-1 px-2 rounded"
                                                            onclick="event.preventDefault(); if (confirm('Tem certeza que quer deletar essa transação?')) { this.form.submit() }">Deletar</button>
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
