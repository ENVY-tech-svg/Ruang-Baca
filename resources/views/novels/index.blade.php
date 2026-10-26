@extends('layouts.app')

@section('title', 'Katalog Rekomendasi Novel — Ruang Baca')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-12 relative">
    
    <!-- Hero Section dengan Ambient Floating Glow & Stats Ringkas -->
    <section class="relative mb-14 border-b border-black/10 dark:border-white/10 pb-14 transition-colors duration-300 overflow-hidden rounded-3xl p-2">
        <!-- Floating Light Blobs -->
        <div class="absolute -top-10 -left-10 w-72 h-72 bg-accent/20 dark:bg-accent/25 rounded-full blur-3xl pointer-events-none animate-float"></div>
        <div class="absolute top-1/2 -right-10 w-80 h-80 bg-amber-600/15 dark:bg-accent/20 rounded-full blur-3xl pointer-events-none animate-float-delayed"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-end justify-between gap-8">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-accent/10 dark:bg-accent/20 border border-accent/20 text-accent text-xs font-semibold uppercase tracking-widest mb-5 backdrop-blur-md shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-accent animate-pulse"></span>
                    Kurasi Editorial Sastra
                </div>
                <h1 class="font-serif text-4xl sm:text-5xl md:text-6xl font-bold text-dark dark:text-cream-100 leading-[1.12] tracking-tight">
                    Menjelajahi Cerita,<br class="hidden sm:inline"/> Menemukan Kehangatan Kata.
                </h1>
                <p class="text-muted dark:text-cream-100/70 text-base md:text-lg mt-4 leading-relaxed">
                    Selamat datang di Ruang Baca. Rekomendasi novel-novel pilihan dengan sudut pandang editorial yang tenang, elegan, dan nyaman dibaca.
                </p>
            </div>

            <!-- Stats Ringkas & Tombol Widget Acak -->
            <div class="flex flex-col items-start md:items-end gap-5 shrink-0">
                <div class="flex items-center gap-6 sm:gap-8 pt-4 md:pt-0 border-t md:border-t-0 border-black/10 dark:border-white/10">
                    <div class="text-center md:text-right">
                        <span class="font-serif text-3xl sm:text-4xl font-bold text-dark dark:text-cream-100 block">{{ $novels->total() }}</span>
                        <span class="text-[11px] text-muted dark:text-cream-100/60 uppercase tracking-wider font-semibold">Buku Terkurasi</span>
                    </div>
                    <div class="w-px h-10 bg-black/10 dark:bg-white/10"></div>
                    <div class="text-center md:text-right">
                        <span class="font-serif text-3xl sm:text-4xl font-bold text-amber-500 block">4.8★</span>
                        <span class="text-[11px] text-muted dark:text-cream-100/60 uppercase tracking-wider font-semibold">Rata-rata Rating</span>
                    </div>
                </div>

                <!-- Widget Tombol "Bingung Mau Baca Apa?" -->
                <button type="button" onclick="pickRandomNovel()" class="group relative overflow-hidden bg-gradient-to-r from-accent via-accent to-accentDark text-white px-6 py-3 rounded-2xl text-xs font-semibold shadow-lg hover:shadow-2xl transition-all duration-300 flex items-center gap-2.5 hover:scale-105 active:scale-95">
                    <span class="text-lg group-hover:rotate-180 transition-transform duration-500">🎲</span>
                    <span>Bingung Mau Baca Apa?</span>
                    <span class="bg-white/20 px-2 py-0.5 rounded-full text-[10px] uppercase font-bold tracking-wider backdrop-blur-sm">Acak Novel</span>
                </button>
            </div>
        </div>
    </section>

    <!-- Pilihan Editor (Spotlight Banner) - Hanya Muncul di Halaman 1 tanpa Filter -->
    @if(!request('search') && !request('genre') && request('page', 1) == 1 && isset($featured))
        <section id="spotlightSection" class="mb-14 relative z-10 transition-all duration-300">
            <div class="relative bg-white/80 dark:bg-darkCard/80 backdrop-blur-xl border border-black/5 dark:border-white/10 rounded-3xl p-6 md:p-8 overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 group">
                <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-accent/15 rounded-full blur-3xl pointer-events-none animate-pulse-glow"></div>

                <div class="relative z-10 grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
                    <div class="md:col-span-4 flex justify-center">
                        <div class="relative w-48 sm:w-56 h-72 rounded-2xl overflow-hidden bg-cream-300/40 dark:bg-black/40 p-4 shadow-xl border border-black/5 dark:border-white/10 flex items-center justify-center group-hover:scale-105 transition-transform duration-500">
                            <div class="skeleton-shimmer absolute inset-0 bg-gradient-to-r from-cream-200 via-white/40 dark:from-darkCard dark:via-white/5 dark:to-darkCard to-cream-200 animate-pulse"></div>
                            
                            <img 
                                src="{{ e($featured['cover_image']) }}" 
                                alt="{{ e($featured['title']) }}"
                                class="max-h-full w-auto object-contain drop-shadow-2xl relative z-10 opacity-0 transition-opacity duration-500"
                                onload="this.classList.remove('opacity-0'); if(this.previousElementSibling) this.previousElementSibling.remove();"
                                onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80'; this.classList.remove('opacity-0');"
                            >
                            <span class="absolute top-3 left-3 bg-accent text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-md z-20">
                                Sorotan Utama
                            </span>
                        </div>
                    </div>

                    <div class="md:col-span-8 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-2 mb-3">
                                @foreach((array)$featured['genre'] as $g)
                                    <span class="text-xs font-semibold text-accent bg-accent/10 dark:bg-accent/20 px-3 py-1 rounded-full border border-accent/20">
                                        {{ e($g) }}
                                    </span>
                                @endforeach
                                <span class="text-xs text-amber-500 font-bold ml-2">★ {{ number_format($featured['rating'], 1) }}</span>
                            </div>

                            <h2 class="font-serif text-3xl md:text-4xl font-bold text-dark dark:text-cream-100 group-hover:text-accent transition-colors">
                                <a href="{{ route('novels.show', $featured['slug']) }}">
                                    {{ e($featured['title']) }}
                                </a>
                            </h2>
                            <p class="text-sm text-muted dark:text-cream-100/70 font-medium mt-1">
                                Karya {{ e($featured['author']) }} &bull; {{ $featured['release_year'] ?? '-' }}
                            </p>

                            @if(!empty($featured['quote']))
                                <blockquote class="my-4 border-l-2 border-accent pl-4 italic font-serif text-base text-dark/90 dark:text-cream-100/90 line-clamp-2">
                                    "{{ e($featured['quote']) }}"
                                </blockquote>
                            @endif

                            <p class="text-sm text-muted/90 dark:text-cream-100/80 line-clamp-3 leading-relaxed mt-2">
                                {{ e($featured['synopsis']) }}
                            </p>
                        </div>

                        <div class="mt-6 pt-4 border-t border-black/5 dark:border-white/10 flex items-center justify-between">
                            <span class="text-xs text-muted/70 dark:text-cream-100/50 italic">Edisi {{ e($featured['publisher'] ?? 'Umum') }}</span>
                            <a href="{{ route('novels.show', $featured['slug']) }}" class="bg-dark dark:bg-accent text-cream-100 dark:text-white hover:bg-accent dark:hover:bg-accentDark px-5 py-2.5 rounded-xl text-xs font-semibold transition-all shadow-md flex items-center gap-2 hover:translate-x-1">
                                Baca Ulasan Lengkap &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- ANCHOR TARGET KATALOG (Target Scroll) -->
    <div id="catalog" class="scroll-mt-24"></div>

    <!-- TAB NAVIGASI KATALOG -->
    <div class="flex items-center justify-between gap-4 mb-6 relative z-30">
        <div class="inline-flex items-center gap-2 p-1.5 bg-black/5 dark:bg-white/5 backdrop-blur-md rounded-2xl border border-black/10 dark:border-white/10 shadow-sm">
            <button 
                type="button" 
                id="tabAllBtn" 
                onclick="switchCatalogTab('all')" 
                class="px-6 py-2.5 rounded-xl text-xs sm:text-sm font-semibold bg-accent text-white shadow-md active-tab-glow transition-all duration-300"
            >
                Semua Novel
            </button>
            <button 
                type="button" 
                id="tabFavBtn" 
                onclick="switchCatalogTab('favorites')" 
                class="px-6 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-muted dark:text-cream-100/70 hover:text-dark dark:hover:text-cream-100 transition-all duration-300 flex items-center gap-2"
            >
                <span>Favorit Saya</span>
                <span id="favCountBadge" class="bg-accent/20 text-accent dark:bg-accent/30 text-[11px] px-2 py-0.5 rounded-full font-bold">0</span>
            </button>
        </div>
    </div>

    <!-- Filter Bar -->
    <section id="filterSection" class="mb-10 relative z-30 transition-all duration-300">
        <form action="{{ route('home') }}#catalog" method="GET" class="space-y-4 md:space-y-0 md:flex md:items-center md:gap-3 bg-white/70 dark:bg-darkCard/70 backdrop-blur-xl p-3 rounded-2xl border border-black/5 dark:border-white/10 shadow-sm relative z-30">
            <div class="relative flex-grow">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari judul novel, penulis, atau sinopsis..."
                    class="w-full bg-white dark:bg-darkCard/80 border border-black/10 dark:border-white/10 rounded-xl px-4 py-3 pl-10 text-sm text-dark dark:text-cream-100 focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent transition-all placeholder:text-muted/60 dark:placeholder:text-cream-100/40"
                >
                <svg class="w-4 h-4 absolute left-3.5 top-3.5 text-muted dark:text-cream-100/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            <div class="w-full md:w-48 relative" id="genreDropdownContainer">
                <input type="hidden" name="genre" id="selectedGenreInput" value="{{ request('genre') }}">
                <button type="button" onclick="toggleGenreDropdown()" class="w-full bg-white dark:bg-darkCard/80 border border-black/10 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-left flex items-center justify-between focus:outline-none text-dark dark:text-cream-100">
                    <span class="truncate font-medium">{{ request('genre') ? request('genre') : 'Semua Genre' }}</span>
                    <svg class="w-4 h-4 text-muted dark:text-cream-100/50 transition-transform duration-200" id="genreArrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div id="genreDropdownMenu" class="hidden absolute left-0 right-0 mt-2 bg-white dark:bg-darkCard border border-black/10 dark:border-white/10 rounded-xl shadow-2xl max-h-56 overflow-y-auto z-50 py-1.5 text-sm backdrop-blur-md">
                    <div onclick="selectGenre('')" class="px-4 py-2.5 hover:bg-cream-100 dark:hover:bg-white/10 cursor-pointer transition-colors">Semua Genre</div>
                    @foreach($genres as $g)
                        <div onclick="selectGenre('{{ $g }}')" class="px-4 py-2.5 hover:bg-cream-100 dark:hover:bg-white/10 cursor-pointer transition-colors">{{ $g }}</div>
                    @endforeach
                </div>
            </div>

            <div class="w-full md:w-44">
                <select name="sort" onchange="this.form.submit()" class="w-full bg-white dark:bg-darkCard/80 border border-black/10 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-dark dark:text-cream-100 focus:outline-none font-medium">
                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>★ Rating Tertinggi</option>
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>📅 Tahun Terbaru</option>
                    <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>🔤 Judul (A-Z)</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="bg-dark dark:bg-accent text-cream-100 dark:text-white hover:bg-accent px-6 py-3 rounded-xl text-sm font-medium transition-all hover:shadow-md active:scale-95">Cari</button>
                @if(request('search') || request('genre') || request('sort') !== 'rating')
                    <a href="{{ route('home') }}#catalog" class="bg-black/5 dark:bg-white/10 hover:bg-black/10 text-dark dark:text-cream-100 px-4 py-3 rounded-xl text-sm font-medium transition-colors">Reset</a>
                @endif
            </div>
        </form>
    </section>

    <!-- Grid Kartu Novel Interaktif -->
    @if($novels->count() > 0)
        <div id="novelGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 relative z-10">
            @foreach($novels as $novel)
                @php
                    $genresList = (array) $novel['genre'];
                    $visibleGenres = array_slice($genresList, 0, 2);
                    $extraCount = count($genresList) - count($visibleGenres);
                @endphp

                <article class="bg-white/90 dark:bg-darkCard/90 backdrop-blur-md border border-black/5 dark:border-white/10 hover:border-accent/50 rounded-3xl overflow-hidden card-hover-effect flex flex-col group relative" data-slug="{{ $novel['slug'] }}">
                    <div class="relative h-80 overflow-hidden bg-cream-300/40 dark:bg-black/40 p-5 flex items-center justify-center">
                        <div class="skeleton-shimmer absolute inset-0 bg-gradient-to-r from-cream-200 via-white/40 dark:from-darkCard dark:via-white/5 dark:to-darkCard to-cream-200 animate-pulse"></div>

                        <img 
                            src="{{ e($novel['cover_image']) }}" 
                            alt="Cover {{ e($novel['title']) }}" 
                            class="max-h-full w-auto object-contain drop-shadow-xl group-hover:scale-105 group-hover:-rotate-1 transition-all duration-500 ease-out opacity-0" 
                            loading="lazy" 
                            onload="this.classList.remove('opacity-0'); if(this.previousElementSibling) this.previousElementSibling.remove();"
                            onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80'; this.classList.remove('opacity-0');"
                        >
                        
                        <div class="absolute top-3 left-3 flex items-center gap-1.5 max-w-[70%] flex-wrap z-20">
                            @foreach($visibleGenres as $g)
                                <span class="bg-dark/80 dark:bg-black/80 backdrop-blur-md text-cream-100 text-[10px] px-2.5 py-0.5 rounded-full border border-white/10 font-medium">{{ e($g) }}</span>
                            @endforeach
                            @if($extraCount > 0)
                                <span class="bg-accent/90 text-white text-[10px] font-bold px-2 py-0.5 rounded-full border border-white/10">+{{ $extraCount }}</span>
                            @endif
                        </div>

                        <button type="button" onclick="toggleBookmark('{{ $novel['slug'] }}')" class="bookmark-btn absolute bottom-3 right-3 p-2.5 rounded-full bg-dark/70 dark:bg-black/70 text-white hover:bg-accent transition-all shadow-lg hover:scale-110 active:scale-90 z-20" title="Simpan Novel">
                            <svg class="w-4 h-4 bookmark-icon transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                        </button>

                        @if($novel['rating'] > 0)
                            <div class="absolute top-3 right-3 bg-accent/90 backdrop-blur-md text-white font-semibold text-xs px-2.5 py-1 rounded-full flex items-center gap-1 shadow-md z-20">
                                <span class="text-amber-200">★</span> {{ number_format($novel['rating'], 1) }}
                            </div>
                        @endif
                    </div>

                    <div class="p-6 flex flex-col flex-grow justify-between">
                        <div>
                            <div class="text-xs text-muted dark:text-cream-100/60 mb-1.5 font-medium flex items-center gap-1.5">
                                <span>{{ e($novel['author']) }}</span>
                                <span>&bull;</span>
                                <span>{{ $novel['release_year'] ?? '-' }}</span>
                            </div>
                            <h2 class="font-serif text-xl font-bold text-dark dark:text-cream-100 group-hover:text-accent transition-colors line-clamp-1">
                                <a href="{{ route('novels.show', $novel['slug']) }}">{{ e($novel['title']) }}</a>
                            </h2>
                            <p class="text-sm text-muted/90 dark:text-cream-100/70 mt-3 line-clamp-3 leading-relaxed">
                                {{ e($novel['synopsis']) }}
                            </p>
                        </div>

                        <div class="mt-6 pt-4 border-t border-black/5 dark:border-white/10 flex items-center justify-between">
                            <button type="button" onclick="openQuickPreview({{ json_encode($novel) }})" class="text-xs font-medium text-muted hover:text-dark dark:hover:text-cream-100 flex items-center gap-1 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Intip Cepat
                            </button>
                            <a href="{{ route('novels.show', $novel['slug']) }}" class="text-xs font-semibold text-accent hover:text-accentDark inline-flex items-center gap-1 group-hover:translate-x-1.5 transition-transform">
                                Baca Kurasi &rarr;
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div id="paginationContainer" class="mt-14 flex justify-center">
            {{ $novels->fragment('catalog')->links('pagination::tailwind') }}
        </div>

        <div id="emptyFavState" class="hidden bg-white/80 dark:bg-darkCard/80 backdrop-blur-xl border border-black/5 dark:border-white/10 rounded-3xl p-12 text-center max-w-lg mx-auto my-12 shadow-sm">
            <svg class="w-12 h-12 text-muted/40 dark:text-cream-100/40 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
            <h3 class="font-serif text-2xl font-bold text-dark dark:text-cream-100">Belum Ada Novel Favorit</h3>
            <p class="text-sm text-muted dark:text-cream-100/60 mt-2">Anda belum menyimpan novel apapun. Klik ikon pita bookmark pada kartu novel untuk menyimpannya ke daftar ini.</p>
            <button type="button" onclick="switchCatalogTab('all')" class="mt-6 bg-accent hover:bg-accentDark text-white px-6 py-2.5 rounded-xl text-sm font-medium shadow-md transition-colors">
                Jelajahi Katalog
            </button>
        </div>
    @else
        <div class="bg-white/80 dark:bg-darkCard/80 backdrop-blur-xl border border-black/5 dark:border-white/10 rounded-3xl p-12 text-center max-w-lg mx-auto my-12 shadow-sm">
            <h3 class="font-serif text-2xl font-bold text-dark dark:text-cream-100">Novel Tidak Ditemukan</h3>
            <p class="text-sm text-muted dark:text-cream-100/60 mt-2">Maaf, kami tidak menemukan novel yang cocok dengan kriteria pencarian Anda saat ini.</p>
            <a href="{{ route('home') }}#catalog" class="inline-block mt-6 bg-dark dark:bg-accent text-cream-100 dark:text-white px-6 py-2.5 rounded-xl text-sm font-medium shadow-md">Lihat Semua Novel</a>
        </div>
    @endif

</div>

<!-- Modal Intip Cepat & Modal Random Book -->
<div id="quickPreviewModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-md opacity-0 pointer-events-none transition-all duration-300">
    <div class="bg-white/95 dark:bg-darkCard/95 backdrop-blur-2xl border border-black/10 dark:border-white/10 rounded-3xl max-w-2xl w-full p-6 md:p-8 shadow-2xl relative transform scale-95 transition-all duration-300 max-h-[90vh] overflow-y-auto">
        
        <div class="flex items-center justify-between pb-4 mb-4 border-b border-black/5 dark:border-white/10">
            <span id="qpModalBadge" class="text-[10px] font-bold uppercase tracking-widest text-accent bg-accent/10 px-3 py-1 rounded-full border border-accent/20">
                Quick Preview
            </span>
            <button type="button" onclick="closeQuickPreview()" class="p-1.5 text-muted hover:text-dark dark:hover:text-cream-100 rounded-full hover:bg-black/5 dark:hover:bg-white/10 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
            <div class="md:col-span-4 flex justify-center">
                <img id="qpImage" src="" alt="" class="w-40 h-56 object-contain rounded-xl bg-cream-200 dark:bg-black/40 p-2 shadow-lg transition-all duration-300">
            </div>
            <div class="md:col-span-8">
                <span id="qpGenre" class="text-xs font-semibold text-accent uppercase tracking-wider block mb-1"></span>
                <h3 id="qpTitle" class="font-serif text-2xl font-bold text-dark dark:text-cream-100"></h3>
                <p id="qpAuthor" class="text-xs text-muted dark:text-cream-100/60 mt-0.5 mb-3"></p>
                <blockquote id="qpQuote" class="border-l-2 border-accent pl-3 italic text-sm text-dark/80 dark:text-cream-100/80 mb-4 hidden"></blockquote>
                <p id="qpSynopsis" class="text-xs text-muted dark:text-cream-100/70 leading-relaxed line-clamp-4 mb-6"></p>
                
                <div class="flex items-center gap-3">
                    <a id="qpDetailBtn" href="" class="inline-block bg-accent hover:bg-accentDark text-white px-5 py-2.5 rounded-xl text-xs font-semibold shadow-md transition-colors">Halaman Detail Lengkap &rarr;</a>
                    <button type="button" id="qpReshuffleBtn" onclick="pickRandomNovel()" class="hidden bg-black/5 dark:bg-white/10 hover:bg-black/10 text-dark dark:text-cream-100 px-4 py-2.5 rounded-xl text-xs font-semibold transition-colors flex items-center gap-1.5 active:scale-95">
                        <span class="inline-block transition-transform duration-300">🎲</span> Acak Lagi
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let currentCatalogTab = 'all';
    const allNovelsList = @json($novels->items());

    function toggleGenreDropdown() {
        document.getElementById('genreDropdownMenu').classList.toggle('hidden');
        document.getElementById('genreArrow').classList.toggle('rotate-180');
    }

    function selectGenre(val) {
        document.getElementById('selectedGenreInput').value = val;
        document.getElementById('selectedGenreInput').closest('form').submit();
    }

    document.addEventListener('click', function(event) {
        const container = document.getElementById('genreDropdownContainer');
        if (container && !container.contains(event.target)) {
            const menu = document.getElementById('genreDropdownMenu');
            const arrow = document.getElementById('genreArrow');
            if (menu) menu.classList.add('hidden');
            if (arrow) arrow.classList.remove('rotate-180');
        }
    });

    function openQuickPreview(novel, isRandom = false) {
        const modalBadge = document.getElementById('qpModalBadge');
        const reshuffleBtn = document.getElementById('qpReshuffleBtn');

        if (isRandom) {
            modalBadge.textContent = '🎲 Rekomendasi Acak Hari Ini';
            reshuffleBtn.classList.remove('hidden');
        } else {
            modalBadge.textContent = 'Quick Preview';
            reshuffleBtn.classList.add('hidden');
        }

        document.getElementById('qpImage').src = novel.cover_image;
        document.getElementById('qpGenre').textContent = Array.isArray(novel.genre) ? novel.genre.join(', ') : novel.genre;
        document.getElementById('qpTitle').textContent = novel.title;
        document.getElementById('qpAuthor').textContent = 'Karya ' + novel.author + ' (' + (novel.release_year || '-') + ')';
        document.getElementById('qpSynopsis').textContent = novel.synopsis;
        document.getElementById('qpDetailBtn').href = '/novel/' + novel.slug;

        const qpQuote = document.getElementById('qpQuote');
        if (novel.quote) {
            qpQuote.textContent = '"' + novel.quote + '"';
            qpQuote.classList.remove('hidden');
        } else {
            qpQuote.classList.add('hidden');
        }

        const modal = document.getElementById('quickPreviewModal');
        modal.classList.remove('opacity-0', 'pointer-events-none');
        modal.firstElementChild.classList.remove('scale-95');
    }

    function pickRandomNovel() {
        if (!allNovelsList || allNovelsList.length === 0) return;
        
        const img = document.getElementById('qpImage');
        if (img) img.classList.add('scale-90', 'opacity-50');

        setTimeout(() => {
            const randomIndex = Math.floor(Math.random() * allNovelsList.length);
            const randomNovel = allNovelsList[randomIndex];
            openQuickPreview(randomNovel, true);
            if (img) img.classList.remove('scale-90', 'opacity-50');
        }, 180);
    }

    function closeQuickPreview() {
        const modal = document.getElementById('quickPreviewModal');
        modal.classList.add('opacity-0', 'pointer-events-none');
        modal.firstElementChild.classList.add('scale-95');
    }

    function switchCatalogTab(tab) {
        currentCatalogTab = tab;
        const btnAll = document.getElementById('tabAllBtn');
        const btnFav = document.getElementById('tabFavBtn');
        const filterSection = document.getElementById('filterSection');
        const spotlightSection = document.getElementById('spotlightSection');
        const paginationContainer = document.getElementById('paginationContainer');

        if (tab === 'favorites') {
            if (btnAll) btnAll.className = "px-6 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-muted dark:text-cream-100/70 hover:text-dark dark:hover:text-cream-100 transition-all duration-200";
            if (btnFav) btnFav.className = "px-6 py-2.5 rounded-xl text-xs sm:text-sm font-semibold bg-accent text-white shadow-md active-tab-glow transition-all duration-200 flex items-center gap-2";
            if (filterSection) filterSection.classList.add('hidden');
            if (spotlightSection) spotlightSection.classList.add('hidden');
            if (paginationContainer) paginationContainer.classList.add('hidden');
            filterFavoriteCards();
        } else {
            if (btnFav) btnFav.className = "px-6 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-muted dark:text-cream-100/70 hover:text-dark dark:hover:text-cream-100 transition-all duration-200 flex items-center gap-2";
            if (btnAll) btnAll.className = "px-6 py-2.5 rounded-xl text-xs sm:text-sm font-semibold bg-accent text-white shadow-md active-tab-glow transition-all duration-200";
            if (filterSection) filterSection.classList.remove('hidden');
            if (spotlightSection) spotlightSection.classList.remove('hidden');
            if (paginationContainer) paginationContainer.classList.remove('hidden');
            
            document.querySelectorAll('article[data-slug]').forEach(art => art.classList.remove('hidden'));
            const emptyFavState = document.getElementById('emptyFavState');
            const novelGrid = document.getElementById('novelGrid');
            if (emptyFavState) emptyFavState.classList.add('hidden');
            if (novelGrid) novelGrid.classList.remove('hidden');
        }
    }

    function filterFavoriteCards() {
        const bookmarks = getBookmarks();
        const cards = document.querySelectorAll('article[data-slug]');
        let visibleCount = 0;

        cards.forEach(art => {
            const slug = art.getAttribute('data-slug');
            if (bookmarks.includes(slug)) {
                art.classList.remove('hidden');
                visibleCount++;
            } else {
                art.classList.add('hidden');
            }
        });

        const emptyFavState = document.getElementById('emptyFavState');
        const novelGrid = document.getElementById('novelGrid');

        if (visibleCount === 0) {
            if (novelGrid) novelGrid.classList.add('hidden');
            if (emptyFavState) emptyFavState.classList.remove('hidden');
        } else {
            if (novelGrid) novelGrid.classList.remove('hidden');
            if (emptyFavState) emptyFavState.classList.add('hidden');
        }
    }

    function updateBookmarkUI() {
        const bookmarks = getBookmarks();
        
        const badge = document.getElementById('favCountBadge');
        const navBadge = document.getElementById('navFavBadge');
        if (badge) badge.textContent = bookmarks.length;
        if (navBadge) navBadge.textContent = bookmarks.length;

        document.querySelectorAll('article[data-slug]').forEach(art => {
            const slug = art.getAttribute('data-slug');
            const icon = art.querySelector('.bookmark-icon');
            if (icon) {
                if (bookmarks.includes(slug)) {
                    icon.setAttribute('fill', 'currentColor');
                } else {
                    icon.setAttribute('fill', 'none');
                }
            }
        });

        if (currentCatalogTab === 'favorites') {
            filterFavoriteCards();
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        
        if (urlParams.get('tab') === 'favorites') {
            switchCatalogTab('favorites');
        }

        // Auto-scroll ke catalog jika ada query parameter (page, search, genre, sort, tab) atau hashtag #catalog
        const hasCatalogQuery = urlParams.has('page') || urlParams.has('search') || urlParams.has('genre') || urlParams.has('sort') || urlParams.has('tab');
        const hasCatalogHash = window.location.hash === '#catalog';

        if (hasCatalogHash || hasCatalogQuery) {
            const catalogElem = document.getElementById('catalog');
            if (catalogElem) {
                setTimeout(() => {
                    catalogElem.scrollIntoView({ behavior: 'smooth' });
                }, 100);
            }
        }

        updateBookmarkUI();
    });
</script>
@endsection