@extends('layouts.app')

@section('main')

  {{-- Include only necessary head elements in the layout, not here --}}
  <link rel="stylesheet" href="{{ asset('css/style_book.css') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Philosopher:wght@400;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="preload" as="image" href="{{ asset('assets/images/hero-banner.png') }}">

  <main>
    <article>

      <!-- HERO SECTION -->
      <section class="section hero" id="home" aria-label="home">
        <div class="container">
          @include('layouts.message')

          <div class="hero-content">
            <p class="section-subtitle">Author Name: {{ $book->author }}</p>
            <h1 class="h1 hero-title">Title: {{ $book->title }}</h1>
            <div class="content mt-3">
              Description: {{ $book->description }}
            </div>

            <div class="hero-banner has-before">
              <img src="{{ asset('uploads/books/' . $book->image) }}" alt="{{ $book->title }}" width="431" height="596" class="w-100">
            </div>
          </div>

        </div>
      </section>

      <!-- CHAPTER PREVIEW -->
      <section class="section preview" aria-label="preview">
        <div class="container">
         
  
          <p class="section-subtitle">Chapter Preview</p>

          <h2 class="h2 section-title has-underline">
            Read some chapter free
            <span class="span has-before"></span>
          </h2>
          @foreach($stories as $index => $story)
          <ul class="tab-list">
         
         
            <li>
              <div class="tab-card">
                <h3 class="h3 tab-text">
                  <a href="{{ route('story.part', ['bookId' => $book->id, 'storyId' => $story->id]) }}">
                    <button class="w-100">Part {{ $index + 1 }}</button>
                  </a>
                </h3>
              </div>
            </li>
          @endforeach

            {{-- Example dummy tabs (can be removed or replaced) --}}

          </ul>

          <div class="container-btu">
            {{-- <a href="{{ route('book.showstories', $book->id) }}">
              <button class="btu">Read More</button>
            </a> --}}
          </div>

        </div>
      </section>

    </article>
  </main>

  <!-- FOOTER -->
  <footer class="footer">
    <div class="container">

      <div class="footer-top">
        <a href="{{ url('/') }}" class="logo">ReadNovel</a>

        <ul class="footer-list">
          <li><a href="{{ url('/') }}" class="footer-link">Home</a></li>
          <li><a href="#" class="footer-link">Benefits</a></li>
          <li><a href="#" class="footer-link">Chapters</a></li>
          <li><a href="#" class="footer-link">Contact</a></li>
        </ul>
      </div>

      <div class="footer-bottom">
        <p class="copyright">
          &copy; 2025 All right reserved. Made with ❤ by MemeTeam.
        </p>
      </div>

    </div>
  </footer>

  <!-- SCRIPTS -->
  <script src="{{ asset('assets/js/script.js') }}"></script>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

@endsection
