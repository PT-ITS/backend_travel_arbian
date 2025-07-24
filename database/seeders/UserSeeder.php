<?php

namespace Database\Seeders;

use App\Models\Driver;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'level' => '0',
            'password' => Hash::make('12345'),
        ]);

        // Driver
        User::create([
            'name' => 'driver',
            'email' => 'driver@gmail.com',
            'level' => '1',
            'password' => Hash::make('12345'),
        ]);
        Driver::create([
            'nama_lengkap' => 'Nama Driver',
            'alamat' => 'Alamat Driver',
            'umur' => '21',
            'nik' => '3529010101010101',
            'sim' => '1552-0101-010101',
            'foto' => 'Foto Driver',
            'fk_id_user' => '2',
        ]);
    }
}
