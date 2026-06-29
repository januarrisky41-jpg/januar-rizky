<?php
// app/Http/Controllers/FavoriteController.php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FavoriteController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | TOGGLE FAVORIT (Tambah/Hapus dengan satu klik)
    |--------------------------------------------------------------------------
    */
    public function toggle($id)
    {
        try {
            $property = Property::find($id);
            
            if (!$property) {
                return response()->json([
                    'success' => false,
                    'message' => 'Properti tidak ditemukan'
                ], 404);
            }

            $favorites = Session::get('favorites', []);

            $index = array_search($id, $favorites);

            if ($index !== false) {
                unset($favorites[$index]);
                $favorites = array_values($favorites);
                $isFavorite = false;
                $message = 'Dihapus dari favorit';
            } else {
                $favorites[] = $id;
                $isFavorite = true;
                $message = 'Ditambahkan ke favorit';
            }

            Session::put('favorites', $favorites);

            return response()->json([
                'success' => true,
                'isFavorite' => $isFavorite,
                'message' => $message,
                'totalFavorites' => count($favorites)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | LIST FAVORIT
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $favoriteIds = Session::get('favorites', []);
        $favorites = Property::whereIn('id', $favoriteIds)->get();

        return view('favorites.index', compact('favorites'));
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS FAVORIT
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        try {
            $favorites = Session::get('favorites', []);
            $index = array_search($id, $favorites);

            if ($index !== false) {
                unset($favorites[$index]);
                $favorites = array_values($favorites);
                Session::put('favorites', $favorites);
                
                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Favorit berhasil dihapus'
                    ]);
                }
                
                return redirect('/favorites')
                    ->with('success', 'Favorit berhasil dihapus');
            }

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Favorit tidak ditemukan'
                ], 404);
            }

            return redirect('/favorites')
                ->with('error', 'Favorit tidak ditemukan');

        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus favorit'
                ], 500);
            }
            return redirect('/favorites')
                ->with('error', 'Gagal menghapus favorit');
        }
    }
}