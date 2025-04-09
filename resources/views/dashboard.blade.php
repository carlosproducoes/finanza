<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-3 gap-3">
                        <x-financial-card title="Total de Entradas no Mês" :value="$totalEntryTransactions" class="bg-green-500 text-white" />
                        <x-financial-card title="Total de Saídas no Mês" :value="$totalExitTransactions" class="bg-red-500 text-white" />
                        <x-financial-card title="Saldo" :value="$balance" class="bg-yellow-500 text-white" />
                        <x-financial-card title="Total de Contas a Receber no Mês" :value="$totalEntryFinancialAccounts" class="bg-green-500 text-white" />
                        <x-financial-card title="Total de Contas a Pagar no Mês" :value="$totalExitFinancialAccounts" class="bg-red-500 text-white" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
