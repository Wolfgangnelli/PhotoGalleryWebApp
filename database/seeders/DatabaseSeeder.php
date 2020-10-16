<?php

//namespace Database\Seeders;

use App\User;
use App\Models\Album;
use App\Models\Photo;
use App\Models\AlbumCategory;
use App\Models\Video;
use Database\Seeders\VideoSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /* dico a mysql di disabilitare un attimo le fk   */

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        User::truncate();
        Album::truncate();
        Photo::truncate();
        AlbumCategory::truncate();
        Video::truncate();

        $this->call([
            UserSeeder::class,
            AlbumCategorySeeder::class,
            AlbumSeeder::class,
            PhotoSeeder::class,
            VideoSeeder::class,
        ]);
    }
}
