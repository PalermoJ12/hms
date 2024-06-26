<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MedicalRecords>
 */
class MedicalRecordsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patients_id' => \App\Models\Patients::factory(),
            'doctors_id' => \App\Models\Doctors::factory(),
            'record' => $this->faker->paragraph,
        ];
    }
}
