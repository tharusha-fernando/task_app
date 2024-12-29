<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Task;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('12345678'), // Password should be hashed for security
        ]);

        for ($i = 1; $i <= 4; $i++) {
            $project = Project::factory()->create([
                'name' => 'Project ' . $i,
            ]);

            for ($j = 1; $j <= 2; $j++) {
                Task::factory()->create([
                    'project_id' => $project->id,
                    'created_by' => 1, // Assuming the created user has ID 1
                    'name' => 'Task ' . $j . ' for Project ' . $i,
                ]);
            }
        }
    }
}
