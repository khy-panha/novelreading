<?php

namespace App\Http\Controllers;

use App\Notifications\ResetPasswordNotification;
use File;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Setting;
use App\Models\Subscription;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Str;        
 

class AccountController extends Controller
{
    public function register() {

        return view('account.register');
    }
    public function processRegister(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:5',
            'password_confirmation' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('account.register')
            ->withErrors($validator)
            ->withInput();               
        }

        $user= new User();
        $user->name =$request->name;
        $user->email =$request->email;
        $user->password =Hash::make($request->password);
        $user->save();

        return redirect()->route('account.login')->with('success','You have registerterd successfully.');

    }
    public function login (){
        return view('account.login');

    }
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('account.login')->withInput()->withErrors($validator);
        }
    
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
    
            // Redirect based on role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'author') {
                return redirect()->route('account.profile');
            } else {
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('account.login')->with('error', 'Either email/password is incorrect.');
        }
    }
    
    //show user profile
    public function profile () {
        $user = User::find(Auth::user()->id);
        $totalSubscriptions = Subscription::count();
        $relatedBooks =Book::where('status',1)->take(3)->inRandomOrder()->get();
        return view('account.profile', [
            'user' => $user,
            'relatedBooks' => $relatedBooks,
            'totalSubscriptions' => $totalSubscriptions
        ]);
        
    }
    //update user profile
    public function updateProfile(Request $request)
    {
        $books = Book::orderBy("created_at", "desc");
        $books = $books->where("status", 1)->paginate(9);
        $rules = [
            'name' => 'required|min:3',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        // Validate input
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('account.profile')->withInput()->withErrors($validator);
        }

        // Get the logged-in user
        $user = Auth::user();

        // Update name
        $user->name = $request->name;

        // If there's a new image
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($user->image) {
                File::delete(public_path('uploads/profile/' . $user->image));
            }

            // Save new image
            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;
            $image->move(public_path('uploads/profile/'), $imageName);

            $user->image = $imageName;
        }

        $user->save();

        return redirect()->route('account.profile')->with('success', 'Profile updated successfully.');
    }

    public function logout () {
        Auth::logout();
        return redirect()->route('account.logout');
     }
    public function forgotPasswordForm()
    {
            return view('account.forgot_password');
    }

    // 2. Send Reset Link to Email
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        // Create a plain token
        $token = Str::random(60);

        // Store plain token (no bcrypt)
        DB::table('password_resets')->where('email', $request->email)->delete();

        // Send email manually
        $user->notify(new ResetPasswordNotification($token));

        return redirect()->route('account.login')->with('success', 'Your password has been reset!');
    }

    // 3. Show Reset Password Form (from email)
    public function resetPasswordForm($token)
            {
                return view('account.reset_password', [
                    'token' => $token,
                    'email' => request('email') // Pass email too
                ]);
      }

    // 4. Update New Password
    public function updatePassword(Request $request)
        {
            // Validate that the email, password, and token are present
            $request->validate([
                'email' => 'required|email|exists:users,email',
                'password' => 'required|confirmed|min:5',
                'token' => 'required'
            ]);
            
            // Check if the reset token exists for the email
            $passwordReset = DB::table('password_resets')
                ->where('email', $request->email)
                ->where('token', $request->token)
                ->first();
        
            // If token doesn't exist, return an error
            if (!$passwordReset) {
                return back()->withErrors(['email' => 'Invalid token or email.']);
            }
        
            // Find the user
            $user = User::where('email', $request->email)->first();
        
            // Update the password and save the user
            $user->password = Hash::make($request->password);
            $user->save();
        
            // Delete the token from the database
            DB::table('password_resets')->where('email', $request->email)->delete();
        
            // Redirect to login page with success message
            return redirect()->route('account.login')->with('success', 'Your password has been reset!');
    }
        
        
    
    public function menu_account () {
        $user = User::find(Auth::user()->id);
        $book = Book::first();
        $relatedBooks =Book::where('status',1)->take(3)->inRandomOrder()->get();
       return view('account.menu_account',[
        'user'=>$user,
        'book'=>$book,
        'relatedBooks'=>$relatedBooks
       ]);
    }
    
    public function requestAuthor()
    {
        $user = Auth::user();
        
        // Ensure that the user has not already requested author status
        if ($user->author_status !== 'none') {
            return redirect()->route('books.index')->with('error', 'You have already submitted a request or are already an author.');
        }
        
        // Check the approval mode from the settings (default to 'manual' if not set)
        $modeSetting = Setting::where('key', 'author_approval_mode')->first();
        $mode = $modeSetting ? $modeSetting->value : 'manual';
    
        if ($mode === 'auto') {
            // If the mode is auto, approve the user immediately
            $user->author_status = 'approved';
            $user->is_approved = true;
            $user->role = 'author'; 
        } else {
            // If the mode is manual, set the status to pending
            $user->author_status = 'pending';
        }
    
        $user->save();
    
        // Provide feedback based on the approval mode
        if ($mode === 'auto') {
            return redirect()->route('books.index')->with('success', 'You have been automatically approved as an author.');
        } else {
            return redirect()->route('books.index')->with('success', 'Your request to become an author has been submitted and is awaiting approval.');
        }
    }
    
        

}

