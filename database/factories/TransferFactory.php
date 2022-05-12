<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transfer>
 */
class TransferFactory extends Factory
{
    use WithFaker;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'       => $this->faker->word(),
            'hash'       => Str::random(),
            'code'       => Hash::make('12345'),
            'expires_at' => $this->faker->boolean() ? null : Carbon::now()->addHours($this->faker->numberBetween(1, 48)),
        ];
    }
}
