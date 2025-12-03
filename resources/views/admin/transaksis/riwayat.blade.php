 <x-layout>
     <x-slot:title>
         {{ $title }}
     </x-slot>
     <div
         class="bg-white p-6 rounded-md shadow-md transform transition duration-700 opacity-0 translate-y-5 animate-fadeInUp delay-300 relative">

         <div class="flex justify-between items-center mb-6">
             <form method="GET" action="{{ route('admin.transaksis.riwayat') }}"
                 class="mb-6 grid grid-cols-2 md:grid-cols-5 gap-4 items-end">

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
                         <a href="{{ route('admin.transaksis.riwayat') }}"
                             class="w-full block text-center bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded shadow">
                             Reset
                         </a>
                     </div>
                 @endif
             </form>
         </div>

         <div class="overflow-x-auto rounded shadow">
             <table class="min-w-full divide-y divide-gray-200 mb-10">
                 <thead class="bg-gray-100">
                     <tr>
                         <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">No</th>
                         <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Kode Transaksi</th>
                         <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Tanggal</th>
                         <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Nama Bahan Baku</th>
                         <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Kode Bahan Baku</th>
                         <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Jumlah</th>
                         <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Keterangan</th>
                     </tr>
                 </thead>
                 <tbody class="bg-white divide-y divide-gray-200">
                     @forelse($transaksis as $index => $transaksi)
                         <tr>
                             <td class="px-4 py-2 text-sm text-gray-900">{{ $index + 1 }}</td>
                             <td class="px-4 py-2 text-sm text-gray-900">{{ $transaksi->kode_transaksi }}</td>
                             <td class="px-4 py-2 text-sm text-gray-900">{{ $transaksi->created_at->format('d-m-Y') }}
                             </td>
                             <td class="px-4 py-2 text-sm text-gray-900">{{ $transaksi->rawMaterial->name }}</td>
                             <td class="px-4 py-2 text-sm text-gray-900">{{ $transaksi->rawMaterial->bahan_baku_kd }}
                             </td>
                             <td class="px-4 py-2 text-sm text-gray-900">{{ $transaksi->jumlah }}</td>
                             <td class="px-4 py-2 text-sm text-gray-900">{{ $transaksi->keterangan ?? '-' }}</td>
                         </tr>
                     @empty
                         <tr>
                             <td colspan="7" class="px-4 py-4 text-center text-sm text-gray-500">
                                 Belum ada transaksi stok.
                             </td>
                         </tr>
                     @endforelse
                 </tbody>
             </table>
         </div>

         {{ $transaksis->links() }}

     </div>
 </x-layout>
