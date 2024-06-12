<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointments>
 */
class AppointmentsFactory extends Factory
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
            'appointment_date' => $this->faker->dateTimeBetween('2024-05-31', '2024-12-31'),
            'status' => $this->faker->randomElement(['booked', 'completed', 'cancelled']),
        ];
    }
}
