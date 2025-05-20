<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Adicionar Conta a @if($movementType == 'entry') Receber @else Pagar @endif</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">

                        <div class="flex mb-4">

                        </div>
                        
                        <form action="{{ route('financial-accounts.store') }}" method="POST">
                            @csrf

                            <input type="hidden" name="movement_type" value="{{ $movementType }}">

                            @include('financial-accounts.form')

                            <div class="mt-4">
                                <x-input-label for="is_installment" value="É parcelado:" />

                                <input id="is_installment"
                                                type="checkbox"
                                                name="is_installment"
                                                @if(old('is_installment') == 'on') checked @endif />

                                <x-input-error :messages="$errors->get('is_installment')" class="mt-2" />
                            </div>

                            <div class="mt-4 @if(old('is_installment') != 'on') hidden @endif">
                                <x-input-label for="number_installments" value="Número de parcelas:" />

                                <x-text-input id="number_installments" class="block mt-1 w-full"
                                                type="number"
                                                name="number_installments"
                                                value="{{ old('number_installments') }}"
                                                step="1" 
                                                min="1"
                                                :disabled="old('is_installment') != 'on'" />

                                <x-input-error :messages="$errors->get('number_installments')" class="mt-2" />
                            </div>

                            <button class="bg-blue-500 text-white py-1 px-2 mt-3 rounded">Adicionar</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        @vite(['resources/js/financial-accounts/create.js'])
    @endpush

</x-app-layout>
