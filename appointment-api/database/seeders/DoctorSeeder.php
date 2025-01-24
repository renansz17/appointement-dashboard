<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorSeeder extends Seeder
{
    public function run()
    {
        $doctors = [
            ['name' => 'Carlos Mendes', 'email' => 'carlos.mendes@email.com', 'phone' => '11987654321'],
            ['name' => 'Fernanda Costa', 'email' => 'fernanda.costa@email.com', 'phone' => '21987654321'],
            ['name' => 'Ricardo Silva', 'email' => 'ricardo.silva@email.com', 'phone' => '31987654321'],
            ['name' => 'Juliana Rocha', 'email' => 'juliana.rocha@email.com', 'phone' => '41987654321'],
            ['name' => 'Marcelo Alves', 'email' => 'marcelo.alves@email.com', 'phone' => '51987654321'],
            ['name' => 'Mariana Santos', 'email' => 'mariana.santos@email.com', 'phone' => '61987654321'],
            ['name' => 'Pedro Lima', 'email' => 'pedro.lima@email.com', 'phone' => '71987654321'],
            ['name' => 'Camila Oliveira', 'email' => 'camila.oliveira@email.com', 'phone' => '81987654321'],
            ['name' => 'Felipe Souza', 'email' => 'felipe.souza@email.com', 'phone' => '91987654321'],
            ['name' => 'Ana Paula Mendes', 'email' => 'ana.mendes@email.com', 'phone' => '11912345678'],
        ];

        DB::table('doctors')->insert($doctors);
    }
}
