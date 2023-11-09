<x-dialog-modal wire:model="isModalOpen">
    <x-slot name="title">
        {{ __('Creating/editing campaign') }}
    </x-slot>

    <x-slot name="content">
        <form>
            <div class="mb-4">
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" type="text" wire:model.defer="name" />
                <x-input-error for="name" class="mt-2" />
            </div>

            <h2 class="mb-4 text-lg border-b">Keycloak settings</h2>
            <div class="mb-4 grid grid-cols-3 gap-4">
                <div>
                    <x-label for="realm" value="{{ __('Realm') }}" />
                    <x-input id="realm" type="text" wire:model.defer="realm" />
                    <x-input-error for="realm" class="mt-2" />
                </div>
                <div>
                    <x-label for="client_id" value="{{ __('Client ID') }}" />
                    <x-input id="client_id" type="text" wire:model.defer="client_id" />
                    <x-input-error for="client_id" class="mt-2" />
                </div>
                <div>
                    <x-label for="client_secret" value="{{ __('Client Secret') }}" />
                    <x-input id="client_secret" type="text" wire:model.defer="client_secret" />
                    <x-input-error for="client_secret" class="mt-2" />
                </div>
            </div>

            <h2 class="mb-4 text-lg border-b">Moodle settings</h2>

            <div class="mb-4 w-full">
                <label for="courseInput" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Create a new course in Moodle?') }}:</label>
                <select name="newcourse" id="courseInput" wire:model="newcourse" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block text-gray-700 text-sm font-bold mb-2">
                    <option value="0">{{ __('Please select') }}</option>
                    <option value="1">{{ __('Create a new course') }}</option>
                    <option value="2">{{ __('Duplicate an existing course') }}</option>
                </select>
                @error('newcourse') <span class="text-red-500">{{ $message }}</span>@enderror
            </div>

            @if ($newcourse == 2)
                <div class="mb-4 w-full">
                    <label for="courseTemplateInput" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Select Moodle template course') }}:</label>
                    <select name="coursetemplate" id="courseTemplateInput" wire:model="coursetemplate" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block text-gray-700 text-sm font-bold mb-2">
                        <option value="0">{{ __('Please select') }}</option>
                        @foreach($courses as $course)
                            <option value="{{$course->id}}">{{ $course->id . ' - ' . $course->fullname }}</option>
                        @endforeach
                    </select>
                    @error('coursetemplate') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
            @endif

            @if ($newcourse > 0)
                <div class="flex flex-row gap-4">
                    <div class="basis-1/2">
                        <x-label for="courseshortname" value="{{ __('Short Name') }}" />
                        <x-input id="courseshortname" type="text" wire:model.defer="courseshortname" />
                        <x-input-error for="courseshortname" class="mt-2" />
                    </div>

                    <div class="basis-1/2">
                        <x-label for="coursefullname" value="{{ __('Full Name') }}" />
                        <x-input id="coursefullname" type="text" wire:model.defer="coursefullname" />
                        <x-input-error for="coursefullname" class="mt-2" />
                    </div>
                </div>
            @endif
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

