<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'first_name' => 'test',
            'last_name' => 'user',
            'role' => 'admin',
            'email' => 'test@example.com',
        ]);

        // organizations
        \App\Models\User::factory()->create([
            'first_name' => 'test',
            'last_name' => 'organization',
            'role' => 'organization',
            'email' => 'test1@example.com',
        ]);

        // users
        \App\Models\User::factory()->create([
            'first_name' => 'test',
            'last_name' => 'user',
            'role' => 'student',
            'email' => 'test2@example.com',
        ]);

        // events
        \App\Models\Event::create([
            'name' => 'test event',
            'description' => 'test event description',
            'date' => '2021-01-01',
            'start_time' => '10:00',
            'end_time' => '12:00',
            'location' => 'test location',
            'status' => 'pending',
            'cover_image' => 'test.jpg',
            'event_type' => 'seminar',
            'user_id' => 2,
        ]);


    }
}
