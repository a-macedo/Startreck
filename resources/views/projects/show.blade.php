@extends('layouts.app')

@section('content')

<h1 class="title">{{ $project->title }}</h1>
<div class="content">
    <p class="h-space">{{ $project->description }}</p>
    <p>
        <a class="h-space" href="/projects/{{ $project->id }}/edit">Edit</a>
        <a class="h-space" href="/projects">Back</a>
    </p>
</div>


@if ($project->tasks->count())
    <div class="box">
        @foreach ($project->tasks as $task)
            <div>
                <form action="/tasks/{{ $task->id }}" method="POST">
                    @method('PATCH')
                    @csrf
                    <label class="checkbox {{ $task->completed ? 'is-complete' : '' }}" for="completed">
                        <input type="checkbox" name="completed" onChange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
                        {{ $task->description }}
                    </label>
                </form>
            </div>
        @endforeach
    </div>
@endif 

<form method="POST" action="/projects/{{ $project->id }}/tasks" class="box">
    @csrf
    <label for="description">New Task</label>
    <div class="control">
        <input type="text" class="input {{ $errors->has('description') ? 'is-danger' : '' }}" name="description" placeholder="New Task">
    </div>
    <div class="field">
        <div class="control">
            <button type="submit" class="button is-link v-space">Add Taks</button>
        </div>
    </div>

    @include('errors')

</form>



@endsection