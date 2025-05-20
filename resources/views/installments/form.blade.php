<div class="mt-4">
    <x-input-label for="description" value="Descrição:" />

    <x-text-input id="description" class="block mt-1 w-full"
                    type="text"
                    name="description"
                    value="{{ old('description', $installment->financialAccount->description . ' (' . $installment->number . '/' . $installment->financialAccount->total_installments . ')' ?? '') }}"
                    disabled />

    <x-input-error :messages="$errors->get('description')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="due_date" value="Data de Vencimento:" />

    <x-text-input id="due_date" class="block mt-1 w-full"
                    type="date"
                    name="due_date"
                    value="{{ old('due_date', $installment->due_date ?? '') }}" 
                    required />

    <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="projected_amount" value="Valor Projetado:" />

    <x-text-input id="projected_amount" class="block mt-1 w-full"
                    type="number"
                    name="projected_amount"
                    value="{{ old('projected_amount', $installment->projected_amount ?? '') }}"
                    step="0.01" 
                    min="0"
                    required />

    <x-input-error :messages="$errors->get('projected_amount')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="category" value="Categoria:" />

    <x-text-input id="category" class="block mt-1 w-full"
                    type="text"
                    name="category"
                    value="{{ old('category', $installment->financialAccount->category->name ?? '') }}" 
                    disabled />

    <x-input-error :messages="$errors->get('category')" class="mt-2" />
</div>