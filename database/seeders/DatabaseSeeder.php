<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        //$this->call(DomainSeeder::class);
        //$this->call(SubdomainSeeder::class);
        //$this->call(LocationSeeder::class);
    }
}
