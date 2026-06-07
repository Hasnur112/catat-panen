<?php

namespace Database\Seeders;

use App\Models\Panen;
use App\Models\User;
use App\Models\Varietas;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        User::create([
            'name'     => 'Super Admin',
            'email'    => 'superadmin@catapanen.com',
            'password' => bcrypt('password'),
            'role'     => 'super_admin',
        ]);

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

        // Petani Demo 3
        $petani3 = User::create([
            'name'     => 'Ahmad Fauzi',
            'email'    => 'ahmad@catapanen.com',
            'password' => bcrypt('password'),
            'role'     => 'petani',
        ]);

        // Seed varietas master
        $varietasList = [
            'Ciherang', 'Inpari 32', 'Inpari 42', 'Mekongga',
            'IR64', 'Situ Bagendit', 'Logawa', 'Cibogo',
            'Memberamo', 'Lainnya',
        ];
        foreach ($varietasList as $nama) {
            Varietas::create(['nama' => $nama]);
        }

        // Data panen demo (dengan status)
        $jenisPadi = ['Ciherang', 'Inpari 32', 'Mekongga', 'IR64', 'Inpari 42'];

        $users = [$petani1, $petani2, $petani3];
        foreach ($users as $user) {
            for ($i = 5; $i >= 0; $i--) {
                $date = now()->subMonths($i)->setDay(rand(1, 20));
                // Panen lama => Verified, panen terbaru => sebagian Pending
                $status = ($i > 1) ? 'Verified' : ($i === 0 ? 'Pending' : 'Verified');
                Panen::create([
                    'user_id'    => $user->id,
                    'jenis_padi' => $jenisPadi[array_rand($jenisPadi)],
                    'volume'     => rand(500, 3000) + (rand(0, 99) / 100),
                    'tanggal'    => $date->toDateString(),
                    'keterangan' => $i % 2 === 0 ? 'Panen musim ' . ($i % 2 === 0 ? 'hujan' : 'kemarau') : null,
                    'status'     => $status,
                ]);
            }
        }

        // Tambah beberapa data Pending untuk admin
        Panen::create([
            'user_id'    => $petani1->id,
            'jenis_padi' => 'Ciherang',
            'volume'     => 1250.50,
            'tanggal'    => now()->toDateString(),
            'keterangan' => 'Panen perdana musim ini',
            'status'     => 'Pending',
        ]);
        Panen::create([
            'user_id'    => $petani2->id,
            'jenis_padi' => 'Inpari 32',
            'volume'     => 875.00,
            'tanggal'    => now()->subDay()->toDateString(),
            'keterangan' => null,
            'status'     => 'Pending',
        ]);
    }
}
