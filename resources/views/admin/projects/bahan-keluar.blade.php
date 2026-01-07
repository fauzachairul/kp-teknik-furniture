<x-layout>
    <x-slot:title>{{ $title }}</x-slot>

    <div class="space-y-6">

        {{-- Header Project --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-800">
                        {{ $project->name }}
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Kode Project:
                        <span class="font-medium">{{ $project->project_kode }}</span>
                    </p>
                </div>

                <a href="{{ route('projects.index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-sm">
                    ← Kembali
                </a>
            </div>
        </div>

        {{-- Rekap Bahan Terpakai --}}
        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">

            <div class="px-6 py-4 border-b bg-gray-50">
                <h2 class="font-semibold text-gray-800">
                    Rekap Bahan Baku Terpakai
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Total pemakaian bahan untuk project ini
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-white">
                        <tr class="text-left text-gray-500">
                            <th class="px-6 py-3 font-medium">Bahan Baku</th>
                            <th class="px-6 py-3 font-medium text-right">Total Terpakai</th>
                            <th class="px-6 py-3 font-medium">Satuan</th>
                            <th class="px-6 py-3 font-medium">Dikeluarkan Oleh</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($bahanTerpakai as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-medium text-gray-800">
                                    {{ $item->name }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold">
                                        {{ $item->total_jumlah }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $item->satuan }}
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $item->pengeluar ?? '-' }}
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-6 text-center text-gray-500">
                                    Belum ada pemakaian bahan untuk project ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</x-layout>
