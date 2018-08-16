<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Pedro Pool',
            'email' => 'pedropool13@gmail.com',
            'password' => bcrypt('secret'),
            'space_id' => 1,
        ]);
    }
}
