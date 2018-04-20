<?php

use Illuminate\Database\Seeder;

class StartupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $joseph = DB::table('users')->insert([
            'name' => 'Joseph Montanez',
            'email' => 'joseph@gmail.com',
            'password' => bcrypt('slimymustang93'),
        ]);

        $misty = DB::table('users')->insert([
            'name' => 'Misty Montanez',
            'email' => 'misty@gmail.com',
            'password' => bcrypt('heavycar24'),
        ]);

        $andres = DB::table('users')->insert([
            'name' => 'Andres Montanez',
            'email' => 'andres@gmail.com',
            'password' => bcrypt('coldink50'),
        ]);
    }
}
