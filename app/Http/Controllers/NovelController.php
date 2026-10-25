<?php

namespace App\Http\Controllers;

use App\Repositories\NovelRepository;
use Exception;
use Illuminate\Http\Request;

class NovelController 
{
    protected NovelRepository $repository;

    public function __construct(NovelRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Halaman Katalog Utama.
     */
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');
            $genre = $request->input('genre');
            $sort = $request->input('sort', 'rating');

            // Limit input search untuk keamanan
            if ($search && strlen($search) > 100) {
                $search = substr($search, 0, 100);
            }

            // Mengambil data terpaginasi, genre unik, novel unggulan, dan tanggal update JSON
            $novels = $this->repository->getPaginated($search, $genre, $sort, 6);
            $genres = $this->repository->getGenres();
            $featured = $this->repository->getFeatured();
            $lastUpdated = $this->repository->getLastModified();

            return view('novels.index', compact('novels', 'genres', 'featured', 'search', 'genre', 'sort', 'lastUpdated'));
        } catch (Exception $e) {
            // Tampilkan error 500 ramah pengguna jika JSON corrupt / hilang
            return response()->view('errors.500', ['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Halaman Detail Novel.
     */
    public function show(string $slug)
    {
        try {
            $novel = $this->repository->findBySlug($slug);

            if (!$novel) {
                abort(404);
            }

            $recommendations = $this->repository->getRecommendations($slug, 3);
            $lastUpdated = $this->repository->getLastModified();

            return view('novels.show', compact('novel', 'recommendations', 'lastUpdated'));
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
            throw $e;
        } catch (Exception $e) {
            return response()->view('errors.500', ['message' => $e->getMessage()], 500);
        }
    }
}