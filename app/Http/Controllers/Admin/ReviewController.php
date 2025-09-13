<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user', 'vehicle'])->latest()->paginate(10);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function update(Request $request, Review $review)
    {
        // ▼▼▼ Otorisasi ditambahkan di sini ▼▼▼
        $this->authorize('update', $review);

        // Aksi ini akan menjadi toggle untuk status 'approved'
        $review->update([
            'approved' => !$review->approved,
        ]);

        $message = $review->approved ? 'Ulasan berhasil disetujui.' : 'Persetujuan ulasan berhasil dibatalkan.';

        return redirect()->route('admin.reviews.index')->with('success', $message);
    }

    public function destroy(Review $review)
    {
        // ▼▼▼ Otorisasi ditambahkan di sini ▼▼▼
        $this->authorize('delete', $review);

        $review->delete();
        return redirect()->route('admin.reviews.index')->with('success', 'Ulasan berhasil dihapus.');
    }
}
