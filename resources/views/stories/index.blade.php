@extends('layouts.app')

@section('main')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

<div class="stories-container">
    
    {{-- Book banner (shown once) --}}
    <div class="profile-banner">
      <div class="profile-details">
          <a href="{{ route('stories.index', $book->id) }}">
              <img src="{{ asset('uploads/books/' . $book->image) }}" alt="{{ $book->title }}" class="card-image">
          </a>
          <div class="profile-info">
              <h1>{{ $book->title }}</h1>
              <p>Romance • Drama</p>
              <p>by {{ $book->author }}</p>
          </div>
      </div>
      <a href="{{ route('stories.create', $book->id) }}" class="Add-Epersode">
          + Add Episode
      </a>
  </div>
  

    {{-- Chapters and description --}}
    <div class="chapters">
        <div class="chapter-list">
            {{-- Loop stories here to only show parts --}}
            @foreach ($stories as $story)
            <div class="chapter">
                <div class="chapter-meta">
                    <strong>{{ $story->part }}</strong>
                    <span>Updated {{ $story->created_at->format('M d, Y') }} • ❤️{{ $book->likes()->count() }}</span>
                </div>
            </div>
            @endforeach
        </div>

        <div class="sidebar">
            <p><strong>Description:</strong></p>
            <p>{{ $book->description }}</p>
            <a href="#" class="button">First episode</a>
        </div>
    </div>
</div>
@endsection
