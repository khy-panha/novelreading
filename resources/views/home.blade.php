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

      <!-- 
        - #HERO
      -->

      <section class="section hero" id="home" aria-label="home">
        <div class="container">

          <div class="hero-content">

            <p class="section-subtitle">Let's Make The Best Investment</p>

            <h1 class="h1 hero-title">Read More And Make Success The Result Of Perfection.</h1>

            <p class="section-text">
              Get lost in another world, one page at a time. #BookLovers.
            </p>

          </div>

          <div class="hero-banner has-before">
            <img src="./assets/images/hero-banner.png" width="431" height="596"
              alt="things i never said, a novel by claudia wilson" class="w-100">

            <button class="play-btn" aria-label="play video">
              <ion-icon name="play-outline" aria-hidden="true"></ion-icon>
            </button>
          </div>

        </div>
      </section>

      <!-- 
        - #BENEFITS
      -->

      <section class="section benefits" id="benefits" aria-label="benefits" id="searchResults">
        <div class="container">

          <div class="grid-list" id="bookList">

            <li class="benefits-content">
              <h2 class="h2 section-title">New Novel</h2>

              <p class="section-text">Get lost in another world, one page at a time. #BookLovers.</p>
            </li>

            @if($books->isNotEmpty())
            @foreach ($books as $book)
            <li class="book-item">
              <div class="benefits-card has-before has-after">

                <h3 class="h3 card-title">{{ $book->title }}</h3>
                <img src="{{ asset('uploads/books/' . $book->image) }}" alt="Book Image" class="card-image" loading="lazy">
                <a href="{{ route('book.detail', $book->id) }}" class="btn-link">
                  <span class="span">Read more</span>
                  <ion-icon name="chevron-forward-outline" aria-hidden="true"></ion-icon>
                </a>

              </div>
            </li>
          @endforeach
        @endif
           

          </div>

        </div>
      </section>


      <!-- 
        - #BENEFITS
      -->

      <section class="section benefits" id="chapters" aria-label="benefits" id="searchResults">
        <div class="container">

          <div class="grid-list" id="bookList">

            <li class="benefits-content">
              <h2 class="h2 section-title">Pupular</h2>

              <p class="section-text">Get lost in another world, one page at a time. #BookLovers.</p>
            </li>

            <li class="book-item">
              <div class="benefits-card has-before has-after">

                <h3 class="h3 card-title">Title : 7</h3>
            
                <!-- Replace the paragraph with an image -->
                <img src="img/book1.png" alt="Description of the image" class="card-image" loading="lazy">
            
                <a href="Chapter.html" class="btn-link">
                    <span class="span">Read more</span>
                    <ion-icon name="chevron-forward-outline" aria-hidden="true"></ion-icon>
                </a>
            
            </div>
            </li>

            <li class="book-item">
              <div class="benefits-card has-before has-after">

                <h3 class="h3 card-title">Title : 8</h3>
            
                <!-- Replace the paragraph with an image -->
                <img src="img/book2.png" alt="Description of the image" class="card-image" loading="lazy">
            
                <a href="Chapter.html" class="btn-link">
                    <span class="span">Read more</span>
                    <ion-icon name="chevron-forward-outline" aria-hidden="true"></ion-icon>
                </a>
            
            </div>
            </li>

            <li class="book-item">
              <div class="benefits-card has-before has-after">

                <h3 class="h3 card-title">Title : 9</h3>
            
                <!-- Replace the paragraph with an image -->
                <img src="img/book3.png" alt="Description of the image" class="card-image" loading="lazy">
            
                <a href="Chapter.html" class="btn-link">
                    <span class="span">Read more</span>
                    <ion-icon name="chevron-forward-outline" aria-hidden="true"></ion-icon>
                </a>
            
            </div>
            </li>

            <li class="book-item">
              <div class="benefits-card has-before has-after">

                <h3 class="h3 card-title">Title : 10</h3>
            
                <!-- Replace the paragraph with an image -->
                <img src="img/book4.png" alt="Description of the image" class="card-image" loading="lazy">
            
                <a href="Chapter.html" class="btn-link">
                    <span class="span">Read more</span>
                    <ion-icon name="chevron-forward-outline" aria-hidden="true"></ion-icon>
                </a>
            
            </div>
            </li>

            <li class="book-item">
              <div class="benefits-card has-before has-after">

                <h3 class="h3 card-title">Title : 11</h3>
            
                <!-- Replace the paragraph with an image -->
                <img src="img/book5.png" alt="Description of the image" class="card-image" loading="lazy">
            
                <a href="Chapter.html" class="btn-link">
                    <span class="span">Read more</span>
                    <ion-icon name="chevron-forward-outline" aria-hidden="true"></ion-icon>
                </a>
            
            </div>
            </li>

            <li class="book-item">
              <div class="benefits-card has-before has-after">

                <h3 class="h3 card-title">Title : 12</h3>
            
                <!-- Replace the paragraph with an image -->
                <img src="img/book6.png" alt="Description of the image" class="card-image" loading="lazy">
            
                <a href="Chapter.html" class="btn-link">
                    <span class="span">Read more</span>
                    <ion-icon name="chevron-forward-outline" aria-hidden="true"></ion-icon>
                </a>
            
            </div>
            </li>

          </div>

        </div>
      </section>


      <!-- 
        - #BENEFITS
      -->

      <section class="section benefits" id="benefits" aria-label="benefits" id="searchResults">
        <div class="container">

          <div class="grid-list" id="bookList">

            <li class="benefits-content">
    
              <h2 class="h2 section-title">Recommend</h2>

              <p class="section-text">Get lost in another world, one page at a time. #BookLovers.</p>
            </li>

            @if ($relatedBooks->isNotEmpty())
            @foreach ($relatedBooks as $relatedBook)
                <li class="book-item">
                  <div class="benefits-card has-before has-after">
        
                    <h3 class="h3 card-title">{{ $relatedBook->title }}</h3>
                    <img src="{{ asset('uploads/books/' . $relatedBook->image) }}" alt="Book Image" class="card-image" loading="lazy">
                    <a href="{{ route('book.detail', $relatedBook->id) }}" class="btn-link">
                      <span class="span">Read more</span>
                      <ion-icon name="chevron-forward-outline" aria-hidden="true"></ion-icon>
                    </a>
        
                  </div>
                </li>
            @endforeach
        @endif
           

          </div>

        </div>
      </section>

      <!-- 
        - #CONTACT
      -->

      <section class="section contact" id="contact" aria-label="contact">
        <div class="container">

          <p class="section-subtitle">Contact</p>

          <h2 class="h2 section-title has-underline">
            Write me anything
            <span class="span has-before"></span>
          </h2>

          <div class="wrapper">

            <form action="" class="contact-form">

              <input type="text" name="name" placeholder="Your Name" required class="input-field">

              <input type="email" name="email_address" placeholder="Your Email" required class="input-field">

              <input type="text" name="subject" placeholder="Subject" required class="input-field">

              <textarea name="message" placeholder="Your Message" class="input-field"></textarea>

              <button type="submit" class="btn btn-primary">Send Now</button>

            </form>

            <ul class="contact-card">

              <li>
                <p class="card-title">Address: Phnom Penh</p>

                <address class="address">
                  16, Lankaway <br>
                  Phnom Penh, Cambodia
                </address>
              </li>

              <li>
                <p class="card-title">Phone:+855 123 456</p>

                <a href="tel:+855 123 456" class="card-link"> +855 123 456</a>
              </li>

              <li>
                <p class="card-title">Email:</p>

                <a href="mailto:support@support.com" class="card-link">support@Teameme.com</a>
              </li>

              <li>
                <p class="social-list-title h3">Our Contec</p>

                <ul class="social-list">

                  <li>
                    <a href="" class="social-link">
                      <ion-icon name="logo-facebook"></ion-icon>
                    </a>
                  </li>

                  <li>
                    <a href="#" class="social-link">
                      <ion-icon name="logo-twitter"></ion-icon>
                    </a>
                  </li>

                  <li>
                    <a href="#" class="social-link">
                      <ion-icon name="logo-linkedin"></ion-icon>
                    </a>
                  </li>

                  <li>
                    <a href="#" class="social-link">
                      <ion-icon name="logo-youtube"></ion-icon>
                    </a>
                  </li>

                  <li>
                    <a href="#" class="social-link">
                      <ion-icon name="logo-whatsapp"></ion-icon>
                    </a>
                  </li>

                </ul>
              </li>

            </ul>

          </div>

        </div>
      </section>

    </article>
  </main>





  <!-- 
    - #FOOTER
  -->

  <footer class="footer">
    <div class="container">

      <div class="footer-bottom">
        <p class="copyright">
          &copy; 2025 All right reserved. Made with ❤ by MemeTeam.
        </p>
      </div>

    </div>
  </footer>


  <!-- 
    - custom js link
  -->
  <script src="{{ asset('js/script.js') }}"></script>

  <!-- 
    - ionicon link
  -->


</body>
@endsection