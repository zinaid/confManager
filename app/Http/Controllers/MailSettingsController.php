<?php

namespace App\Http\Controllers;
use DB;
use App\Models\MailSettings;
use Illuminate\Http\Request;

class MailSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    public function view_mail_settings($conference){

        $mail_settings = DB::table('mail_settings')
        ->where('conference', '=', $conference)
        ->get();
   
        return view('settings.mail_settings', [
            'mail_settings' => $mail_settings,
            'conference' => $conference
        ]);
    }

    public function add_mail_settings(Request $request)
    {
        $conference = $request->conference;
        $type = $request->type;

        $mail_settings = DB::table('mail_settings')
        ->where([
            ['conference', '=', $conference],
            ['type', '=', $type]
        ])->get();

            return view('settings.add_mail_settings', [
                'conference' => $conference,
                'type' => $type,
                'mail_settings' => $mail_settings,
            ]); 
    }

    public function add_mail_settings_submit(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
            'conference' => 'required|integer',
            'type' => 'required|integer',
        ]);
        
        MailSettings::where([
            ['conference', $request->conference],
            ['type', $request->type]
        ])->delete();

        $user = MailSettings::create([
            'text' => $request->text,
            'status' => 1,
            'type' => $request->type,
            'conference' => $request->conference,
        ]);
        
        return redirect()->route('mail_settings');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MailSettings  $mailSettings
     * @return \Illuminate\Http\Response
     */
    public function show(MailSettings $mailSettings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MailSettings  $mailSettings
     * @return \Illuminate\Http\Response
     */
    public function edit(MailSettings $mailSettings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MailSettings  $mailSettings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MailSettings $mailSettings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MailSettings  $mailSettings
     * @return \Illuminate\Http\Response
     */
    public function destroy(MailSettings $mailSettings)
    {
        //
    }
}
