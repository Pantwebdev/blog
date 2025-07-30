@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="container mt-4">
        <h2>Welcome to Admin Dashboard</h2>
        <p>You are logged in as admin.</p>
        <div class="col-3">
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">Total Blog Posts</h5>
                    <p class="card-text display-4">{{ $posts }}</p>
                </div>
            </div>
        </div>

        <a href="{{ route('admin.posts.index') }}" class="btn btn-primary mt-3">Manage Blog Posts</a>
    </div>
@endsection