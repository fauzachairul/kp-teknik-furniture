<x-layout>
    <x-slot:title>
        {{ $title }}
    </x-slot>
    <!-- Loader Overlay -->
    <div id="page-loader"
        class="fixed inset-0 bg-white flex items-center justify-center z-50 transition-opacity duration-500">
        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-blue-500 border-solid"></div>
    </div>

    <div class="md:hidden mt-5 flex justify-end">
        <button onclick="document.getElementById('usersModal').classList.remove('hidden')"
            class="bg-slate-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition">
            Tambah User
        </button>
    </div>

    <div
        class="bg-white p-6 rounded-md shadow-md transform transition duration-700 opacity-0 translate-y-5 animate-fadeInUp delay-[300ms] relative">
        <div class="mb-5 flex justify-between gap-y-5 lg:gap-y-0 lg:items-center flex-col-reverse md:flex-row">

            <form action="{{ route('admin.units.index') }}" method="GET">
                <div class="search-bar">
                    <input
                        class="px-3 py-1 border rounded-lg border-gray-300 focus:border-transparent focus:outline-none focus:ring-blue-400 focus:ring-1 mr-4"
                        type="text" name="search" id="search" placeholder="Cari sesuatu...."
                        value="{{ request('search') }}">
                    <button class="rounded-lg px-4 py-1 bg-slate-900 text-gray-100">Cari</button>

                    @if (request()->has('search') && request('search') !== '')
                        <a href="{{ route('admin.units.index') }}"
                            class="rounded-lg px-4 py-[0.3rem] bg-slate-600 text-gray-100">Reset</a>
                    @endif
                </div>
            </form>

            <div class="hidden md:block">
                <button onclick="document.getElementById('usersModal').classList.remove('hidden')"
                    class="bg-slate-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition">
                    Tambah User
                </button>
            </div>
        </div>

        <div class="overflow-x-auto rounded">
            <table
                class="min-w-full divide-y divide-gray-200 border border-gray-300 rounded-lg overflow-hidden mb-5 shadow-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">No</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Nama</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Role</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($users as $user)
                        <tr class="odd:bg-white even:bg-gray-50">
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $user->name }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $user->email }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $user->role }}</td>
                            <td class="px-4 py-2 text-sm text-blue-600">
                                <div class="flex gap-2 items-center">
                                    <button class="edit-btn p-2 bg-yellow-500 text-white rounded"
                                        data-id="{{ $user->id }}"
                                        data-edit-url="{{ route('user.edit', $user->id) }}"
                                        data-update-url="{{ route('user.update', $user->id) }}">
                                        <i data-feather="edit"></i>
                                    </button>
                                    <form class="delete-form" data-delete-url="{{ route('user.destroy', $user->id) }}">
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
                            <td colspan="7" class="text-center">Tidak ada data yang tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $users->links() }}
    </div>

    {{-- modal tambah --}}
    <div id="usersModal"
        class="fixed inset-0 bg-black/30 backdrop-blur-lg flex items-center justify-center hidden z-50">
        <!-- Modal Card -->
        <div class="bg-white w-full max-w-lg p-6 rounded-lg shadow-lg relative">
            <!-- Close Button -->
            <button onclick="document.getElementById('usersModal').classList.add('hidden')"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">
                &times;
            </button>

            <h2 class="text-xl font-semibold mb-4 text-gray-800">Tambah User</h2>

            <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" id="name" name="name" required
                        class="mt-1 block w-full border border-gray-300 rounded-md p-2 shadow-sm focus:ring-black focus:border-black">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email<input type="text"
                            id="email" name="email" required
                            class="mt-1 block w-full border border-gray-300 rounded-md p-2 shadow-sm focus:ring-black focus:border-black">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password<input type="password"
                            id="password" name="password" required
                            class="mt-1 block w-full border border-gray-300 rounded-md p-2 shadow-sm focus:ring-black focus:border-black">
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select name="role" id="role" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                        <option value="">-- Pilih User Role --</option>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
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

    <!-- Modal Edit Background -->
    <div id="editModal" class="fixed inset-0 bg-black/20 backdrop-blur-sm hidden z-50 justify-center">
        <div class="flex justify-center items-center min-h-screen">
            <!-- Modal Container -->
            <div id="modalContent"
                class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 transform scale-95 opacity-0 transition-all duration-300">
                <!-- Modal Header -->
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Edit User</h2>
                    <button class="text-gray-400 hover:text-gray-600 text-xl" id="closeModal">&times;</button>
                </div>

                <!-- Modal Body -->
                <form id="editUserForm">
                    <input type="hidden" id="editUserId">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" id="editUserName"
                            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-black focus:ring-black px-3 py-2 text-gray-800"
                            required>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="text" id="editUserEmail"
                            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-black focus:ring-black px-3 py-2 text-gray-800"
                            required>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Password Baru</label>
                        <input type="text" id="editUserPassword"
                            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-black focus:ring-black px-3 py-2 text-gray-800">
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Role</label>
                        <select id="editRole" required
                            class="w-full border border-gray-300 rounded-md px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-black">
                            <option value="user">user</option>
                            <option value="admin">admin</option>
                        </select>
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
                <form id="deleteUsersForm" method="POST">
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

            $(function() {
                const showModal = () => {
                    $('#editModal').removeClass('hidden');
                    setTimeout(() => {
                        $('#modalContent').removeClass('scale-95 opacity-0').addClass(
                            'scale-100 opacity-100');
                    }, 10);
                }

                const hideModal = () => {
                    $('#modalContent').removeClass('scale-100 opacity-100').addClass('scale-95 opacity-0');
                    setTimeout(() => {
                        $('#editModal').addClass('hidden');
                    }, 300);
                }

                $('.edit-btn').on('click', function() {
                    const id = $(this).data('id');
                    const editUrl = $(this).data('edit-url');
                    const updateUrl = $(this).data('update-url');

                    $.get(editUrl, function(data) {
                        $('#editUserId').val(data.id);
                        $('#editUserName').val(data.name);
                        $('#editUserEmail').val(data.email);
                        $('#editRole').val(data.role);

                        $('#editUserPassword').val('');

                        $('#editUserForm').data('update-url', updateUrl);
                        showModal();
                    });
                });

                $('#closeModal').on('click', hideModal);
                $('#closeModal2').on('click', hideModal);

                $('#editUserForm').on('submit', function(e) {
                    e.preventDefault();
                    const submitBtn = $(this).find('button[type="submit"]');
                    submitBtn.prop('disabled', true).text('Menyimpan...');

                    const updateUrl = $(this).data('update-url');
                    const password = $('#editUserPassword').val();

                    const postData = {
                        _method: 'PUT',
                        _token: '{{ csrf_token() }}',
                        name: $('#editUserName').val(),
                        email: $('#editUserEmail').val(),
                        role: $('#editRole').val(),
                    };

                    if (password !== '') {
                        postData.password = password;
                    }

                    $.ajax({
                        url: updateUrl,
                        type: 'POST',
                        data: postData,
                        success: function(response) {
                            hideModal();
                            window.location = "{{ route('users.index') }}?success=1";
                        },
                        error: function(xhr) {
                            alert('Gagal update. Cek input atau server.');
                            console.error(xhr.responseText);
                        },
                        complete: function() {
                            submitBtn.prop('disabled', false).text('Simpan');
                        }
                    });
                });
                //modal delete

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
                    $('#deleteUsersForm').attr('action', actionUrl);
                    showDeleteModal();
                });

                $('#cancelDelete').on('click', hideDeleteModal);

                $('#deleteUsersForm').on('submit', function() {
                    hideDeleteModal();
                });
            });
        </script>
    @endpush
</x-layout>
