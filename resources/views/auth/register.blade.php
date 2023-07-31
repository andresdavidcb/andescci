<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" class="block w-full mt-1" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block w-full mt-1" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-jet-input id="password_confirmation" class="block w-full mt-1" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

                <div class="mt-4">
                    <x-jet-label for="is_admin">
                        <div class="flex items-center">
                            <x-jet-checkbox name="is_admin" id="is_admin" value="1"/>

                            <div class="ml-2">
                                {{ __('Usuario Administrador?') }}
                            </div>
                        </div>
                    </x-jet-label>
                </div>

                <div class="mt-4">
                    <x-jet-label for="is_empresa">
                        <div class="flex items-center">
                            <x-jet-checkbox name="is_empresa" id="is_empresa" value="1"/>

                            <div class="ml-2">
                                {{ __('Usuario Empresa?') }}
                            </div>
                        </div>
                    </x-jet-label>
                </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button class="ml-4">
                    {{ __('Register') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
