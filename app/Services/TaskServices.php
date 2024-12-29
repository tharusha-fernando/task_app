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
            ->when(isset($validatedData['order_by']), function ($query) use ($validatedData) {
                $direction = $validatedData['direction'] ?? 'asc';
                $query->orderBy($validatedData['order_by'], $direction);
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
        // dd($order);

        foreach($order as $item){
            Task::where('id', $item['id'])->first()->update(['priority' => $item['position']]);//used first to fire the observer to later deal with paginated data or may be fire a custom event later
        }
        return true;
    }
}
