<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use DB;

class Profile extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */

    public function index()
    {
        $id = Auth::id();

        $users = DB::table('users')
             ->where('id', '=', $id)
             ->get();

        return view('profile', [
            'users' => $users
        ]);
    }
    
    
     public function finish_registration(Request $request)
    {
        $profile = User::find(Auth::id());

        $profile->country = $request->country;
        $profile->city = $request->city;
        $profile->affiliation = $request->affiliation;
        $profile->affiliation_country = $request->affiliation_country;
        $profile->affiliation_city = $request->affiliation_city;
        $profile->status = 1;

        $profile->save();

        return redirect(RouteServiceProvider::HOME);
    }

    public function update_profile(Request $request)
    {
        $profile = User::find(Auth::id());

        $profile->country = $request->country;
        $profile->city = $request->city;
        $profile->title = $request->title;
        $profile->affiliation = $request->affiliation;
        $profile->affiliation_country = $request->affiliation_country;
        $profile->affiliation_city = $request->affiliation_city;

        $profile->save();

        return redirect(RouteServiceProvider::HOME);
    }

    public function view_administration($conference)
    {

        $users = DB::table('users')
             ->where('conference', '=', $conference)
             ->get();
        
        return view('settings.administration', [
            'users' => $users,
            'conference' => $conference
        ]);
    }

    public function add_administration(Request $request)
    {
        $conference = $request->conference;
        $permission = $request->permission;

        return view('settings.add_administration', [
            'conference' => $conference,
            'permission' => $permission,
        ]);
    }

    public function add_administration_submit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'affiliation' => 'required|string|max:255',
            'affiliation_country' => 'required|string|max:255',
            'affiliation_city' => 'required|string|max:255',
            'conference' => 'required|integer',
            'permission' => 'required|integer',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'permission' => $request->permission,
            'conference' => $request->conference,
            'country' => $request->country,
            'city' => $request->city,
            'affiliation' => $request->affiliation,
            'affiliation_country' => $request->affiliation_country,
            'affiliation_city' => $request->affiliation_city,
            'status' => 1,
            'title' => $request->title,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        return redirect()->route('administration');

    }

}