<section class="space-y-6">
    <div>
        <h2 class="text-lg font-medium text-gray-900">
            Видалення акаунту
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Якщо ви видалите акаунт всі ваші дані будуть видалені.
        </p>
    </div>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >Видалити акаунт</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                Ви впевнені що хочите видалити акаунт?
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Якщо ви видалите акаунт всі ваші дані буде знищено. Будь-ласка введіть пароль для видалення акаунту.
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="Пароль" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Відмінити
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    Видалити акаунт
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
