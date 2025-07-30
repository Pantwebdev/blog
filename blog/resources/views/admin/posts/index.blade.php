@php use Illuminate\Support\Str; @endphp
@extends('admin.layout')

@section('title', 'All Blog Posts')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>All Blog Posts</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="successMessage">
            {{ session('success') }}
        </div>
    @endif

    <div class="row mb-3 justify-content-between">
        <div class="col-md-5">
            <form method="GET" action="{{ route('admin.posts.index') }}" class="d-flex gap-5">
                <input type="text" name="search" class="form-control" placeholder="Search..."
                    value="{{ request('search') }}">
                <button type="submit" class="btn btn-info ml-2">Search</button>
            </form>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.posts.create') }}" class="btn btn-primary me-2">+ New Post</a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-warning">Home</a>
        </div>
    </div>



    @if($posts->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>URL</th>
                    <th>Created</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                    <tr>
                        <td>{{$loop->iteration + ($posts->currentPage() - 1) * $posts->perpage()}}</td>
                        <td>{{ $post->title }}</td>
                        {{-- <td>{{ $loop->iteration + ($posts->currentPage() - 1) * $posts->perPage() }}</td> --}}
                        <td>{{Str::limit(strip_tags($post->description), 100, '....')}}</td>
                        {{-- <td>{!! $post->description !!}</td> --}}
                        <td>{{ $post->url }}</td>
                        <td>{{ $post->created_at->format('d M Y') }}</td>
                        <td> <img src="{{ asset('storage/' . $post->image) }}" width="150" class="mb-2"></td>
                        <td>
                            <a href="{{ route('admin.posts.edit', $post) }}"><i class="bi bi-pencil"></i></a>

                            <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Delete this post?')" style="border: none; box-shadow: none;"><i class="bi bi-trash3"></i></button>

                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-left mt-3">
            {{ $posts->links('pagination::bootstrap-4') }}
            {{-- {{ $posts->appends(request()->only('search'))->links() }} --}}
        </div>
    @else
        <p>No posts found.</p>
    @endif
@endsection
<script>
    // Hide success message after 3 seconds (3000ms)
    setTimeout(function () {
        let alert = document.getElementById('successMessage');
        if (alert) {
            alert.style.display = 'none';
        }
    }, 2000);
</script>
<script>
    window.addEventListener('DOMContentLoaded', function () {
        const url = new URL(window.location.href);
        if (url.searchParams.has('search')) {
            // Clear the search field
            const input = document.querySelector('input[name="search"]');
            if (input) {
                input.value = '';
            }
        }
    });
</script>