<x-app-layout title="{{ __('Estadisticas') }}">
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Estadisticas') }}
        </h2>

        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
            @foreach ($storesData as $store)
                <!-- Card -->
                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div
                        class="p-3 mr-4 text-purple-500 bg-purple-100 rounded-full dark:text-purple-100 dark:bg-purple-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm uppercase font-medium text-gray-600 dark:text-gray-400">
                            {{ $store['number'] }}  {{ $store['name'] }}
                        </p>
                        <p class="text-md font-semibold text-gray-700 dark:text-gray-200">
                            {{ __('Estimado') }}: {{ $store['estimated'] }}
                        </p>
                        <p class="text-md font-semibold text-gray-700 dark:text-gray-200">
                            {{ __('Canjeados') }}: {{ $store['citizens_count'] }}
                        </p>
                        <p class="text-md font-semibold text-gray-700 dark:text-gray-200">
                            {{ __('Verificados') }}: {{ $store['verified'] }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
