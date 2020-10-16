<?php

//namespace Database\Seeders;

use App\Models\AlbumCategory;
use Illuminate\Database\Seeder;

class AlbumCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'abstract',
            'animals',
            'business',
            'cats',
            'city',
            'food',
            'nightlife',
            'fashion',
            'people',
            'nature',
            'sports',
            'technics',
            'transport'
        ];

        foreach ($categories as $category) {
            AlbumCategory::create(
                [
                    'category_name' => $category,
                    'user_id' => 0
                ]
            );
        }
    }
}
