<div class="mt-4">
    <x-input-label for="name" value="Nome:" />

    <x-text-input id="name" class="block mt-1 w-full"
                    type="text"
                    name="name"
                    value="{{ old('name', $category->name ?? '') }}"
                    required />

    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="type" value="Tipo:" />

    <select name="movement_type" id="movement_type" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full" @if(isset($category)) disabled @endif>
        <option value="" @if(empty(old('movement_type', $category->movement_type ?? ''))) selected @endif>Tipo</option>
        <option value="entry" @if(old('movement_type', $category->movement_type ?? '') == 'entry') selected @endif>Entrada</option>
        <option value="exit" @if(old('movement_type', $category->movement_type ?? '') == 'exit') selected @endif>Saída</option>
    </select>

    <x-input-error :messages="$errors->get('movement_type')" class="mt-2" />
</div>