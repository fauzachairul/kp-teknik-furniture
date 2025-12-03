<x-user-layout>
    <x-slot:title>
        Dashboard
    </x-slot>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mb-10">
        <div
            class="card bg-sky-200 rounded-xl flex justify-center items-center py-8 shadow-md transform transition duration-700 opacity-0 translate-y-5 animate-fadeInUp delay-[100ms]">
            <div>
                <p class="text-2xl font-medium text-sky-600">Transaksi Hari Ini</p>
                <p class="text-sky-500 text-xl font-bold">
                    {{ $totalTxOut }}
                </p>
            </div>
        </div>
    </div>

    <h2 class="text-4xl my-5">Transaksi Terbaru</h2>
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 px-4 py-2 text-left">No</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Kode Transaksi</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Tanggal</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Jenis</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Proyek</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Keterangan</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Bahan Baku & Jumlah</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Total Item</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($txOutHariIni as $item)
                    <tr class="even:bg-gray-50">
                        <td class="border border-gray-300 px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $item->stock_out_kode }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('d-m-Y') }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $item->jenis_pengeluaran }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ $item->project->name ?? '-' }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2">{{ $item->keterangan ?? '-' }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            @foreach ($item->detailOuts as $detail)
                                <p>{{ $detail->rawMaterial->name }} - <span
                                        class="font-semibold">{{ $detail->jumlah }}</span></p>
                            @endforeach
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ $item->detailOuts->sum('jumlah') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-sm text-gray-500">
                            Belum ada data transaksi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-user-layout>
