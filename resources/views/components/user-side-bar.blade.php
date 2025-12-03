<div id="overlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 hidden"></div>

<aside id="sidebar"
    class="fixed left-0 top-0 -translate-x-full transition-transform duration-300 lg:translate-x-0 bg-white h-screen w-64 z-50 overflow-y-scroll shadow-[1px_0px_4px_0px_rgba(0,0,0,0.2)]">

    <div class="wrapper flex flex-col gap-8 w-full h-full items-start p-4">
        <div class="logo flex items-center flex-col gap-2 py-5 px-2 rounded-lg bg-[#F6F5F8] shadow-md">
            <img src="{{ asset('img/logo.png') }}" alt="" class="w-1/3">
            <h1 class="text-center font-bold text-xl">Teknik Mebel Furniture</h1>
        </div>

        <nav class="flex flex-col w-full justify-between h-full pb-10">
            <div class="flex flex-col w-full gap-4">
                <!-- Dashboard -->
                <a href="/user/dashboard"
                    class="w-full py-2 px-2 rounded-lg flex items-center hover:bg-slate-200 
                    {{ request()->is('user/dashboard') ? 'bg-slate-200' : '' }}">
                    <i data-feather="home"></i>
                    <p class="font-semibold text-slate-800 ms-3 whitespace-nowrap">Dashboard</p>
                </a>

                <!-- Data Master -->
                <div class="menu-toggle w-full py-2 px-2 rounded-lg font-semibold text-slate-800 cursor-pointer flex items-center justify-between hover:bg-slate-200"
                    data-target="data-master-menu" data-icon="cvd">
                    <div class="flex items-center gap-3">
                        <i data-feather="file"></i>
                        <p>Data Master</p>
                    </div>
                    <i id="cvd" class="cvd transition duration-150" data-feather="chevron-down"></i>
                </div>

                <div id="data-master-menu"
                    class="w-full flex flex-col gap-2 bg-[#F6F5F8] p-4 shadow 
                    {{ request()->is('user/raw-materials*') ? '' : 'hidden' }}">
                    <a href="{{ route('user.rawMaterials.index') }}"
                        class="w-full py-2 px-2 rounded-lg font-semibold text-slate-700 hover:bg-slate-200 text-sm 
                        {{ request()->is('user/raw-materials*') ? 'bg-slate-200' : '' }}">
                        Data Bahan Baku
                    </a>
                </div>

                <!-- Transaksi Master -->
                <div class="menu-toggle w-full py-2 px-2 rounded-lg font-semibold text-slate-800 cursor-pointer flex items-center justify-between hover:bg-slate-200"
                    data-target="transaksi-master-menu" data-icon="cvd-2">
                    <div class="flex items-center gap-3">
                        <i data-feather="shopping-bag"></i>
                        <p>Transaksi Master</p>
                    </div>
                    <i id="cvd-2" class="cvd transition duration-150" data-feather="chevron-down"></i>
                </div>

                <div id="transaksi-master-menu"
                    class="w-full flex flex-col gap-2 bg-[#F6F5F8] p-4 shadow 
                    {{ request()->is('user/transaksis*') ? '' : 'hidden' }}">

                    <!-- Transaksi Keluar -->
                    <div class="menu-toggle w-full py-2 px-2 rounded-lg font-semibold text-slate-800 cursor-pointer flex items-center justify-between hover:bg-slate-200"
                        data-target="transaksi-keluar-menu" data-icon="cvd-4">
                        <div class="flex items-center gap-3">
                            <i data-feather="log-out" class="w-[18px]"></i>
                            <p class="text-sm">Transaksi Stok Keluar</p>
                        </div>
                        <i class="cvd transition duration-150" data-feather="chevron-down"></i>
                    </div>

                    <div id="transaksi-keluar-menu"
                        class="w-full flex flex-col gap-2 bg-slate-200 p-4 shadow rounded-md 
                        {{ request()->is('user/transaksis/*') || request()->is('user/transaksis/*') ? '' : 'hidden' }}">
                        <a href="{{ route('user.transaksis.create') }}"
                            class="w-full py-2 px-2 rounded-lg font-semibold text-slate-700 hover:bg-slate-300 text-sm 
                            {{ request()->is('user/transaksis') ? 'bg-slate-300' : '' }}">
                            Stock Keluar
                        </a>
                        <a href="{{ route('user.transaksis.history-out') }}"
                            class="w-full py-2 px-2 rounded-lg font-semibold text-slate-700 hover:bg-slate-300 text-sm 
                            {{ request()->is('user/transaksis/history-out') ? 'bg-slate-300' : '' }}">
                            Riwayat Stock Keluar
                        </a>
                    </div>
                </div>


                <!-- Logout -->
                <div class="py-5">
                    <button onclick="document.getElementById('confirmLogout').classList.remove('hidden')"
                        class="group flex items-center justify-start w-11 h-11 bg-red-600 rounded-full cursor-pointer relative overflow-hidden transition-all duration-200 shadow-lg hover:w-32 hover:rounded-lg active:translate-x-1 active:translate-y-1">
                        <div
                            class="flex items-center justify-center w-full transition-all duration-300 group-hover:justify-start group-hover:px-3">
                            <svg class="w-4 h-4" viewBox="0 0 512 512" fill="white">
                                <path
                                    d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z">
                                </path>
                            </svg>
                        </div>
                        <div
                            class="absolute right-5 transform translate-x-full opacity-0 text-white text-lg font-semibold transition-all duration-300 group-hover:translate-x-0 group-hover:opacity-100">
                            Logout
                        </div>
                    </button>
                </div>
        </nav>
    </div>
</aside>
