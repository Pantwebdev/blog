@extends('admin.layout')

@section('title', 'Edit Blog Post')

@section('content')
    <div class="container">
        <h2>Edit Blog Post</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label>Title</label>
                <input type="text" name="title" value="{{ old('title', $post->title) }}" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label>Description</label>
                {{-- <textarea name="description" class="form-control" rows="5" required>{{  old('description',  $post->description )  }}</textarea> --}}
                 {{-- <textarea name="description" id="description"
                class="form-control">{{ old('description', $post->description ?? '') }}</textarea> --}}
                 <textarea id="summernote" name="description" class="form-control">
                {{ old('description', $post->description ?? '') }}
            </textarea>
            </div>

            <div class="form-group mb-3">
                <label>Meta Title</label>
                <input type="text" name="meta_title" value="{{ old('meta_title', $post->meta_title) }}" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label>Meta Description</label>
                <textarea name="meta_description" class="form-control" rows="3">{{ old('meta_description', $post->meta_description) }}</textarea>
            </div>

            {{-- <div class="form-group mb-3">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div> --}}

            <div class="form-group mb-3">
                <label>Current Image</label><br>
                @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" width="150" class="mb-2"/><br>
                @else
                    <small>No image uploaded.</small><br>
                @endif
            </div>

            <div class="form-group mb-3">
                <label>New Image (Optional)</label>
                <input type="file" name="image" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Update Post</button>
            <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#summernote').summernote({
                height: 300,
                placeholder: 'Write your blog content here...'
            });
        });
    </script>
@endpush
