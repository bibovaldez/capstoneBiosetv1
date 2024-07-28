<?php

namespace Database\Factories;

use App\Models\Building;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // $table->id();
        // $table->string('name');
        // $table->string('username')->unique();
        // $table->string('email')->unique();
        // $table->foreignId('building_id')->nullable();
        // $table->timestamp('email_verified_at')->nullable();
        // $table->string('password');
        // $table->rememberToken();
        // $table->string('profile_photo_path', 2048)->nullable();
        // $table->timestamps();
        // $table->enum('role', ['admin', 'user'])->default('user');
        return [
            'name' => $this->faker->name,
            'username' => $this->faker->unique()->userName,
            'email' => 'bibovaldez2002@gmail.com',
            'email_verified_at' => now(),
            'building_id' => 1,
            'password' => static::$password ??= Hash::make('11111111'),
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'role' => 'user',
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
