@extends('layouts.app')

@section('title', 'Kesalahan Server — Ruang Baca')

@section('content')
<div class="max-w-md mx-auto px-6 py-24 text-center">
    <span class="font-serif text-8xl font-bold text-red-800/30 block mb-2">500</span>
    <h1 class="font-serif text-3xl font-bold text-dark">Terjadi Kesalahan Data</h1>
    <p class="text-sm text-muted mt-3">
        {{ $message ?? 'Gagal membaca sumber data novel. Harap pastikan format file JSON valid.' }}
    </p>
    <a href="{{ route('home') }}" class="inline-block mt-8 bg-dark text-cream-100 hover:bg-accent px-6 py-3 rounded-lg text-sm font-medium transition-colors">
        Coba Muat Ulang
    </a>
</div>
@endsection