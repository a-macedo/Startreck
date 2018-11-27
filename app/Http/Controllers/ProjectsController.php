<?php

namespace App\Http\Controllers;

use \App\Project;
use \App\Mail\ProjectCreated;
use \Illuminate\Support\Facades\Mail;

// use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    // protect page against not loged in usuers.
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // $projects = Project::where('owner_id', auth()->id()) -> get();
        // return view('projects.index', compact('projects'));
        // return $projects; //debug - print all
        return view('projects.index', [
            'projects' => auth()->user()->projects
        ]);
    }

    public function create()
    {
        return view('projects.create');
    }

    public function show(Project $project)
    {
        // render the projects.show if user is authorized to update project.
        $this->authorize('update', $project); 
        return view('projects.show', compact('project'));
    }

    public function store()
    {

        $attributes = $this->validateProject();
        $attributes['owner_id'] = auth()->id();

        // $project = new Project(); //
        // $project->title = request('title'); //
        // $project->description = request('description'); //
        // $project->owner_id = auth()->id();//
        // $project->save(); //
        // dump($project);//
        // dd($project);

        $project = Project::create($attributes);

        Mail::to($project->owner->email)->send(
            new ProjectCreated($project)
        );

        return redirect('/projects');
    }

    public function edit(Project $project)
    {
        // $project = Project::findOrFail($id); 
        return view('projects.edit', compact('project'));
    }

    public function update(Project $project)
    {
        $project->update($this->validateProject());
        // dd(request()->all());
        // $project = Project::findOrFail($id); 
        // $project->title = request('title');
        // $project->description = request('description');
        // $project->save();
        return redirect('/projects');
    }

    public function destroy(Project $project)
    {
        // Project::findOrFail($id)->delete();
        $project->delete();

        return redirect('/projects');
    }

    public function validateProject()
    {
        return request()->validate([
            'title' => ['required', 'min:3'],
            'description' => ['required', 'min:8']
        ]);
    }
}
