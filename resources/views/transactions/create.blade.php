<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Adicionar Transação</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">

                        <h2 class="text-center text-xl font-bold">Adicionar Transação</h2>
                        
                        <form action="{{ route('transaction.store') }}" method="POST" class="w-1/2 m-auto">
                            @csrf

                            @if ($errors->has('error'))
                                <div class="bg-red-500 text-white px-3 py-2 my-4 rounded">{{ $errors->get('error')[0] }}</div>
                            @endif

                            @include('transactions.form')

                            <button type="submit" class="mt-3 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Adicionar</button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('#date').mask('00/00/0000')
            $('#amount').mask('000.000.000.000.000,00', {
                reverse: true,
                placeholder: '0,00',
                onKeyPress: function(value, event, field, options) {
                    if (value.length < 3) {
                        field.val(',' + value)
                    }
                }
            });
        })
    </script>

</x-app-layout>