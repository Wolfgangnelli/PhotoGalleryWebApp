<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Photo;
use App\User;

class Album extends Model
{
    //protected $table = 'Album'

    protected $fillable = [
        'album_name', 'description', 'user_id', 'album_thumb'
    ];
    use SoftDeletes;

    /**
     * Per usare questo metodo come attributo, devo usare questa convenzione:
     * get
     * Path    Nome proprietà in maiuscolo
     * Attribute
     *  
     */
    public function getPathAttribute()
    {
        $url = $this->album_thumb;

        if (stristr($this->album_thumb, 'http') === false) {
            $url = 'storage/' . $this->album_thumb;
        }

        return $url;
    }

    public function getShortDescrAttribute()
    {
        return substr($this->description, 0, 60) . '...';
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        //album_album_category
        return $this->belongsToMany(AlbumCategory::class, 'album_category', 'album_id', 'category_id')->withTimestamps();
    }
}
