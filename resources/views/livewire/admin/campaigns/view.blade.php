<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Campaigns') }}
    </h2>
</x-slot>
<x-slot name="breadcrumb">
    <li aria-current="page">
        <div class="flex items-center">
            <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">{{ __('Campaigns') }}</span>
        </div>
    </li>
</x-slot>

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4 dark:bg-gray-800">
        @if (session()->has('message'))
            <div id="alert" class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3">
                <div class="flex">
                    <p class="flex-1">{{ session('message') }}</p>
                    <div class="ml-auto">
                        <button class="bg-transparent text-2xl font-semibold leading-none outline-none focus:outline-none" onclick="document.getElementById('alert').remove();">
                            <span>×</span>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <button wire:click="create()" class="bg-blue-500 hover:bg-blue-700 text-white py-1 mb-6 px-3 rounded my-3 mt-1">Create new campaign</button>

        @if($isModalOpen)
            @include('livewire.admin.campaigns.modalform')
        @endif

        @if (count($campaigns) > 0)
            <table class="table-fixed w-full">
                <thead>
                <tr class="bg-gray-100 border dark:border-gray-600 dark:bg-gray-600 dark:text-gray-200">
                    <th class="text-left px-4 py-2 w-20">{{ __('ID') }}</th>
                    <th class="text-left px-4 py-2">{{ __('Name') }}</th>
                    <th class="text-left px-4 py-2">{{ __('Realm') }}</th>
                    <th class="text-center px-4 py-2">{{ __('Actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($campaigns as $campaign)
                    <tr>
                        <td class="border dark:border-gray-600 dark:text-gray-400 px-4 py-2">{{ $campaign->id }}</td>
                        <td class="border dark:border-gray-600 dark:text-gray-400 px-4 py-2">{{ $campaign->name }}</td>
                        <td class="border dark:border-gray-600 dark:text-gray-400 px-4 py-2">{{ $campaign->realm }}</td>
                        <td class="border dark:border-gray-600 dark:text-gray-400 px-4 py-2 text-center">
                            <div class="block mb-2">
                                <a href="{{route('campaigns.managers', $campaign->id) }}" class="mr-1 bg-slate-500 hover:bg-slate-700 text-white py-1 px-2 rounded">
                                    Managers
                                </a>
                                <a href="{{route('campaigns.groups', $campaign->id) }}" class="mr-1 bg-violet-500 hover:bg-violet-700 text-white py-1 px-2 rounded">
                                    Groups
                                </a>
                                <a href="{{route('campaigns.students', $campaign->id) }}" class="mr-1 bg-green-500 hover:bg-green-700 text-white py-1 px-2 rounded">
                                    Students
                                </a>
                            </div>
                            <button wire:click="edit({{ $campaign->id }})" class="bg-amber-500 hover:bg-amber-700 text-white py-1 px-3 rounded text-sm">{{ __('Edit') }}</button>
                            <button wire:click="confirmItemDeletion({{ $campaign->id }})" wire:loading.attr="disabled" class="bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded text-sm">{{ __('Delete') }}</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{ $campaigns->links('pagination', ['is_livewire' => true]) }}

    <x-confirmation-modal wire:model="itemIdToDelete">
        <x-slot name="title">
            Are you sure?
        </x-slot>

        <x-slot name="content">
            <p class="my-5">The record will be deleted and it will not be possible to recover it!</p>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('itemIdToDelete', false)" wire:loading.attr="disabled">
                Cancel
            </x-secondary-button>

            <x-danger-button class="ml-2" wire:click="delete({{ $itemIdToDelete }})" wire:loading.attr="disabled">
                Yes, delete it!
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>
