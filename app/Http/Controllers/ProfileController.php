<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;




class ProfileController extends Controller
{

    public function show(string $id)
    {        
        $user = User::findOrFail($id);
        return Inertia::render('UserProfile/Index', [
            'user' => $user,
        ]);

        //return response()->json($user);
    }	
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit');
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request, string $id)
    {

        $request->all();
        dd($request->all());

        // if is a file "image" in the request
        if ($request->hasFile('image')) {
            // get the file
            $file = $request->file('image');
            // generate a new filename. getClientOriginalExtension() for the file extension
            $filename = Str::random() . '.' . $file->getClientOriginalExtension();
            // save to storage/app/public as the new $filename
            $path = $file->storeAs('public', $filename);
            // delete the old image.
            Storage::delete($request->user()->image);
            // update the user
            $request->image = $filename;
        }


        $user = $request->user();
        $user->update($request);
        

        return Inertia::render('UserProfile/Index', [
            'user' => $user,
        ]);
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
