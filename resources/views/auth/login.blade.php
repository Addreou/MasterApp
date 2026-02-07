<x-guest-layout>
    <div class="flex items-center justify-center min-h-screen px-2">
        <div class="flex flex-col items-center gap-4 p-4
            border rounded-lg
            shadow-2xl
            bg-custom-primary">
            <section class="w-full pb-2 show-custom-devices
            border-separated border-b-2 border-gray-200 ">
                <x-application-logo />
            </section>
            <section class="flex flex-col items-center">
                <span class="font-bold text-xl show-custom-devices">{{ Str::title( __('login.signIn'))}}</span>
                <span class="font-bold text-xl hide-custom-devices">{{ config('app.name') }}</span>
                <span class="font-light text-base">{{ __('login.message') }}</span>
                <form x-data="{ email: '', password: '', loading: false }"
                x-on:submit="loading = true"
                method="post" action="{{ route('login') }}"
                class="flex flex-col w-full mt-4 gap-4" novalidate>
                    @csrf
                    <x-alerts.alert
                        :show="$errors->has('failed')"
                        position="top-right"
                        category="error"
                        title="Error"
                        description="Ocurrió un error inesperado."
                        :showActions="false"
                        acceptText=""
                        cancelText=""
                        errorKey="failed"
                        :autoDismiss="true"
                    />
                    <x-forms.generic-error for="failed" :autoDismiss="true"></x-forms.generic-error>
                    <div class="flex flex-col">
                        <x-forms.label for="email" :value="__('login.email')" :icon="'fa-solid fa-envelope'" class="flex justify-between" />
                        <x-forms.input type="email" x-model="email" id="email" name="email" placeholder="{{ __('login.email') }}" autocomplete="on" autoDismiss="true"/>
                    </div>
                    <div x-data="{ isPasswordShow: false }"
                        class="flex flex-col">
                        <x-forms.label for="password" :value="__('login.password')" :icon="'fa-solid fa-key'" class="flex justify-between" />
                        <x-forms.input x-bind:type="isPasswordShow ? 'text' : 'password'" x-model="password" id="password" name="password" placeholder="{{ __('login.password') }}" autoDismiss="true"/>
                        <div class="flex items-center gap-2 mt-2 w-fit">
                            <x-forms.checkbox x-model="isPasswordShow"
                            id="showPassword" name="showPassword" class="mt-2"
                            class="cursor-pointer"/>
                            <x-forms.label for="showPassword" class="cursor-pointer opacity-70 select-none">
                                <span x-text="isPasswordShow ? '{{ __('login.hide_password') }}' : '{{ __('login.show_password') }}'"></span>
                                <i :class="isPasswordShow ? 'fa-solid fa-eye-slash fa-sm' : 'fa-solid fa-eye fa-sm'"></i>
                            </x-forms.label>
                        </div>
                    </div>
                    <x-forms.button class="btn-custom-success" :type="'submit'"
                    x-bind:disabled="!email || !password">
                        {{ Str::title( __('login.signIn')) }}
                    </x-forms.button>
                    <div class="flex justify-end">
                        <x-general.nav-link href="#" class="text-base" active>{{ __('login.forgot_password') }}</x-general.nav-link>
                    </div>
                </form>
            </section>
        </div>
    </div>
</x-guest-layout>
