<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\Gmail;
use Illuminate\Support\Str;

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
        #$profile->affiliation_country = $request->affiliation_country;
        #$profile->affiliation_city = $request->affiliation_city;
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
        #$profile->affiliation_country = $request->affiliation_country;
        #$profile->affiliation_city = $request->affiliation_city;

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
        $user_pass = $request->password;
        
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'affiliation' => 'required|string|max:255',
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

        // SEND MAIL TO ADMINISTRATION AFTER SUCCESSFUL REGISTRATION OF THEM
        $email = $request->email;
        $title_email = $request->title;
        $name_email = $request->name;
        $lastname_email =$request->lastname;
        $conf_acronym_email = DB::table('conferences')->where('id', $request->conference)->select('acronym')->pluck('acronym')->first();
        
        if($request->permission == 2){
            $administration_role = "Technical Secretar";
        }elseif($request->permission == 3){
            $administration_role = "Editor";
        }elseif($request->permission == 4){
            $administration_role = "Reviewer";
        }

       
        $text_for_mail = DB::table('mail_settings')->where([
            ['conference', $request->conference],
            ['type', 8],
            ])->select('text')->pluck('text')->first();

        $text_for_mail_formatted = Str::replaceArray('$title', [$title_email], $text_for_mail);
        $text_for_mail_formatted = Str::replaceArray('$name', [$name_email], $text_for_mail_formatted);
        $text_for_mail_formatted = Str::replaceArray('$lastname', [$lastname_email], $text_for_mail_formatted);
        $text_for_mail_formatted = Str::replaceArray('$conf_administration', [$administration_role], $text_for_mail_formatted);
        $text_for_mail_formatted = Str::replaceArray('$username', [$request->email], $text_for_mail_formatted);
        $text_for_mail_formatted = Str::replaceArray('$user_pass', [$user_pass], $text_for_mail_formatted);
        $text_for_mail_formatted = Str::replaceArray('$conf_acronym', [$conf_acronym_email, $conf_acronym_email], $text_for_mail_formatted);
        
        $details = [
            'title'=>'RIM 2021 - Registration',
            'body'=>''.$text_for_mail_formatted.'',
        ];

        Mail::to($email)->send(new Gmail($details));
        
        return redirect()->route('administration');

    }

}