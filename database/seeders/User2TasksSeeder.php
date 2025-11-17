<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use Carbon\Carbon;

class User2TasksSeeder extends Seeder
{
    public function run()
    {
        $userId = 2;

        // Task created today (day)
        Task::create([
            'title' => 'Task created today',
            'description' => 'Task assigned for today',
            'status' => 'pending',
            'project_id' => 1,
            'user_id' => $userId,
            'due_date' => Carbon::today(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Task created this week (but not today)
        Task::create([
            'title' => 'Task created this week',
            'description' => 'Task assigned for this week',
            'status' => 'pending',
            'project_id' => 1,
            'user_id' => $userId,
            'due_date' => Carbon::today()->addDays(2),
            'created_at' => Carbon::now()->subDays(2),
            'updated_at' => Carbon::now()->subDays(2),
        ]);

        // Task created this month (but not this week)
        Task::create([
            'title' => 'Task created this month',
            'description' => 'Task assigned for this month',
            'status' => 'pending',
            'project_id' => 1,
            'user_id' => $userId,
            'due_date' => Carbon::today()->addWeeks(2),
            'created_at' => Carbon::now()->subWeeks(1),
            'updated_at' => Carbon::now()->subWeeks(1),
        ]);

        // Task created last month
        Task::create([
            'title' => 'Task created last month',
            'description' => 'Task assigned for last month',
            'status' => 'pending',
            'project_id' => 1,
            'user_id' => $userId,
            'due_date' => Carbon::today()->addMonth(),
            'created_at' => Carbon::now()->subMonth(),
            'updated_at' => Carbon::now()->subMonth(),
        ]);
    }
}
