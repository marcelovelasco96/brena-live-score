<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Partidos
            </h2>

            <a href="{{ route('matches.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                Nuevo partido
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @forelse ($matches as $match)
                    <div class="flex items-center justify-between border-b py-4">
                        <div>
                            <p class="font-bold text-gray-800">
                                {{ $match->team_a_name }} vs {{ $match->team_b_name }}
                            </p>
                            <p class="text-sm text-gray-500">
                                {{ $match->sport === 'football' ? 'Fútbol' : 'Vóley' }}
                                @if ($match->title)
                                    · {{ $match->title }}
                                @endif
                            </p>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('matches.settings', $match) }}"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-bold hover:bg-blue-700">
                                ⚙️ Configurar
                            </a>

                            <a href="{{ route('matches.control', $match) }}"
                                class="px-4 py-2 bg-gray-900 text-white rounded-lg text-sm font-bold hover:bg-gray-700">
                                🎮 Control
                            </a>

                            <a href="{{ route('matches.overlay', $match) }}" target="_blank"
                                class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-bold hover:bg-red-700">
                                📺 Overlay
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">Aún no hay partidos creados.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
