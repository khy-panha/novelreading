<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Comment;
use App\Models\Story;
use App\Models\Views;
use Auth;
use Illuminate\Http\Request;
use Validator;

class HomeController extends Controller
{
    public function index(Request $request){

        $books = Book::orderBy("created_at","desc");
    
    if(!empty($request->keyword))
    {
       $books->where('title','like','%'. $request->keyword. '%');
    }

        $books= $books->where("status",1)->paginate(9);
        $relatedBooks =Book::where('status',1)
        ->take(3)
        ->inRandomOrder()
        ->get();
        return view('home',[
            'books'=> $books,
            'relatedBooks'=> $relatedBooks
        ]);
    }
    public function showStoryPart($bookId, $storyId)
        {
            $books = Book::orderBy("created_at", "desc");
    
            // Fetch the book and its related stories
            $book = Book::with('stories')->findOrFail($bookId);
            
            // Get all stories, ordered by part (or ID)
            $stories = $book->stories->sortBy('part')->values(); // You can use 'id' if preferred
        
            // Get the current story
            $story = $stories->firstWhere('id', $storyId);
            if (!$story) {
                abort(404, 'Story not found in this book');
            }
        
            // Get current index
            $currentIndex = $stories->search(function ($s) use ($storyId) {
                return $s->id == $storyId;
            });
        
            // Determine prev and next stories
            $prevStory = $currentIndex > 0 ? $stories[$currentIndex - 1] : null;
            $nextStory = $currentIndex < $stories->count() - 1 ? $stories[$currentIndex + 1] : null;
        
            // Pass everything to view
            return view('showstories', compact('book', 'story', 'prevStory', 'nextStory','books'));
    }
        
    //This method will show book detail page
    public function detail($id){

        $book = Book::with('comments','comments.user')->findOrFail($id);
        $stories = $book->stories;
        // $user = User::find(Auth::user()->id);
        $relatedBooks =Book::where('status',1)->take(3)->inRandomOrder()->get();
        $viewCount = Views::where('book_id', $id)->count();
        
        return view('book-detail',[
            'book'=> $book,

            'relatedBooks'=> $relatedBooks,
            'viewCount' => $viewCount,
             'stories'=>$stories,
            // 'user'=> $user,	
        ]);
    }
    //this will save comment
    public function saveComment(Request $request){
        $validator = Validator::make($request->all(),[
            'review'=>'',
            'rating'=>'',
        ]);
        if ($validator->fails()){
            return response()->json([
                'status'=> 'false',
                'errors'=> $validator->errors(),
            ]);
        }

        

        $comment = new Comment();
        $comment->comment =$request->comment;
        $comment->rating = $request->rating;
        $comment->user_id = Auth::user()->id;
        $comment->book_id = $request->book_id;
        $comment->save();
        

        session()->flash('success','Comment submitted sucessfully');

        return response()->json([
            'status'=> 'true',
            // 'comment'=> $comment,
        ]);
    }
    public function deleteComment($commentId)
{
    $comment = Comment::findOrFail($commentId);

    // Check if the logged-in user is either the author of the comment or the author of the book
    if (auth()->user()->id == $comment->user_id || auth()->user()->id == $comment->book->user_id) {
        // Delete the comment
        $comment->delete();

        return redirect()->route('book.detail', $comment->book->id)->with('success', 'Comment deleted successfully');
    } else {
        return redirect()->route('book.detail', $comment->book->id)->with('error', 'You are not authorized to delete this comment');
    }
}

    public function trackView($bookId)
    {
        // Check if the user has already viewed the book
        $view = new Views();
        $view->book_id = $bookId;
        $view->user_id = Auth::user()->id;
        $view->viewed_at = now();
        $view->save();

        return redirect()->route('book.showstories', $bookId);
    }
    public function updateViewCount($bookId)
    {
        $book = Book::findOrFail($bookId);
        
        // Count views for this book
        $viewCount = Views::where('book_id', $bookId)->count();

        // Update the book's view count (if you want to store it in a column on the Book model)
        $book->view_count = $viewCount;
        $book->save();

        return response()->json(['success' => true]);
    }


}
