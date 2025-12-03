<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://unpkg.com/feather-icons"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    @vite('resources/css/app.css')
    <title>{{ $title }}</title>
    </style>
</head>

<body class="bg-[#F6F5F8]">

    <main class="flex h-auto relative">
        <div class="content-wrapper grow relative lg:ml-64">
            <x-header>
                {{ $title }}
            </x-header>
            <div class="content w-full p-4 lg:p-8">
                {{ $slot }}
            </div>
        </div>



        <x-user-sidebar></x-user-sidebar>


    </main>
    @if ($errors->any())
        <div class="absolute top-5 right-5 p-4 bg-red-500 text-white z-99999">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('success'))
        <div id="toast-succes"
            class="absolute top-4 right-4 max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg z-10 cursor-pointer"
            role="alert" tabindex="-1" aria-labelledby="hs-toast-success-example-label">
            <div class="flex p-4">
                <div class="shrink-0">
                    <svg class="shrink-0 size-4 text-teal-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="16"
                        height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z">
                        </path>
                    </svg>
                </div>
                <div class="ms-3">
                    <p id="hs-toast-success-example-label" class="text-sm text-gray-700 dark:text-neutral-400">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    <div id="confirmLogout"
        class="fixed inset-0 bg-black/30 backdrop-blur-lg flex items-center justify-center hidden z-50">
        <!-- Modal Card -->
        <div class="bg-white p-6 rounded-lg shadow-lg relative">
            <!-- Close Button -->
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Apakah Anda Yakin Mau Logout?</h2>
            <div class="flex gap-5 items-center justify-center">
                <button onclick="document.getElementById('confirmLogout').classList.add('hidden')"
                    class="bg-slate-400 text-white px-4 py-2 rounded hover:bg-gray-800 transition">
                    Batal
                </button>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="bg-black text-white px-4 py-2 rounded hover:bg-gray-800 transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>



    @vite('resources/js/script.js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        feather.replace();
    </script>

    @stack('scripts')
</body>

</html>
