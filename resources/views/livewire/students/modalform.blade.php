<x-dialog-modal wire:model="isModalOpen">
    <x-slot name="title">
        {{ __('Creating/editing student') }}
    </x-slot>

    <x-slot name="content">
        <form>
            <div class="">
                <div class="mb-4">
                    <x-label for="firstname" value="{{ __('First name') }}" />
                    <x-input id="firstname" type="text" wire:model.defer="firstname" />
                    <x-input-error for="firstname" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-label for="lastname" value="{{ __('Last name') }}" />
                    <x-input id="lastname" type="text" wire:model.defer="lastname" />
                    <x-input-error for="lastname" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" type="text" wire:model.defer="email" />
                    <x-input-error for="email" class="mt-2" />
                </div>
                <div class="mb-4">
                    <label for="groupInput" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Group') }}:</label>
                    <x-form.select :options="$groups" :selected="$group" id="groupInput" class="mt-1 block w-full" wire:model.defer="group" />
                    @error('group') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
            </div>
        </form>
    </x-slot>

    <x-slot name="footer">
        <x-secondary-button wire:click="closeModal()">
            {{ __('Cancel') }}
        </x-secondary-button>

        <x-button wire:click.prevent="store()" class="ml-2">
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-dialog-modal>
