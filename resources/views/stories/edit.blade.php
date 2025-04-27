
@extends('layouts.app')

@section('main')

{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_part.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Responsive Card Layout</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body> --}}
    <div class="series-container">
        <div class="series1">
            <button class="series-button">1</button>Series
        </div>
        <div class="series2">
            <button class="series-button">2</button> Series
        </div>
    </div>
    <div class="input-container">
        @include('layouts.message')
        <div class="list-title">
            <h2>Series Title:{{ $book->title }}</h2>
        </div> 
            
        <form action="{{ route('stories.update', [$book->id, $story->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
                       
            @method('PUT')
            <div class="form-group">
                <label for="titleInput">Part</label>
                <input 
                        type="text" 
                        class="form-control @error('part') is-invalid @enderror" 
                        placeholder="Enter part" 
                        name="part" 
                        id="part" 
                        value="{{ old('part', $story->part) }}" />
                    
                        @error('part')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
            </div>

            <div class="form-group">
                <label for="story">Write Whole Story</label>
                <textarea 
                        class="ckeditor form-control auto-expand @error('story') is-invalid @enderror" 
                        placeholder="Enter your story" 
                        name="story" 
                        id="story"
                        rows="5">{{ old('story', $story->story) }}</textarea>

                        @error('story')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
            </div> 
            
            <div class="status-group">
                <label for="selectOne">Status</label>
                <select class="custom-select" id="inputGroupSelect04">   
                <option value="1">On-going</option>
                <option value="2">End</option>
                </select>
            
            </div>
            <div class="button-container">
            <button class="btn btn-primary mt-2">Edit</button>   
            </div>
        </form> 
    </div>
{{-- 
    

</body>

</html> --}}
@endsection
