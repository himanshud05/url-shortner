<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600" href="{{ route('create.url') }}">+ Create New URL</a>
            <a class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600" href="{{ url('/telescope') }}">View Analytics</a>
            
            <div class="mt-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h5 class="text-lg font-bold mb-4">Your Shortened URLs</h5>

                    @if ($urlModels->count())
                        <table class="min-w-full table-auto bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-700 text-left">
                                    <th class="px-4 py-2">Sno</th>
                                    <th class="px-4 py-2">Original URL</th>
                                    <th class="px-4 py-2">Short URL</th>
                                    <th class="px-4 py-2">Created At</th>
                                    <th class="px-4 py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($urlModels as $key => $urlModel)
                                    <tr class="border-b border-gray-200 dark:border-gray-600">
                                        <td class="px-4 py-2">{{ $key + 1 }}</td>
                                        <td class="px-4 py-2 break-words">{{ $urlModel->original_url }}</td>
                                        <td class="px-4 py-2">
                                            <a href="{{ $urlModel->original_url }}" class="text-green-600 hover:underline" target="_blank">
                                                {{ $urlModel->short_url }}
                                            </a>
                                        </td>
                                        <td class="px-4 py-2">{{ $urlModel->created_at->format('d M Y') }}</td>
                                        <td class="px-4 py-2 space-x-2">
                                            <a href="{{route('redirect', $urlModel->short_url)}}" target="_blank" class="text-blue-600 hover:underline">Visit</a>
                                            <a href="{{ route('urls.show', $urlModel->id) }}" class="text-green-600 hover:underline">View</a>
                                            <a href="{{ route('urls.edit', $urlModel->id) }}" class="text-yellow-600 hover:underline">Edit</a>
                                            <form action="{{ route('urls.destroy', $urlModel->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this URL?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $urlModels->links() }}
                        </div>
                    @else
                        <p class="text-gray-500">No URLs created yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>