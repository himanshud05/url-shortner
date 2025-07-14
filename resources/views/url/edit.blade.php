<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
           Edit URL
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h5 class="mb-4 font-bold text-lg">Edit URL</h5>
                    <form action="{{ route('urls.update', $urlModel->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="original_url" class="block text-gray-700 dark:text-gray-300">Original URL:</label>
                            <input type="text" id="original_url" name="original_url" value="{{ $urlModel->original_url }}"
                                   class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm">
                        </div>
                        <div class="mb-4">
                            <label for="expires_at" class="block text-gray-700 dark:text-gray-300">Expires At:</label>
                            <input type="datetime-local" id="expires_at" name="expires_at"
                                   value="{{ \Carbon\Carbon::parse($urlModel->expires_at)->format('Y-m-d\TH:i') }}"
                                   class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm">
                        </div>
                        <div class="mb-4">
                            <label for="is_disabled" class="inline-flex items-center">
                                <input type="checkbox" id="is_disabled" name="is_disabled"
                                       {{ $urlModel->is_disabled ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                <span class="ml-2 text-gray-700 dark:text-gray-300">Disable URL</span>
                            </label>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Update Url</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>