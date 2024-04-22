<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {

        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());
    
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
    
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->storePublicly('uploads', 'public');
            $imageUrl = asset('storage/' . str_replace('public/', '', $imagePath));
            $request->user()->image = $imageUrl; // Assicurati che 'image' sia un campo stringa nel modello dell'utente
        }
        // if($request->user()->image = ''){
        //     $request->user()->image = null;
        // }
        $request->user()->save();
    
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
    
    

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function settings(){
        $user = auth()->user();
        $settings = json_decode($user->settings, true);
        $orderByValue = $settings['orderBy'] ?? null;
        $orderForValue = $settings['orderFor'] ?? null;
        $orderPerPageValue = $settings['perPage'] ?? null;
        $user->settings = json_encode($settings);
        $user->save();
        return view('profile.partials.settings', compact('user', 'settings', 'orderByValue', 'orderPerPageValue' , 'orderForValue'));
    }

    public function stripe(Request $request){
        $user = auth()->user();
        $settings = json_decode($user->settings, true);
  
        if($request['active'] == null){
            $request['active'] = 0;
        };
        $requestData = $request->all();
        
      
        $active = $requestData['active'];
        $public_key = $requestData['public_key'];
        $private_key = $requestData['private_key'];
        

        $settings['payMethods'][0]['active'] = $active;
        $settings['payMethods'][0]['publickey'] = $public_key;
        $settings['payMethods'][0]['privateKey'] = $private_key ;
        $orderByValue = $settings['orderBy'] ?? null;
        $orderForValue = $settings['orderFor'] ?? null;
        $orderPerPageValue = $settings['perPage'] ?? null;
        
        $user->settings = json_encode($settings);

        $user->save();
        return view('profile.partials.settings', compact('user', 'settings', 'orderByValue', 'orderPerPageValue' , 'orderForValue'));
    }

    public function updateSettings(Request $request){
        $user = auth()->user();
        $settings = json_decode($user->settings, true);
        $requestData = $request->all();
        $settings['orderBy'] = $requestData['orderBy'];
        $settings['orderFor'] = $requestData['orderFor'];
        $settings['perPage'] = $requestData['perPage'];

        $orderByValue = $settings['orderBy'] ?? null;
        $orderForValue = $settings['orderFor'] ?? null;
        $orderPerPageValue = $settings['perPage'] ?? null;

        $user->settings = json_encode($settings);
        $user->save();
        return view('profile.partials.settings', compact('user', 'settings', 'orderByValue', 'orderPerPageValue' , 'orderForValue'));
    }
}
