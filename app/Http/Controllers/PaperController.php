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
            'abstract' => 'required|string|max:255',
        ]);

        DB::table('papers')->insert([
        'title' => $request->title,
        'abstract' => $request->abstract,
        'author' => $id,
        ]);

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
       
        return view('papers_view', [
            'papers' => $papers
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
