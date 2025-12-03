<x-layout>
    <x-slot:title>
        {{ $title }}
    </x-slot>

    <!-- Loader Overlay -->
    <div id="page-loader"
        class="fixed inset-0 bg-white flex items-center justify-center z-50 transition-opacity duration-500">
        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-blue-500 border-solid"></div>
    </div>

    @if (session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
            class="fixed top-5 right-5 bg-red-600 text-white px-4 py-2 rounded shadow-lg"
            x-html="`{!! session('error') !!}`">
        </div>
    @endif

    <div class="flex justify-end mt-5">
        <button onclick="document.getElementById('projectsModal').classList.remove('hidden')"
            class="bg-slate-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition md:hidden">
            Tambah Project
        </button>

    </div>

    <div
        class="bg-white p-4 rounded-md shadow-md transform transition duration-700 opacity-0 translate-y-5 animate-fadeInUp delay-300 relative">

        <div class="flex justify-between items-center mb-6">

            <button onclick="document.getElementById('projectsModal').classList.remove('hidden')"
                class="bg-slate-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition hidden md:block">
                Tambah Project
            </button>

            <!-- Form Pencarian & Filter -->
            <form action="{{ route('projects.index') }}" method="GET" class="flex flex-wrap gap-3 items-center">
                <!-- Search -->
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari project..."
                        class="pl-9 pr-3 py-2 border border-gray-300 rounded-md focus:ring-black focus:border-black">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 absolute left-3 top-3 text-gray-400"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z" />
                    </svg>
                </div>

                <!-- Filter Status -->
                <select name="status" onchange="this.form.submit()"
                    class="border border-gray-300 rounded-md px-3 py-2 bg-white focus:ring-black focus:border-black">
                    <option value="">Semua Status</option>
                    <option value="on progress" {{ request('status') == 'on progress' ? 'selected' : '' }}>On Progress
                    </option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan
                    </option>
                </select>

                <button type="submit"
                    class="bg-slate-900 text-white px-4 py-2 rounded-md hover:bg-gray-800 transition">
                    Cari
                </button>

                <!-- Tombol reset -->
                @if (request('search') || request('status'))
                    <a href="{{ route('projects.index') }}"
                        class="text-gray-600 underline hover:text-gray-800 text-sm ml-1 px-4 py-2 rounded-md border">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto rounded">
            <table
                class="min-w-full divide-y divide-gray-200 border border-gray-300 rounded-lg overflow-hidden shadow-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">#</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Kode</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Nama Project</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Customer</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Mulai</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Selesai</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($projects as $index => $project)
                        <tr class="odd:bg-white even:bg-gray-50">
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 font-medium">
                                {{ $project->project_kode }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $project->name }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $project->customer_name }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800">
                                {{ $project->tanggal_mulai->format('d M Y') }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800">
                                {{ $project->tanggal_selesai ? $project->tanggal_selesai->format('d M Y') : '-' }}
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-800">
                                <span
                                    class="px-2 py-1 text-xs rounded-full
                                @if ($project->status === 'on progress') bg-yellow-100 text-yellow-800
                                @elseif($project->status === 'selesai') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <button class="edit-project-btn bg-blue-500 text-white px-3 py-1 rounded"
                                        data-id="{{ $project->id }}"
                                        data-edit-url="{{ route('project.edit', $project->id) }}"
                                        data-update-url="{{ route('project.update', $project->id) }}">
                                        Edit
                                    </button>
                                    <form class="delete-form"
                                        data-delete-url="{{ route('project.hapus', $project->id) }}">
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
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">Tidak ada project
                                ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    <!-- Modal tambah Background -->
    <div id="projectsModal"
        class="fixed inset-0 bg-black/30 backdrop-blur-lg flex items-center justify-center hidden z-50">
        <!-- Modal Card -->
        <div class="bg-white w-full max-w-lg p-6 rounded-lg shadow-lg relative">
            <!-- Close Button -->
            <button onclick="document.getElementById('projectsModal').classList.add('hidden')"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">
                &times;
            </button>

            <h2 class="text-xl font-semibold mb-4 text-gray-800">Tambah Project</h2>

            <form action="{{ route('project.store') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Nama Project -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Project</label>
                    <input type="text" name="name" id="name" required
                        class="mt-1 block w-full border border-gray-300 rounded-md p-2 shadow-sm focus:ring-black focus:border-black">
                </div>

                <!-- Nama Customer -->
                <div>
                    <label for="customer_name" class="block text-sm font-medium text-gray-700">Nama
                        Customer</label>
                    <input type="text" name="customer_name" id="customer_name" required
                        class="mt-1 block w-full border border-gray-300 rounded-md p-2 shadow-sm focus:ring-black focus:border-black">
                </div>

                <!-- Tanggal Mulai -->
                <div>
                    <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Tanggal
                        Mulai</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" required
                        class="mt-1 block w-full border border-gray-300 rounded-md p-2 shadow-sm focus:ring-black focus:border-black">
                </div>

                <!-- Tanggal Selesai -->
                <div>
                    <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700">Tanggal
                        Selesai</label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                        class="mt-1 block w-full border border-gray-300 rounded-md p-2 shadow-sm focus:ring-black focus:border-black">
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" required
                        class="w-full border border-gray-300 rounded-md px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-black">
                        <option value="on progress" selected>On Progress</option>
                        <option value="selesai">Selesai</option>
                        <option value="dibatalkan">Dibatalkan</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-black text-white px-4 py-2 rounded hover:bg-gray-800 transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Project -->
    <div id="projectsModaledit"
        class="fixed inset-0 bg-black/30 backdrop-blur-lg flex items-center justify-center hidden z-50">
        <div class="bg-white w-full max-w-lg p-6 rounded-lg shadow-lg relative">
            <!-- Close Button -->
            <button type="button" id="closeProjectModal"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">&times;</button>

            <h2 class="text-xl font-semibold mb-4 text-gray-800">Edit Project</h2>

            <form id="editProjectForm" class="space-y-4">
                @csrf
                <input type="hidden" id="editProjectId">

                <!-- Kode Project -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Kode Project</label>
                    <input type="text" id="editProjectKode"
                        class="mt-1 block w-full border border-gray-300 rounded-md p-2 shadow-sm focus:ring-black focus:border-black"
                        readonly>
                </div>

                <!-- Nama Project -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Project</label>
                    <input type="text" id="editProjectName" required
                        class="mt-1 block w-full border border-gray-300 rounded-md p-2 shadow-sm focus:ring-black focus:border-black">
                </div>

                <!-- Nama Customer -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Customer</label>
                    <input type="text" id="editCustomerName" required
                        class="mt-1 block w-full border border-gray-300 rounded-md p-2 shadow-sm focus:ring-black focus:border-black">
                </div>

                <!-- Tanggal Mulai -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                    <input type="date" id="editTanggalMulai" required
                        class="mt-1 block w-full border border-gray-300 rounded-md p-2 shadow-sm focus:ring-black focus:border-black">
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select id="editStatus" required
                        class="w-full border border-gray-300 rounded-md px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-black">
                        <option value="on progress">On Progress</option>
                        <option value="selesai">Selesai</option>
                        <option value="dibatalkan">Dibatalkan</option>
                    </select>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-black text-white px-4 py-2 rounded hover:bg-gray-800 transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="fixed inset-0 bg-black/20 backdrop-blur-sm hidden z-50">
        <div class="flex justify-center items-center min-h-screen">
            <div class="bg-white rounded-lg p-6 w-full max-w-sm shadow-lg text-center transform scale-95 opacity-0 transition-all duration-300"
                id="deleteModalContent">
                <h2 class="text-lg font-bold mb-4">Konfirmasi Hapus</h2>
                <p class="mb-6">Apakah Anda yakin ingin menghapus kategori ini?</p>
                <form id="deleteProjectForm" method="POST">
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

            // Modal show/hide
            function showProjectModal() {
                $('#projectsModaledit').removeClass('hidden');
            }

            function hideProjectModal() {
                $('#projectsModaledit').addClass('hidden');
            }

            // Event listener
            $('.edit-project-btn').on('click', function() {
                const id = $(this).data('id');
                const editUrl = $(this).data('edit-url');
                const updateUrl = $(this).data('update-url');

                $.get(editUrl, function(data) {
                    $('#editProjectId').val(data.id);
                    $('#editProjectKode').val(data.project_kode);
                    $('#editProjectName').val(data.name);
                    $('#editCustomerName').val(data.customer_name);
                    $('#editTanggalMulai').val(data.tanggal_mulai);
                    $('#editStatus').val(data.status);
                    $('#editProjectForm').data('update-url', updateUrl);

                    showProjectModal();
                });
            });

            $('#closeProjectModal').on('click', hideProjectModal);

            // Submit edit form
            $('#editProjectForm').on('submit', function(e) {
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
                        name: $('#editProjectName').val(),
                        customer_name: $('#editCustomerName').val(),
                        tanggal_mulai: $('#editTanggalMulai').val(),
                        status: $('#editStatus').val(),
                    },
                    success: function(response) {
                        hideProjectModal();
                        showToast(response.message || 'Project berhasil diperbarui');
                        setTimeout(() => location.reload(), 1500);
                    },
                    error: function(xhr) {
                        alert('Gagal update. Periksa input atau server.');
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
                $('#deleteProjectForm').attr('action', actionUrl);
                showDeleteModal();
            });

            $('#cancelDelete').on('click', hideDeleteModal);

            $('#deleteProjectForm').on('submit', function() {
                hideDeleteModal();
            });
        </script>
    @endpush
</x-layout>
