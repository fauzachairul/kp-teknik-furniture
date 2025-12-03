<x-layout>
    <x-slot:title>
        Laporan Stok Keluar
    </x-slot:title>

    <div class="bg-white w-full p-4 lg:p-8 rounded-lg shadow-lg relative">
        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center mb-6">
                <form method="GET" action="{{ route('laporan.stockOuts') }}"
                    class="mb-6 grid grid-cols-1 md:grid-cols-5 gap-4 items-end">

                    {{-- Tanggal Mulai --}}
                    <div>
                        <label class="block
                    text-sm text-gray-600">Tanggal Mulai</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                            class="w-full mt-1 border-gray-300 rounded shadow-sm px-2 py-2">
                    </div>

                    {{-- Tanggal Akhir --}}
                    <div>
                        <label class="block text-sm text-gray-600">Tanggal Akhir</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                            class="w-full mt-1 border-gray-300 rounded shadow-sm px-2 py-2">
                    </div>

                    {{-- Jenis Pengeluaran --}}
                    <div>
                        <label class="block text-sm text-gray-600">Jenis Pengeluaran</label>
                        <select name="jenis_pengeluaran"
                            class="w-full mt-1 border-gray-300 rounded shadow-sm px-2 py-2">
                            <option value="">-- Semua --</option>
                            <option value="produksi" {{ request('jenis_pengeluaran') == 'produksi' ? 'selected' : '' }}>
                                Produksi</option>
                            <option value="rusak" {{ request('jenis_pengeluaran') == 'rusak' ? 'selected' : '' }}>
                                Rusak</option>
                            <option value="hilang" {{ request('jenis_pengeluaran') == 'hilang' ? 'selected' : '' }}>
                                Hilang</option>
                            <option value="lainnya" {{ request('jenis_pengeluaran') == 'lainnya' ? 'selected' : '' }}>
                                Lainnya</option>
                            {{-- Tambahkan opsi lainnya jika ada --}}
                        </select>
                    </div>

                    {{-- Tombol Filter --}}
                    <div>
                        <button type="submit"
                            class="w-full bg-black hover:bg-slate-900 text-white font-semibold py-2 px-2 rounded shadow flex items-center gap-x-2 justify-center">
                            <i data-feather="filter" class="w-4"></i> Filter
                        </button>
                    </div>
                    @if (request()->filled('start_date') || request()->filled('end_date') || request()->filled('jenis_pengeluaran'))
                        {{-- Tombol Reset --}}
                        <div>
                            <a href="{{ route('laporan.stockOuts') }}"
                                class="w-full block text-center bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded shadow">
                                Reset
                            </a>
                        </div>
                    @endif
                </form>

                <a target="_blank"
                    href="{{ route('laporan.stockOuts-pdf', request()->only(['start_date', 'end_date', 'jenis_pengeluaran'])) }}"
                    class="px-4 py-2 bg-green-700 text-white font-medium rounded-sm flex gap-x-2 items-center">
                    <i data-feather="download" class="w-5"></i> Download PDF
                </a>
            </div>
            <div class="overflow-x-auto bg-white rounded shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">No</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Kode Transaksi</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Tanggal</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Jenis</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Proyek</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Keterangan</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Bahan Baku & Jumlah</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Total Item</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($stockOuts as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $item->stock_out_kode }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    {{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('d-m-Y') }}</td>
                                <td class="px-4 py-3 text-sm capitalize text-gray-700">{{ $item->jenis_pengeluaran }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    {{ $item->project->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $item->keterangan ?? '-' }}</td>
                                {{-- <td class="px-4 py-3 text-sm text-gray-700">{{ $item->detailOuts->count() }}</td> --}}
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    {{-- <ul class="list-disc list-inside"> --}}
                                    @foreach ($item->detailOuts as $detail)
                                        <p>{{ $detail->rawMaterial->name }} - <span
                                                class="font-semibold">{{ $detail->jumlah }}</span></p>
                                    @endforeach
                                    {{-- </ul> --}}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">
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
        </div>
    </div>
</x-layout>
