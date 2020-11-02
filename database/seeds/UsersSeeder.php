<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name'     => 'Admin',
            'email'     => 'admin@mail.com',
            'password'     => bcrypt('1234'),
            'estatus'     => '1',
            'nivel' => '1',
        ]);

        $admin->assignRole('Admin');


        $visitante = User::create([
            'name'     => 'visitante',
            'email'     => 'visitante@mail.com',
            'password'     => bcrypt('1234'),
            'estatus'     => '1',
            'nivel' => '1',
        ]);

        $visitante->assignRole('Visitante');



    }
}
