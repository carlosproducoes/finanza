<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Contas a Pagar/Receber</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">

                        <div class="mb-4">
                            <div class="flex justify-between items-center px-3 py-2 mb-3">
                                <a href="{{ route('financial-accounts.index', ['date' => \Carbon\Carbon::createFromFormat('m-Y', $date)->subMonth()->format('m-Y')]) }}" class="text-xl"><</a>
                                    <h2 class="text-xl font-bold">{{ ucfirst(\Carbon\Carbon::createFromFormat('m-Y', $date)->monthName) }}</h2>
                                <a href="{{ route('financial-accounts.index', ['date' => \Carbon\Carbon::createFromFormat('m-Y', $date)->addMonth()->format('m-Y')]) }}" class="text-xl">></a>
                            </div>
                            
                            <x-dropdown align="left">
                                <x-slot name="trigger">
                                    <button class="bg-blue-500 text-white py-1 px-3 rounded">Adicionar Conta</button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('financial-accounts.create', 'exit')">A Pagar</x-dropdown-link>
                                    <x-dropdown-link :href="route('financial-accounts.create', 'entry')">A Receber</x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                        
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-center font-semibold text-gray-600">Descrição</th>
                                    <th class="px-4 py-2 text-center font-semibold text-gray-600">Data de Vencimento</th>
                                    <th class="px-4 py-2 text-center font-semibold text-gray-600">Data de Pagamento</th>
                                    <th class="px-4 py-2 text-center font-semibold text-gray-600">Valor Projetado</th>
                                    <th class="px-4 py-2 text-center font-semibold text-gray-600">Valor Pago</th>
                                    <th class="px-4 py-2 text-center font-semibold text-gray-600">Tipo</th>
                                    <th class="px-4 py-2 text-center font-semibold text-gray-600">Status</th>
                                    <th class="px-4 py-2 text-center font-semibold text-gray-600">Categoria</th>
                                    <th class="px-4 py-2 text-center font-semibold text-gray-600">Ações</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white">
                                @foreach($financialAccounts as $financialAccount)
                                    <tr>
                                        <th class="px-4 py-2 border-b text-gray-600 text-left">{{ $financialAccount->description }}</th>
                                        <th class="px-4 py-2 border-b text-gray-600 text-left">{{ $financialAccount->due_date }}</th>
                                        <th class="px-4 py-2 border-b text-gray-600 text-left">{{ $financialAccount->payment_date }}</th>
                                        <th class="px-4 py-2 border-b text-gray-600 text-left">{{ $financialAccount->projected_amount }}</th>
                                        <th class="px-4 py-2 border-b text-gray-600 text-left">{{ $financialAccount->paid_amount }}</th>
                                        <th class="px-4 py-2 border-b text-gray-600 text-center">
                                            <div class="inline @if($financialAccount->movement_type == 'entry') bg-green-500 @else bg-red-500 @endif text-white text-md w-auto py-1 px-3 rounded-full">
                                                {{ $financialAccount->movement_type == 'entry' ? 'Entrada' : 'Saída' }}
                                            </div>
                                        </th>
                                        <th class="px-4 py-2 border-b text-gray-600 text-center">
                                            @if($financialAccount->status == 'pending')
                                                <div class="inline bg-yellow-500 text-white text-md w-auto py-1 px-3 rounded-full">Pendente</div>
                                            @elseif($financialAccount->status = 'paid')
                                                <div class="inline bg-green-500 text-white text-md w-auto py-1 px-3 rounded-full">Paga</div>
                                            @elseif($financialAccount->status = 'overdue')
                                                <div class="inline bg-red-500 text-white text-md w-auto py-1 px-3 rounded-full">Atrasada</div>
                                            @endif
                                        </th>
                                        <th class="px-4 py-2 border-b text-gray-600 text-left">{{ $financialAccount->category }}</th>
                                        <th class="px-4 py-2 border-b text-gray-600 text-left">
                                            <div class="flex gap-2">
                                                @switch ($financialAccount->type)
                                                    @case ('financial_account')
                                                        @if($financialAccount->status != 'paid')
                                                            <a href="{{ route('financial-accounts.pay', ['financialAccount' => $financialAccount->id]) }}" class="bg-green-500 text-white py-1 px-2 rounded">Confirmar</a>
                                                            <a href="{{ route('financial-accounts.edit', $financialAccount->id) }}" class="bg-yellow-500 text-white py-1 px-2 rounded">Editar</a>
                                                            <form action="{{ route('financial-accounts.destroy', $financialAccount->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="bg-red-500 text-white py-1 px-2 rounded"
                                                                        onclick="event.preventDefault(); if (confirm('Tem certeza que quer deletar essa conta?')) { this.form.submit() }">Deletar</button>
                                                            </form>
                                                        @endif
                                                        @break
                                                    @case ('installment')
                                                        @if($financialAccount->status != 'paid')
                                                            <a href="{{ route('installments.pay', $financialAccount->id) }}" class="bg-green-500 text-white py-1 px-2 rounded">Confirmar</a>
                                                            <a href="{{ route('installments.edit', $financialAccount->id) }}" class="bg-yellow-500 text-white py-1 px-2 rounded">Editar</a>
                                                            <form action="{{ route('installments.destroy', $financialAccount->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="bg-red-500 text-white py-1 px-2 rounded"
                                                                        onclick="event.preventDefault(); if (confirm('Tem certeza que quer deletar essa parcela?')) { this.form.submit() }">Deletar</button>
                                                            </form>
                                                        @endif
                                                        @break
                                                @endswitch
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
