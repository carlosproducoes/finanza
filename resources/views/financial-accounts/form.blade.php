<div class="mt-4">
    <x-input-label for="description" value="Descrição:" />

    <x-text-input id="description" class="block mt-1 w-full"
                    type="text"
                    name="description"
                    value="{{ old('description', $financialAccount->description ?? '') }}" />

    <x-input-error :messages="$errors->get('description')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="due_date" value="Data de Vencimento:" />

    <x-text-input id="due_date" class="block mt-1 w-full"
                    type="date"
                    name="due_date"
                    value="{{ old('due_date', $financialAccount->due_date ?? '') }}" 
                    required />

    <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="projected_amount" value="Valor Projetado:" />

    <x-text-input id="projected_amount" class="block mt-1 w-full"
                    type="number"
                    name="projected_amount"
                    value="{{ old('projected_amount', $financialAccount->projected_amount ?? '') }}"
                    step="0.01" 
                    min="0"
                    required />

    <x-input-error :messages="$errors->get('projected_amount')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="category_id" value="Categoria:" />

    <select name="category_id" id="category_id" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full" required>
        <option value="" @if(empty(old('category_id', $financialAccount->category_id ?? ''))) selected @endif>Categoria</option>

        @foreach($categories as $category)
            <option value="{{ $category->id }}" @if($financialAccount->category_id == $category->id) selected @endif>{{ $category->name }}</option>
        @endforeach
    </select>

    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
</div>