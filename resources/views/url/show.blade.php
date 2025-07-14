<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('URL Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h5 class="text-lg font-bold mb-4">URL Detail</h5>

                    <div class="mb-4">
                        <strong>Original URL:</strong><br>
                        <span class="text-blue-500 break-words">{{ $urlModel->original_url }}</span>
                    </div>

                    <div class="mb-4">
                        <strong>Short URL:</strong><br>
                        <a href="{{$urlModel->original_url}}" class="text-green-600 hover:underline" target="_blank">
                            {{ $urlModel->short_url }}
                        </a>
                    </div>

                    <div class="mb-4">
                        <strong>Created At:</strong><br>
                        {{ $urlModel->created_at->format('d M Y, h:i A') }}
                    </div>

                    <div class="mb-4">
                        <strong>Expires At:</strong><br>
                        {{ $urlModel->expires_at ? $urlModel->expires_at->format('d M Y, h:i A') : 'No expiration' }}
                    </div>

                    <div class="flex space-x-4 mt-6">
                        <a href="{{ route('urls.edit', $urlModel->id) }}"
                           class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</a>
                        <a href="{{ route('dashboard') }}"
                           class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
