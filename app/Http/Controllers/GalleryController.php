<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Photo;
use App\Models\AlbumCategory;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $albums = Album::latest()->with('categories')->paginate(env('ALBUM_PER_PAGE'));
        return view('gallery.albums')->with('albums', $albums);
    }

    public function showAlbumImages(Album $album)
    {
        $images = Photo::whereAlbumId($album->id)->latest()->get();
        return view('gallery.images', ['images' => $images, 'album' => $album]);
    }

    public function showAlbumsByCategory(AlbumCategory $category)
    {
        $albums = $category->albums()->paginate(env('ALBUM_PER_PAGE'));
        return view('gallery.albums')->with('albums', $albums);
    }
}
