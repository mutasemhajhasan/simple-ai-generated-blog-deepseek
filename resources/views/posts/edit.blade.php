@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Post</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                       id="title" name="title" value="{{ old('title', $post->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="excerpt" class="form-label">Excerpt</label>
                                <textarea class="form-control @error('excerpt') is-invalid @enderror"
                                          id="excerpt" name="excerpt" rows="3" required>{{ old('excerpt', $post->excerpt) }}</textarea>
                                @error('excerpt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="body" class="form-label">Content</label>
                                <textarea class="form-control @error('body') is-invalid @enderror"
                                          id="body" name="body" rows="10" required>{{ old('body', $post->body) }}</textarea>
                                @error('body')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                @if($post->featured_image)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $post->featured_image) }}" class="img-thumbnail" width="200">
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox"
                                                   id="remove_image" name="remove_image">
                                            <label class="form-check-label" for="remove_image">
                                                Remove featured image
                                            </label>
                                        </div>
                                    </div>
                                @endif
                                <label for="featured_image" class="form-label">Change Featured Image</label>
                                <input class="form-control @error('featured_image') is-invalid @enderror"
                                       type="file" id="featured_image" name="featured_image">
                                @error('featured_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Categories</label>
                                <div class="row">
                                    @foreach($categories as $category)
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                       name="categories[]" value="{{ $category->id }}"
                                                       id="category-{{ $category->id }}"
                                                       {{ $post->categories->contains($category) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="category-{{ $category->id }}">
                                                    {{ $category->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Post</button>
                            <a href="{{ route('posts.show', $post) }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
