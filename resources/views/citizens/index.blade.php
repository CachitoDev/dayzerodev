<x-app-layout title="{{ __('Ciudadanos') }}">
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Ciudadanos') }}
        </h2>

        @if ($errors->any())
            <div class="mb-4">
                <div class="font-medium text-red-600">¡Oh no! Algo salió mal.</div>

                <ul class="mt-3 text-sm text-red-600 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="px-4 py-3 gap-x-2 my-2 bg-white rounded-lg shadow-lg dark:bg-gray-800">
            <label class="block text-sm">
                <div class="relative text-gray-500 focus-within:text-purple-600">
                    <form action="{{ route('citizens.index') }}" method="GET">
                        <input name="search"
                            class="block w-full pr-20 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                            placeholder="Folio de Canje" autocomplete="off" />
                        <button
                            class="absolute inset-y-0 right-0 px-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-r-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                            Buscar
                        </button>
                    </form>
                </div>
            </label>
        </div>

        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">{{ __('#') }}</th>
                            <th class="px-4 py-3">{{ __('Folio') }}</th>
                            <th class="px-4 py-3">{{ __('Nombre') }}</th>
                            <th class="px-4 py-3">{{ __('CURP') }}</th>
                            <th class="px-4 py-3">{{ __('Estado') }}</th>
                            <th class="px-4 py-3">{{ __('Acciones') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach ($citizens as $citizen)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3 text-sm">
                                    <a target="_blank" href="{{ $citizen->getImageUrl() }}">{{ $citizen->id }}</a>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $citizen->folio }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $citizen->name }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $citizen->curp }}
                                </td>
                                <td class="px-4 py-3 text-xs">
                                    @if (!$citizen->verified)
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-700">
                                            {{ __('Sin Canjear') }}
                                        </span>
                                    @else
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                            {{ __('Canjeado') }}
                                        </span>
                                    @endif
                                </td>

                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-4 text-sm">
                                        @if (!$citizen->verified)
                                            <form action="{{ route('citizens.verifiedCitizen', $citizen->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                                    aria-label="Delete">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <span class="ml-2">{{ __('Verificar') }}</span>
                                                </button>
                                            </form>
                                        @else
                                            <span
                                                class="flex items-center justify-between text-xs font-medium leading-tight text-gray-500 bg-gray-200 rounded-full dark:text-gray-400 dark:bg-gray-700 px-2 py-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span class="ml-2">{{ __('Verificado') }}</span>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($citizens->count())
                <div
                    class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                    <span class="flex items-center col-span-3">
                        {{ __('Mostrando') }} {{ $citizens->firstItem() }} - {{ $citizens->lastItem() }}
                        {{ __('de') }} {{ $citizens->total() }}
                    </span>
                    <span class="col-span-2"></span>
                    <!-- Pagination -->
                    <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                        <nav aria-label="Table navigation">
                            {{ $citizens->withQueryString()->links() }}
                        </nav>
                    </span>
                </div>
            @else
                <div
                    class="px-4 py-3 rounded-md text-sm text-center font-semibold text-gray-700 uppercase bg-white sm:grid-cols-9 dark:text-gray-500 dark:bg-gray-800">
                    {{ __('No Se Han Encontrado Datos') }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
