<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Synchronization Logs') }}
    </h2>
</x-slot>
<x-slot name="breadcrumb">
    <li aria-current="page">
        <div class="flex items-center">
            <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">{{ __('Synchronization Logs') }}</span>
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

        @if (count($logs) > 0)
            <table class="table-fixed w-full">
                <thead>
                <tr class="bg-gray-100 border dark:border-gray-600 dark:bg-gray-600 dark:text-gray-200">
                    <th class="text-left px-4 py-2 w-20">{{ __('ID') }}</th>
                    <th class="text-left px-4 py-2">{{ __('Model') }}</th>
                    <th class="text-left px-4 py-2">{{ __('Action') }}</th>
                    <th class="text-center px-4 py-2">{{ __('Message') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($logs as $log)
                    <tr>
                        <td class="border dark:border-gray-600 dark:text-gray-400 px-4 py-2">{{ $log->id }}</td>
                        <td class="border dark:border-gray-600 dark:text-gray-400 px-4 py-2">{{ $log->model }}</td>
                        <td class="border dark:border-gray-600 dark:text-gray-400 px-4 py-2">{{ $log->action }}</td>
                        <td class="border dark:border-gray-600 dark:text-gray-400 px-4 py-2">
                            @if ($log->status == 201)
                                <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                    {{ $log->message }}
                                </span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                    {{ $log->message }}
                                </span>
                            @endif

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{ $logs->links('pagination', ['is_livewire' => true]) }}
</div>
