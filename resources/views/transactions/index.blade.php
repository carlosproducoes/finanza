<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Livro Caixa</h2>

        <a href="{{ route('transaction.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Adicionar Transação</a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg">

                <form action="{{ route('transaction.index') }}" method="POST">
                    @csrf

                    <div class="flex flex-col gap-2">
                        <div id="filters" class="rounded">

                            <x-text-input id="search" class=""
                                                type="text"
                                                name="search"
                                                value="{{ session('transactions_filters.search.value', old('search')) }}"
                                                placeholder="Busque por algo..." />


                            <x-text-input id="start_date" class=""
                                                type="text"
                                                name="start_date"
                                                value="{{ session('transactions_filters.start_date.value', old('start_date')) }}"
                                                placeholder="Data início" />

                            <x-text-input id="end_date" class=""
                                                type="text"
                                                name="end_date"
                                                value="{{ session('transactions_filters.end_date.value', old('end_date')) }}"
                                                placeholder="Data fim" />
                            
                            <select name="movement_type" id="movement_type" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="" class="border-gray-300 rounded-md shadow-sm">Tipo</option>

                                    @foreach($movementTypes as $movementType)
                                        <option value="{{ $movementType->id }}" class="border-gray-300 rounded-md shadow-sm" {{ session('transactions_filters.movement_type.input') == $movementType->id ? 'selected' : '' }}>
                                            @if($movementType->name == 'entry')
                                                Entrada
                                            @else
                                                Saída
                                            @endif
                                        </option>
                                    @endforeach
                            </select>

                            <select name="bank_account" id="bank_account" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="" class="border-gray-300 rounded-md shadow-sm">Conta</option>

                                    @foreach($bankAccounts as $bankAccount)
                                        <option value="{{ $bankAccount->id }}" class="border-gray-300 rounded-md shadow-sm" {{ session('transactions_filters.bank_account.input') == $bankAccount->id ? 'selected' : '' }}>{{ $bankAccount->name }}</option>
                                    @endforeach
                            </select>

                        </div>

                        <div class="flex justify-end">
                            <button class="bg-yellow-500 text-white px-4 py-2 rounded">Buscar</button>
                        </div>
                        
                    </div>

                </form>

                <div id="filters-activated" class="text-sm">
                    @if(!empty($filters))
                    
                        <div class="font-bold mb-1">Filtros ativos:</div>

                        <div class="flex gap-2">

                            @foreach($filters as $key => $filter)
                                <form action="{{ route('transaction.index') }}" method="POST">
                                    @csrf

                                    <input type="hidden" name="remove_filter" value="{{ $key }}"> 

                                    <div class="flex gap-2 px-4 py-2 bg-white text-gray-600 border-2 border-gray-300 rounded-full">
                                        <div>{{ $filter['name'] }}: {{ $filter['value'] }}</div>
                                        <button class="font-bold">X</button>
                                    </div>
                                </form>
                            @endforeach

                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-600">Descrição</th>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-600">Data</th>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-600">Valor</th>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-600">Tipo</th>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-600">Conta</th>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-600">Saldo</th>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-600">Ações</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white">
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td class="px-4 py-2 border-b text-gray-600">{{ $transaction->description }}</td>
                                        <td class="px-4 py-2 border-b text-gray-600">{{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}</td>
                                        <td class="px-4 py-2 border-b text-gray-600">{{ number_format($transaction->amount, 2, ',', '.') }}</td>
                                        <td class="px-4 py-2 border-b text-gray-600">
                                            @if($transaction->movementType->name == 'entry')
                                                <span class="inline-block px-3 py-1 text-white text-sm bg-green-500 rounded-full">Entrada</span>
                                            @else
                                                <span class="px-3 py-1 text-white text-sm bg-red-500 rounded-full">Saída</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2 border-b text-gray-600">{{ $transaction->bankAccount->name }}</td>
                                        <td class="px-4 py-2 border-b text-gray-600">{{ number_format($transaction->current_balance, 2, ',', '.') }}</td>
                                        <td class="px-4 py-2 border-b text-gray-600">
                                            <div class="flex gap-2">
                                                <a href="" class="px-3 py-1 rounded bg-blue-500 text-white">Editar</a>
                                                <form action="" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-3 py-1 rounded bg-red-500 text-white" onclick="return confirm('Tem certeza que deseja deletar?')">Deletar</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('#start_date').mask('00/00/0000')
            $('#end_date').mask('00/00/0000')
        })
    </script>
</x-app-layout>
