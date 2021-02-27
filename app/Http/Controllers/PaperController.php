<?php

namespace App\Http\Controllers;
use DB;

use App\Models\Paper;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PaperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::id();

        $papers = DB::table('papers')
             ->where('author', '=', $id)
             ->get();

        return view('papers', [
            'papers' => $papers
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
     * 
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $id = Auth::id();

        $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'required|string|max:2000',
            'keywords' => 'required|string|max:500',
            'section' => 'required|integer',
            'topic' => 'required|integer',
            'more_authors' => 'required|integer',
            'paper_student' => 'required|integer',
            'paper_type' => 'required|integer',
        ]);

        DB::table('papers')->insert([
        'title' => $request->title,
        'abstract' => $request->abstract,
        'keywords' => $request->keywords,
        'conference' => 1,
        'section' => $request->section,
        'topic_area' => $request->topic,
        'student' => $request->paper_student,
        'type' => $request->paper_type,
        'file' => "bla bla",
        'created_at' => "2020-01-01",
        'status' => 1,
        'author' => $id,
        ]);

        $last_inserted_paper_id= DB::getPdo()->lastInsertId();

        if($request->more_authors == 1){
            $author_number = $request->author_number;
            for($i=0;$i<$author_number;$i++){
                $author_name = "author_name".$i;
                $author_lastname = "author_lastname".$i;
                $author_email = "author_email".$i;
                $author_affiliation = "author_affiliation".$i;
                $author_country = "author_country".$i;
                $author_city = "author_city".$i;

                DB::table('authors')->insert([
                    'name' => $request->$author_name,
                    'lastname' => $request->$author_lastname,
                    'email' => $request->$author_email,
                    'country' => $request->$author_country,
                    'city' => $request->$author_city,
                    'affiliation' => $request->$author_affiliation,
                    'paper_id' => $last_inserted_paper_id,
                    ]);

            }
        }

        DB::table('paper_logs')->insert([
            'status' => 1,
            'date' => date("Y-m-d"),
            'user_id' => $id,
            'paper_id' => $last_inserted_paper_id,
            ]);

        // SEND MAIL FOR SUCCESS SUBMISSION
        

        return redirect()->back()->with('message', 'Success');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Paper  $paper
     * @return \Illuminate\Http\Response
     */
    public function show($paper)
    {
        $id = Auth::id();

        $papers = DB::table('papers')
             ->where('id', '=', $paper)
             ->get();

        $author_id = DB::table('papers')->where('id', '=', $paper)->value('author');
        
        $main_author_info = DB::table('users')
        ->where('id', '=', $author_id)
        ->get();

        $other_author_info = DB::table('authors')
        ->where('paper_id', '=', $paper)
        ->get();

        $logs_info = DB::table('paper_logs')
        ->where('paper_id', '=', $paper)
        ->get();
        
        return view('papers_view', [
            'papers' => $papers,
            'main_authors' => $main_author_info,
            'other_authors' => $other_author_info,
            'logs_info' => $logs_info,
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Paper  $paper
     * @return \Illuminate\Http\Response
     */
    public function edit(Paper $paper)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Paper  $paper
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Paper $paper)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Paper  $paper
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paper $paper)
    {
        //
    }
}
