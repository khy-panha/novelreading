@extends('layouts.app')

@section('main')
  <!-- 
    - primary meta tags
  -->
  <title>ReadNovel - Read More And Make Success</title>
  <meta name="title" content="ReadNovel - Read More And Make Success">
  <meta name="description"
    content="Read More And Make Success The Result Of Perfection. - Get lost in another world, one page at a time. #BookLovers.">

  <!-- 
    - favicon
  -->
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">

  <!-- 
    - custom css link
  -->
  <link rel="stylesheet" href="{{ asset('css/style_book.css') }}">

  <!-- 
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Philosopher:wght@400;700&family=Poppins:wght@400;500;600&display=swap"
    rel="stylesheet">

  <!-- 
    - preload image
  -->
  <link rel="preload" as="image" href="./assets/images/hero-banner.png">

</head>

<body>

  <!-- 
    - #HEADER
  -->


  <main>
    <article>
      <!-- Book Reading Page -->
      <section class="section reading" id="reading" aria-label="reading" style="background-color: #f5f0e9; margin-top: 50px;">
        <div class="container">
          <div class="reading-content">
            <h1 class="h1 reading-title">Title: {{ $book->title }} - Part {{ $story->part }}</h1>
            <p id="bookText" class="section-text">
              <p>{!! $story->story !!}</p>

            </p>
            
          </div>
          <div class="container-btn">
            {{-- Previous Button --}}
            @if($prevStory)
                <a href="{{ route('story.part', ['bookId' => $book->id, 'storyId' => $prevStory->id]) }}">
                    <button class="btn">Previous</button>
                </a>
            @else
                <a href="{{ route('book.detail', $book->id) }}">
                    <button class="btn">To Book</button>
                </a>
            @endif
        
            {{-- Next Button --}}
            @if($nextStory)
                <a href="{{ route('story.part', ['bookId' => $book->id, 'storyId' => $nextStory->id]) }}">
                    <button class="btn">Next</button>
                </a>
            @else
                <a href="{{ route('book.detail', $book->id) }}">
                    <button class="btn">?</button>
                </a>
            @endif
        </div>
        
        </div>
      </section>
      
    </article>
  </main>

  <!-- 
    - #FOOTER
  -->
  <footer class="footer">
    <!-- <div class="container">
      <div class="footer-bottom">
        <p class="copyright">
          © 2025 All rights reserved. Made with ❤ by MemeTeam.
        </p>
      </div>
    </div> -->
  </footer>

  <!-- 
    - custom js link
  -->
  <script src="{{ asset('js/script.js') }}"></script>

  <!-- 
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>