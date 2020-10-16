<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class PhotosController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Photo::class);
    }

    protected $roles = [
        'album_id' => 'required|integer|exists:albums,id',
        'name' => 'required',
        'description' => 'required',
        //'img_path' => 'required|image'
    ];

    protected $messages = [
        'required' => 'Il campo :attribute è obbligatorio.',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Photo::get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
        $albumId = $req->has('album_id') ? $req->input('album_id') : null;
        //dd($albumId);
        $album = Album::firstOrNew(['id' => $albumId]);
        //dd($album);

        $photo = new Photo();
        $albums = $this->getAlbums();
        return view('images_views.editimage', ['album' => $album, 'photo' => $photo, 'albums' => $albums]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        Validator::make($req->all(), $this->roles, $this->messages)->validate();
        //$req->validate($this->roles);

        $photo = new Photo();

        $photo->name = $req->input('name');
        $photo->description = $req->input('description');
        $photo->album_id = $req->input('album_id');
        $photo->img_path = $req->input('img_path');

        $this->processFile($photo, $req);
        $res = $photo->save();

        $message = $res ? $photo->name . ' Images saved correctly' : $photo->name . ' Images not saved correctly';
        session()->flash('message', $message);

        return redirect()->route('album.getimages', $photo->album_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photo)
    {
        return $photo;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Photo $photo)
    {
        $albums = $this->getAlbums();

        //$photo = Photo::with('album')->find($photo); se non faccio il type hinting 
        //uso la Relationship stabilita in Photo Model. chiamo il metodo come fosse una proprietà
        $album = $photo->album;

        return view('images_views.editimage', ['photo' => $photo, 'album' => $album, 'albums' => $albums]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, Photo $photo)
    {
        Validator::make($req->all(), $this->roles, $this->messages)->validate();
        //$req->validate($this->roles);

        //dd($req->all());
        $photo->name = $req->input('name');
        $photo->description = $req->input('description');
        $photo->album_id = $req->input('album_id');

        $res = $photo->save();

        if ($res) {
            if ($this->processFile($photo, $req)) {
                $photo->save();
            }
        }

        $message = $res ? 'Photo ' . $photo->id . ' updated' : 'Photo ' . $photo->id . ' not update';
        session()->flash('message', $message);

        //return redirect()->route('photos.index');
        return redirect()->route('album.getimages', $photo->album_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        //return Photo::destroy($id);

        $disk = config('filesystem.default');
        $thumNail = $photo->img_path;

        $res = $photo->delete();
        if ($res) {
            if ($thumNail && Storage::disk($disk)->exists($thumNail)) {
                Storage::disk($disk)->delete($thumNail);
            }
        }

        return $res;
    }

    public function processFile(Photo $photo, Request $req = null)
    {
        if (!$req) {
            $req = request();
        }
        if (!$req->hasFile('img_path')) {
            return false;
        }

        $file = $req->file('img_path');
        if (!$file->isValid()) {
            return false;
        }

        $extension = $req->file('img_path')->extension();
        //$imgName = preg_replace('@[a-z0-9]i@', '_', $photo->name);

        $path = $file->storeAs(env('IMG_DIR') . '/albumID' . $photo->album_id, $photo->id ? $photo->id : $photo->name . '-' . $req->name . '.' . $extension);
        $photo->img_path = $path;

        return true;
    }

    public function getAlbums()
    {
        return Album::orderBy('album_name')->where('user_id', Auth::id())->get();
    }
}
