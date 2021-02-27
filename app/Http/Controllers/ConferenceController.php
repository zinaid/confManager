<?php

namespace App\Http\Controllers;
use DB;

use App\Models\Conference;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;

class ConferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conferences = DB::table('conferences')
             ->get();
        
        return view('settings.general_settings', [
            'conferences' => $conferences
        ]);
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
        $request->validate([
            'name' => 'required|string|max:255|unique:conferences',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'abstract_submission_date' => 'nullable|date',
            'full_paper_date' => 'nullable|date',
            'acceptance_notification_date' => 'nullable|date',
            'place' => 'required|string|max:255',
            'logo' => 'required|string|max:100000',
        ]);

        $conference = Conference::create([
            'name' => $request->name,
            'user_id' => Auth::id(),
            'status' => 2,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'abstract_submission_date' => $request->abstract_submission_date,
            'full_paper_date' => $request->full_paper_date,
            'acceptance_notification_date' => $request->acceptance_notification_date,
            'place' => $request->place,
            'logo' => $request->logo,
            
        ]);

        return redirect()->route('settings');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Conference  $conference
     * @return \Illuminate\Http\Response
     */
    public function show($conference)
    {
        $conferences = DB::table('conferences')
             ->where('id', '=', $conference)
             ->get();

        $author_id = DB::table('conferences')->value('user_id');
        
        $author_info = DB::table('users')
        ->where('id', '=', $author_id)
        ->get();

        return view('settings.conference_view', [
            'conferences' => $conferences,
            'author_infos' => $author_info
        ]);

    }

    public function deactivate_conference($conference)
    {
        $conferences = Conference::find($conference);

        $conferences->status = 2;

        $conferences->save();

        return redirect()->route('settings');
    }

    public function activate_conference($conference)
    {
        $conferences = Conference::find($conference);

        $conferences->status = 1;

        $conferences->save();

        return redirect()->route('settings');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Conference  $conference
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $conference)
    {
        $conferences = Conference::find($conference);

        $conferences->name = $request->name;
        $conferences->start_date = $request->start_date;
        $conferences->end_date = $request->end_date;
        $conferences->abstract_submission_date = $request->abstract_submission_date;
        $conferences->full_paper_date = $request->full_paper_date;
        $conferences->acceptance_notification_date = $request->acceptance_notification_date;
        $conferences->place = $request->place;
        $conferences->logo = $request->logo;

        $conferences->save();

        return redirect()->route('settings');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Conference  $conference
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conference $conference)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Conference  $conference
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conference $conference)
    {
        //
    }
}
