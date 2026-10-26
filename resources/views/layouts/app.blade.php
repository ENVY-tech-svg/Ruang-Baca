<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ruang Baca — Kurasi Novel Editorial')</title>
    
    <!-- PWA Link -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#8B6B4A">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Anti-Flicker Script -->
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        cream: { 100: '#FAF6EE', 200: '#FBF7F0', 300: '#F3ECE0' },
                        dark: '#24211D',
                        darkBg: '#181614',
                        darkCard: '#24211D',
                        muted: '#77716A',
                        accent: '#8B6B4A',
                        accentDark: '#6D5237',
                    },
                    fontFamily: {
                        serif: ['"Cormorant Garamond"', 'Georgia', 'serif'],
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: rgba(0,0,0,0.03); }
        .dark ::-webkit-scrollbar-track { background: rgba(255,255,255,0.03); }
        ::-webkit-scrollbar-thumb { background: #8B6B4A; border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: #6D5237; }

        /* Custom Keyframe Animations */
        @keyframes floatSlow {
            0%, 100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-12px) scale(1.04); }
        }
        .animate-float {
            animation: floatSlow 7s ease-in-out infinite;
        }
        .animate-float-delayed {
            animation: floatSlow 9s ease-in-out 2s infinite;
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 0.65; transform: scale(1.08); }
        }
        .animate-pulse-glow {
            animation: pulseGlow 5s ease-in-out infinite;
        }

        /* Micro Interactions */
        .card-hover-effect {
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.3s ease;
        }
        .card-hover-effect:hover {
            transform: translateY(-8px) scale(1.01);
            box-shadow: 0 20px 35px -10px rgba(139, 107, 74, 0.2);
        }

        .active-tab-glow {
            box-shadow: 0 0 15px rgba(139, 107, 74, 0.4);
        }
    </style>
</head>
<body class="bg-cream-100 text-dark dark:bg-darkBg dark:text-cream-100 font-sans antialiased flex flex-col min-h-screen transition-colors duration-500 relative selection:bg-accent selection:text-white">

    <!-- Header / Navbar Desktop & Mobile -->
    <header class="border-b border-black/5 dark:border-white/10 bg-cream-100/80 dark:bg-darkBg/80 backdrop-blur-xl sticky top-0 z-40 transition-colors duration-300">
        <div class="max-w-6xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="{{ route('home') }}" class="group flex items-center gap-3">
                <span class="w-10 h-10 rounded-2xl bg-dark text-cream-100 dark:bg-accent dark:text-white flex items-center justify-center font-serif text-xl font-bold group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-md">RB</span>
                <span class="font-serif text-2xl tracking-tight font-bold text-dark dark:text-cream-100 group-hover:text-accent transition-colors">Ruang Baca</span>
            </a>

            <div class="flex items-center gap-4">
                <nav class="flex items-center gap-3 sm:gap-6 text-sm font-medium text-muted dark:text-cream-100/70">
                    <a href="{{ route('home') }}#catalog" class="hover:text-dark dark:hover:text-cream-100 transition-colors py-1">Katalog</a>
                    
                    <!-- Menu Favorit -->
                    <button type="button" onclick="openFavoritesNav()" class="hover:text-dark dark:hover:text-cream-100 transition-all flex items-center gap-2 py-1.5 px-3.5 rounded-xl bg-accent/10 dark:bg-accent/20 border border-accent/20 text-accent font-semibold text-xs sm:text-sm hover:scale-105 active:scale-95 shadow-sm">
                        <svg class="w-4 h-4 transition-transform group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24"><path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                        <span>Favorit</span>
                        <span id="navFavBadge" class="bg-accent text-white text-[10px] px-2 py-0.5 rounded-full font-bold shadow-sm">0</span>
                    </button>
                </nav>

                <!-- Switch Tema -->
                <button id="themeToggleBtn" onclick="toggleTheme()" type="button" class="p-2.5 rounded-xl bg-black/5 dark:bg-white/10 text-dark dark:text-cream-100 hover:bg-black/10 dark:hover:bg-white/20 transition-all hover:scale-110 active:scale-90" title="Ganti Tema">
                    <svg id="sunIcon" class="w-4 h-4 hidden dark:block text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <svg id="moonIcon" class="w-4 h-4 block dark:hidden text-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                </button>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Desain Footer Editorial Terbuka -->
    <footer class="bg-dark text-cream-100 dark:bg-black/80 border-t border-white/10 mt-24 transition-colors duration-300 relative overflow-hidden">
        <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-[500px] h-[500px] bg-accent/10 rounded-full blur-3xl pointer-events-none animate-pulse-glow"></div>

        <div class="max-w-6xl mx-auto px-6 pt-16 pb-12 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-10 border-b border-white/10 pb-12">
                
                <!-- Brand Info -->
                <div class="md:col-span-5 space-y-4">
                    <div class="flex items-center gap-3">
                        <span class="w-10 h-10 rounded-2xl bg-accent text-white flex items-center justify-center font-serif text-xl font-bold shadow-md">RB</span>
                        <h3 class="font-serif text-2xl font-bold tracking-tight text-white">Ruang Baca</h3>
                    </div>
                    <p class="text-sm text-cream-100/70 leading-relaxed max-w-sm">
                        Katalog dan repositori kurasi sastra Indonesia pilihan dengan pendekatan sudut pandang editorial yang tenang, rapi, dan nyaman dibaca.
                    </p>
                    <div class="inline-flex items-center gap-2 text-xs font-semibold text-accent bg-accent/10 px-3.5 py-1.5 rounded-full border border-accent/20 backdrop-blur-md">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                        Laravel JSON Native Engine
                    </div>
                </div>

                <!-- Navigasi Cepat -->
                <div class="md:col-span-3 space-y-3">
                    <h4 class="text-xs uppercase tracking-widest font-semibold text-accent">Navigasi Utama</h4>
                    <ul class="space-y-2.5 text-sm text-cream-100/70">
                        <li><a href="{{ route('home') }}#catalog" class="hover:text-white hover:translate-x-1 inline-block transition-transform">Katalog Lengkap</a></li>
                        <li><a href="javascript:void(0)" onclick="openFavoritesNav()" class="hover:text-white hover:translate-x-1 inline-block transition-transform">Favorit Saya</a></li>
                        <li><a href="javascript:void(0)" onclick="triggerRandomModalFromFooter()" class="hover:text-white hover:translate-x-1 inline-flex items-center gap-2 transition-transform"><span>Acak Rekomendasi</span> <span class="text-[10px] bg-accent/30 text-amber-200 px-1.5 py-0.5 rounded-full font-bold">🎲 Hot</span></a></li>
                        <li><a href="javascript:void(0)" onclick="scrollToTop()" class="hover:text-white hover:translate-x-1 inline-block transition-transform">Kembali ke Atas ↑</a></li>
                    </ul>
                </div>

                <!-- Status Sistem & Update -->
                <div class="md:col-span-4 space-y-3">
                    <h4 class="text-xs uppercase tracking-widest font-semibold text-accent">Informasi Kurator</h4>
                    <div class="p-4 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-md space-y-2.5 text-xs text-cream-100/80 shadow-inner">
                        <p class="flex justify-between items-center">
                            <span class="text-cream-100/50">Terakhir Diperbarui:</span>
                            <span class="font-semibold text-amber-300">{{ $lastUpdated ?? '-' }}</span>
                        </p>
                        <p class="flex justify-between items-center">
                            <span class="text-cream-100/50">Penyimpanan Data:</span>
                            <span class="font-semibold text-cream-100">Local JSON Storage</span>
                        </p>
                        <p class="flex justify-between items-center">
                            <span class="text-cream-100/50">Status Sistem:</span>
                            <span class="text-emerald-400 font-semibold flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-emerald-400"></span> Online</span>
                        </p>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-cream-100/50 gap-4">
                <p>&copy; {{ date('Y') }} Ruang Baca. Dioptimalkan tanpa database relasional.</p>
                <p class="italic font-serif text-sm text-cream-100/70">"Buku adalah cermin: kamu hanya melihat di dalamnya apa yang sudah kamu miliki."</p>
            </div>
        </div>
    </footer>

    <!-- Toast Notification dengan Animasi Slide & Fade -->
    <div id="toastNotification" class="fixed bottom-8 left-1/2 -translate-x-1/2 z-50 bg-dark dark:bg-accent text-white px-6 py-3.5 rounded-2xl shadow-2xl text-xs font-semibold tracking-wide flex items-center gap-2.5 opacity-0 pointer-events-none translate-y-4 transition-all duration-300 border border-white/10">
        <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
        <span id="toastMessage">Pesan Toast</span>
    </div>

    <script>
        function toggleTheme() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            }
        }

        function showToast(msg) {
            const toast = document.getElementById('toastNotification');
            document.getElementById('toastMessage').textContent = msg;
            toast.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-4');
            setTimeout(() => {
                toast.classList.add('opacity-0', 'pointer-events-none', 'translate-y-4');
            }, 2800);
        }

        function getBookmarks() {
            return JSON.parse(localStorage.getItem('ruangbaca_bookmarks') || '[]');
        }

        function toggleBookmark(slug) {
            let bookmarks = getBookmarks();
            if (bookmarks.includes(slug)) {
                bookmarks = bookmarks.filter(s => s !== slug);
                showToast('Dihapus dari Favorit Saya');
            } else {
                bookmarks.push(slug);
                showToast('Disimpan ke Favorit Saya');
            }
            localStorage.setItem('ruangbaca_bookmarks', JSON.stringify(bookmarks));
            if (typeof updateBookmarkUI === 'function') updateBookmarkUI();
        }

        function openFavoritesNav() {
            if (window.location.pathname === '/') {
                if (typeof switchCatalogTab === 'function') switchCatalogTab('favorites');
            } else {
                window.location.href = '/?tab=favorites#catalog';
            }
        }

        function triggerRandomModalFromFooter() {
            if (window.location.pathname === '/' && typeof pickRandomNovel === 'function') {
                pickRandomNovel();
            } else {
                window.location.href = '/';
            }
        }

        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>
</body>
</html>