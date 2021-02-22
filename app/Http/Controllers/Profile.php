<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\Controller;
use App\Models\User;
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
        $profile->affiliation = $request->affiliation;
        $profile->affiliation_country = $request->affiliation_country;
        $profile->affiliation_city = $request->affiliation_city;
        $profile->status = 1;

        $profile->save();

        return redirect(RouteServiceProvider::HOME);
    }

}