<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Livro Caixa
        </h2>
    </x-slot>

    <div class="py-12">
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
                                                <span class="inline-block px-2 py-1 text-white text-sm bg-green-500 rounded">Entrada</span>
                                            @else
                                                <span class="px-2 py-1 text-white text-sm bg-red-500 rounded">Saída</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2 border-b text-gray-600">{{ $transaction->bankAccount->name }}</td>
                                        <td class="px-4 py-2 border-b text-gray-600">{{ number_format($transaction->current_balance, 2, ',', '.') }}</td>                                        
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
