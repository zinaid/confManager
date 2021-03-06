<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\Gmail;

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
        $user_pass = $request->password;
        $username = $request->email;


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

        $text_for_mail_formatted = "<p>Dear $request->title $request->name $request->lastname,</p>

        <p>Thank you for your registration on ConfManager.</p>
        
        <p>Your account informations are:</p>
        
        <p><strong>username</strong>: $username</p>
        
        <p><strong>password</strong>: $user_pass</p>
        
        <p>Kindest regards,&nbsp;</p>
        
        <p>This is an automatically generated email &ndash; please do not reply to it.</p>
        ";
        
        $details = [
            'title'=>'Registration',
            'body'=>''.$text_for_mail_formatted.'',
        ];

        Mail::to($request->email)->send(new Gmail($details));

        return redirect(RouteServiceProvider::HOME);
    }

    public function finish_registration(Request $request)
    {
        $request->validate([
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'affiliation' => 'required|string|max:255',
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
