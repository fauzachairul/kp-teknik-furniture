<x-layout>
    <x-slot:title>
        {{ $title }}
    </x-slot>
    <div class="bg-white w-full p-4 lg:p-8 rounded-lg shadow-lg relative">

        <div class="mb-5 flex justify-between items-center">
            <form action="{{ route('laporan.raw-materials') }}" method="GET" class="flex items-center gap-5">

                <div class="category-filter flex gap-2 items-center">

                    <select name="category" id="category"
                        class="px-3 py-1 border rounded-lg border-gray-300 focus:outline-none focus:ring-blue-400 focus:ring-1 mr-2">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <button class="rounded-lg px-4 py-1 bg-slate-900 text-gray-100 flex gap-1 items-center"><i
                            data-feather="filter" class="w-4"></i> Filter</button>

                    @if (request()->has('category') && request('category') !== '')
                        <a href="{{ route('laporan.raw-materials') }}"
                            class="rounded-lg px-4 py-[0.3rem] bg-slate-600 text-gray-100">Reset</a>
                    @endif
                </div>
            </form>

            <a target="_blank" href="{{ route('laporan.rawMaterials-pdf', request()->only(['search', 'category'])) }}"
                class="px-4 py-2 bg-green-700 text-white font-medium rounded-sm flex gap-x-2 items-center">
                <i data-feather="download" class="w-5"></i> Download PDF
            </a>
        </div>

        <!-- TABEL MATERIAL -->
        <table
            class="w-full lg:min-w-full divide-y divide-gray-200 border border-gray-300 rounded-lg overflow-hidden mb-5 shadow-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">NO</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Kode Bahan Baku</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Nama Bahan Baku</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Kategori</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Unit</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Stok</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($materials as $material)
                    <tr class="odd:bg-white even:bg-gray-50">
                        <td class="px-4 py-2 text-sm text-gray-800">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 text-sm text-gray-800">{{ $material->bahan_baku_kd }}</td>
                        <td class="px-4 py-2 text-sm text-gray-800">{{ $material->name }}</td>
                        <td class="px-4 py-2 text-sm text-gray-800">{{ $material->category->name }}</td>
                        <td class="px-4 py-2 text-sm text-gray-800">{{ $material->unit->name }}</td>
                        <td class="px-4 py-2 text-sm text-gray-800">
                            @if ($material->stock == 0)
                                <span class="px-2 py-1 text-xs font-semibold text-white bg-red-500 rounded-full">Stok
                                    Habis</span>
                            @elseif ($material->stock < $material->min_stock)
                                <span
                                    class="px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-200 rounded-full">Stok
                                    Rendah ({{ $material->stock }})</span>
                            @else
                                {{ $material->stock }}
                            @endif
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data yang tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
