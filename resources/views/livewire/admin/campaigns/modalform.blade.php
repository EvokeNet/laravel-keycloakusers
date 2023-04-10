<x-dialog-modal wire:model="isModalOpen">
    <x-slot name="title">
        {{ __('Creating/editing campaign') }}
    </x-slot>

    <x-slot name="content">
        <form>
            <div class="">
                <div class="mb-4">
                    <x-label for="name" value="{{ __('Name') }}" />
                    <x-input id="name" type="text" wire:model.defer="name" />
                    <x-input-error for="name" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-label for="realm" value="{{ __('Realm') }}" />
                    <x-input id="realm" type="text" wire:model.defer="realm" />
                    <x-input-error for="realm" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-label for="client_id" value="{{ __('Client ID') }}" />
                    <x-input id="client_id" type="text" wire:model.defer="client_id" />
                    <x-input-error for="client_id" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-label for="client_secret" value="{{ __('Client Secret') }}" />
                    <x-input id="client_secret" type="text" wire:model.defer="client_secret" />
                    <x-input-error for="client_secret" class="mt-2" />
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

