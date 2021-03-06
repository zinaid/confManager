<?php

namespace App\Http\Controllers;
use DB;

use App\Models\PaperFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaperFileController extends Controller
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

    public function download_pdf(Request $request){

        $papers = DB::table('papers')
             ->where('id', '=', $request->paper_id)
             ->get();

        $author_id = DB::table('papers')->where('id', '=',  $request->paper_id)->value('author');
        
        $main_author_info = DB::table('users')
        ->where('id', '=', $author_id)
        ->get();

        $other_author_info = DB::table('authors')
        ->where('paper_id', '=', $request->paper_id)
        ->get();

        $logs_info = DB::table('paper_logs')
        ->where('paper_id', '=',  $request->paper_id)
        ->get();

        $paper_files = DB::table('paper_files')
        ->where('paper_id', '=',  $request->paper_id)
        ->get();

        return Storage::download(''.$request->paper_number.'/'.$request->paper_file);

        return view('papers_view', [
            'papers' => $papers,
            'main_authors' => $main_author_info,
            'other_authors' => $other_author_info,
            'logs_info' => $logs_info,
            'paper_files' => $paper_files,
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaperFile  $paperFile
     * @return \Illuminate\Http\Response
     */
    public function show(PaperFile $paperFile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaperFile  $paperFile
     * @return \Illuminate\Http\Response
     */
    public function edit(PaperFile $paperFile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaperFile  $paperFile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaperFile $paperFile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaperFile  $paperFile
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaperFile $paperFile)
    {
        //
    }
}
