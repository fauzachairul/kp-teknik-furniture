<x-layout>
    <x-slot:title>
        {{ $title }}
    </x-slot>

    <form action="{{ route('project.store') }}" method="POST"
        class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md space-y-6">
        @csrf

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <h2 class="text-2xl font-semibold text-gray-700">Tambah Project Baru</h2>

        <!-- Nama Project -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Project</label>
            <input type="text" name="name" id="name" required
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Nama Customer -->
        <div>
            <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Customer</label>
            <input type="text" name="customer_name" id="customer_name" required
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Tanggal Mulai -->
        <div>
            <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" id="tanggal_mulai" required
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Tanggal Selesai -->
        <div>
            <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Status -->
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" id="status" required
                class="w-full border border-gray-300 rounded-md px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="on progress" selected>On Progress</option>
                <option value="selesai">Selesai</option>
                <option value="dibatalkan">Dibatalkan</option>
            </select>
        </div>

        <!-- Submit Button -->
        <div class="pt-4">
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-300">
                Simpan Project
            </button>
        </div>
    </form>
</x-layout>
