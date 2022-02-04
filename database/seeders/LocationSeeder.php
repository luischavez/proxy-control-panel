<?php

namespace Database\Seeders;

use App\Models\Subdomain;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subdomains = Subdomain::all();

        foreach ($subdomains as $subdomain) {
            $subdomain->locations()->create([
                'path'      => '/',
                'type'      => 'proxy',
                'subtype'   => 'http',
                'target'    => '127.0.0.1',
            ]);
            $subdomain->locations()->create([
                'path'      => '/redirect',
                'type'      => 'redirect',
                'subtype'   => null,
                'target'    => '127.0.0.1',
            ]);
            $subdomain->locations()->create([
                'path'      => '/ws',
                'type'      => 'proxy',
                'subtype'   => 'ws',
                'target'    => '127.0.0.1',
            ]);
        }
    }
}
