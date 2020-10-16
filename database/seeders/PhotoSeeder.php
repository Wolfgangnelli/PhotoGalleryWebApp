<?php

//namespace Database\Seeders;

use App\Models\Album;
use App\Models\Photo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(Photo::class, 200)->create();
        $albums = Album::get();

        foreach ($albums as $album) {
            factory(Photo::class, 8)->create(
                //sovrascrivo il valore dell attributo album_id che nella factory ho impostato su 1
                ['album_id' => $album->id]
            );
        }
    }
}
