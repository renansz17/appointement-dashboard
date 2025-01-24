<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatientSeeder extends Seeder
{
    public function run()
    {
        $patients = [
            ['name' => 'Ana Clara', 'email' => 'ana.clara@email.com', 'phone' => '11999999999'],
            ['name' => 'João Pedro', 'email' => 'joao.pedro@email.com', 'phone' => '21988888888'],
            ['name' => 'Maria Eduarda', 'email' => 'maria.eduarda@email.com', 'phone' => '31977777777'],
            ['name' => 'Gabriel Silva', 'email' => 'gabriel.silva@email.com', 'phone' => '41966666666'],
            ['name' => 'Rafaela Costa', 'email' => 'rafaela.costa@email.com', 'phone' => '51955555555'],
            ['name' => 'Lucas Almeida', 'email' => 'lucas.almeida@email.com', 'phone' => '61944444444'],
            ['name' => 'Isabela Souza', 'email' => 'isabela.souza@email.com', 'phone' => '71933333333'],
            ['name' => 'Mateus Rocha', 'email' => 'mateus.rocha@email.com', 'phone' => '81922222222'],
            ['name' => 'Camila Oliveira', 'email' => 'camila.oliveira@email.com', 'phone' => '91911111111'],
            ['name' => 'Felipe Santos', 'email' => 'felipe.santos@email.com', 'phone' => '11912345678'],
        ];

        DB::table('patients')->insert($patients);
    }
}
