<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    public function owner()
    {
        // return $this->belongsTo('App\User', 'owner_id', 'id');
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function completedTasks()
    {
        //return $this->hasMany(Task::class)
        //return $this->tasks()->where(['completed' => 1])->count();
        return $this->tasks()->where('tasks.completed', true)->get();
    }

    public function addTask($task)
    {
        $this->tasks()->create($task);
        // return Task::create([
        //     'project_id' => $this->id,
        //     'description' => $description
        // ]);
    }
}

