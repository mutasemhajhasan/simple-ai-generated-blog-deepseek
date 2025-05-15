@extends('layouts.app')

@section('title', 'All Posts')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>All Posts</h1>
        @auth
            <a href="{{ route('posts.create') }}" class="btn btn-primary">Create Post</a>
        @endauth
    </div>

    <div class="row">
        @foreach($posts as $post)
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    @if($post->featured_image)
                        <img src="{{ asset('storage/' . $post->featured_image) }}" class="card-img-top" alt="{{ $post->title }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-text">{{ Str::limit($post->excerpt, 150) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-primary">Read More</a>
                            <small class="text-muted">Posted {{ $post->published_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    <div class="card-footer">
                        @foreach($post->categories as $category)
                            <a href="{{ route('categories.show', $category) }}" class="badge bg-secondary text-decoration-none me-1">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center">
        {{ $posts->links('pagination::bootstrap-5') }}
    </div>
@endsection
