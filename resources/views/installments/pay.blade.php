<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Confirmar Conta</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">

                        <div class="flex mb-4">

                        </div>
                        
                        <form action="{{ route('installments.process', $installment->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mt-4">
                                <x-input-label for="description" value="Descrição:" />

                                <x-text-input id="description" class="block mt-1 w-full"
                                                type="description"
                                                name="description"
                                                value="{{ old('description', $installment->financialAccount->description ?? '') }}" 
                                                disabled />

                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="payment_date" value="Data de Pagamento:" />

                                <x-text-input id="payment_date" class="block mt-1 w-full"
                                                type="date"
                                                name="payment_date"
                                                value="{{ old('payment_date', $installment->payment_date ?? '') }}" 
                                                required />

                                <x-input-error :messages="$errors->get('payment_date')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="paid_amount" value="Valor Pago:" />

                                <x-text-input id="paid_amount" class="block mt-1 w-full"
                                                type="number"
                                                name="paid_amount"
                                                value="{{ old('paid_amount', $installment->paid_amount ?? '') }}"
                                                step="0.01" 
                                                min="0"
                                                required />

                                <x-input-error :messages="$errors->get('paid_amount')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="bank_account" value="Conta:" />

                                <select name="bank_account" id="bank_account" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full" required>
                                    <option value="" @if(empty(old('bank_account'))) selected @endif>Conta</option>

                                    @foreach($bankAccounts as $bankAccount)
                                        <option value="{{ $bankAccount->id }}" @if(old('bank_account') == $bankAccount->id) selected @endif>{{ $bankAccount->name }}</option>
                                    @endforeach
                                </select>

                                <x-input-error :messages="$errors->get('bank_account')" class="mt-2" />
                            </div>

                            <button class="bg-blue-500 text-white py-1 px-2 mt-3 rounded">Confirmar</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
