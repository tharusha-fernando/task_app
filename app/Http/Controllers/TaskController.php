<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\TaskIndexRequest;
use App\Http\Requests\TaskReOrderRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Services\TaskServices;
use Illuminate\Auth\Access\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate as FacadesGate;
use Throwable;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskServices $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(TaskIndexRequest $request)
    {
        $validatedData = $request->validated();
        $data = $this->taskService->getIndexData($validatedData);

        // dd($data);
        // dd($tasks);

        return view('tasks.index')->with($data);
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::all(); //$this->taskService->getAllProjects();
        return view('tasks.create', compact('projects'));
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $validatedData = $request->validated();
        try {
            $response = DB::transaction(function () use ($validatedData) {
                $this->taskService->storeTask($validatedData);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Daily Dose Created Successfully',
                ], 200);
            });
            return $response;
        } catch (Throwable $th) {
            // Handle exceptions
            $error = config('app.debug') ? $th->getMessage() : 'Internal Server Error';

            return response()->json([
                'status' => 'error',
                'error' => $error,
            ], 500);
        }


        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        FacadesGate::authorize('update', $task);
        $projects = Project::all();
        return view('tasks.edit', compact('task', 'projects'));
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        FacadesGate::authorize('update', $task);

        $validatedData = $request->validated();
        try {
            $response = DB::transaction(function () use ($validatedData, $task) {
                $this->taskService->updateTask($validatedData, $task);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Task Updated Successfully',
                ], 200);
            });
            return $response;
        } catch (Throwable $th) {
            // Handle exceptions
            $error = config('app.debug') ? $th->getMessage() : 'Internal Server Error';

            return response()->json([
                'status' => 'error',
                'error' => $error,
            ], 500);
        }
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Task $task)
    // {

    //     //
    public function destroy(Task $task)
    {
        try {
            $response = DB::transaction(function () use ($task) {
                $task->delete();
                return response()->json(['status' => 'success', 'message' => 'Task Deleted Successfully'], 200);
            });
            return $response;
        } catch (Throwable $th) {
            $error = config('app.debug') ? $th->getMessage() : 'Internal Server Error';
            return response()->json(['status' => 'error', 'error' => $error], 500);
        }
    }

    public function reorder(TaskReOrderRequest $request){
        try {
            $validatedData = $request->validated();
            $response = DB::transaction(function () use ($validatedData) {
                $this->taskService->reorderTasks($validatedData);
                return response()->json(['status' => 'success', 'message' => 'Tasks Reordered Successfully'], 200);
            });
            return $response;
        } catch (Throwable $th) {
            $error = config('app.debug') ? $th->getMessage() : 'Internal Server Error';
            return response()->json(['status' => 'error', 'error' => $error], 500);
        }
    }
    // }
}
