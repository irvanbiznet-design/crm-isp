<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InternetPackage;

class InternetPackageSeeder extends Seeder
{
    public function run()
    {
        $packages = [
            [
                'name' => 'Paket Hemat',
                'download_speed' => 10,
                'upload_speed' => 2,
                'burst' => 0,
                'limit' => 0,
                'price' => 150000,
                'fup' => '100 GB',
                'active_days' => 30,
                'description' => 'Paket internet hemat dengan kecepatan 10 Mbps',
            ],
            [
                'name' => 'Paket Reguler',
                'download_speed' => 20,
                'upload_speed' => 5,
                'burst' => 0,
                'limit' => 0,
                'price' => 250000,
                'fup' => '200 GB',
                'active_days' => 30,
                'description' => 'Paket internet reguler dengan kecepatan 20 Mbps',
            ],
            [
                'name' => 'Paket Premium',
                'download_speed' => 50,
                'upload_speed' => 10,
                'burst' => 0,
                'limit' => 0,
                'price' => 500000,
                'fup' => 'Unlimited',
                'active_days' => 30,
                'description' => 'Paket internet premium dengan kecepatan 50 Mbps',
            ],
            [
                'name' => 'Paket Enterprise',
                'download_speed' => 100,
                'upload_speed' => 20,
                'burst' => 0,
                'limit' => 0,
                'price' => 1000000,
                'fup' => 'Unlimited',
                'active_days' => 30,
                'description' => 'Paket internet enterprise dengan kecepatan 100 Mbps',
            ],
        ];

        foreach ($packages as $package) {
            InternetPackage::create($package);
        }
    }
}
