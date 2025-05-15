@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ $category->name }}</h1>
        <a href="{{ route('categories.index') }}" class="btn btn-outline-primary">
            Back to Categories
        </a>
    </div>

    @if($category->description)
        <div class="card mb-4">
            <div class="card-body">
                <p class="card-text">{{ $category->description }}</p>
            </div>
        </div>
    @endif

    <h2 class="mb-3">Posts in this category</h2>

    @if($posts->count() > 0)
        <div class="row">
            @foreach($posts as $post)
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        @if($post->featured_image)
                            <img src="{{ Storage::url($post->featured_image) }}"
                                 class="card-img-top"
                                 alt="{{ $post->title }}"
                                 style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                            </h5>
                            <p class="card-text">{{ Str::limit($post->excerpt, 150) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-primary">Read More</a>
                                <small class="text-muted">
                                    {{ $post->published_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            @foreach($post->categories as $postCategory)
                                <a href="{{ route('categories.show', $postCategory) }}"
                                   class="badge bg-secondary text-decoration-none me-1">
                                    {{ $postCategory->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $posts->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="alert alert-info">
            No posts found in this category.
            @auth
                <a href="{{ route('posts.create') }}" class="alert-link">Create a new post</a> in this category.
            @endauth
        </div>
    @endif
</div>
@endsection
