<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
         
        $validated = $request->validate([
            'email' => 'nullable',
            'name' => 'nullable',
            'bio' => 'nullable',
        ]); 

       $user =User::find($request->userID);
       if($validated['email'] != null){
        $user-> update([
            'email' => $validated['email']
       ]);
       }
       if($validated['name'] != null){
        $user-> update([
            'name' => $validated['name']
       ]);
       }
    
       if($validated['bio'] != null){
        $user-> update([
            'bio' => $validated['bio']
       ]);
    }
}

    public function uploadPFP(Request $request){
        if($request->hasFile('profile_picture')){
            $link = Storage::disk('public')->put('photos', $request->file('profile_picture'));
            $request->user()->update(['pfpPath' => $link]);http://127.0.0.1:8000/5fc4f4d4-e175-4a4c-8b91-313d8b811a89
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
