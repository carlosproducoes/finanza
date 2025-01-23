<div class="mt-4">
    <x-input-label for="name" value="Nome:" />

    <x-text-input id="name" class="block mt-1 w-full"
                    type="text"
                    name="name"
                    value="{{ old('name', $bankAccount->name ?? '') }}"
                    required />

    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="balance" value="Saldo:" />

    <x-text-input id="balance" class="block mt-1 w-full"
                    type="number"
                    name="balance"
                    value="{{ old('balance', $bankAccount->balance ?? '') }}" 
                    step="0.01" 
                    min="0"
                    required />

    <x-input-error :messages="$errors->get('balance')" class="mt-2" />
</div>