<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReportProblemMail;

class ProfileController extends Controller
{
    public function profile(){
        if(Auth::check()){
            return view('administration.profile');
        }else{
            abort(403, 'Unauthorized action.');
        }

    }

    public function profile_update(Request $request)
    {
        // Validate the request
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
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

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['success' => false, 'errors' => ['current_password' => ['Current password is incorrect']]]);
        }
       
        $user->update(['password' => Hash::make($request->new_password)]);

        return response()->json(['success' => true, 'message' => 'Password changed successfully!']);
    }

    public function getSuperAdmins(){
        $superAdmin = UserType::where('name', 'Superadmin')->first();
        $superAdmins = User::where('usertype_id', $superAdmin->id)->get();
        return response()->json($superAdmins);
    }

    public function sendEmail(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Get the sender (current user) and recipient (super admin)

            $sender = Auth::user();
            $recipient = User::findOrFail($request->user_id);
            $recipient = User::findOrFail($request->user_id);

            $emailData = [
                'first_name' => Auth::user()->first_name,
                'last_name' => Auth::user()->last_name,
                'email' => Auth::user()->email,
                'message' => $request->message,
                'reportedAt' => now(),
                'subject' => $request->subject,
            ];
           

            // Send email using the Mailable class
            Mail::to($recipient->email)
                ->send(new ReportProblemMail($emailData));

            return response()->json([
                'success' => true,
                'message' => 'Email sent successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send email',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
