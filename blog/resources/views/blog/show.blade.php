@extends('blog.layout')

@section('content')
    <div class="container py-5">
        <h1 class="mb-4">{{ $post->title }}</h1>

        @if($post->image)
            <div class="col-12">
                <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid mb-4" alt="{{ $post->title }}">
            </div>

        @endif

        <div class="blog-content">
            {!! $post->description !!}
        </div>

        <hr>
        <a href="{{ route('blog.index') }}" class="btn btn-secondary mt-3">Back to Blog</a>
    </div>
@endsection