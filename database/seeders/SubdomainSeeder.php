<?php

namespace Database\Seeders;

use App\Models\Domain;
use Illuminate\Database\Seeder;

class SubdomainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $domains = Domain::all();

        foreach ($domains as $domain) {
            $domain->subdomains()->create([
                'name' => 'www',
            ]);
        }
    }
}
