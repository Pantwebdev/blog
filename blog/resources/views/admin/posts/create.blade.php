@extends('admin.layout')

@section('title', 'Create Blog Post')

@section('content')
    <h2>Create New Blog Post</h2>

    <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="title">Title<span class="text-danger">*</span></label>
            <input name="title" id="title" class="form-control" required value="{{ old('title') }}">
        </div>

        <div class="form-group">
            <label for="description">Description<span class="text-danger">*</span></label>
            <textarea name="description" id="description" rows="5" class="form-control" required>{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="image">Upload Image</label>
            <input type="file" name="image" id="image" class="form-control-file">
        </div>

        <div class="form-group">
            <label for="meta_title">Meta Title</label>
            <input name="meta_title" id="meta_title" class="form-control" value="{{ old('meta_title') }}">
        </div>

        <div class="form-group">
            <label for="meta_description">Meta Description</label>
            <input name="meta_description" id="meta_description" class="form-control" value="{{ old('meta_description') }}">
        </div>

        <div class="form-group">
            <label for="status">Status<span class="text-danger">*</span></label>
            <select name="status" id="status" class="form-control" required>
                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Save Post</button>
        <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
