 <header
     class="w-full py-6 px-4 lg:px-8 flex justify-between items-center bg-white shadow-[0px_2px_2px_0px_rgba(0,0,0,0.2)]">
     <div class="logo">
         <h1 class="text-center font-semibold text-2xl">{{ $slot }}</h1>
     </div>

     <div class="hidden md:block">
         <p class="text-sm font-light">Selamat Datang, {{ Auth::user()->name }}</p>
     </div>
     <button id="btn" class="lg:hidden p-2 cursor-pointer"><i data-feather="menu"></i></button>
 </header>
