<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Events') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Events</h2>
                    <p class="mt-1 text-sm text-gray-500">Historique des appels API QwenService.</p>
                </div>

                <div class="mt-4 sm:mt-0 w-full sm:w-auto">
                    <form id="eventsSearchForm" method="GET" action="{{ route('events.index') }}" class="flex flex-col sm:flex-row sm:items-center gap-3">
                        <div class="relative w-full sm:w-72">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 10.5a7.5 7.5 0 0013.15 6.15z" />
                                </svg>
                            </div>
                            <input id="eventsSearchInput" type="text" name="search" value="{{ $search ?? request('search') }}" placeholder="Filtrer par client" class="block w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            @if(($search ?? request('search')) !== null && trim((string)($search ?? request('search'))) !== '')
                                <a href="{{ route('events.index', array_filter(['serial' => $serial ?? request('serial'), 'sort' => $sort ?? request('sort')])) }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600" aria-label="Clear search">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </a>
                            @endif
                        </div>

                        <div class="relative w-full sm:w-56">
                            <input id="eventsSerialInput" type="text" name="serial" value="{{ $serial ?? request('serial') }}" placeholder="Filtrer par serial number" class="block w-full py-2.5 px-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>

                        <input type="hidden" name="sort" value="{{ $sort ?? request('sort', 'desc') }}">

                        <a href="{{ route('events.index', array_filter(['search' => $search ?? request('search'), 'serial' => $serial ?? request('serial'), 'sort' => ($sort ?? request('sort','desc')) === 'asc' ? 'desc' : 'asc'])) }}" class="inline-flex items-center justify-center px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 8a1 1 0 011-1h10a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2zm0 8a1 1 0 011-1h6a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2z" />
                            </svg>
                            Date {{ ($sort ?? request('sort','desc')) === 'asc' ? '↑' : '↓' }}
                        </a>

                        <a href="{{ route('events.index', array_filter(['search' => $search ?? request('search'), 'serial' => $serial ?? request('serial'), 'sort' => $sort ?? request('sort','desc'), 'export' => 'csv'])) }}" class="inline-flex items-center justify-center px-4 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                            <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 16V4m0 12l-3-3m3 3l3-3M4 20h16" />
                            </svg>
                            Export CSV
                        </a>
                    </form>
                </div>
            </div>

            <script>
                (function () {
                    const form = document.getElementById('eventsSearchForm');
                    const searchInput = document.getElementById('eventsSearchInput');
                    const serialInput = document.getElementById('eventsSerialInput');
                    if (!form) return;

                    let t = null;
                    const onInput = function () {
                        if (t) clearTimeout(t);
                        t = setTimeout(function () {
                            form.submit();
                        }, 400);
                    };
                    if (searchInput) searchInput.addEventListener('input', onInput);
                    if (serialInput) serialInput.addEventListener('input', onInput);
                })();
            </script>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Client</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Serial Number</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date &amp; Heure</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Erreur</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($events as $event)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $event->client_name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-mono">
                                        {{ $event->serial_number }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $event->called_at?->format('d/m/Y H:i:s') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full {{ $event->status === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $event->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $event->error_message ?? '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="md:hidden bg-gray-50 p-4 space-y-4">
                    @foreach($events as $event)
                        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h4 class="font-bold text-gray-900 text-lg leading-tight">{{ $event->client_name }}</h4>
                                    <p class="text-xs text-gray-500 font-mono mt-0.5">{{ $event->serial_number }}</p>
                                </div>
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $event->status === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $event->status }}
                                </span>
                            </div>
                            <div class="text-sm text-gray-600">
                                <div class="flex justify-between py-2 border-t border-gray-100">
                                    <span class="text-gray-500">Date</span>
                                    <span class="font-medium">{{ $event->called_at?->format('d/m/Y H:i:s') }}</span>
                                </div>
                                @if($event->error_message)
                                    <div class="pt-2 text-xs text-red-600">
                                        {{ $event->error_message }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="px-6 py-4 bg-white border-t border-gray-100">
                    {{ $events->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
