<?php

namespace App\Http\Controllers;
use DB;

use App\Models\TopicAreas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TopicAreasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function add_topic(Request $request)
    {
        $section = $request->id;
        
        return view('settings.add_topic', [
            'section' => $section,
        ]);
    }

    public function view_topic(Request $request)
    {
        $section = $request->id;

        $topics = DB::table('topic_areas')
             ->where('section', '=', $section)
             ->get();
        
        return view('settings.topics', [
            'topics' => $topics,
            'section' =>  $section,
        ]);
    }

    public function ajax_topics(Request $request)
    {
        $section = $request->section;

        $topics = DB::table('topic_areas')
             ->where('section', '=', $section)
             ->get();
        
        return response()->json($topics);
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
            'name' => 'required|string|max:255',
        ]);

        $topic = TopicAreas::create([
            'name' => $request->name,
            'user_id' => Auth::id(),
            'status' => 1,
            'section' => $request->section_id,
        ]);

        return redirect()->route('settings');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TopicAreas  $topicAreas
     * @return \Illuminate\Http\Response
     */
    public function show(TopicAreas $topicAreas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TopicAreas  $topicAreas
     * @return \Illuminate\Http\Response
     */
    public function edit(TopicAreas $topicAreas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TopicAreas  $topicAreas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TopicAreas $topicAreas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TopicAreas  $topicAreas
     * @return \Illuminate\Http\Response
     */
    public function destroy(TopicAreas $topicAreas)
    {
        //
    }
}
