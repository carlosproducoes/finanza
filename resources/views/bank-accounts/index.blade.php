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
                            <a href="{{ route('bank-accounts.create') }}" class="bg-blue-500 text-white py-1 px-2 rounded">Adicionar Conta</a>
                        </div>

                        @if(!empty($success))
                            <div class="bg-green-500 text-white py-1 px-2 rounded">{{ $success }}</div>
                        @endif
                        
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-600">Nome</th>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-600">Saldo</th>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-600">Ações</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white">
                                @foreach($bankAccounts as $bankAccount)
                                    <tr>
                                        <th class="px-4 py-2 border-b text-gray-600 text-left">{{ $bankAccount->name }}</th>
                                        <th class="px-4 py-2 border-b text-gray-600 text-left">{{ $bankAccount->balance }}</th>
                                        <th class="px-4 py-2 border-b text-gray-600 text-left">
                                            <div class="flex gap-2">
                                                <a href="{{ route('bank-accounts.edit', $bankAccount->id) }}" class="bg-yellow-500 text-white py-1 px-2 rounded">Editar</a>
                                                <form action="{{ route('bank-accounts.destroy', $bankAccount->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="bg-red-500 text-white py-1 px-2 rounded"
                                                            onclick="event.preventDefault(); if (confirm('Tem certeza que quer deletar essa conta?')) { this.form.submit() }">Deletar</button>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('#start_date').mask('00/00/0000')
            $('#end_date').mask('00/00/0000')
        })
    </script>
</x-app-layout>
