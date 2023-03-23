<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
                    <x-application-logo class="block h-12 w-auto" />

                    <h1 class="mt-8 text-2xl font-medium text-gray-900 dark:text-white">
                        Welcome to Evoke users management system!
                    </h1>

                    <h2 class="mt-4 text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        You are managing campaign: <span class="font-semibold">{{ $user->campaign->name }}</span>
                    </h2>
                </div>

                <div>
                    <div class="bg-gray-200 dark:bg-gray-800 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
                        <div>
                            <div class="flex items-center">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    <a href="{{ route('campaigns.groups', $user->campaign_id) }}"><i class="fas fa-people-roof"></i> Groups</a>
                                </h2>
                            </div>

                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                Groups and group users management
                            </p>

                            <p class="mt-4 text-sm">
                                <a href="{{ route('campaigns.groups', $user->campaign_id) }}" class="inline-flex items-center font-semibold text-indigo-700 dark:text-indigo-300">
                                    Manage groups
                                </a>
                            </p>
                        </div>

                        <div>
                            <div class="flex items-center">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    <a href="{{ route('campaigns.students', $user->campaign_id) }}"><i class="fas fa-user"></i> Users</a>
                                </h2>
                            </div>

                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                Users management
                            </p>

                            <p class="mt-4 text-sm">
                                <a href="{{ route('campaigns.students', $user->campaign_id) }}" class="inline-flex items-center font-semibold text-indigo-700 dark:text-indigo-300">
                                    Manage users
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
