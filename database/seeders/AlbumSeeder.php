<?php

//namespace Database\Seeders;

use App\Models\AlbumCategory;
use App\Models\Album;
use App\Models\AlbumsCategory;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlbumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::get();
        foreach ($users as $user) {
            factory(Album::class, 8)->create([
                'user_id' => $user->id
            ])->each(function ($album) {
                $cats = AlbumCategory::inRandomOrder()->take(3)->pluck('id');
                $cats->each(function ($cat_id) use ($album) {
                    AlbumsCategory::create([
                        'album_id' => $album->id,
                        'category_id' => $cat_id
                    ]);
                });
            });
        }
    }
}
