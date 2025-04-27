<?php

namespace App\Http\Controllers;

use App\Notifications\ResetPasswordNotification;
use File;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Like;

use App\Models\Subscription;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Password; 

use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Str;        
use Carbon\Carbon;  

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

        // Create a token manually
        $token = Str::random(60);

        // Store it in password_resets table
        DB::table('password_resets')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => bcrypt($token),
                'created_at' => Carbon::now()
            ]
        );

        // Send email manually
        $user->notify(new ResetPasswordNotification($token));

        return back()->with('success', 'We have emailed your password reset link!');
    }

        // 3. Show Reset Password Form (from email)
        public function resetPasswordForm($token)
        {
            return view('account.reset_password', ['token' => $token]);
        }

    // 4. Update New Password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:5',
            'password_confirmation' => 'required'
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('account.login')->with('success', 'Your password has been reset!')
                    : back()->withErrors(['email' => 'Failed to reset password.']);
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
            $user = auth()->user();
        
            if (getAuthorApprovalMode() === 'auto') {
                $user->update([
                    'role' => 'author',
                    'author_status' => 'approved',
                    'is_approved' => true,
                ]);
            } else {
                $user->update([
                    'author_status' => 'pending',
                ]);
            }
        
            return back()->with('success', 'Your request has been submitted.');
    }
    
    

    

    

}

