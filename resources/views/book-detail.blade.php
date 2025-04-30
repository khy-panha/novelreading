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
        {{-- <div class="container"> --}}
          @include('layouts.message')
         
          <div class="hero-content">
            <div class="left-content">
                <p class="section-subtitle">Author Name: {{ $book->author }}</p>
                <h1 class="h1 hero-title">Title: {{ $book->title }}</h1>
                <p>Total views: {{ $viewCount }}</p>
                <div class="star-rating d-inline-flex ml-2" title="">
                  <span class="rating-text theme-font theme-yellow">{{ $book->averageRating() }} / 5</span>
                  <div class="star-rating d-inline-flex mx-2" title="">
                      <div class="back-stars ">
                          <i class="fa fa-star " aria-hidden="true"></i>
                          <i class="fa fa-star" aria-hidden="true"></i>
                          <i class="fa fa-star" aria-hidden="true"></i>
                          <i class="fa fa-star" aria-hidden="true"></i>
                          <i class="fa fa-star" aria-hidden="true"></i>

                          <div class="front-stars" style="width: {{ $book->averageRating() * 20}}%">
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                          </div>
                      </div>
                  </div>
                  <span class="theme-font text-muted">({{ $book->comments()->count()}} Review)</span>
              </div>
    
              <div class="button-group">
                <!-- Like Button (Heart Icon) -->
                <form action="{{ route('book.like', $book->id) }}" method="POST">
                    @csrf
                    <button type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16" style="color: red;">
                            <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"></path>
                        </svg>
                    </button>
                </form>
                <div class="count">{{ $book->likes()->count() }}</div>
            
                <!-- Subscribe Button (Bell Icon) -->
                <form action="{{ route('book.subscribe', $book->id) }}" method="POST">
                    @csrf
                    <button type="submit">
                        <i class="fa-solid fa-bell" style="font-size: 24px;color:blue"></i>
                    </button>
                </form>
                <div class="count">{{ $book->subscriptions()->count() }}</div>
            </div>
            
            </div>
            <div class="hero-banner has-before">
              <img src="{{ asset('uploads/books/' . $book->image) }}" alt="{{ $book->title }}" width="431" height="596" class="w-100">

            </div>
          </div>

        {{-- </div> --}}
      </section>
      <section class="section description" aria-label="description">
        <div class="content mt-3">
          <h2>Description:</h2>
          <p> {{ $book->description }}</p>
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
      
          <ul class="tab-list">
            @foreach($stories as $index => $story)
              <li>
                <div class="tab-card" data-tab-card>
                  <a href="{{ route('story.part', ['bookId' => $book->id, 'storyId' => $story->id]) }}">
                  <h3 class="h3 tab-text">Part {{ $index + 1 }}</h3>
                 
                    <button class="w-100">Part {{ $index + 1 }}</button>
                  </a>
                </div>
              </li>
            @endforeach
          </ul>
        </div>

      </section>
      
      @if (Auth::guest())
      <script>
          function showAlert() {
              alert("Please Login First!");
          }
      </script>
      <a href="{{ route('account.login') }}">
        <div class="comment-container">
          <h2>Raise Your Comment and Rating Here...</h2>
          <button onclick="openModal()" class="rating-and-comment">Rate & Comment</button>
        </div>
      </a>
  @else
      @if (Auth::user()->role !== 'auth') {{-- Allow all roles except restricted authors --}}
          <section class="section rating" aria-label="rating">
            <div class="comment-container">
              <h2>Raise Your Comment and Rating Here...</h2>
              <button onclick="openModal()" class="rating-and-comment">Rate & Comment</button>
            </div>
              <div class="comments-list" id="commentSection">
                  @foreach ($book->comments as $comment)
                      <div class="card border-0 shadow-lg my-4">
                          <div class="card-body">
                              <div class="d-flex justify-content-between"> 
                                  <h5 class="mb-3">{{ $comment->user->name }}</h5>
                                  <span class="text-muted">
                                      {{ \Carbon\Carbon::parse($comment->created_at)->format('d M, Y') }}
                                  </span>
                              </div>
                              <div class="mb-3">
                                  <div class="star-rating d-inline-flex">
                                      <div class="back-stars">
                                          @for ($i = 1; $i <= 5; $i++)
                                              <i class="fa fa-star" aria-hidden="true"></i>
                                          @endfor
                                          <div class="front-stars" style="width: {{ $comment->rating * 20 }}%">
                                              @for ($i = 1; $i <= 5; $i++)
                                                  <i class="fa fa-star" aria-hidden="true"></i>
                                              @endfor
                                          </div>
                                      </div>
                                  </div>
                                  <span class="theme-font theme-yellow">{{ $comment->rating }} / 5</span>
                              </div>
                              <div class="content">
                                  <p>{{ $comment->comment }}</p>
                              </div>
  
                              @if (auth()->user()->id == $comment->user_id || auth()->user()->id == $comment->book->user_id)
                                  <form action="{{ route('comment.delete', $comment->id) }}" method="POST" style="display:inline;">
                                      @csrf
                                      @method('DELETE')
                                      <button type="submit" class="delete-comment">Delete Comment</button>
              
                                  </form>
                              @endif
                          </div>
                      </div>
                  @endforeach
              </div>
          </section>
      @endif
  @endif
  
  <div id="commentModal" class="modal">
      <div class="modal-content">
          <span class="close" onclick="closeModal()">&times;</span>
          <section class="section comment" aria-label="comment">
              <div class="content mt-3">
                  <div class="comment-box">
                      <h1>Rate and Comment</h1>
                      <form method="POST" action="{{ route('book.saveComment') }}" id="ratingForm">
                          @csrf
                          <input type="hidden" name="book_id" value="{{ $book->id }}">
                            
                          <div class="star-rating" style="display: flex; flex-direction: row;">
                              @foreach (range(5, 1) as $i)
                                  <input id="star{{ $i }}" type="radio" name="rating" value="{{ $i }}" required />
                                  <label for="star{{ $i }}">★</label>
                              @endforeach
                          </div>
  
                          <textarea name="comment" id="commentText" rows="4" placeholder="Write a comment..." required></textarea>
                          <button type="submit" class="comment-btn">Submit</button>
                      </form>
  
                     
                  </div>
              </div>
          </section>
      </div>
      @if(session('success'))
      <div class="alert alert-success">
          {{ session('success') }}
      </div>
  @endif
  </div>
  
      </article>
    </main>

  <!-- FOOTER -->
  <footer class="footer">
    <div class="container">

      <div class="footer-top">
        <a href="{{ url('/') }}" class="logo">ReadNovel</a>

        {{-- <ul class="footer-list">
          <li><a href="{{ url('/') }}" class="footer-link">Home</a></li>
        </ul> --}}
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
  <script>
    function openModal() {
        document.getElementById("commentModal").style.display = "block";
    }

    function closeModal() {
        document.getElementById("commentModal").style.display = "none";
    }

    // Optional: Close modal when clicking outside
    window.onclick = function(event) {
        var modal = document.getElementById("commentModal");
        if (event.target == modal) {
            closeModal();
        }
    }

    // Reopen modal after form submission if there's an error or success message
    @if(session('success') || $errors->any())
        openModal();
    @endif
</script>
    
@endsection
