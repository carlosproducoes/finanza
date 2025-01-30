<div class="mt-4">
    <x-input-label for="description" value="Descrição:" />

    <x-text-input id="description" class="block mt-1 w-full"
                    type="text"
                    name="description"
                    value="{{ old('description', $transaction->description ?? '') }}" />

    <x-input-error :messages="$errors->get('description')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="amount" value="Valor:" />

    <x-text-input id="amount" class="block mt-1 w-full"
                    type="number"
                    name="amount"
                    value="{{ old('amount', $transaction->amount ?? '') }}"
                    step="0.01" 
                    min="0"
                    required />

    <x-input-error :messages="$errors->get('amount')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="date" value="Data:" />

    <x-text-input id="date" class="block mt-1 w-full"
                    type="date"
                    name="date"
                    value="{{ old('date', $transaction->date ?? '') }}" 
                    required />

    <x-input-error :messages="$errors->get('date')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="category_id" value="Categoria:" />

    <select name="category_id" id="category_id" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full" required>
        <option value="" @if(empty(old('category_id', $transaction->category_id ?? ''))) selected @endif>Categoria</option>

        @foreach($categories as $category)
            <option value="{{ $category->id }}" @if(old('category_id', $transaction->category_id ?? '') == $category->id) selected @endif>{{ $category->name }}</option>
        @endforeach
    </select>

    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="bank_account" value="Conta:" />

    <select name="bank_account" id="bank_account" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full" required>
        <option value="" @if(empty(old('bank_account', $transaction->bank_account ?? ''))) selected @endif>Conta</option>

        @foreach($bankAccounts as $bankAccount)
            <option value="{{ $bankAccount->id }}" @if(old('bank_account', $transaction->bank_account_id ?? '') == $bankAccount->id) selected @endif>{{ $bankAccount->name }}</option>
        @endforeach
    </select>

    <x-input-error :messages="$errors->get('bank_account')" class="mt-2" />
</div>