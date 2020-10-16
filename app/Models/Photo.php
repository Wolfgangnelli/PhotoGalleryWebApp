<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Album;

class Photo extends Model
{
    /**
     * Model accessors for img_path attribute
     */
    public function getImgPathAttribute($value)
    {

        if (stristr($value, 'http') === false) {
            $value = 'storage/' . $value;
        }

        return $value;
    }

    /**
     * Model mutators for name attribute
     */
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtoupper($name);
    }

    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id');
    }
}
