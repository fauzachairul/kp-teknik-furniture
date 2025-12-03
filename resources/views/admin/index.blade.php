<x-layout>
    <x-slot:title>
        {{ $title }}
    </x-slot>

    <!-- Loader Overlay -->
    <div id="page-loader"
        class="fixed inset-0 bg-white flex items-center justify-center z-50 transition-opacity duration-500">
        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-blue-500 border-solid"></div>
    </div>

    <!-- Konten Dashboard -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-10">

        <div
            class="card bg-sky-200 rounded-xl flex justify-center items-center py-8 shadow-md transform transition duration-700 opacity-0 translate-y-5 animate-fadeInUp delay-100">
            <div>
                <p class="text-2xl font-medium text-slate-600">Jumlah Bahan Baku</p>
                <p class="text-sky-900 text-xl font-bold">
                    {{ $rawMaterials }}
                    <span class="text-slate-600 font-medium">Barang</span>
                </p>
            </div>
        </div>

        <div
            class="card bg-yellow-200 rounded-xl flex justify-center items-center py-8 shadow-md transform transition duration-700 opacity-0 translate-y-5 animate-fadeInUp delay-200">
            <div>
                <p class="text-2xl font-medium text-slate-600">Jumlah Kategori</p>
                <p class="text-yellow-800 text-xl font-bold">{{ $categories }} <span
                        class="text-slate-600 font-medium">Kategori</span></p>
            </div>
        </div>

        <div
            class="card bg-teal-100 rounded-xl flex justify-center items-center py-8 shadow-md transform transition duration-700 opacity-0 translate-y-5 animate-fadeInUp delay-300">
            <div>
                <p class="text-2xl font-medium text-slate-600">Jumlah Satuan</p>
                <p class="text-teal-700 text-xl font-bold"> {{ $units }} <span
                        class="text-slate-600 font-medium">Jenis Satuan</span></p>
            </div>
        </div>

        <div
            class="card bg-red-200 rounded-xl flex justify-center items-center py-8 shadow-md transform transition duration-700 opacity-0 translate-y-5 animate-fadeInUp delay-400">
            <div>
                <p class="text-2xl font-medium text-slate-600">Transaksi Hari Ini</p>
                <p class="text-red-900 text-xl font-bold">{{ $totalTransaksi }}<span
                        class="text-slate-600 font-medium">Transaksi</span></p>
            </div>
        </div>

    </div>


    <div
        class="bg-white p-6 rounded-md mt-6 shadow-md border transform transition duration-700 opacity-0 translate-y-5 animate-fadeInUp delay-500">
        <h2 class="text-xl font-semibold mb-4">Bahan Baku Yang Hampir Habis | Habis</h2>

        @if ($lowStockMaterials->isEmpty())
            <p class="text-gray-600">Semua stok aman.</p>
        @else
            <table
                class="w-full lg:min-w-full divide-y divide-gray-200 border border-gray-300 rounded-lg overflow-hidden mb-5 shadow-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">NO</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Kode Material</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Nama Material</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Kategori</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Unit</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Stok</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($lowStockMaterials as $material)
                        <tr class="odd:bg-white even:bg-gray-50">
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $material->bahan_baku_kd }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $material->name }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $material->category->name }}
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $material->unit->name }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $material->stock }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div
        class="bg-white p-6 rounded-md mt-6 shadow-md border transform transition duration-700 opacity-0 translate-y-5 animate-fadeInUp delay-600">
        <h2 class="text-xl font-semibold mb-4">Transaksi Terbaru</h2>

        <form method="GET" action="{{ route('dashboard') }}" class="mb-4">
            <select name="filter" onchange="this.form.submit()"
                class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="masuk" {{ $filter == 'masuk' ? 'selected' : '' }}>Stok Masuk</option>
                <option value="keluar" {{ $filter == 'keluar' ? 'selected' : '' }}>Stok Keluar</option>
            </select>
        </form>

        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 px-4 py-2 text-left">Tanggal</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Kode Transaksi</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Bahan Baku</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Jumlah</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $item)
                    <tr class="even:bg-gray-50">
                        <td class="border border-gray-300 px-4 py-2">
                            {{ \Carbon\Carbon::parse($item['tanggal'])->format('d-m-Y H:i') }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $item['kode_transaksi'] }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $item['bahan_baku'] }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $item['jumlah'] }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $item['keterangan'] ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center p-4">Tidak ada transaksi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>



    <div
        class="bg-white p-6 rounded shadow mt-6 border transform transition duration-700 opacity-0 translate-y-5 animate-fadeInUp delay-700">
        <h1 class="text-xl font-bold text-gray-800 mb-4">Bahan Baku Paling Sering Keluar</h1>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">No</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Nama Bahan Baku</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Total Terpakai</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($mostUsed as $index => $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $item->rawMaterial->name ?? '-' }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $item->total_terpakai }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-4 text-center text-sm text-gray-500">Belum ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    @push('scripts')
        <script>
            window.addEventListener('load', function() {
                const loader = document.getElementById('page-loader');
                loader.classList.add('opacity-0');
                setTimeout(() => loader.style.display = 'none', 500);
            });
        </script>
    @endpush
</x-layout>
