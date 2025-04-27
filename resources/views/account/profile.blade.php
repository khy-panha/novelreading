    @extends('layouts.app')

    @section('main')
    <link rel="stylesheet" href="{{ asset('css/style_acc.css') }}">
    <div class="account-container">
        <div class="menu-on-top">
            <div class="p-2-subscribe">
                <a href="{{ route('account.profile') }}">Subscribe</a>
            </div>
            <div class="p-3-dashbord">
            @if (in_array(Auth::user()->role, ['author', 'admin']))
                <div class="p-2">
                    <a href="{{ route('books.index') }}">DASHBOARD</a>
                </div>
            @endif
            </div>

            <div class="p-4-account"><a href="{{ route('account.menu_account') }}">ACCOUNT</a></div>
        </div>
        <div class="profile-container">
            <!-- Display User Info -->
            <div class="user-info">
                <h5 class="welcome-message">Welcome, {{ $user->name }}</h5>
            </div>
        
            <!-- Display Book Info and Subscriptions -->
            <div class="book-info">
                @if($totalSubscriptions)
                <h5>Subscriptions: <span class="subscriptions-count">{{ $totalSubscriptions }}</span></h5>

                @else
                    <h5>Have No Subscription</h5>
                @endif
            </div>
        </div>
        @if(Auth::user()->role === 'user' && Auth::user()->author_status === 'none')
    <form method="POST" action="{{ route('account.requestAuthor') }}">
        @csrf
        <button type="submit" class="btn btn-primary">Become an Author</button>
    </form>
    @elseif(Auth::user()->author_status === 'pending')
        <p class="text-warning">Your request to become an author is pending admin approval.</p>
    @endif
    </div>
    <div class="d-flex ml-4">
        <div class="list-1">
            <ul class="list-group">
                <li class="list-group-item">Most Views</li>
                @if(isset($relatedBooks) && $relatedBooks->isNotEmpty())
                    @foreach ($relatedBooks as $relatedBook)
                        <li class="list-group-item">

                            <a href="{{ route('book.detail', $relatedBook->id) }}">
                                <img src="{{ asset('uploads/books/' . $relatedBook->image) }}" class="card-img-top">
                            </a>
                            <div class="text">
                            <h3 class="h4 heading">{{ $relatedBook->title }}</h3>
                            <p>by {{ $relatedBook->author }}</p>
                            </div>
                        </li>
                    @endforeach
                @else
                    <li class="list-group-item">No related books found.</li>
                @endif
            </ul>
        </div>
        <div class="list-2">
            <ul class="list-group">
                <li class="list-group-item">Most By Genre</li>
                <!-- Add dynamic genre-based books here -->
            </ul>
        </div>
</div>

@endsection
