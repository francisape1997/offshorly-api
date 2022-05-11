<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(NoteSeeder::class);
        $this->call(UserSeeder::class);
    }
}
