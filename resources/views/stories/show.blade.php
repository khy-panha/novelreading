@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $story->part }}</h2>
    <p>{{ $story->story }}</p>

    @if ($story->pdf_file)
        <h3>PDF Viewer</h3>
        <iframe src="{{ asset('storage/' . $story->pdf_file) }}" width="100%" height="600px"></iframe>
    @else
        <p>No PDF uploaded for this story.</p>
    @endif
</div>
@endsection
