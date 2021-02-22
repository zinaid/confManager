<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        Auth::login($user = User::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'title' => $request->title,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]));

        event(new Registered($user));

        return redirect(RouteServiceProvider::HOME);
    }

    public function finish_registration(Request $request)
    {
        $request->validate([
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'affiliation' => 'required|string|max:255',
            'affiliation_country' => 'required|string|email|max:255|unique:users',
            'affiliation_city' => 'required|string|confirmed|min:8',
        ]);

        Auth::login($user = User::update([
            'country' => $request->country,
            'city' => $request->city,
            'affiliation' => $request->affiliation,
            'affiliation_country' => $request->affiliation_country,
            'affiliation_city' => $request->affiliation_country,
        ]));

        return redirect(RouteServiceProvider::HOME);
    }

}
