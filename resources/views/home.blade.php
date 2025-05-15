@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container py-5">
    <!-- Hero Section -->
    <div class="hero bg-light p-5 rounded-3 mb-5">
        <div class="text-center">
            <h1 class="display-4 fw-bold">Welcome to Laravel Blog</h1>
            <p class="lead">A simple blog application built with Laravel</p>
            <a href="{{ route('posts.index') }}" class="btn btn-primary btn-lg mt-3">Browse Posts</a>
        </div>
    </div>

    <!-- Featured Posts -->
    <section class="mb-5">
        <h2 class="mb-4 border-bottom pb-2">Featured Posts</h2>
        <div class="row g-4">
            @foreach($featuredPosts as $post)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        @if($post->featured_image)
                            <img src="{{ asset('storage/' . $post->featured_image) }}" class="card-img-top" alt="{{ $post->title }}" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            <p class="card-text">{{ Str::limit($post->excerpt, 100) }}</p>
                            <a href="{{ route('posts.show', $post) }}" class="btn btn-outline-primary">Read More</a>
                        </div>
                        <div class="card-footer bg-transparent">
                            <small class="text-muted">Posted {{ $post->published_at->diffForHumans() }} by {{ $post->user->name }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Recent Posts -->
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
            <h2>Recent Posts</h2>
            <a href="{{ route('posts.index') }}" class="btn btn-outline-primary">View All Posts</a>
        </div>
        <div class="row g-4">
            @foreach($recentPosts as $post)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            <p class="card-text">{{ Str::limit($post->excerpt, 80) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-outline-primary">Read More</a>
                                <small class="text-muted">{{ $post->published_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Categories -->
    <section>
        <h2 class="mb-4 border-bottom pb-2">Categories</h2>
        <div class="row g-3">
            @foreach($categories as $category)
                <div class="col-md-3 col-sm-6">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $category->name }}</h5>
                            <p class="card-text">{{ $category->posts_count }} posts</p>
                            <a href="{{ route('categories.show', $category) }}" class="btn btn-sm btn-outline-primary">View Posts</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>
@endsection
