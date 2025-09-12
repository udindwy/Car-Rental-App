<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    // Method privat untuk mengambil dan menampilkan halaman berdasarkan slug
    private function showPage(string $slug)
    {
        $page = Page::where('slug', $slug)->where('published', true)->firstOrFail();
        return view('public.page', compact('page'));
    }

    public function terms()
    {
        return $this->showPage('syarat-ketentuan');
    }

    public function about()
    {
        // Ambil data halaman 'tentang-kami' dari database
        $page = Page::where('slug', 'tentang-kami')->where('published', true)->first();

        // Tampilkan view 'about.blade.php' dengan data halaman
        return view('public.about', compact('page'));
    }
}
