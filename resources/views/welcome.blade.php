@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-conten">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header title t-center">Welcome to Startreck</div>

                <div class="card-body t-center">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Thank you for sign up with us!
                        
                    <a href="/projects/create" class="space-v"><p>Create your first project</p></a>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
