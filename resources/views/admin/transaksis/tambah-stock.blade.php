 <x-layout>
     <x-slot:title>
         {{ $title }}
     </x-slot>

     <div class="bg-white w-full p-4 lg:p-8 rounded-lg shadow-lg relative">
         <div class="max-w-5xl mx-auto px-6 py-10">
             <h2 class="text-2xl font-bold text-gray-800 mb-6">Transaksi Stok Masuk</h2>

             @if (session('success'))
                 <div class="mb-6 px-4 py-3 bg-green-100 text-green-800 border border-green-300 rounded-md">
                     {{ session('success') }}
                 </div>
             @endif
             <form action="{{ route('tambah-stock.store') }}" method="POST" class="space-y-4">
                 @csrf

                 <input type="hidden" name="bahan_baku_id" value="{{ $material->id }}">
                 <div>
                     <label for="name" class="block text-sm font-medium text-gray-700">Nama Bahan Baku</label>
                     <input type="text"
                         class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"
                         value="{{ $material->name }}" readonly>
                     <p>Stok Saat ini {{ $material->stock }}</p>
                 </div>
                 <div>
                     <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah</label>
                     <input type="number" name="jumlah" id="jumlah" required
                         class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200 @error('jumlah') border-red-500 focus:ring-red-500 @else border-gray-300 focus:ring-blue-200 @enderror"
                         placeholder="Masukkan jumlah yang ingin ditambahkan" min="1">
                     @error('jumlah')
                         <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                     @enderror
                 </div>
                 <div>
                     <label for="keterangan" class="block text-sm font-medium text-gray-700">keterangan
                         (opsional)</label>
                     <textarea name="keterangan" id="keterangan"
                         class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200 @error('keterangan') border-red-500 focus:ring-red-500 @else border-gray-300 focus:ring-blue-200 @enderror"></textarea>
                     @error('keterangan')
                         <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                     @enderror
                 </div>
                 <div>
                     <button type="submit"
                         class="bg-slate-900 text-white px-4 py-2 rounded-md hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500">
                         Simpan
                     </button>
                     <a href="{{ route('admin.transaksis.index') }}"
                         class="bg-white text-slate-900 px-4 py-2 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 border-2 ml-5">
                         Batal
                     </a>
                 </div>
             </form>
         </div>
     </div>
 </x-layout>
