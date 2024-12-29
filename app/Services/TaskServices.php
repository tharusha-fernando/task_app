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
            ->when(isset($validatedData['project_id']), function ($query) use ($validatedData) {
                $query->where('project_id', $validatedData['project_id']);
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

    public function updateTask($validatedData, Task $task){
        return $task->update($validatedData);
    }

    public function reorderTasks($validatedData){
        $order=$validatedData['order'];

        foreach($order as $key => $value){
            Task::where('id', $value)->first()->update(['position' => $key+1]);//used first to fire the observer to later deal with paginated data or may be fire a custom event later
        }
        return true;
    }
}
