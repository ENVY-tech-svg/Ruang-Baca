@extends('layouts.app')

@section('title', e($novel['title']) . ' — Ruang Baca')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-12">
    
    <!-- Tombol Kembali -->
    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm text-muted dark:text-cream-100/70 hover:text-dark dark:hover:text-cream-100 mb-8 transition-colors">
        &larr; Kembali ke Katalog
    </a>

    <!-- Detail Header & Grid -->
    <div class="bg-white dark:bg-darkCard border border-black/5 dark:border-white/10 rounded-2xl p-6 md:p-10 shadow-sm transition-colors duration-300">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 md:gap-12 items-start">
            
            <!-- Cover Image -->
            <div class="md:col-span-4">
                <div class="rounded-xl overflow-hidden bg-cream-200 dark:bg-black/40 shadow-md p-3 flex items-center justify-center">
                    <img 
                        src="{{ e($novel['cover_image']) }}" 
                        alt="Cover {{ e($novel['title']) }}"
                        class="w-full h-auto max-h-[420px] object-contain drop-shadow-md rounded-lg"
                        onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80';"
                    >
                </div>
            </div>

            <!-- Metadata Detail -->
            <div class="md:col-span-8 flex flex-col justify-between h-full">
                <div>
                    <!-- Badge Genre (Multi-Genre Loop) -->
                    <div class="flex flex-wrap items-center gap-2 mb-3">
                        @foreach((array)$novel['genre'] as $g)
                            <span class="bg-accent/10 dark:bg-accent/20 text-accent font-semibold text-xs px-3 py-1 rounded-full border border-accent/20">
                                {{ e($g) }}
                            </span>
                        @endforeach
                        <span class="text-xs text-muted dark:text-cream-100/60">&bull; {{ $novel['release_year'] ?? '-' }}</span>
                        @if($novel['rating'] > 0)
                            <span class="text-amber-600 dark:text-amber-400 font-semibold text-xs">&starf; {{ number_format($novel['rating'], 1) }} <span class="text-muted dark:text-cream-100/50 text-[10px] font-normal">(Kurasi Editorial)</span></span>
                        @endif
                    </div>

                    <h1 class="font-serif text-3xl md:text-5xl font-bold text-dark dark:text-cream-100 leading-tight">
                        {{ e($novel['title']) }}
                    </h1>
                    
                    <p class="text-lg text-muted dark:text-cream-100/70 mt-2 font-medium">
                        Karya <span class="text-dark dark:text-cream-100 font-semibold">{{ e($novel['author']) }}</span>
                    </p>

                    <!-- Informasi Spesifikasi Buku & Estimasi Waktu Baca -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 my-6 p-4 rounded-xl bg-cream-100/60 dark:bg-black/20 border border-black/5 dark:border-white/10 text-xs">
                        <div>
                            <span class="text-muted dark:text-cream-100/60 block mb-0.5">Penerbit</span>
                            <span class="font-semibold text-dark dark:text-cream-100">{{ e($novel['publisher'] ?? '-') }}</span>
                        </div>
                        <div>
                            <span class="text-muted dark:text-cream-100/60 block mb-0.5">Halaman</span>
                            <span class="font-semibold text-dark dark:text-cream-100">{{ $novel['total_pages'] ? $novel['total_pages'] . ' hal.' : '-' }}</span>
                        </div>
                        <div>
                            <span class="text-muted dark:text-cream-100/60 block mb-0.5">Estimasi Baca</span>
                            <span class="font-semibold text-accent">{{ $novel['total_pages'] ? ceil($novel['total_pages'] / 60) . ' Jam' : '-' }}</span>
                        </div>
                        <div>
                            <span class="text-muted dark:text-cream-100/60 block mb-0.5">Tema Utama</span>
                            <span class="font-semibold text-dark dark:text-cream-100">{{ e($novel['main_theme']) }}</span>
                        </div>
                    </div>

                    <!-- Quote Editorial & Tombol Salin Kutipan -->
                    @if(!empty($novel['quote']))
                        <div class="my-6 p-4 rounded-xl bg-cream-300/30 dark:bg-black/30 border-l-4 border-accent relative group">
                            <blockquote class="italic font-serif text-lg text-dark/90 dark:text-cream-100/90 leading-relaxed">
                                "{{ e($novel['quote']) }}"
                            </blockquote>
                            <button type="button" onclick="copyQuote({{ json_encode($novel['quote']) }})" class="mt-3 text-xs font-semibold text-accent hover:text-accentDark inline-flex items-center gap-1 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                Salin Kutipan
                            </button>
                        </div>
                    @endif

                    <!-- Sinopsis -->
                    <div class="mt-6">
                        <h3 class="text-xs uppercase tracking-widest font-semibold text-accent mb-2">Sinopsis</h3>
                        <p class="text-dark/80 dark:text-cream-100/80 text-sm md:text-base leading-relaxed whitespace-pre-line">
                            {{ e($novel['synopsis']) }}
                        </p>
                    </div>
                </div>

                <!-- Action Buttons: Beli, Bagikan & Bookmark -->
                <div class="mt-8 pt-6 border-t border-black/5 dark:border-white/10 flex flex-wrap items-center gap-3">
                    @if(!empty($novel['gramedia_link']))
                        <a 
                            href="{{ e($novel['gramedia_link']) }}" 
                            target="_blank" 
                            rel="noopener noreferrer"
                            class="bg-accent hover:bg-accentDark text-white px-6 py-3 rounded-xl text-sm font-medium transition-colors shadow-sm inline-flex items-center gap-2"
                        >
                            Beli Resmi di Gramedia
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    @endif

                    <!-- Tombol Bagikan -->
                    <button type="button" onclick="shareNovel()" class="bg-black/5 dark:bg-white/10 hover:bg-black/10 dark:hover:bg-white/20 text-dark dark:text-cream-100 px-5 py-3 rounded-xl text-sm font-medium transition-colors inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                        Bagikan
                    </button>

                    <!-- Tombol Favorit -->
                    <button type="button" onclick="toggleBookmark('{{ $novel['slug'] }}')" class="bg-black/5 dark:bg-white/10 hover:bg-black/10 dark:hover:bg-white/20 text-dark dark:text-cream-100 px-5 py-3 rounded-xl text-sm font-medium transition-colors inline-flex items-center gap-2">
                        <svg id="detailBookmarkIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                        Favorit
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Rekomendasi Novel Lain -->
    @if(isset($recommendations) && $recommendations->count() > 0)
        <section class="mt-16">
            <h2 class="font-serif text-2xl font-bold text-dark dark:text-cream-100 mb-6">Rekomendasi Lainnya</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($recommendations as $rec)
                    <a href="{{ route('novels.show', $rec['slug']) }}" class="group bg-white dark:bg-darkCard border border-black/5 dark:border-white/10 hover:border-accent/40 rounded-xl p-4 flex gap-4 items-center hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        <img 
                            src="{{ e($rec['cover_image']) }}" 
                            alt="{{ e($rec['title']) }}"
                            class="w-16 h-20 object-cover rounded-md bg-cream-200 dark:bg-black/40 shadow-sm"
                            onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80';"
                        >
                        <div>
                            <span class="text-[10px] text-accent font-semibold uppercase tracking-wider block">
                                {{ implode(', ', (array)$rec['genre']) }}
                            </span>
                            <h4 class="font-serif font-bold text-dark dark:text-cream-100 text-base group-hover:text-accent transition-colors line-clamp-1">
                                {{ e($rec['title']) }}
                            </h4>
                            <p class="text-xs text-muted dark:text-cream-100/60 mt-1">{{ e($rec['author']) }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

</div>

<!-- Script Interaksi Halaman Detail -->
<script>
    function copyQuote(text) {
        navigator.clipboard.writeText(text).then(() => {
            showToast('Kutipan berhasil disalin ke clipboard!');
        });
    }

    function shareNovel() {
        if (navigator.share) {
            navigator.share({
                title: '{{ e($novel["title"]) }} — Ruang Baca',
                text: 'Rekomendasi novel {{ e($novel["title"]) }} karya {{ e($novel["author"]) }} di Ruang Baca.',
                url: window.location.href,
            }).catch(() => {});
        } else {
            navigator.clipboard.writeText(window.location.href).then(() => {
                showToast('Tautan novel disalin ke clipboard!');
            });
        }
    }

    function updateBookmarkUI() {
        const bookmarks = getBookmarks();
        const icon = document.getElementById('detailBookmarkIcon');
        if (icon) {
            if (bookmarks.includes('{{ $novel["slug"] }}')) {
                icon.setAttribute('fill', 'currentColor');
            } else {
                icon.setAttribute('fill', 'none');
            }
        }
    }

    document.addEventListener('DOMContentLoaded', updateBookmarkUI);
</script>
@endsection