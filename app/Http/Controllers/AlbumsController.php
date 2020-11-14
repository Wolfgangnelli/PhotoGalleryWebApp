<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Photo;
use App\Http\Requests\AlbumRequest;
use App\Http\Requests\AlbumUpdateRequest;
use App\Models\AlbumCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Gate;
use App\Events\NewAlbumCreated;

class AlbumsController extends Controller
{

    /**
     * Protecting routes with Route middleware calling it from the controller's constructor
     */
    public function __construct()
    {
     
    }

    /**
     * Get all albums
     * 
     * @return view 
     */
    public function index(Request $request)
    {
        $id = Auth::id();
        $queryBuilder = Album::orderByDesc('id')->withCount('photos')->with('categories');
        $queryBuilder->where('user_id', $id);

        if ($request->has('id')) {

            $queryBuilder->where('id', '=', $request->input('id'));
        }
        if ($request->has('album_name')) {

            $queryBuilder->where('album_name', 'like', $request->input('album_name') . '%');
        }
        $albums = $queryBuilder->paginate(env('ALBUM_PER_PAGE'));

        return view('albums.albums', ['albums' => $albums]);
    }

    /**
     * Delete an album
     * 
     * @param id
     */
    public function delete(Album $album)
    {
        $this->authorize($album);

        $disk = config('filesystems.default');
        $thumbNail = $album->album_thumb;

        $res = $album->delete();
        if ($res) {
            if ($thumbNail && Storage::disk($disk)->exists($thumbNail)) {
                Storage::disk($disk)->delete($thumbNail);
            }
        }

        if (request()->ajax()) {
            return $res;
        } else {
            $message = 'Album ' . $album->id . ' ' . $album->album_name . '  DELETED';
            session()->flash('message', $message);

            return redirect()->route('albums');
        }
    }

    public function show(Album $album)
    {
        $res = DB::table('albums')->where('id', $album->id)->get();
        return $res;
    }

    public function edit($id)
    {
        $album = Album::find($id);
        $this->authorize($album);
 
        $categories = AlbumCategory::get();
        $selectedCategories = $album->categories->pluck('id')->toArray();

        return view('albums.editalbum')->with([
            'album' => $album,
            'categories' => $categories,
            'selectedCategories' => $selectedCategories
        ]);
    }

    /**
     * Update an album
     * 
     * @return view
     */
    public function store($id, AlbumUpdateRequest $req)
    {
        $data = $req->only(['name', 'description']);
        $data['id'] = $id;

        $album = Album::find($id);

        $this->authorize($album);

        $album->album_name = $data['name'];
        $album->description = $data['description'];
        $album->user_id = $req->user()->id;

        $this->processFile($id, $req, $album);
        $res = $album->save();

        $album->categories()->sync($req->categories);

        $message = $res ? 'Album ' . $id . ' update correctly' : 'Album ' . $id . ' not updated';
        session()->flash('message', $message);
        return redirect()->route('albums');
    }

    /**
     * Create an album
     * 
     * @return view
     */
    public function create()
    {
        $album = new Album();
        $categories = AlbumCategory::get();

        return view('albums.createalbum', [
            'album' => $album,
            'categories' => $categories,
            'selectedCategories' => []
        ]);
    }

    /**
     * Save the album created
     * 
     * @return albumsView
     */
    public function save(AlbumRequest $req)
    {
        $data = $req->only(['name', 'description']);
        $data['user_id'] = Auth::id();

        $album = new Album();
        $album->album_name = $data['name'];
        $album->description = $data['description'];
        $album->user_id = $data['user_id'];
        $album->album_thumb = '';

        $res = $album->save();


        if ($res) {
            event(new NewAlbumCreated($album));

            //verifico se album è stato legato a delle categorie, se si aggiungo categorie all'album
            if ($req->has('categories')) {
                $album->categories()->attach($req->categories);
            }
            //processo il file
            if ($this->processFile($album->id, $req, $album)) {
                $album->save();
            }
        }

        $message = $res ? 'Album ' . $data['name'] . ' create correctly' : 'Album ' . $data['name'] . ' not created';
        session()->flash('message', $message);

        return redirect()->route('albums');
    }

    /**
     * 
     * Ottiene il file caricato e lo salva col path definito
     * 
     * @param int $id
     * @param Request $req
     * @param $album
     * 
     */
    public function processFile($id, Request $req, &$album)
    {
        if (!$req->hasFile('album_thumb')) {
            return false;
        }

        $file = $req->file('album_thumb');
        if (!$file->isValid()) {
            return false;
        }

        $extension = $req->file('album_thumb')->extension();

        $path = $file->storeAs(env('ALBUM_THUMB_DIR'), $id . '-' . $req->name . '.' . $extension);
        $album->album_thumb = $path;

        return true;
    }

    /**
     * Get the photos/images for an album
     */
    public function getImages(Album $album)
    {
        $images = Photo::where('album_id', $album->id)->latest()->paginate(env('IMG_PER_PAGE'));
        return view('images_views.albumimages', ['images' => $images, 'album' => $album]);
    }
}
