@extends('layouts.app')

@section('content')

<h1 class="title">Create a new Projects</h1>

<form method="POST" action="/projects">
    @csrf
    
    <div class="field">
        <label class="label" for="title">project title</label>
        <div class="control">
            <input name="title" class="input {{ $errors->has('title') ? 'is-danger' : '' }}" placeholder="Project title" required>
        </div>
    </div>

    <div class="field">
        <label class="label" for="title">Project description</label>
        <div class="control">
            <textarea name="description" class="textarea {{ $errors->has('description') ? 'is-danger' : '' }}" placeholder="Project description" required></textarea>
        </div>
    </div>

    <div class="field">
        <div class="control">
            <button type="submit" class="button is-link">Create Project</button>
        </div>
    </div>

    @include('errors')

</form>

@endsection