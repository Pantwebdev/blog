@extends('blog.layout')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Latest Blog Posts</h1>

    <div class="row">
        @foreach ($posts as $post)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="{{ $post->title }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-text">{{ Str::limit(strip_tags($post->description), 100) }}</p>
                        <a href="{{ route('blog.show', $post->url) }}" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $posts->links() }}
    </div>
</div>
@endsection
