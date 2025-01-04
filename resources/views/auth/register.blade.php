<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{ $errors }}

        <!-- Name -->
        <div>
            <x-input-label for="name" value="Nome:" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->first('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" value="E-mail:" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->first('email')" class="mt-2" />
        </div>

        <!-- Type of Use -->
        <div class="mt-4">
            <div class="block font-medium text-sm text-gray-700 dark:text-gray-300">Tipo de Uso:</div>

            <div class="flex gap-3">
                <div>
                    <input type="radio" name="type_of_use" id="personal" class=" font-medium text-sm" value="personal" required @if(old('type_of_use') == 'personal') checked @endif>
                    <label for="personal">Pessoal</label>
                </div>
                <div>
                    <input type="radio" name="type_of_use" id="business" class="font-medium text-sm" value="business" @if(old('type_of_use') == 'business') checked @endif>
                    <label for="business">Empresarial</label>
                </div>
            </div>
            <x-input-error :messages="$errors->first('type_of_use')" class="mt-2" />

            <div class="company_name_container mt-2 @if(old('type_of_use') == 'business') checked @else hidden @endif">
                <x-input-label for="company_name" value="Nome da Empresa:" />
                <x-text-input id="company_name" class="block mt-1 w-full"
                                type="text"
                                name="company_name"
                                value="{{ old('company_name') }}"/>
                <x-input-error :messages="$errors->first('company_name')" class="mt-2" />
            </div>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Senha:" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->first('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Confirmação da Senha" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->first('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                Já possui um cadastro?
            </a>

            <x-primary-button class="ms-4">
                Cadastrar
            </x-primary-button>
        </div>
    </form>

    <script>
        var typeOfUseInputs = document.querySelectorAll('input[name="type_of_use"]')
        var companyNameContainer = document.querySelector('.company_name_container')
        var companyNameInput = document.querySelector('#company_name')

        typeOfUseInputs.forEach(typeOfUseInput => {
            typeOfUseInput.addEventListener('change', function (event) {
                if (this.value == 'business') {
                    companyNameContainer.classList.remove('hidden')
                    companyNameInput.setAttribute('required', 'required')
                    return
                }

                companyNameContainer.classList.add('hidden')
                companyNameInput.removeAttribute('required')
            })
        })
    </script>
</x-guest-layout>
