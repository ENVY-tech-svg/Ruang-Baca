<!DOCTYPE html>
<html lang="id">
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
    </style>
</head>
<body class="bg-cream-100 text-dark dark:bg-darkBg dark:text-cream-100 font-sans antialiased flex flex-col min-h-screen transition-colors duration-300 relative">

    <!-- Header / Navbar Desktop & Mobile -->
    <header class="border-b border-black/5 dark:border-white/10 bg-cream-100/80 dark:bg-darkBg/80 backdrop-blur-md sticky top-0 z-40 transition-colors duration-300">
        <div class="max-w-6xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="{{ route('home') }}" class="group flex items-center gap-3">
                <span class="w-9 h-9 rounded-full bg-dark text-cream-100 dark:bg-accent dark:text-white flex items-center justify-center font-serif text-lg font-bold group-hover:scale-105 transition-all shadow-sm">RB</span>
                <span class="font-serif text-2xl tracking-tight font-bold text-dark dark:text-cream-100 group-hover:text-accent transition-colors">Ruang Baca</span>
            </a>

            <div class="flex items-center gap-4">
                <nav class="flex items-center gap-3 sm:gap-6 text-sm font-medium text-muted dark:text-cream-100/70">
                    <a href="{{ route('home') }}" class="hover:text-dark dark:hover:text-cream-100 transition-colors">Katalog</a>
                    
                    <!-- Menu Favorit di Navbar (Terlihat di Desktop & Mobile) -->
                    <button type="button" onclick="openFavoritesNav()" class="hover:text-dark dark:hover:text-cream-100 transition-colors flex items-center gap-1.5 py-1.5 px-3 rounded-xl bg-accent/10 dark:bg-accent/20 border border-accent/20 text-accent font-semibold text-xs sm:text-sm">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                        <span>Favorit</span>
                        <span id="navFavBadge" class="bg-accent text-white text-[10px] px-2 py-0.5 rounded-full font-bold">0</span>
                    </button>
                </nav>

                <!-- Switch Tema -->
                <button id="themeToggleBtn" onclick="toggleTheme()" type="button" class="p-2.5 rounded-xl bg-black/5 dark:bg-white/10 text-dark dark:text-cream-100 hover:bg-black/10 dark:hover:bg-white/20 transition-all">
                    <svg id="sunIcon" class="w-4 h-4 hidden dark:block text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <svg id="moonIcon" class="w-4 h-4 block dark:hidden text-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                </button>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-cream-100 dark:bg-black/50 border-t border-white/10 mt-20 transition-colors duration-300">
        <div class="max-w-6xl mx-auto px-6 py-12 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h3 class="font-serif text-2xl font-bold text-cream-100">Ruang Baca</h3>
                <p class="text-sm text-cream-100/60 mt-1">Arsip dan Kurasi Sastra Indonesia Berbasis File JSON Lokal.</p>
            </div>
            <div class="text-xs text-cream-100/50 text-center md:text-right space-y-1">
                <p>&copy; {{ date('Y') }} Ruang Baca. Tanpa Database Relasional & Eloquent.</p>
            </div>
        </div>
    </footer>

    <!-- Toast Notification -->
    <div id="toastNotification" class="fixed bottom-6 left-1/2 -translate-x-1/2 z-50 bg-dark dark:bg-accent text-white px-5 py-3 rounded-2xl shadow-2xl text-xs font-semibold tracking-wide flex items-center gap-2 opacity-0 pointer-events-none transition-all duration-300">
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
            toast.classList.remove('opacity-0', 'pointer-events-none');
            setTimeout(() => {
                toast.classList.add('opacity-0', 'pointer-events-none');
            }, 3000);
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
                window.location.href = '/?tab=favorites';
            }
        }
    </script>
</body>
</html>