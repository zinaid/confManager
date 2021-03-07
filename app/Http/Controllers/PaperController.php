<?php

namespace App\Http\Controllers;
use DB;

use App\Models\Paper;
use App\Models\User;
use App\Models\ReviewerFormular;
use App\Models\EditorFormular;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\Gmail;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use DataTables;


class PaperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     // FUNKCIJE ZA INFORMACIJE O KONFERENCIJAMA
     public function getConfSecretar($conf_id)
     {
         $secretar = DB::table('users')->where([
             ['conference', $conf_id],
             ['permission', 2],
             ])->get();

         return $secretar;
     }

     public function getConfEditors($conf_id)
     {
         $editors = DB::table('users')->where([
             ['conference', $conf_id],
             ['permission', 3],
             ])->get();

         return $editors;
     }

     public function getConfReviewers($conf_id)
     {
         $reviewers = DB::table('users')->where([
             ['conference', $conf_id],
             ['permission', 4],
             ])->get();

         return $reviewers;
     }

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
        $conference_id = $request->conference;

        $server_addr = $request->ip();
        $paper_timestamp = "".date('Y-m-d H:i:s')." ".$server_addr."";

        $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'required|string|max:2000',
            'keywords' => 'required|string|max:500',
            'section' => 'required|integer',
            'topic' => 'required|integer',
            'more_authors' => 'required|integer',
            #'paper_student' => 'required|integer',
            'paper_type' => 'required|integer',
            'paper_file' => 'mimes:doc,docx|max:2500000'
        ]);

        // RANDOM NUMBER GENERATOR
        $digits = 4;
        $paper_number = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);

        $biggest_id = DB::table('papers')->latest('id')->pluck('id')->first()+1;

        $paper_number .= $biggest_id;
        $conference_id = $request->conference;

        if($request->paper_file != NULL){
            $file_existance = 1;
        }else{
            $file_existance = 0;
        }

        DB::table('papers')->insert([
        'title' => $request->title,
        'abstract' => $request->abstract,
        'keywords' => $request->keywords,
        'paper_number' => $paper_number,
        'conference' => $conference_id,
        'section' => $request->section,
        'topic_area' => $request->topic,
        #'student' => $request->paper_student,
        'student' => 0,
        'type' => $request->paper_type,
        'file' => $file_existance,
        'created_at' => date("Y-m-d"),
        'status' => 1,
        'author' => $id,
        'paper_timestamp' => $paper_timestamp,
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

        if($request->paper_file != NULL){
            // SAVE TO PAPER FILES AND SAVE DOC FILE
            $file = new Filesystem();
            $directory_subfolder_name = $paper_number;
            $directory = 'app/' . $directory_subfolder_name;
            $filenameSave = ''.$paper_number.'_submit';

            if ( $file->isDirectory(storage_path($directory)) )
            {
                return 'Please contact administrator, or try again.';
            }
            else
            {
                $file->makeDirectory(storage_path($directory), 755, true, true);

                // Get filename with the extension
                $filenameWithExt = $request->file('paper_file')->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $request->file('paper_file')->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore = $filenameSave.'.'.$extension;
                // Upload Image
                $path = $request->file('paper_file')->storeAs('/'.$paper_number.'',$fileNameToStore);

                DB::table('paper_files')->insert([
                    'paper_id' => $last_inserted_paper_id,
                    'paper_number' => $paper_number,
                    'type' => 1,
                    'status' => 1,
                    'date' => date("Y-m-d"),
                    'file' => $fileNameToStore,
                    ]);
            }
        }



        // SEND MAIL FOR SUCCESS SUBMISSION
        $email = DB::table('users')->where('id', $id)->select('email')->pluck('email')->first();
        $title_author_email = DB::table('users')->where('id', $id)->select('title')->pluck('title')->first();
        $name_email = DB::table('users')->where('id', $id)->select('name')->pluck('name')->first();
        $lastname_email = DB::table('users')->where('id', $id)->select('lastname')->pluck('lastname')->first();
        $conf_acronym_email = DB::table('conferences')->where('id', $conference_id)->select('acronym')->pluck('acronym')->first();
        $conf_submit_date = DB::table('conferences')->where('id', $conference_id)->select('full_paper_date')->pluck('full_paper_date')->first();

        if($file_existance == 1){
            $text_for_mail = DB::table('mail_settings')->where([
                ['conference', $conference_id],
                ['type', 1],
                ])->select('text')->pluck('text')->first();
        }else{
            $text_for_mail = DB::table('mail_settings')->where([
                ['conference', $conference_id],
                ['type', 9],
                ])->select('text')->pluck('text')->first();
        }

        $text_for_mail_formatted = Str::replaceArray('$title', [$title_author_email], $text_for_mail);
        $text_for_mail_formatted = Str::replaceArray('$name', [$name_email], $text_for_mail_formatted);
        $text_for_mail_formatted = Str::replaceArray('$lastname', [$lastname_email], $text_for_mail_formatted);
        $text_for_mail_formatted = Str::replaceArray('$paper_title', [$request->title], $text_for_mail_formatted);
        $text_for_mail_formatted = Str::replaceArray('$conf_acronym', [$conf_acronym_email, $conf_acronym_email, $conf_acronym_email], $text_for_mail_formatted);
        $text_for_mail_formatted = Str::replaceArray('$paper_number', [$paper_number], $text_for_mail_formatted);
        if($file_existance == 0){
            $text_for_mail_formatted = Str::replaceArray('$submit_date', [$conf_submit_date], $text_for_mail_formatted);
        }

        $details = [
            'title'=>'RIM 2021 - Submission',
            'body'=>''.$text_for_mail_formatted.'',
        ];

        Mail::to($email)->send(new Gmail($details));

        // SEND MAIL TO FOR SECRETAR AFTER SUCCESS
        $secretars = $this->getConfSecretar($conference_id);
        foreach ($secretars as $secretar){
            $secretar_id =$secretar->id;
            $secretar_name = $secretar->name;
            $secretar_lastname = $secretar->lastname;
            $secretar_email = $secretar->email;
            $secretar_title = $secretar->title;
        }

        $text_for_mail_secretar = DB::table('mail_settings')->where([
            ['conference', $conference_id],
            ['type', 2],
            ])->select('text')->pluck('text')->first();

        $text_for_mail_secretar_formatted = Str::replaceArray('$title', [$secretar_title], $text_for_mail_secretar);
        $text_for_mail_secretar_formatted = Str::replaceArray('$name', [$secretar_name], $text_for_mail_secretar_formatted);
        $text_for_mail_secretar_formatted = Str::replaceArray('$lastname', [$secretar_lastname], $text_for_mail_secretar_formatted);
        $text_for_mail_secretar_formatted = Str::replaceArray('$paper_title', [$request->title], $text_for_mail_secretar_formatted);
        $text_for_mail_secretar_formatted = Str::replaceArray('$paper_number', [$paper_number], $text_for_mail_secretar_formatted);
        $text_for_mail_secretar_formatted = Str::replaceArray('$conf_acronym', [$conf_acronym_email, $conf_acronym_email], $text_for_mail_secretar_formatted);

        $details = [
            'title'=>'RIM 2021 - Submission',
            'body'=>''.$text_for_mail_secretar_formatted.'',
        ];

        Mail::to($secretar_email)->send(new Gmail($details));

        DB::table('paper_logs')->insert([
            'paper_id' => $last_inserted_paper_id,
            'user_id' => $id,
            'status' => 1,
            'date' => date("Y-m-d"),
            ]);

        return redirect()->route('papers');

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

        # Other acters in system see other files
        if(Auth::user()->permission == 3){
            $paper_files = DB::table('paper_files')
            ->where('paper_id', '=', $paper)
            ->whereIn('type', [2,3])
            ->get();
        }elseif(Auth::user()->permission == 4){
            $paper_files = DB::table('paper_files')
            ->where('paper_id', '=', $paper)
            ->whereIn('type', [2,3])
            ->get();
        }else{
            $paper_files = DB::table('paper_files')
            ->where('paper_id', '=', $paper)
            ->get();
        }

        return view('papers_view', [
            'papers' => $papers,
            'main_authors' => $main_author_info,
            'other_authors' => $other_author_info,
            'logs_info' => $logs_info,
            'paper_files' => $paper_files,
        ]);

    }

    public function getPapers(Request $request)
    {
        if ($request->ajax()) {
           
            $id = $request->id;
            $permission = Auth::user()->permission;

            if($permission == 0){
                $data = Paper::where('author', $id)->get();
            }elseif($permission == 3){
                $data = DB::table('papers')
                ->join('editor_formulars', 'papers.id', '=', 'editor_formulars.paper_id')
                ->where('editor_formulars.editor_id', '=', $id)
                ->select('papers.*')
                ->get();
            }elseif($permission == 4){
                $data = DB::table('papers')
                ->join('reviewer_formulars', 'papers.id', '=', 'reviewer_formulars.paper_id')
                ->where('reviewer_formulars.reviewer_id', '=', $id)
                ->select('papers.*')
                ->get();
            }else{
                $data = Paper::latest()->get();
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="papers/'.$row->id.'" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">See More</a>';
                    return $actionBtn;
                })
                ->addColumn('status_text', function($row){
                    if($row->status == 1){
                        $status_text = "<p class='inline-flex items-center px-4 py-2 bg-gray-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150'>Submited</p>";
                    }elseif($row->status == 2){
                        $status_text = "<p class='inline-flex items-center px-4 py-2 bg-blue-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150'>With Editor</p>";
                    }elseif($row->status == 3){
                        $status_text = "<p class='inline-flex items-center px-4 py-2 bg-blue-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150'>Under Review</p>";
                    }elseif($row->status == 4){
                        $status_text = "<p class='inline-flex items-center px-4 py-2 bg-red-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150'>Minor Revision</p>";
                    }elseif($row->status == 5){
                        $status_text = "<p class='inline-flex items-center px-4 py-2 bg-red-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150'>Major Revision</p>";
                    }elseif($row->status == 6){
                        $status_text = "<p class='inline-flex items-center px-4 py-2 bg-red-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150'>Rejected</p>";
                    }elseif($row->status == 7){
                        $status_text = "<p class='inline-flex items-center px-4 py-2 bg-green-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150'>Accepted</p>";
                    }
                    return $status_text;
                })
                ->addColumn('author_name', function($row){
                    $author_id = DB::table('papers')->select('author')->where('id', $row->id)->pluck('author')->first();
                    $author_name = DB::table('users')->select('name')->where('id', $author_id)->pluck('name')->first();
                    $author_lastname = DB::table('users')->select('lastname')->where('id', $author_id)->pluck('lastname')->first();
                    $author_name = ''.$author_name.' '.$author_lastname.'';
                    return $author_name;
                })
                ->rawColumns(['action','status_text', 'author_name'])
                ->make(true);
        }

        return view('papers_list');

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

    public function paper_upload(Request $request){
        $paper_id = $request->paper_id;
        $paper_number = $request->paper_number;
        $paper_type = $request->paper_type;

        return view('paper_upload', [
            'paper_id' => $paper_id,
            'paper_number' => $paper_number,
            'paper_type' => $paper_type,
        ]);
    }

    public function add_paper_file(Request $request){
        $request->validate([
            'paper_id' => 'required|integer',
            'type' => 'required|integer',
            'paper_file' => 'mimes:doc,docx,pdf|max:2500000'
        ]);

        $paper_number = $request->paper_number;
        $paper_id = $request->paper_id;

        if($request->paper_file != NULL){
            // SAVE TO PAPER FILES AND SAVE DOC FILE
            $file = new Filesystem();
            $directory_subfolder_name = $request->paper_number;
            $directory = 'app/' . $directory_subfolder_name;
            if($request->type == 1){
                $filenameSave = ''.$paper_number.'_submit';
                $file->makeDirectory(storage_path($directory), 755, true, true);

                $update_query = DB::table('papers')
                ->where('id', $paper_id)
                ->update(['file' => 1]);

            }elseif($request->type == 2){
                $filenameSave = ''.$paper_number.'_submit_without_meta';
            }

            if ( $file->isDirectory(storage_path($directory)) )
            {
                // Get filename with the extension
                $filenameWithExt = $request->file('paper_file')->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $request->file('paper_file')->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore = $filenameSave.'.'.$extension;
                // Upload Image
                $path = $request->file('paper_file')->storeAs('/'.$paper_number.'',$fileNameToStore);

                DB::table('paper_files')->insert([
                    'paper_id' => $request->paper_id,
                    'paper_number' => $request->paper_number,
                    'type' => $request->type,
                    'status' => 1,
                    'date' => date("Y-m-d"),
                    'file' => $fileNameToStore,
                    ]);

            }
        }

        $papers = DB::table('papers')
             ->where('id', '=', $request->paper_id)
             ->get();

        $author_id = DB::table('papers')->where('id', '=', $request->paper_id)->value('author');

        $main_author_info = DB::table('users')
        ->where('id', '=', $author_id)
        ->get();

        $other_author_info = DB::table('authors')
        ->where('paper_id', '=', $request->paper_id)
        ->get();

        $logs_info = DB::table('paper_logs')
        ->where('paper_id', '=', $request->paper_id)
        ->get();

        # Other acters in system see other files
        if(Auth::user()->permission == 3){
            $paper_files = DB::table('paper_files')
            ->where('paper_id', '=', $paper_id)
            ->whereIn('type', [2,3])
            ->get();
        }elseif(Auth::user()->permission == 4){
            $paper_files = DB::table('paper_files')
            ->where('paper_id', '=', $paper_id)
            ->whereIn('type', [2,3])
            ->get();
        }else{
            $paper_files = DB::table('paper_files')
            ->where('paper_id', '=', $paper_id)
            ->get();
        }

        return redirect('/papers/'.$request->paper_id.'')->with([
            'papers' => $papers,
            'main_authors' => $main_author_info,
            'other_authors' => $other_author_info,
            'logs_info' => $logs_info,
            'paper_files' => $paper_files,
        ]);

    }

    public function assign_editor(Request $request){
        $paper_id = $request->paper_id;
        $paper_number = $request->paper_number;

        $editors = $this->getConfEditors($request->conference);

        return view('assign_editor', [
            'editors' => $editors,
            'paper_id' => $paper_id,
            'paper_number' => $paper_number,
        ]);
    }

    public function assign_editor_submit(Request $request){

        $id = Auth::id();
        $paper_id = $request->paper_id;
        $paper_number = $request->paper_number;
        $editor_id = $request->editor;

        # generate editor formular, through this formular editor will give his verdict about paper
        DB::table('editor_formulars')->insert([
           'created_at' => date("Y-m-d"),
           'editor_id' => $editor_id,
           'paper_id' => $paper_id,
        ]);


        # send mail to editor to let him know about this assignment
        $conference_id = DB::table('papers')->where('id', '=', $paper_id)->value('conference');
        $conf_acronym_email = DB::table('conferences')->where('id', '=', $conference_id)->value('acronym');
        $paper_title = DB::table('papers')->where('id', '=', $paper_id)->value('title');

        $editors = DB::table('users')->where([
            ['id', $editor_id],
            ])->get();

        foreach ($editors as $editor){
            $editor_name = $editor->name;
            $editor_lastname = $editor->lastname;
            $editor_email = $editor->email;
            $editor_title = $editor->title;
        }

        $text_for_mail_editor = DB::table('mail_settings')->where([
            ['conference', $conference_id],
            ['type', 3],
            ])->select('text')->pluck('text')->first();

        $text_for_mail_editor_formatted = Str::replaceArray('$title', [$editor_title], $text_for_mail_editor);
        $text_for_mail_editor_formatted = Str::replaceArray('$name', [$editor_name], $text_for_mail_editor_formatted);
        $text_for_mail_editor_formatted = Str::replaceArray('$lastname', [$editor_lastname], $text_for_mail_editor_formatted);
        $text_for_mail_editor_formatted = Str::replaceArray('$paper_title', [$paper_title], $text_for_mail_editor_formatted);
        $text_for_mail_editor_formatted = Str::replaceArray('$paper_number', [$paper_number], $text_for_mail_editor_formatted);
        $text_for_mail_editor_formatted = Str::replaceArray('$conf_acronym', [$conf_acronym_email, $conf_acronym_email], $text_for_mail_editor_formatted);

        $details = [
            'title'=>'RIM 2021 - Editor',
            'body'=>''.$text_for_mail_editor_formatted.'',
        ];

        Mail::to($editor_email)->send(new Gmail($details));

        # generate notification for editor

        # change paper status
        $update_query = DB::table('papers')
              ->where('id', $paper_id)
              ->update(['status' => 2]);

        # add paper logs

        DB::table('paper_logs')->insert([
            'paper_id' => $paper_id,
            'user_id' => $id,
            'status' => 2,
            'date' => date("Y-m-d"),
            ]);

        # return view paper/id with all necessery data
        $papers = DB::table('papers')
             ->where('id', '=', $paper_id)
             ->get();

        $author_id = DB::table('papers')->where('id', '=', $paper_id)->value('author');

        $main_author_info = DB::table('users')
        ->where('id', '=', $author_id)
        ->get();

        $other_author_info = DB::table('authors')
        ->where('paper_id', '=', $paper_id)
        ->get();

        $logs_info = DB::table('paper_logs')
        ->where('paper_id', '=', $paper_id)
        ->get();

        # Other acters in system see other files
        if(Auth::user()->permission == 3){
            $paper_files = DB::table('paper_files')
            ->where('paper_id', '=', $paper_id)
            ->whereIn('type', [2,3])
            ->get();
        }elseif(Auth::user()->permission == 4){
            $paper_files = DB::table('paper_files')
            ->where('paper_id', '=', $paper_id)
            ->whereIn('type', [2,3])
            ->get();
        }else{
            $paper_files = DB::table('paper_files')
            ->where('paper_id', '=', $paper_id)
            ->get();
        }

        return redirect('/papers/'.$paper_id.'')->with([
            'papers' => $papers,
            'main_authors' => $main_author_info,
            'other_authors' => $other_author_info,
            'logs_info' => $logs_info,
            'paper_files' => $paper_files,
        ]);
    }

    public function assign_reviewer(Request $request){
        $paper_id = $request->paper_id;
        $paper_number = $request->paper_number;

        $reviewers = $this->getConfReviewers($request->conference);

        return view('assign_reviewer', [
            'reviewers' => $reviewers,
            'paper_id' => $paper_id,
            'paper_number' => $paper_number,
        ]);
    }

    public function assign_reviewer_submit(Request $request){

        $id = Auth::id();
        $paper_id = $request->paper_id;
        $paper_number = $request->paper_number;
        $reviewer_id = $request->reviewer;
        $paper_status = DB::table('papers')->where('id', '=', $paper_id)->value('status');

        # generate reviewer formular, through this reviewer editor will give his verdict about paper
        DB::table('reviewer_formulars')->insert([
           'reviewer_id' => $reviewer_id,
           'created_at' => date("Y-m-d"),
           'paper_id' => $paper_id,
        ]);

        # send mail to reviewer to let him know about this assignment
        $conference_id = DB::table('papers')->where('id', '=', $paper_id)->value('conference');
        $conf_acronym_email = DB::table('conferences')->where('id', '=', $conference_id)->value('acronym');
        $paper_title = DB::table('papers')->where('id', '=', $paper_id)->value('title');

        $reviewers = DB::table('users')->where([
            ['id', $reviewer_id],
            ])->get();

        foreach ($reviewers as $reviewer){
            $reviewer_name = $reviewer->name;
            $reviewer_lastname = $reviewer->lastname;
            $reviewer_email = $reviewer->email;
            $reviewer_title = $reviewer->title;
        }

        $text_for_mail_reviewer = DB::table('mail_settings')->where([
            ['conference', $conference_id],
            ['type', 4],
            ])->select('text')->pluck('text')->first();

        $text_for_mail_reviewer_formatted = Str::replaceArray('$title', [$reviewer_title], $text_for_mail_reviewer);
        $text_for_mail_reviewer_formatted = Str::replaceArray('$name', [$reviewer_name], $text_for_mail_reviewer_formatted);
        $text_for_mail_reviewer_formatted = Str::replaceArray('$lastname', [$reviewer_lastname], $text_for_mail_reviewer_formatted);
        $text_for_mail_reviewer_formatted = Str::replaceArray('$paper_title', [$paper_title], $text_for_mail_reviewer_formatted);
        $text_for_mail_reviewer_formatted = Str::replaceArray('$paper_number', [$paper_number], $text_for_mail_reviewer_formatted);
        $text_for_mail_reviewer_formatted = Str::replaceArray('$conf_acronym', [$conf_acronym_email, $conf_acronym_email], $text_for_mail_reviewer_formatted);

        $details = [
            'title'=>'RIM 2021 - Editor',
            'body'=>''.$text_for_mail_reviewer_formatted.'',
        ];

        Mail::to($reviewer_email)->send(new Gmail($details));

        # generate notification for editor

        # change paper status if its not already on status Under Review - 3 (this is a case for adding more reviewers)
        if($paper_status != 3){
        $update_query = DB::table('papers')
              ->where('id', $paper_id)
              ->update(['status' => 3]);

        # add paper logs

        DB::table('paper_logs')->insert([
            'paper_id' => $paper_id,
            'user_id' => $id,
            'status' => 3,
            'date' => date("Y-m-d"),
            ]);
        }
        # return view paper/id with all necessery data
        $papers = DB::table('papers')
             ->where('id', '=', $paper_id)
             ->get();

        $author_id = DB::table('papers')->where('id', '=', $paper_id)->value('author');

        $main_author_info = DB::table('users')
        ->where('id', '=', $author_id)
        ->get();

        $other_author_info = DB::table('authors')
        ->where('paper_id', '=', $paper_id)
        ->get();

        $logs_info = DB::table('paper_logs')
        ->where('paper_id', '=', $paper_id)
        ->get();

        # Other acters in system see other files
        if(Auth::user()->permission == 3){
            $paper_files = DB::table('paper_files')
            ->where('paper_id', '=', $paper_id)
            ->whereIn('type', [2,3])
            ->get();
        }elseif(Auth::user()->permission == 4){
            $paper_files = DB::table('paper_files')
            ->where('paper_id', '=', $paper_id)
            ->whereIn('type', [2,3])
            ->get();
        }else{
            $paper_files = DB::table('paper_files')
            ->where('paper_id', '=', $paper_id)
            ->get();
        }

        return redirect('/papers/'.$paper_id.'')->with([
            'papers' => $papers,
            'main_authors' => $main_author_info,
            'other_authors' => $other_author_info,
            'logs_info' => $logs_info,
            'paper_files' => $paper_files,
        ]);
    }

    public function review(Request $request){
        $paper_id = $request->paper_id;
        $paper_number = $request->paper_number;

        $papers = DB::table('papers')
        ->where('id', '=', $paper_id)
        ->get();

        return view('review', [
            'papers' => $papers,
            'paper_id' => $paper_id,
            'paper_number' => $paper_number,
        ]);
    }

    public function review_submission(Request $request)
    {
        $id = Auth::id();
        $paper_id = $request->paper_id;
        $paper_number = $request->paper_number;

        $server_addr = $request->ip();
        $review_timestamp = "".date('Y-m-d H:i:s')." ".$server_addr."";

        $request->validate([
            'instructions' => 'required|integer',
            'paper_type' => 'required|integer',
            'contribution' => 'required|integer',
            'interest' => 'required|integer',
            'structure' => 'required|integer',
            'supplementary' => 'required|integer',
            'terminology' => 'required|integer',
            'decision' => 'required|integer',
            'comment' => 'string',
            'file_question' => 'required|integer',
            'review_file' => 'mimes:doc,docx,pdf|max:2500000'
        ]);


        if($request->file_question == 1){
            $file_existance = 1;
        }else{
            $file_existance = 0;
        }

        $review_counters = DB::table('reviewer_formulars')->where([
            ['paper_id', $paper_id],
            ["reviewer_acceptance", 1],
            ["status", 1],
            ])->count();

        $review_counters = $review_counters + 1;

        $ReviewerFormular = ReviewerFormular::where([
            ["paper_id", $paper_id],
            ["reviewer_id", $id],
            ["reviewer_acceptance", 1],
            ["status", 0],
            ])->first();
        
        if($file_existance == 1){
            // SAVE TO PAPER FILES THIS REVIEW DOC
            $file = new Filesystem();
            $directory_subfolder_name = $paper_number;
            $directory = 'app/' . $directory_subfolder_name;
            $filenameSave = ''.$paper_number.'_review'.$review_counters.'';

            if ( $file->isDirectory(storage_path($directory)) )
            {
                // Get just ext
                $extension = $request->file('review_file')->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore = $filenameSave.'.'.$extension;
                // Upload Image
                $path = $request->file('review_file')->storeAs('/'.$paper_number.'',$fileNameToStore);

                DB::table('paper_files')->insert([
                    'paper_id' => $paper_id,
                    'paper_number' => $paper_number,
                    'type' => 3,
                    'status' => 1,
                    'date' => date("Y-m-d"),
                    'file' => $fileNameToStore,
                    ]);

            }
        }

        $ReviewerFormular->status = 1;
        $ReviewerFormular->decision = $request->decision;
        $ReviewerFormular->decision_date = date("Y-m-d");
        $ReviewerFormular->ip_timestamp = $review_timestamp;
        $ReviewerFormular->author_instructions = $request->instructions;
        $ReviewerFormular->paper_type = $request->paper_type;
        $ReviewerFormular->paper_contribution = $request->contribution;
        $ReviewerFormular->paper_interest = $request->interest;
        $ReviewerFormular->paper_structure = $request->structure;
        $ReviewerFormular->paper_supplementary_parts = $request->supplementary;
        $ReviewerFormular->paper_terminology = $request->terminology;
        $ReviewerFormular->reviewer_comment = $request->comment;

        $ReviewerFormular->save();

        // SEND MAIL TO FOR SECRETAR AFTER SUCCESS
        $editor_id = DB::table('editor_formulars')->where('paper_id', $paper_id)->select('editor_id')->pluck('editor_id')->first();
        $conference_id = DB::table('papers')->where('id', $paper_id)->select('conference')->pluck('conference')->first();
        $paper_title = DB::table('papers')->where('id', $paper_id)->select('title')->pluck('title')->first();
        $conf_acronym_email = DB::table('conferences')->where('id', $conference_id)->select('acronym')->pluck('acronym')->first();

        $editors = DB::table('users')->where('id', $editor_id)->get();

        foreach ($editors as $editor){
            $editor_id =$editor->id;
            $editor_name = $editor->name;
            $editor_lastname = $editor->lastname;
            $editor_email = $editor->email;
            $editor_title = $editor->title;
        }

        $text_for_mail_editor = DB::table('mail_settings')->where([
            ['conference', $conference_id],
            ['type', 5],
            ])->select('text')->pluck('text')->first();
        
        $text_for_mail_editor_formatted = Str::replaceArray('$title', [$editor_title], $text_for_mail_editor);
        $text_for_mail_editor_formatted = Str::replaceArray('$name', [$editor_name], $text_for_mail_editor_formatted);
        $text_for_mail_editor_formatted = Str::replaceArray('$lastname', [$editor_lastname], $text_for_mail_editor_formatted);
        $text_for_mail_editor_formatted = Str::replaceArray('$paper_title', [$paper_title], $text_for_mail_editor_formatted);
        $text_for_mail_editor_formatted = Str::replaceArray('$paper_number', [$paper_number], $text_for_mail_editor_formatted);
        $text_for_mail_editor_formatted = Str::replaceArray('$conf_acronym', [$conf_acronym_email, $conf_acronym_email], $text_for_mail_editor_formatted);

        $details = [
            'title'=>'RIM 2021 - Reviewer Response',
            'body'=>''.$text_for_mail_editor_formatted.'',
        ];

        Mail::to($editor_email)->send(new Gmail($details));
        
        # return view paper/id with all necessery data
        $papers = DB::table('papers')
             ->where('id', '=', $paper_id)
             ->get();

        $author_id = DB::table('papers')->where('id', '=', $paper_id)->value('author');

        $main_author_info = DB::table('users')
        ->where('id', '=', $author_id)
        ->get();

        $other_author_info = DB::table('authors')
        ->where('paper_id', '=', $paper_id)
        ->get();

        $logs_info = DB::table('paper_logs')
        ->where('paper_id', '=', $paper_id)
        ->get();

        # Other acters in system see other files
        if(Auth::user()->permission == 3){
            $paper_files = DB::table('paper_files')
            ->where('paper_id', '=', $paper_id)
            ->whereIn('type', [2,3])
            ->get();
        }elseif(Auth::user()->permission == 4){
            $paper_files = DB::table('paper_files')
            ->where('paper_id', '=', $paper_id)
            ->whereIn('type', [2,3])
            ->get();
        }else{
            $paper_files = DB::table('paper_files')
            ->where('paper_id', '=', $paper_id)
            ->get();
        }

        return redirect('/papers/'.$paper_id.'')->with([
            'papers' => $papers,
            'main_authors' => $main_author_info,
            'other_authors' => $other_author_info,
            'logs_info' => $logs_info,
            'paper_files' => $paper_files,
        ]);

    }

    public function editor_decision(Request $request){
        $paper_id = $request->paper_id;
        $paper_number = $request->paper_number;

        $papers = DB::table('papers')
        ->where('id', '=', $paper_id)
        ->get();

        return view('editor_decision', [
            'papers' => $papers,
            'paper_id' => $paper_id,
            'paper_number' => $paper_number,
        ]);
    }

    public function editor_decision_submit(Request $request)
    {
        $id = Auth::id();
        $paper_id = $request->paper_id;
        $paper_number = $request->paper_number;
        $server_addr = $request->ip();
        $editor_timestamp = "".date('Y-m-d H:i:s')." ".$server_addr."";

        $request->validate([
            'decision' => 'required|integer'
        ]);

        $decision = $request->decision;
        if($decision == 7){
            $decision_text ="Accepted";
        }elseif($decision == 6){
            $decision_text ="Rejected";
        }elseif($decision == 5){
            $decision_text = "Accepted with Major Revision";
        }elseif($decision == 4){
            $decision_text = "Accepted with Minor Revision";
        }

        $EditorFormular = EditorFormular::where([
            ["paper_id", $paper_id],
            ["editor_id", $id],
            ["status", 0],
            ])->first();
        
        $EditorFormular->status = 1;
        $EditorFormular->decision = $request->decision;
        $EditorFormular->decision_date = date("Y-m-d");
        $EditorFormular->ip_timestamp = $editor_timestamp;

        $EditorFormular->save();

        // SEND MAIL TO SECRETAR AFTER EDITOR DECISION
        $conference_id = DB::table('papers')->where('id', $paper_id)->select('conference')->pluck('conference')->first();
        $secretars = $this->getConfSecretar($conference_id);
        $paper_title = DB::table('papers')->where('id', $paper_id)->select('title')->pluck('title')->first();
        $conf_acronym_email = DB::table('conferences')->where('id', $conference_id)->select('acronym')->pluck('acronym')->first();
        
        foreach ($secretars as $secretar){
            $secretar_id =$secretar->id;
            $secretar_name = $secretar->name;
            $secretar_lastname = $secretar->lastname;
            $secretar_email = $secretar->email;
            $secretar_title = $secretar->title;
        }

        $text_for_mail_secretar = DB::table('mail_settings')->where([
            ['conference', $conference_id],
            ['type', 6],
            ])->select('text')->pluck('text')->first();

        $text_for_mail_secretar_formatted = Str::replaceArray('$title', [$secretar_title], $text_for_mail_secretar);
        $text_for_mail_secretar_formatted = Str::replaceArray('$name', [$secretar_name], $text_for_mail_secretar_formatted);
        $text_for_mail_secretar_formatted = Str::replaceArray('$lastname', [$secretar_lastname], $text_for_mail_secretar_formatted);
        $text_for_mail_secretar_formatted = Str::replaceArray('$paper_title', [$paper_title], $text_for_mail_secretar_formatted);
        $text_for_mail_secretar_formatted = Str::replaceArray('$paper_number', [$paper_number], $text_for_mail_secretar_formatted);
        $text_for_mail_secretar_formatted = Str::replaceArray('$conf_acronym', [$conf_acronym_email, $conf_acronym_email], $text_for_mail_secretar_formatted);

        $details = [
            'title'=>'RIM 2021 - Editor Response',
            'body'=>''.$text_for_mail_secretar_formatted.'',
        ];

        #Mail::to($secretar_email)->send(new Gmail($details));

        // SEND MAIL TO AUTOR AFTER EDITOR DECISION

        $authors_id = DB::table('papers')->where('id', $paper_id)->select('author')->pluck('author')->first();
        $authors = DB::table('users')->where('id', $authors_id)->get();
        
        foreach ($authors as $author){
            $author_id =$author->id;
            $author_name = $author->name;
            $author_lastname = $author->lastname;
            $author_email = $author->email;
            $author_title = $author->title;
        }

        $text_for_mail_author = DB::table('mail_settings')->where([
            ['conference', $conference_id],
            ['type', 7],
            ])->select('text')->pluck('text')->first();

        $comments = DB::table('mail_settings')->where([
            ['conference', $conference_id],
            ['type', 7],
            ])->select('text')->pluck('text')->first();

        $text_for_mail_author_formatted = Str::replaceArray('$title', [$author_title], $text_for_mail_author);
        $text_for_mail_author_formatted = Str::replaceArray('$name', [$author_name], $text_for_mail_author_formatted);
        $text_for_mail_author_formatted = Str::replaceArray('$lastname', [$author_lastname], $text_for_mail_author_formatted);
        $text_for_mail_author_formatted = Str::replaceArray('$decision', [$decision_text], $text_for_mail_author_formatted);
        $text_for_mail_author_formatted = Str::replaceArray('$paper_title', [$paper_title], $text_for_mail_author_formatted);
        $text_for_mail_author_formatted = Str::replaceArray('$paper_number', [$paper_number], $text_for_mail_author_formatted);
        $text_for_mail_author_formatted = Str::replaceArray('$conf_acronym', [$conf_acronym_email, $conf_acronym_email], $text_for_mail_author_formatted);
        
        $details = [
            'title'=>'RIM 2021 - Editor and Reviewer Response',
            'body'=>''.$text_for_mail_author_formatted.'',
        ];

        Mail::to($author_email)->send(new Gmail($details));
        
        # return view paper/id with all necessery data
        $papers = DB::table('papers')
             ->where('id', '=', $paper_id)
             ->get();

        $author_id = DB::table('papers')->where('id', '=', $paper_id)->value('author');

        $main_author_info = DB::table('users')
        ->where('id', '=', $author_id)
        ->get();

        $other_author_info = DB::table('authors')
        ->where('paper_id', '=', $paper_id)
        ->get();

        $logs_info = DB::table('paper_logs')
        ->where('paper_id', '=', $paper_id)
        ->get();

        # Other acters in system see other files
        if(Auth::user()->permission == 3){
            $paper_files = DB::table('paper_files')
            ->where('paper_id', '=', $paper_id)
            ->whereIn('type', [2,3])
            ->get();
        }elseif(Auth::user()->permission == 4){
            $paper_files = DB::table('paper_files')
            ->where('paper_id', '=', $paper_id)
            ->whereIn('type', [2,3])
            ->get();
        }else{
            $paper_files = DB::table('paper_files')
            ->where('paper_id', '=', $paper_id)
            ->get();
        }

        return redirect('/papers/'.$paper_id.'')->with([
            'papers' => $papers,
            'main_authors' => $main_author_info,
            'other_authors' => $other_author_info,
            'logs_info' => $logs_info,
            'paper_files' => $paper_files,
        ]);
    }
}
