<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class AlbumCategory extends Model
{
    protected $table = 'album_categories';


    public function albums()
    {
        return $this->belongsToMany(Album::class, 'album_category', 'category_id', 'album_id')->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeGetCategoriesByUserId(Builder $query, User $user)
    {
        return $query->where('user_id', $user->id)->orWhere('user_id', 0)
            ->withCount('albums')->orderByDesc('id')->latest();
    }
}
