@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Categories</h1>
        @can('create', App\Models\Category::class)
            <a href="{{ route('categories.create') }}" class="btn btn-primary">Create Category</a>
        @endcan
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Posts</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->posts_count }}</td>
                            <td>
                                <a href="{{ route('categories.show', $category) }}" class="btn btn-sm btn-outline-primary">View</a>
                                @can('update', $category)
                                    <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                @endcan
                                @can('delete', $category)
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $categories->links() }}
    </div>
</div>
@endsection
