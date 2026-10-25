<?php

namespace App\Repositories;

use App\Services\NovelJsonService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class NovelRepository
{
    protected NovelJsonService $service;

    public function __construct(NovelJsonService $service)
    {
        $this->service = $service;
    }

    /**
     * Mendapatkan daftar genre unik dari seluruh novel.
     */
    public function getGenres(): array
    {
        $allGenres = [];
        foreach ($this->service->getAll() as $novel) {
            $genres = (array) ($novel['genre'] ?? []);
            $allGenres = array_merge($allGenres, $genres);
        }

        $unique = array_unique(array_filter($allGenres));
        sort($unique);

        return array_values($unique);
    }

    /**
     * Mendapatkan data terfilter, tersaring (Fuzzy Multi-Word Search), dan terpaginasi.
     */
    public function getPaginated(?string $search = null, ?string $genre = null, ?string $sort = 'rating', int $perPage = 6): LengthAwarePaginator
    {
        $collection = collect($this->service->getAll());

        if (!empty($search)) {
            // Memecah input pencarian menjadi kata-kata terpisah (Fuzzy Search)
            $words = array_filter(explode(' ', mb_strtolower(trim($search))));

            $collection = $collection->filter(function ($item) use ($words) {
                $title = mb_strtolower($item['title'] ?? '');
                $author = mb_strtolower($item['author'] ?? '');
                $synopsis = mb_strtolower($item['synopsis'] ?? '');

                // Memastikan setiap kata kunci ditemukan di judul, penulis, atau sinopsis
                foreach ($words as $word) {
                    $match = (mb_strpos($title, $word) !== false) ||
                             (mb_strpos($author, $word) !== false) ||
                             (mb_strpos($synopsis, $word) !== false);
                    if (!$match) {
                        return false;
                    }
                }
                return true;
            });
        }

        if (!empty($genre)) {
            $collection = $collection->filter(function ($item) use ($genre) {
                $itemGenres = array_map('mb_strtolower', (array) ($item['genre'] ?? []));
                return in_array(mb_strtolower($genre), $itemGenres);
            });
        }

        // Fitur Pengurutan
        if ($sort === 'latest') {
            $sorted = $collection->sortByDesc('release_year')->values();
        } elseif ($sort === 'title') {
            $sorted = $collection->sortBy('title', SORT_NATURAL | SORT_FLAG_CASE)->values();
        } else {
            $sorted = $collection->sortByDesc('rating')->values();
        }

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = $sorted->slice(($currentPage - 1) * $perPage, $perPage)->values();

        return new LengthAwarePaginator(
            $currentPageItems,
            $sorted->count(),
            $perPage,
            $currentPage,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'query' => request()->query(),
            ]
        );
    }

    /**
     * Mengambil novel unggulan (rating tertinggi).
     */
    public function getFeatured(): ?array
    {
        return collect($this->service->getAll())->sortByDesc('rating')->first();
    }

    /**
     * Mengambil detail novel berdasarkan slug.
     */
    public function findBySlug(string $slug): ?array
    {
        return $this->service->findBySlug($slug);
    }

    /**
     * Mengambil rekomendasi novel lain (mengabaikan novel yang sedang aktif).
     */
    public function getRecommendations(string $currentSlug, int $limit = 3): Collection
    {
        return collect($this->service->getAll())
            ->reject(fn ($item) => $item['slug'] === $currentSlug)
            ->shuffle()
            ->take($limit);
    }

    /**
     * Mendapatkan waktu pembaruan JSON terakhir dari Service.
     */
    public function getLastModified(): string
    {
        return $this->service->getLastModified();
    }
}