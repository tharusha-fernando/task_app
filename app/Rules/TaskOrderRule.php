<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class TaskOrderRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $taskIds = $value;
        $userId = Auth::id();

        // dd(collect($taskIds)->pluck('id')->toArray());

        $taskIds=collect($taskIds)->pluck('id')->toArray();

        // Check if all task IDs exist and are created by the authenticated user
        $tasks = Task::whereIn('id', $taskIds)->where('created_by', $userId)->get();

        if ($tasks->count() !== count($taskIds)) {
            $fail('One or more tasks do not exist or do not belong to the authenticated user.');
            return;
        }

        // Check if the given values are in range with all tasks count
        $totalTasksCount = Task::where('created_by', $userId)->count();

        if (max($taskIds) > $totalTasksCount || min($taskIds) < 1) {
            $fail('The task order values are out of range.');
        }
        //
    }
}
