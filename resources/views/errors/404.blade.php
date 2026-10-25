@extends('layouts.app')

@section('title', 'Halaman Tidak Ditemukan — Ruang Baca')

@section('content')
<div class="max-w-md mx-auto px-6 py-24 text-center">
    <span class="font-serif text-8xl font-bold text-accent/30 block mb-2">404</span>
    <h1 class="font-serif text-3xl font-bold text-dark">Halaman Tidak Ditemukan</h1>
    <p class="text-sm text-muted mt-3">
        Maaf, novel atau halaman yang Anda cari tidak tersedia di dalam arsip JSON Ruang Baca.
    </p>
    <a href="{{ route('home') }}" class="inline-block mt-8 bg-dark text-cream-100 hover:bg-accent px-6 py-3 rounded-lg text-sm font-medium transition-colors">
        Kembali ke Beranda
    </a>
</div>
@endsection