@extends('layouts.app')

@section('content')

<h1 class="title">Projects</h1>

<ul>
    @foreach ($projects as $project)
        <li class="v-space">
            <span class="tag is-info">{{$project->completedTasks()->count()}}/{{ $project->tasks()->count() }}</span>
            <a href="/projects/{{ $project->id }}">{{ $project->title }}</a>
        </li>
    @endforeach
</ul>
<a href="/projects/create" class="button is-link" style="margin-top:2em">New Project</a>

<p id="js-test" style="margin-top:50px"></p>
<script>
    document.getElementById("js-test").innerHTML = "Testing Javascript";
</script>
@endsection