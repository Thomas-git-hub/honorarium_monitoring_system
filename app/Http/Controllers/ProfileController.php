<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile(){
        return view('administration.profile');
    }

    public function profile_update(Request $request)
    {
    // Validate the request
    $request->validate([
        'first_name' => 'required|string|max:255',
        'middle_name' => 'nullable|string|max:255',
        'last_name' => 'required|string|max:255',
        'suffix' => 'nullable|string|max:255',
        'address' => 'required|string|max:255',
        'contact' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'ee_number' => 'required|string|max:255',
        // Add other validations as needed
    ]);

    // Get the authenticated user
    $user = Auth::user();

    // Update user attributes
    $user->first_name = $request->input('first_name');
    $user->middle_name = $request->input('middle_name');
    $user->last_name = $request->input('last_name');
    $user->suffix = $request->input('suffix');
    $user->address = $request->input('address');
    $user->contact = $request->input('contact');
    $user->email = $request->input('email');
    $user->ee_number = $request->input('ee_number');
    // Save the updated user
    $user->save();

    // Return a JSON response
    return response()->json(['success' => true]);
}


}
