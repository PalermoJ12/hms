<?php

namespace Database\Seeders;


use App\Models\User;
use App\Models\Patients;
use App\Models\Doctors;
use App\Models\Appointments;
use App\Models\MedicalRecords;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TruncateTablesSeeder::class,
        ]);

        User::factory(1)->create(['role' => 'admin']);
        $patients = Patients::factory(10)->create();
        $doctors = Doctors::factory(5)->create();

        foreach ($patients as $patient) {
            Appointments::factory(2)->create(['patients_id' => $patient->id, 'doctors_id' => $doctors->random()->id]);
            MedicalRecords::factory(3)->create(['patients_id' => $patient->id, 'doctors_id' => $doctors->random()->id]);
        }
    }
}
