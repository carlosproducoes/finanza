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

                            <div class="mt-4">
                                <x-input-label for="description" value="Descrição:" />

                                <x-text-input id="description" class="block mt-1 w-full"
                                                type="text"
                                                name="description"
                                                value="{{ old('description') }}"
                                                required />

                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="date" value="Data:" />

                                <x-text-input id="date" class="block mt-1 w-full"
                                                type="text"
                                                name="date"
                                                value="{{ old('date') }}"
                                                required />

                                <x-input-error :messages="$errors->get('date')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="amount" value="Valor:" />

                                <x-text-input id="amount" class="block mt-1 w-full"
                                                type="text"
                                                name="amount"
                                                value="{{ old('amount') }}"
                                                required />

                                <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="movement_type" value="Tipo:" />

                                <select name="movement_type" id="movement_type" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full" required>
                                    <option value="" selected disabled></option>
                                    
                                    @foreach ($movementTypes as $movementType)
                                        <option
                                            value="{{ $movementType->id }}"
                                            @if(old('movement_type') == $movementType->id) selected @endif
                                            >{{ $movementType->name == 'entry' ? 'Entrada' : 'Saída' }}</option>
                                    @endforeach
                                </select>

                                <x-input-error :messages="$errors->get('movement_type')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="bank_account" value="Conta:" />

                                <select name="bank_account" id="bank_account" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full" required>
                                    <option value="" selected disabled></option>
                                    
                                    @foreach ($bankAccounts as $bankAccount)
                                        <option
                                            value="{{ $bankAccount->id }}"
                                            @if(old('bank_account') == $bankAccount->id) selected @endif
                                            >{{ $bankAccount->name }}</option>
                                    @endforeach
                                </select>

                                <x-input-error :messages="$errors->get('bank_account')" class="mt-2" />
                            </div>

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