<x-layout>
    <x-slot:title>
        {{ $title }}
    </x-slot>

    <!-- Loader Overlay -->
    <div id="page-loader"
        class="fixed inset-0 bg-white flex items-center justify-center z-50 transition-opacity duration-500">
        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-blue-500 border-solid"></div>
    </div>

    <div class="flex justify-end">
        <button onclick="document.getElementById('rawMaterialModal').classList.remove('hidden')"
            class="bg-slate-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition md:hidden mt-5 shadow-md">
            Tambah Bahan Baku
        </button>
    </div>

    <div
        class="bg-white p-4 rounded-md shadow-md transform transition duration-700 opacity-0 translate-y-5 animate-fadeInUp delay-300">

        <div class="mb-5 flex flex-col md:flex-row md:justify-between md:items-center gap-3 w-full">
            <form action="{{ route('admin.rawMaterials.index') }}" method="GET" class="w-full md:w-auto">
                <div class="search-bar flex flex-col sm:flex-row w-full gap-2">
                    <input
                        class="flex-1 px-3 py-1 border rounded-lg border-gray-300 focus:border-transparent focus:outline-none focus:ring-blue-400 focus:ring-1"
                        type="text" name="search" id="search" placeholder="Cari sesuatu...."
                        value="{{ request('search') }}">
                    <div class="flex gap-2">
                        <button class="rounded-lg px-4 py-1 bg-slate-900 text-gray-100 w-full sm:w-auto">Cari</button>
                        @if (request()->has('search') && request('search') !== '')
                            <a href="{{ route('admin.rawMaterials.index') }}"
                                class="rounded-lg px-4 py-[0.3rem] bg-slate-600 text-gray-100 w-full sm:w-auto text-center">Reset</a>
                        @endif
                    </div>
                </div>
            </form>

            <button onclick="document.getElementById('rawMaterialModal').classList.remove('hidden')"
                class="bg-slate-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition w-full md:w-auto hidden md:block">
                Tambah Bahan Baku
            </button>
        </div>

        <!-- TABEL MATERIAL -->
        <div class="overflow-x-auto rounded">
            <table class="min-w-full divide-y divide-gray-200 border border-gray-300 rounded-lg shadow-sm">
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
                    @forelse ($materials as $material)
                        <tr class="odd:bg-white even:bg-gray-50">
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $material->bahan_baku_kd }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $material->name }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $material->category->name }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $material->unit->name }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800">
                                @if ($material->stock == 0)
                                    <span
                                        class="px-2 py-1 text-xs font-semibold text-white bg-red-500 rounded-full">Stok
                                        Habis</span>
                                @elseif ($material->stock < $material->min_stock)
                                    <span
                                        class="px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-200 rounded-full">Stok
                                        Rendah ({{ $material->stock }})</span>
                                @else
                                    {{ $material->stock }}
                                @endif
                            </td>
                            <td class="px-4 py-2 text-sm">
                                <div class="flex gap-3 justify-center items-center">

                                    <button class="edit-btn p-2 bg-yellow-500 text-white rounded"
                                        data-id="{{ $material->id }}"
                                        data-edit-url="{{ route('admin.rawMaterials.edit', $material->id) }}"
                                        data-update-url="{{ route('rawMaterial.update', $material->id) }}">
                                        <i data-feather="edit"></i>
                                    </button>
                                    <form class="delete-form"
                                        data-delete-url="{{ route('rawMaterial.hapus', $material->id) }}">
                                        <button type="button"
                                            class="p-2 bg-red-600 rounded-md text-white open-delete-modal">
                                            <i data-feather="trash-2"></i>
                                        </button>
                                    </form>
                                </div>
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

        {{ $materials->links() }}
    </div>

    {{-- modal tambah --}}
    <!-- Modal Background -->
    <div id="rawMaterialModal"
        class="fixed inset-0 bg-black/30 backdrop-blur-lg flex items-center justify-center hidden z-50">
        <!-- Modal Card -->
        <div class="bg-white w-full max-w-lg p-6 rounded-lg shadow-lg relative">
            <!-- Close Button -->
            <button onclick="document.getElementById('rawMaterialModal').classList.add('hidden')"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl cursor-pointer">
                &times;
            </button>

            <h2 class="text-xl font-semibold mb-4 text-gray-800">Tambah Bahan Baku</h2>

            <form action="{{ route('rawMaterial.tambah') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" id="name" name="name" required
                        class="mt-1 block w-full border border-gray-300 rounded-md p-2 shadow-sm focus:ring-black focus:border-black">
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                    <select id="category_id" name="category_id" required
                        class="mt-1 block w-full border border-gray-300 rounded-md p-2 shadow-sm focus:ring-black focus:border-black">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="unit_id" class="block text-sm font-medium text-gray-700">Satuan</label>
                    <select id="unit_id" name="unit_id" required
                        class="mt-1 block w-full border border-gray-300 rounded-md p-2 shadow-sm focus:ring-black focus:border-black">
                        <option value="">-- Pilih Jenis Satuan --</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700">Stok</label>
                    <input type="number" id="stock" name="stock" min="0"
                        class="mt-1 block w-full border border-gray-300 rounded-md p-2 shadow-sm focus:ring-black focus:border-black">
                </div>

                <div>
                    <label for="min_stock" class="block text-sm font-medium text-gray-700">Stok Minimum</label>
                    <input type="number" id="min_stock" name="min_stock" min="0"
                        class="mt-1 block w-full border border-gray-300 rounded-md p-2 shadow-sm focus:ring-black focus:border-black">
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-black text-white px-4 py-2 rounded hover:bg-gray-800 transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Background -->
    <div id="editModal" class="fixed inset-0 bg-black/20 backdrop-blur-sm hidden z-50 justify-center">
        <div class="flex justify-center items-center min-h-screen">
            <!-- Modal Container -->
            <div id="modalContent"
                class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 transform scale-95 opacity-0 transition-all duration-300">
                <!-- Modal Header -->
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Edit Bahan Baku</h2>
                    <button class="text-gray-400 hover:text-gray-600 text-xl" id="closeModal">&times;</button>
                </div>

                <!-- Modal Body -->
                <form id="editRmForm">

                    <input type="hidden" id="editBahanBakuId">

                    {{-- kode --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Kode Bahan Baku</label>
                        <input type="text" id="editRmKode"
                            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-black focus:ring-black px-3 py-2 text-gray-800"
                            required>
                    </div>

                    {{-- nama --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nama Bahan Baku</label>
                        <input type="text" id="editRmName"
                            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-black focus:ring-black px-3 py-2 text-gray-800"
                            required>
                    </div>

                    {{-- Unit --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Unit</label>
                        <select id="editUnitId" required
                            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-black focus:ring-black px-3 py-2 text-gray-800">
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>

                    </div>

                    {{-- kategori --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select id="editCategoryId" required
                            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-black focus:ring-black px-3 py-2 text-gray-800">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Stok --}}
                    <div>
                        <input type="hidden" id="editRmStock"
                            class="mt-1 block w-full border rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring">

                    </div>

                    {{-- min stock --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Minimum Stock</label>
                        <input type="text" id="editRmMinStock" required
                            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-black focus:ring-black px-3 py-2 text-gray-800">
                        @error('min_stock')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>



                    <!-- Modal Footer -->
                    <div class="flex justify-end">
                        <button type="button" id="closeModal2"
                            class="mr-3 px-4 py-2 text-gray-600 hover:text-black">Batal</button>
                        <button type="submit"
                            class="px-5 py-2 bg-black text-white rounded-md hover:bg-gray-900">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="fixed inset-0 bg-black/20 backdrop-blur-sm hidden z-50">
        <div class="flex justify-center items-center min-h-screen">
            <div class="bg-white rounded-lg p-6 w-full max-w-sm shadow-lg text-center transform scale-95 opacity-0 transition-all duration-300"
                id="deleteModalContent">
                <h2 class="text-lg font-bold mb-4">Konfirmasi Hapus</h2>
                <p class="mb-6">Apakah Anda yakin ingin menghapus kategori ini?</p>
                <form id="deleteUnitForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-center gap-3">
                        <button type="button" id="cancelDelete" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            window.addEventListener('load', function() {
                const loader = document.getElementById('page-loader');
                loader.classList.add('opacity-0');
                setTimeout(() => loader.style.display = 'none', 500);
            });


            // Toast message reusable
            function showToast(message) {
                const toast = $(`
            <div class="max-w-xs bg-white border border-gray-200 rounded-full shadow-md cursor-pointer">
                <div class="flex p-1">
                    <div class="shrink-0">
                        <svg class="shrink-0 size-4 text-teal-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-700">${message}</p>
                    </div>
                </div>
            </div>
        `);

                $('#toast-container').append(toast);

                toast.on('click', function() {
                    $(this).fadeOut(300, function() {
                        $(this).remove();
                    });
                });

                setTimeout(() => {
                    toast.fadeOut(400, function() {
                        $(this).remove();
                    });
                }, 3000);
            }

            $(function() {
                // Modal edit
                const showModal = () => {
                    $('#editModal').removeClass('hidden');
                    setTimeout(() => {
                        $('#modalContent').removeClass('scale-95 opacity-0').addClass(
                            'scale-100 opacity-100');
                    }, 10);
                };

                const hideModal = () => {
                    $('#modalContent').removeClass('scale-100 opacity-100').addClass('scale-95 opacity-0');
                    setTimeout(() => {
                        $('#editModal').addClass('hidden');
                    }, 300);
                };

                $('.edit-btn').on('click', function() {
                    const id = $(this).data('id');
                    const editUrl = $(this).data('edit-url');
                    const updateUrl = $(this).data('update-url');

                    $.get(editUrl, function(data) {
                        $('#editBahanBakuId').val(data.id);
                        $('#editRmKode').val(data.bahan_baku_kd);
                        $('#editRmName').val(data.name);
                        $('#editCategoryId').val(data.category_id);
                        $('#editUnitId').val(data.unit_id);
                        $('#editRmStock').val(data.stock);
                        $('#editRmMinStock').val(data.min_stock);
                        $('#editRmForm').data('update-url', updateUrl);
                        showModal();
                    });
                });

                $('#closeModal, #closeModal2').on('click', hideModal);

                $('#editRmForm').on('submit', function(e) {
                    e.preventDefault();
                    const submitBtn = $(this).find('button[type="submit"]');
                    submitBtn.prop('disabled', true).text('Menyimpan...');


                    const updateUrl = $(this).data('update-url');

                    $.ajax({
                        url: updateUrl,
                        type: 'POST',
                        data: {
                            _method: 'PUT',
                            _token: '{{ csrf_token() }}',
                            bahan_baku_kd: $('#editRmKode').val(),
                            name: $('#editRmName').val(),
                            category_id: $('#editCategoryId').val(),
                            unit_id: $('#editUnitId').val(),
                            stock: $('#editRmStock').val(),
                            min_stock: $('#editRmMinStock').val(),
                        },
                        success: function(response) {
                            hideModal();
                            showToast(response.message || 'Data berhasil diperbarui');
                            setTimeout(() => location.reload(), 2500);
                        },
                        error: function(xhr) {
                            alert('Gagal update. Cek input atau server.');
                            console.error(xhr.responseText);
                        }
                    });
                });

                // Modal delete
                const showDeleteModal = () => {
                    $('#deleteModal').removeClass('hidden');
                    setTimeout(() => {
                        $('#deleteModalContent').removeClass('scale-95 opacity-0').addClass(
                            'scale-100 opacity-100');
                    }, 10);
                };

                const hideDeleteModal = () => {
                    $('#deleteModalContent').removeClass('scale-100 opacity-100').addClass('scale-95 opacity-0');
                    setTimeout(() => {
                        $('#deleteModal').addClass('hidden');
                    }, 300);
                };

                $('.open-delete-modal').on('click', function() {
                    const form = $(this).closest('.delete-form');
                    const actionUrl = form.data('delete-url');
                    $('#deleteUnitForm').attr('action', actionUrl);
                    showDeleteModal();
                });

                $('#cancelDelete').on('click', hideDeleteModal);

                $('#deleteUnitForm').on('submit', function() {
                    hideDeleteModal();
                });
            });
        </script>
    @endpush
</x-layout>
