<x-user-layout>
    <x-slot:title>
        Detail Transaksi Stok Keluar
    </x-slot:title>
    <div class="bg-white w-full p-4 lg:p-8 rounded-lg shadow-lg relative">

        <div class="container mx-auto px-4 py-6">
            <div class="mb-6">
                <a href="{{ route('user.transaksis.history-out') }}"
                    class="inline-block text-blue-600 hover:underline mb-4">
                    ← Kembali ke Riwayat
                </a>

                <div class="flex justify-between">
                    <h1 class="text-2xl font-bold text-gray-800">Detail Transaksi</h1>
                    <h1 class="text-2xl font-bold text-gray-800">{{ $stockOut->stock_out_kode }}</h1>
                </div>

                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 bg-white p-6 rounded shadow">
                    <div>
                        <p class="text-sm text-gray-500">Tanggal Keluar:</p>
                        <p class="text-base text-gray-800 font-semibold">
                            {{ \Carbon\Carbon::parse($stockOut->tanggal_keluar)->format('d M Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Jenis Pengeluaran:</p>
                        <p class="text-base text-gray-800 font-semibold capitalize">
                            {{ $stockOut->jenis_pengeluaran }}
                        </p>
                    </div>
                    @if ($stockOut->project)
                        <div>
                            <p class="text-sm text-gray-500">Kode Proyek:</p>
                            <p class="text-base text-gray-800 font-semibold">
                                {{ $stockOut->project->project_kode }}
                            </p>
                        </div>
                    @endif
                    @if ($stockOut->project)
                        <div>
                            <p class="text-sm text-gray-500">Nama Proyek:</p>
                            <p class="text-base text-gray-800 font-semibold">
                                {{ $stockOut->project->name }}
                            </p>
                        </div>
                    @endif
                    <div>
                        <p class="text-sm text-gray-500">Keterangan Umum:</p>
                        <p class="text-base text-gray-800">
                            {{ $stockOut->keterangan ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded shadow overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Bahan Baku</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Jumlah</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Keterangan Item</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($stockOut->detailOuts as $detail)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-800">
                                    {{ $detail->rawMaterial->name }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-800">
                                    {{ $detail->jumlah }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-800">
                                    {{ $detail->keterangan ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-6 text-center text-sm text-gray-500">
                                    Tidak ada detail bahan baku.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-user-layout>
