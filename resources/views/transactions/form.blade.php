<div class="mt-4">
    <x-input-label for="description" value="Descrição:" />

    <x-text-input id="description" class="block mt-1 w-full"
                    type="text"
                    name="description"
                    value="{{ old('description', $transaction->description ?? '') }}"
                    required />

    <x-input-error :messages="$errors->get('description')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="date" value="Data:" />

    <x-text-input id="date" class="block mt-1 w-full"
                    type="text"
                    name="date"
                    value="{{ old('date', $transaction->date ?? '') }}"
                    required />

    <x-input-error :messages="$errors->get('date')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="amount" value="Valor:" />

    <x-text-input id="amount" class="block mt-1 w-full"
                    type="text"
                    name="amount"
                    value="{{ old('amount', $transaction->amount ?? '') }}"
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
                @if(old('movement_type', $transaction->movement_type_id ?? '') == $movementType->id) selected @endif
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
                @if(old('bank_account', $transaction->bank_account_id ?? '') == $bankAccount->id) selected @endif
                >{{ $bankAccount->name }}</option>
        @endforeach
    </select>

    <x-input-error :messages="$errors->get('bank_account')" class="mt-2" />
</div>