<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Story;
use App\Models\Like;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

// Removed unused imports
use Intervention\Image\Facades\Image as Image;

class BookController extends Controller
{

    public function index(Request $request) {
        $books = Book::orderBy("created_at", "desc");
    
        if (!empty($request->keyword)) {
            $books->where('title', 'like', '%' . $request->keyword . '%');
        }
    
        $books = $books->where("status", 1)->paginate(9);
        
        // Fetch related books (you can adjust the conditions for related books as per your requirement)
        $relatedBooks =Book::where('status',1)
                                ->take(3)
                                ->inRandomOrder()
                                ->get();
        return view('books.list', [
            'books' => $books,
            'relatedBooks' => $relatedBooks // Pass relatedBooks to the view
        ]);
    }
    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|min:5',
            'author' => 'required|min:3',
            'status' => 'required',
            'image' => 'required|image',
            'genre1' => 'required|string|max:255',
            'genre2' => 'nullable|string|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('books.create')
                ->withInput()
                ->withErrors($validator);
        }

        // Save book in DB
        $book = new Book();
        $book->title = $request->title;
        $book->description = $request->description;
        $book->author = $request->author;
        $book->status = $request->status;
        $book->genre1 = $request->genre1;
        $book->genre2 = $request->genre2;

        // Upload book image here
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;
            $image->move(public_path('uploads/books/'), $imageName);

            $book->image = $imageName; // save the image name to the book entity
        }

        $book->save();

        return redirect()->route('books.index')->with('success', 'Book added successfully.');
    }


    public function edit($id)
    {
        $book = Book::findOrFail($id);
        if (auth()->user()->role === 'author' && $book->user_id !== auth()->id()) {
            abort(403);
        }
        return view('books.edit', [
            'book' => $book,
        ]);
    }

    public function update(Request $request)
    {
        $book = Book::findOrFail($request->id);
        $rules = [
            'title' => 'required|min:5',
            'author' => 'required|min:3',
            'status' => 'required',
            'image' => 'image' ,
            'genre1' => 'required|string|max:255',
            'genre2' => 'nullable|string|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('books.edit', $book->id)
                ->withInput()
                ->withErrors($validator);
        }

        // Update book in DB
        $book->title = $request->title;
        $book->description = $request->description;
        $book->author = $request->author;
        $book->status = $request->status;
        $book->genre1 = $request->genre1;
        $book->genre2 = $request->genre2;

        // Upload book image here
        if ($request->hasFile('image')) {
            // Delete old book image
            if (File::exists(public_path('uploads/books/' . $book->image))) {
                File::delete(public_path('uploads/books/' . $book->image));
            }

            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;
            $image->move(public_path('uploads/books/'), $imageName);
            
            $book->image = $imageName; // save the new image name to the book entity
        }

        $book->save();

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(Request $request)
    {
        $book = Book::find($request->id);
        if (auth()->user()->role === 'author' && $book->user_id !== auth()->id()) {
            abort(403);
        }
        if ($book == null) {
            session()->flash('error', 'Book not found');
            return response()->json([
                'status' => false,
                'message' => 'Book not found'
            ]);
        } else {
            // Delete the image if it exists
            if (File::exists(public_path('uploads/books/' . $book->image))) {
                File::delete(public_path('uploads/books/' . $book->image));
            }

            $book->delete();
            session()->flash('success', 'Book deleted successfully.');
            return response()->json([
                'status' => true,
                'message' => 'Book deleted successfully.',
            ]);
        }
    }
    public function likeBook($bookId)
     {
        $book = Book::findOrFail($bookId);
        $user = auth()->user(); // Assuming the user is authenticated

        // Check if the user has already liked the book
        $existingLike = Like::where('book_id', $book->id)
                            ->where('user_id', $user->id)
                            ->first();

        if ($existingLike) {
            return back()->with('error', 'You have already liked this book.');
        }

        // Create the like record
        $like = new Like();
        $like->book_id = $book->id;
        $like->user_id = $user->id;
        $like->save();

        return back()->with('success', 'You liked this book.');
     }
    public function subscribeToBook($bookId)
        {
            $book = Book::findOrFail($bookId);
            $user = auth()->user(); // Assuming the user is authenticated

            // Check if the user is already subscribed
            $existingSubscription = Subscription::where('book_id', $book->id)
                                                ->where('user_id', $user->id)
                                                ->first();

            if ($existingSubscription) {
                return back()->with('error', 'You are already subscribed to this book.');
            }

            // Create the subscription record
            $subscription = new Subscription();
            $subscription->book_id = $book->id;
            $subscription->user_id = $user->id;
            $subscription->save();

            return back()->with('success', 'You subscribed to this book.');
        }
}