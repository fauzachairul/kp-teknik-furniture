<x-layout>
    <x-slot:title>
        {{ $title }}
    </x-slot>


    <div
        class="bg-white p-6 rounded-md shadow-md transform transition duration-700 opacity-0 translate-y-5 animate-fadeInUp delay-300 relative">
        <div class="mb-5 flex justify-between items-center">
            <form action="{{ route('admin.transaksis.index') }}" method="GET">
                <div class="search-bar">
                    <input
                        class="px-3 py-1 border rounded-lg border-gray-300 focus:border-transparent focus:outline-none focus:ring-blue-400 focus:ring-1 mr-4"
                        type="text" name="search" id="search" placeholder="Cari sesuatu...."
                        value="{{ request('search') }}">
                    <button class="rounded-lg px-4 py-1 bg-slate-900 text-gray-100">Cari</button>
                    @if (request()->has('search') && request('search') !== '')
                        <a href="{{ route('admin.transaksis.index') }}"
                            class="rounded-lg px-4 py-[0.3rem] bg-slate-600 text-gray-100">Reset</a>
                    @endif
                </div>
            </form>
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
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($rawMaterials as $material)
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
                            @elseif ($material->stock < 5)
                                <span
                                    class="px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-200 rounded-full">Stok
                                    Rendah ({{ $material->stock }})</span>
                            @else
                                {{ $material->stock }}
                            @endif
                        </td>
                        <td class="px-4 py-2 text-sm">
                            <a href="{{ route('admin.transaksis.tambah-stock', $material->bahan_baku_kd) }}"
                                class="flex gap-3 text-green-600"><i data-feather="log-in"></i>Tambah
                                Stok</a>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data yang tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- {{ $rawMaterials->links() }} --}}
    </div>

</x-layout>
