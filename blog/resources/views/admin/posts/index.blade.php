@extends('admin.layout')

@section('title', 'All Blog Posts')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>All Blog Posts</h2>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">+ New Post</a>
    </div>

    @if($posts->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>URL</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td>{{ ucfirst($post->status) }}</td>
                        <td>{{ $post->url }}</td>
                        <td>{{ $post->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-warning">Edit</a>

                            <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Delete this post?')" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No posts found.</p>
    @endif
@endsection
