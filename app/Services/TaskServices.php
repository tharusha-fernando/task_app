<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskServices
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getIndexData(array $validatedData)
    {
        $tasks = Task::with('project')
            ->when(isset($validatedData['orderBy']), function ($query) use ($validatedData) {
                $direction = $validatedData['direction'] ?? 'asc';
                $query->orderBy($validatedData['orderBy'], $direction);
            })
            ->when(isset($validatedData['project']), function ($query) use ($validatedData) {
                $query->where('project_id', $validatedData['project']);
            })
            ->paginate($validatedData['page_length'] ?? 20);

            $projects=Project::all();

        return [
            'tasks' => $tasks,
            'projects' => $projects,
        ];

        // $tasks = Task::with('project')->get();
        // return $tasks;
    }

    public function storeTask($validatedData){
        return Task::create($validatedData);
    }
}
