<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Students') }}
    </h2>
</x-slot>

<x-slot name="breadcrumb">
    <li>
        <div class="flex items-center">
            <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            @can('viewAny', \App\Models\Campaign::class)
                <a href="{{route('campaigns')}}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">{{ __('Campaigns') }}</a>
            @else
                <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">{{ __('Campaigns') }}</span>
            @endcan
        </div>
    </li>
    <li aria-current="page">
        <div class="flex items-center">
            <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">{{$campaign->name}}</span>
        </div>
    </li>
    <li aria-current="page">
        <div class="flex items-center">
            <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">{{ __('Students') }}</span>
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

        <button wire:click="create()" class="bg-blue-500 hover:bg-blue-700 text-white py-1 mb-6 px-3 rounded my-3 mt-1">Create new student</button>

        @if($isModalOpen)
            @include('livewire.students.modalform')
        @endif

        @if (count($students) > 0)
            <table class="table-fixed w-full">
                <thead>
                <tr class="bg-gray-100 border dark:border-gray-600 dark:bg-gray-600 dark:text-gray-200">
                    <th class="text-left px-4 py-2 w-20">{{ __('ID') }}</th>
                    <th class="text-left px-4 py-2">{{ __('First name') }}</th>
                    <th class="text-left px-4 py-2">{{ __('Last name') }}</th>
                    <th class="text-left px-4 py-2">{{ __('Email') }}</th>
                    <th class="text-left px-4 py-2">{{ __('Group') }}</th>
                    <th class="text-center px-4 py-2">{{ __('Actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($students as $student)
                    <tr>
                        <td class="border dark:border-gray-600 dark:text-gray-400 px-4 py-2">{{ $student->id }}</td>
                        <td class="border dark:border-gray-600 dark:text-gray-400 px-4 py-2">{{ $student->firstname }}</td>
                        <td class="border dark:border-gray-600 dark:text-gray-400 px-4 py-2">{{ $student->lastname }}</td>
                        <td class="border dark:border-gray-600 dark:text-gray-400 px-4 py-2">{{ $student->email }}</td>
                        <td class="border dark:border-gray-600 dark:text-gray-400 px-4 py-2">{{ $student->group->name }}</td>
                        <td class="border dark:border-gray-600 dark:text-gray-400 px-4 py-2 text-center">
                            <button wire:click="edit({{ $student->id }})" class="bg-amber-500 hover:bg-amber-700 text-white py-1 px-3 rounded">{{ __('Edit') }}</button>
                            <button wire:click="confirmItemDeletion({{ $student->id }})" wire:loading.attr="disabled" class="bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded">{{ __('Delete') }}</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{ $students->links('pagination', ['is_livewire' => true]) }}

    <x-confirmation-modal wire:model="itemIdToDelete">
        <x-slot name="title">
            Você tem certeza disso?
        </x-slot>

        <x-slot name="content">
            <p class="my-5">O registro do gerente será removido e não poderá ser recuperado!</p>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('itemIdToDelete', false)" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>

            <x-danger-button class="ml-2" wire:click="delete({{ $itemIdToDelete }})" wire:loading.attr="disabled">
                Sim, pode excluir!
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>
