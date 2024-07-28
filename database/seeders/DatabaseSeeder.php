<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as FakerFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = FakerFactory::create();
        
        User::factory()->create([
            'name' => $faker->name,
            'username' => $faker->unique()->userName,
            'email' => 'bibovaldez2002@gmail.com',
            'email_verified_at' => now(),
            'building_id' => 1,
            'password' => Hash::make('11111111'),
            'remember_token' => Str::random(10),
            
            'profile_photo_path' => null,
        ]);


        // $table->id();
        // $table->foreignId('admin_id')->nullable()->constrained('users', 'id')->onUpdate('cascade');
        // $table->string('address');
        // $table->string('description');
        // $table->timestamps();


        Building::factory()->create([
            
            'admin_id' => 1,
            'address' => $faker->address,
            'description' => $faker->text(200), // Nullable field
        
        ]);
        
    }
}
