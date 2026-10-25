<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class NovelJsonService
{
    protected string $cacheKey = 'ruang_baca_novels_data';

    /**
     * Membaca dan mengembalikan data novel dalam bentuk array.
     */
    public function getAll(): array
    {
        return Cache::remember($this->cacheKey, 3600, function () {
            return $this->loadDataFromFile();
        });
    }

    /**
     * Membaca file fisik JSON dari storage/app/data/novels.json
     */
    protected function loadDataFromFile(): array
    {
        $fullPath = storage_path('app/data/novels.json');

        if (!file_exists($fullPath)) {
            Log::error("Ruang Baca: File JSON tidak ditemukan di: {$fullPath}");
            throw new Exception("Sumber data novel tidak ditemukan. Pastikan file JSON tersedia.");
        }

        $content = file_get_contents($fullPath);

        if (empty(trim($content))) {
            Log::error("Ruang Baca: File JSON kosong.");
            throw new Exception("Sumber data novel kosong.");
        }

        $data = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error("Ruang Baca: Format JSON tidak valid. Error: " . json_last_error_msg());
            throw new Exception("Format data novel tidak valid. Harap periksa sintaks JSON.");
        }

        return $this->validateAndSanitizeData($data);
    }

    /**
     * Memvalidasi struktur dasar setiap item novel.
     */
    protected function validateAndSanitizeData(array $novels): array
    {
        $sanitized = [];

        foreach ($novels as $novel) {
            if (!is_array($novel) || !isset($novel['slug'], $novel['title'])) {
                continue;
            }

            $sanitized[] = [
                'id' => $novel['id'] ?? uniqid('nv-'),
                'title' => (string) ($novel['title'] ?? 'Tanpa Judul'),
                'slug' => (string) $novel['slug'],
                'author' => (string) ($novel['author'] ?? 'Penulis Tidak Diketahui'),
                'publisher' => $novel['publisher'] ?? null,
                'release_year' => isset($novel['release_year']) ? (int) $novel['release_year'] : null,
                'total_pages' => isset($novel['total_pages']) ? (int) $novel['total_pages'] : null,
                
                // Mendukung multi-genre (array) maupun genre tunggal (string)
                'genre' => is_array($novel['genre'] ?? null) 
                    ? array_map('strval', $novel['genre']) 
                    : [ (string) ($novel['genre'] ?? 'Umum') ],

                'main_theme' => (string) ($novel['main_theme'] ?? '-'),
                'rating' => isset($novel['rating']) ? (float) $novel['rating'] : 0.0,
                'synopsis' => (string) ($novel['synopsis'] ?? 'Sinopsis belum tersedia.'),
                'quote' => (string) ($novel['quote'] ?? ''),
                'cover_image' => (string) ($novel['cover_image'] ?? 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80'),
                'gramedia_link' => !empty($novel['gramedia_link']) && filter_var($novel['gramedia_link'], FILTER_VALIDATE_URL) ? $novel['gramedia_link'] : null,
                'created_at' => $novel['created_at'] ?? now()->toIso8601String(),
                'updated_at' => $novel['updated_at'] ?? now()->toIso8601String(),
            ];
        }

        return $sanitized;
    }

    /**
     * Mengambil novel berdasarkan slug.
     */
    public function findBySlug(string $slug): ?array
    {
        $novels = $this->getAll();

        foreach ($novels as $novel) {
            if ($novel['slug'] === $slug) {
                return $novel;
            }
        }

        return null;
    }

    /**
     * Mendapatkan waktu terakhir file JSON diperbarui.
     */
    public function getLastModified(): string
    {
        $fullPath = storage_path('app/data/novels.json');
        if (file_exists($fullPath)) {
            return date('d M Y, H:i', filemtime($fullPath));
        }
        return now()->format('d M Y, H:i');
    }

    /**
     * Membersihkan cache internal.
     */
    public function clearCache(): void
    {
        Cache::forget($this->cacheKey);
    }
}