<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PatientSeeder::class);
        $this->call(DoctorSeeder::class);
        $this->call(AppointmentSeeder::class);
    }
}
