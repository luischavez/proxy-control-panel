<?php

namespace Database\Seeders;

use App\Models\Domain;
use Illuminate\Database\Seeder;

class DomainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Domain::create([
            'name' => 'demo.com',
        ]);
        Domain::create([
            'name' => 'demo2.com',
        ]);
        Domain::create([
            'name' => 'demo3.com',
        ]);
    }
}
