<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h5>Create Url</h5>
                    <form action="{{route('store.url')}}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="url" class="block text-gray-700 dark:text-gray-300">Enter URL:</label>
                            <input type="text" id="original_url" name="original_url" class="mt-1 block w-full border-gray-300 dark:border-gray-600">
                        </div>
                        <div class="mb-4">
                            <label for="url" class="block text-gray-700 dark:text-gray-300">Expires At</label>
                            <input type="datetime-local" id="expires_at" name="expires_at" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <button type="submit" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
