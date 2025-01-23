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

                        </div>
                        
                        <form action="{{ route('bank-accounts.store') }}" method="POST">
                            @csrf

                            @include('bank-accounts.form')

                            <button class="bg-blue-500 text-white py-1 px-2 mt-3 rounded">Adicionar</button>
                        </form>

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
