@extends('admin.layout')

@section('title', 'Create Blog Post')

@section('content')
    <h2>Create New Blog Post</h2>

    <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="col-12">
            <div class="row shadow-lg p-3 mb-5 bg-body rounded">
                <div class="col-6">
                    <div class="form-group">
                        <label for="title">Title <span class="text-danger">*</span></label>
                        <input name="title" id="title" class="form-control" required value="{{ old('title') }}">
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label for="url">URL <span class="text-danger">*</span></label>
                        <input name="url" id="url" class="form-control" required  value="{{ old('url') }}">
                        <small id="url-message" class="form-text mt-1"></small>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label for="summernote">Description <span class="text-danger">*</span></label>
                        <textarea id="summernote" name="description"
                            class="form-control">{{ old('description', $post->description ?? '') }}</textarea>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group mb-2">
                        <label for="image">Upload Image <span class="text-danger">*</span></label>
                        <input type="file" name="image" id="formFile" class="form-control">
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label for="meta_title">Meta Title <span class="text-danger">*</span></label>
                        <input name="meta_title" id="meta_title" class="form-control" value="{{ old('meta_title') }}">
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label for="meta_description">Meta Description <span class="text-danger">*</span></label>
                        <input name="meta_description" id="meta_description" class="form-control"
                            value="{{ old('meta_description') }}">
                    </div>
                </div>

                <div class="col-6 mt-3">
                    <button type="submit" class="btn btn-success">Save Post</button>
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </form>
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

    <script>
        function slugify(text) {
            return text.toString().toLowerCase()
                .replace(/\s+/g, '-')        // Replace spaces with -
                .replace(/[^\w\-]+/g, '')    // Remove all non-word chars
                .replace(/\-\-+/g, '-')      // Replace multiple - with single -
                .replace(/^-+/, '')          // Trim - from start
                .replace(/-+$/, '');         // Trim - from end
        }

        $('#title').on('input', function () {
            let slug = slugify($(this).val());
            $('#url').val(slug);
            checkUrlAvailability(slug);
        });

        function checkUrlAvailability(slug) {
            $.ajax({
                url: "{{ route('admin.posts.check-url') }}",
                method: 'GET',
                data: { url: slug },
                success: function (data) {
                    let msg = $('#url-message');
                    if (data.available) {
                        msg.text('✅ URL is available').css('color', 'green');
                    } else {
                        msg.text('❌ URL already exists').css('color', 'red');
                    }
                }
            });
        }
    </script>
@endpush