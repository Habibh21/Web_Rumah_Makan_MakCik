<aside class="w-56 xl:w-64 bg-[#111827] border-r border-gray-800 flex flex-col justify-between shadow-[4px_0_24px_rgba(0,0,0,0.3)] shrink-0 z-20 transition-all">
    <div class="p-4 xl:p-5">
        <!-- 🖼️ HEADER LOGO RESMI WARUNG MAK CIK (BESAR & CLEAN) -->
        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-800/60">
            <img src="{{ asset('images/logo.png') }}" 
                 onerror="this.onerror=null; this.src='{{ asset('logo.png') }}';" 
                 class="w-12 h-12 xl:w-14 xl:h-14 object-contain shrink-0 drop-shadow-md" 
                 alt="Logo Mak Cik Resto">
            <div class="min-w-0">
                <h1 class="text-xs xl:text-sm font-black tracking-tight text-white uppercase leading-none truncate">Mak Cik Resto</h1>
                <span class="text-[10px] xl:text-[11px] text-gray-500 font-medium tracking-wide">Workspace Kasir</span>
            </div>
        </div>

        <nav class="space-y-1.5">
            <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 pl-2">Layar Kasir Panel</p>

            <!-- MENU 1: POS -->
            <a href="{{ route('pos.index') }}" 
               class="flex items-center gap-2.5 xl:gap-3 px-3.5 xl:px-4 py-2.5 rounded-lg font-black transition-all duration-200 text-xs shadow-lg {{ request()->routeIs('pos.index') ? 'bg-gradient-to-r from-orange-500 to-amber-600 text-white shadow-orange-500/20 border border-orange-400/20' : 'text-slate-400 hover:bg-gray-800/50 hover:text-white' }}">
                <i data-lucide="cooking-pot" class="w-4 h-4 shrink-0"></i>
                <span class="truncate">Menu Makanan POS</span>
            </a>

            <!-- MENU 2: STATUS MEJA -->
            <a href="{{ route('kasir.meja') }}" 
               class="flex items-center gap-2.5 xl:gap-3 px-3.5 xl:px-4 py-2.5 rounded-lg font-black transition-all duration-200 text-xs shadow-lg mt-1 {{ request()->routeIs('kasir.meja') ? 'bg-gradient-to-r from-orange-500 to-amber-600 text-white shadow-orange-500/20 border border-orange-400/20' : 'text-slate-400 hover:bg-gray-800/50 hover:text-white' }}">
                <i data-lucide="layout-grid" class="w-4 h-4 shrink-0"></i>
                <span class="truncate">Status Keterisian Meja</span>
            </a>

            <!-- MENU 3: RESERVASI WA -->
            <a href="{{ route('kasir.reservasi') }}" 
               class="flex items-center gap-2.5 xl:gap-3 px-3.5 xl:px-4 py-2.5 rounded-lg font-black transition-all duration-200 text-xs shadow-lg mt-1 {{ request()->routeIs('kasir.reservasi') ? 'bg-gradient-to-r from-orange-500 to-amber-600 text-white shadow-orange-500/20 border border-orange-400/20' : 'text-slate-400 hover:bg-gray-800/50 hover:text-white' }}">
                <i data-lucide="calendar-check" class="w-4 h-4 shrink-0"></i>
                <span class="truncate">Daftar Reservasi WA</span>
            </a>

            @if(auth()->user() && auth()->user()->role === 'admin')
                <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mt-6 mb-2 pl-2">Sistem Manajemen</p>
                <a href="{{ route('admin.menu_list') }}" class="group flex items-center gap-2.5 xl:gap-3 text-slate-400 hover:bg-gray-800/50 hover:text-white px-3.5 xl:px-4 py-2.5 rounded-lg transition text-xs font-semibold">
                    <i data-lucide="shield-alert" class="w-4 h-4 text-orange-400 group-hover:text-white transition shrink-0"></i> 
                    <span class="truncate">Masuk Panel Admin</span>
                </a>
            @endif
        </nav>
    </div>

    <div class="p-3.5 xl:p-4 border-t border-gray-800 bg-[#0E131F]">
        <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin keluar dari sistem kasir?')">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-[#1F2937] hover:bg-red-950/40 text-red-400 border border-gray-800 hover:border-red-900/50 font-extrabold py-2.5 px-3 rounded-lg text-xs transition-all duration-150 shadow-sm">
                <i data-lucide="log-out" class="w-4 h-4 shrink-0"></i> <span class="truncate">Keluar Sistem</span>
            </button>
        </form>
    </div>
</aside>