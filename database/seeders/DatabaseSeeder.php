<?php

namespace Database\Seeders;

use App\Models\Panen;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@catapanen.com',
            'password' => bcrypt('password'),
            'role'     => 'admin',
        ]);

        // Petani Demo 1
        $petani1 = User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'budi@catapanen.com',
            'password' => bcrypt('password'),
            'role'     => 'petani',
        ]);

        // Petani Demo 2
        $petani2 = User::create([
            'name'     => 'Siti Rahayu',
            'email'    => 'siti@catapanen.com',
            'password' => bcrypt('password'),
            'role'     => 'petani',
        ]);

        // Data panen demo
        $jenisPadi = ['Ciherang', 'Inpari 32', 'Mekongga', 'IR64', 'Inpari 42'];

        $users = [$petani1, $petani2, $admin];
        foreach ($users as $user) {
            for ($i = 5; $i >= 0; $i--) {
                $date = now()->subMonths($i)->setDay(rand(1, 20));
                Panen::create([
                    'user_id'    => $user->id,
                    'jenis_padi' => $jenisPadi[array_rand($jenisPadi)],
                    'volume'     => rand(500, 3000) + (rand(0, 99) / 100),
                    'tanggal'    => $date->toDateString(),
                    'keterangan' => $i % 2 === 0 ? 'Panen musim ' . ($i % 2 === 0 ? 'hujan' : 'kemarau') : null,
                ]);
            }
        }
    }
}
