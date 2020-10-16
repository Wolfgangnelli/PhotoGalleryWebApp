<?php

//namespace Database\Seeders;

//use App\User;

use App\User;
use Carbon\Carbon as CarbonCarbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(User::class, 30)->create();

        //User::truncate();

        /* for ($i = 0; $i < 30; $i++) {
            DB::table('users')->insert([
                'name' => 'Andrea' . $i,
                'email' => $i . 'nome@gmail.com',
                'password' => Hash::make('password'),
                'created_at' => CarbonCarbon::now(),
            ]);
        }
 */
        /* VECCHIO MODO  
        $sql = 'INSERT INTO users (name, email, password) ';
        $sql .= 'values(:name, :email, :password)';

        for ($i = 0; $i < 30; $i++) {
            DB::statement($sql, [
                 'name' => Str::random(10),
                'email' => Str::random(10) . '@gmail.com',
                'password' => bcrypt('passwordName'),
            ]);
        }
 */
    }
}
