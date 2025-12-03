<x-layout>
    <x-slot:title>
        {{ $title }}
    </x-slot>

    <div class="bg-white w-full p-4 lg:p-8 rounded-lg shadow-lg relative">
        <div class="max-w-5xl mx-auto px-6 py-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Transaksi Stok Keluar</h2>

            @if (session('success'))
                <div class="mb-6 px-4 py-3 bg-green-100 text-green-800 border border-green-300 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('stock-out.store') }}" class="space-y-6">
                @csrf

                <!-- Jenis Pengeluaran -->
                <div>
                    <label for="jenis_pengeluaran" class="block text-sm font-medium text-gray-700 mb-1">Jenis
                        Pengeluaran</label>
                    <select name="jenis_pengeluaran" id="jenis_pengeluaran" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                        <option value="">-- Pilih Jenis Pengeluaran --</option>
                        <option value="produksi">Produksi</option>
                        <option value="rusak">Rusak</option>
                        <option value="hilang">Hilang</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>

                <!-- Proyek -->
                <div id="proyek_section" class="hidden">
                    <label for="project_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Proyek</label>
                    <select name="project_id" class="project-select w-full">
                        <option value="">-- Pilih Proyek --</option>
                        @foreach ($project as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Keterangan Umum -->
                <div>
                    <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">Keterangan Umum</label>
                    <textarea name="keterangan" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400"></textarea>
                </div>

                <hr class="border-gray-200">

                <!-- Detail Bahan -->
                <div>
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Detail Bahan yang Dikeluarkan</h4>

                    <div id="detail_container" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 detail_row">
                            <!-- Bahan -->
                            <div class="md:col-span-4">
                                <select name="bahan_baku_id[]" required class="bahan-select w-full">
                                    <option value="">Pilih Bahan</option>
                                    @foreach ($bahan_baku as $b)
                                        <option value="{{ $b->id }}">{{ $b->name }} (Stok:
                                            {{ $b->stock }} {{ $b->unit->name }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Jumlah -->
                            <div class="md:col-span-2">
                                <input type="number" name="jumlah[]" placeholder="Jumlah" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                            </div>

                            <!-- Keterangan per item -->
                            <div class="md:col-span-4">
                                <input type="text" name="detail_keterangan[]" placeholder="Keterangan per item"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                            </div>

                            <!-- Tombol Hapus -->
                            <div class="md:col-span-2 flex items-center">
                                <button type="button"
                                    class="remove-detail px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md text-sm transition">
                                    <i data-feather="trash-2" class="w-[18px]"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="add_detail"
                        class="mt-4 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 border border-gray-300 rounded-md transition">
                        + Tambah Bahan
                    </button>
                </div>

                <!-- Tombol Simpan -->
                <div>
                    <button type="submit"
                        class="w-full md:w-auto px-4 py-2 bg-black hover:bg-slate-900 text-white rounded-md font-semibold transition">
                        <div class="flex gap-x-2 items-center">
                            <i data-feather="save" class="w-[18px]"></i>Simpan Transaksi
                        </div>
                    </button>
                </div>
            </form>
        </div>

        {{-- Script --}}
        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Init select2
                    $('.bahan-select').select2({
                        placeholder: 'Pilih Bahan',
                        width: '100%'
                    });
                    $('.project-select').select2({
                        placeholder: 'Pilih Proyek',
                        width: '100%'
                    });

                    // Toggle proyek input
                    document.getElementById('jenis_pengeluaran').addEventListener('change', function() {
                        const proyekSection = document.getElementById('proyek_section');
                        proyekSection.classList.toggle('hidden', this.value !== 'produksi');
                    });

                    // Tambah detail row
                    document.getElementById('add_detail').addEventListener('click', function() {
                        const container = document.getElementById('detail_container');
                        const firstRow = container.querySelector('.detail_row');

                        // Destroy select2 sebelum clone
                        $(firstRow).find('.bahan-select').select2('destroy');

                        const newRow = firstRow.cloneNode(true);

                        // Kosongkan input
                        newRow.querySelectorAll('input').forEach(input => input.value = '');
                        newRow.querySelector('select').selectedIndex = 0;

                        container.appendChild(newRow);

                        // Init ulang select2
                        $(firstRow).find('.bahan-select').select2({
                            placeholder: 'Pilih Bahan',
                            width: '100%'
                        });
                        $(newRow).find('.bahan-select').select2({
                            placeholder: 'Pilih Bahan',
                            width: '100%'
                        });
                    });

                    // Hapus row
                    document.addEventListener('click', function(e) {
                        if (e.target.closest('.remove-detail')) {
                            const rows = document.querySelectorAll('.detail_row');
                            if (rows.length > 1) {
                                e.target.closest('.detail_row').remove();
                            }
                        }
                    });
                });
            </script>
        @endpush
    </div>
</x-layout>
