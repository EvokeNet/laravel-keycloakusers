<x-dialog-modal wire:model="isModalOpen">
    <x-slot name="title">
        {{ __('Creating/editing group') }}
    </x-slot>

    <x-slot name="content">
        <form>
            <div class="">
                <div class="mb-4">
                    <x-label for="name" value="{{ __('Name') }}" />
                    <x-input id="name" type="text" wire:model.defer="name" />
                    <x-input-error for="name" class="mt-2" />
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
