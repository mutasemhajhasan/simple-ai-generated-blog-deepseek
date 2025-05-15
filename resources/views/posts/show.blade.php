@php use Illuminate\Support\Facades\Storage; @endphp
@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <article>
        <div class="card mb-4">
          @if($post->featured_image)
    <img src="{{ Storage::url($post->featured_image) }}"
         class="card-img-top"
         alt="{{ $post->title }}"
         style="max-height: 400px; object-fit: cover;">
@endif
            <div class="card-body">
                <h1 class="card-title">{{ $post->title }}</h1>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <span class="text-muted">Posted by {{ $post->user->name }}</span>
                        <span class="mx-2">•</span>
                        <span class="text-muted">
                            @if ($post->published_at)
                                {{ $post->published_at->format('F j, Y') }}
                            @else
                                Draft (not published)
                            @endif
                        </span>
                    </div>
                    @can('update', $post)
                        <div>
                            <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </div>
                    @endcan
                </div>
                <div class="mb-3">
                    @foreach ($post->categories as $category)
                        <a href="{{ route('categories.show', $category) }}"
                            class="badge bg-primary text-decoration-none me-1">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
                <div class="card-text">
                    {!! nl2br(e($post->body)) !!}
                </div>
            </div>
        </div>
    </article>

    <!-- Comments Section -->
    <section class="mb-5">
        <h3 class="mb-4">Comments ({{ $post->comments->count() }})</h3>

        @auth
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('comments.store', $post) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="body" class="form-label">Add Comment</label>
                            <textarea class="form-control" id="body" name="body" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        @endauth

        @foreach ($post->comments as $comment)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="card-subtitle mb-1">{{ $comment->user->name }}</h6>
                            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                        </div>
                        @can('delete', $comment)
                            <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        @endcan
                    </div>
                    <p class="card-text">{{ $comment->body }}</p>
                </div>
            </div>
        @endforeach
    </section>
@endsection
