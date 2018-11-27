<?php

namespace App\Http\Controllers;

use App\Task;
use App\Project;

class ProjectTasksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store (Project $project)
    {
        $project->addTask(
            request()->validate(['description' => 'required'])
        );

        return back();   
    }

    public function update (Task $task)
    {
        // depending on having completed status it complete or incomplete calling the corresponding method
        $method = request()->has('completed') ? 'complete' : 'incomplete';
        $task->$method();
        
        return back();
    }
}
