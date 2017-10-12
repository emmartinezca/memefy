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
            'password' => bcrypt('greenpnd'),
            'image'    => 'shamed.png'
        ]);

        User::create([
            'name'     => 'Maribel Aguilar',
            'email'    => 'maribel.aguilar@gmail.com',
            'password' => bcrypt('greenpnd'),
            'image'    => 'maribel.png'
        ]);
    }
}
