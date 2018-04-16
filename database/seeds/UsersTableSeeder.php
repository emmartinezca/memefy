<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'     => 'Emmanuel Martínez',
            'email'    => 'emmartinezca@gmail.com',
            'password' => bcrypt('webos1'),
            'image'    => 'shamed.png'
        ]);
    }
}
