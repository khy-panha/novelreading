<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function pendingAuthors()
    {
        // Show users who have requested to become authors (pending status)
        $authors = User::where('author_status', 'pending')->get();
        $mode = Setting::where('key', 'author_approval_mode')->first(); // Get current approval mode
        
        // If mode not found, set to 'manual' by default
        if (!$mode) {
            $mode = 'manual';
        } else {
            $mode = $mode->value;
        }
        
        return view('admin.pending-authors', compact('authors','mode'));
    }
    
    
    public function approveAuthor($id)
    {
        $user = User::findOrFail($id);
    
        $user->author_status = 'approved';
        $user->role = 'author';
        $user->is_approved = true;
        $user->save();
    
        return redirect()->back()->with('success', 'Author approved successfully.');
    }

    public function autoApproveAuthor($id)
    {
        $user = User::findOrFail($id);
    
        $user->author_status = 'approved';
        $user->role = 'author';
        $user->is_approved = true;
        $user->save();
    
        return redirect()->back()->with('success', 'Author auto-approved.');
    }
    public function toggleApprovalMode()
{
    // Get the current setting for 'author_approval_mode'
    $mode = Setting::where('key', 'author_approval_mode')->first();

    // Toggle between 'manual' and 'auto'
    if (!$mode || $mode->value == 'auto') {
        $modeValue = 'manual'; // Set to manual if it was previously auto or doesn't exist
    } else {
        $modeValue = 'auto'; // Set to auto if it was previously manual
    }

    // Update the approval mode in the settings table
    Setting::updateOrCreate(
        ['key' => 'author_approval_mode'],
        ['value' => $modeValue]
    );

    // Redirect back to the admin dashboard or pending authors page
    return redirect()->route('admin.pendingAuthors');
}

    
    
    public function index()
{
    // Get the current approval mode from the settings table
    $mode = Setting::where('key', 'author_approval_mode')->first(); 

    // If mode not found, set to 'manual' by default
    if (!$mode) {
        $mode = 'manual';
    } else {
        $mode = $mode->value;
    }

    // Pass the mode to the view
    return view('admin.dashboard', compact('mode'));
}

        
    public function manageUsers()
        {
            $users = User::all(); // or paginate if needed
            $authors = User::where('role', 'author')->get(); // This provides the $authors variable

            return view('admin.users', compact('users', 'authors'));
        }
      public function manageBooks()
    {
        return view('admin.books');
    }

    public function manageCategories()
    {
        return view('admin.categories');
    }

    public function manageSubscriptions()
    {
        return view('admin.subscriptions');
    }

    public function analytics()
    {
        return view('admin.analytics');
    }

    public function feedbackReports()
    {
        return view('admin.feedback');
    }

    public function settings()
    {
        return view('admin.settings');
    }  
        
}
