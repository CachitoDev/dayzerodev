<x-app-layout title="{{ __('Importar Ciudadanos') }}">
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Importar Líderes') }}
        </h2>

        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                    Seleccionar Archivo
                </span>
                <div class="relative text-gray-500 focus-within:text-purple-600">
                    <form action="{{ route('leaders.import.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input
                            class="block w-full pr-20 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                            type="file" name="file" />
                        <button
                            class="absolute inset-y-0 right-0 px-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-r-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                            type="submit">
                            Guardar
                        </button>
                    </form>
                </div>
            </label>
        </div>
    </div>
</x-app-layout>
