<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nuevo partido
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('matches.store') }}"
                class="bg-white shadow-sm sm:rounded-2xl p-6 space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Deporte
                    </label>

                    <select name="sport"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        <option value="football">Fútbol</option>
                        <option value="volleyball">Vóley</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Título / Evento
                    </label>

                    <input type="text" name="title" placeholder="Ej: Interbarrios 2026 - Fecha 1"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Equipo local
                        </label>

                        <input type="text" name="team_a_name" required placeholder="Ej: Breña FC"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Equipo visitante
                        </label>

                        <input type="text" name="team_b_name" required placeholder="Ej: San Pedro"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex justify-between pt-4">
                    <a href="{{ route('matches.index') }}"
                        class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200">
                        Volver
                    </a>

                    <button type="submit"
                        class="px-6 py-3 rounded-xl bg-gray-900 text-white font-semibold hover:bg-gray-700">
                        Crear y controlar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
