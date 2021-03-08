<?php use App\Models\User; ?>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ URL::previous() }}" class="btn btn-warning inline" align="left"> <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M2.117 12l7.527 6.235-.644.765-9-7.521 9-7.479.645.764-7.529 6.236h21.884v1h-21.883z"/></svg></i></a>
            <div class="p-6 bg-white border-b border-gray-200 mt-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="...">
                    @foreach ($papers as $paper)
                        <?php 
                            $created_at = $paper->created_at; $conference = $paper->conference;
                            $paper_status_global = $paper->status;
                            $paper_global_id = $paper->id;
                            $paper_global_number = $paper->paper_number;
                            $paper_global_file = $paper->file;
                        ?>
                        <h2 class="font-bold text-xl text-gray-800 leading-tight">
                            {{ __('General info') }}
                        </h2>
                        <div class="border-l-4 border-gray-500 p-4 mt-4" role="alert">
                            <p class="font-semibold">Title:</p> 
                            <p>{{ $paper->title }}</p> 

                            <p class="mt-4 font-semibold">Abstract:</p> 
                            <p>{!! $paper->abstract !!}</p>

                            <p class="mt-4 font-semibold">Keywords:</p> 
                            <p>{{ $paper->keywords }}</p> 

                            <p class="mt-4 font-semibold">Type:</p>
                            <?php 
                            if($paper->type == 1){ 
                                $paper_type_text = "Original Scientific Paper";
                            }elseif($paper->type == 2){
                                $paper_type_text = "Preliminary notes";
                            }elseif($paper->type == 3){
                                $paper_type_text = "Subject Review";
                            }else{
                                $paper_type_text = "Professional paper";
                            }
                            ?> 
                            <p>{{ $paper_type_text }}</p>
                            <p class="mt-4 font-semibold">Topic Area:</p> 
                            <?php
                                 $paper_section = DB::table('topic_areas')->where('id', '=', $paper->topic_area)->value('name');
                            ?>
                            <p>{{ $paper_section }}</p>
                        </div>
                    @endforeach
                    </div>
                    <div class="...">
                    @if (Auth::user()->permission != 4)
                        @foreach ($main_authors as $main_author)
                            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                                {{ __('Author info') }}
                            </h2>
                            <div class="border-l-4 border-gray-500 p-4 mt-4" role="alert">
                                <p class="font-semibold">Corresponding author:</p> 
                                <p>{{ $main_author->name }} {{ $main_author->lastname }}</p>

                                <p class="mt-4 font-semibold">Corresponding authors affiliation:</p> 
                                <p>{{ $main_author->affiliation }}</p>

                                <p class="mt-4 font-semibold">Corresponding authors email:</p> 
                                <p>{{ $main_author->email }}</p>
                            </div>
                        @endforeach
                        @foreach ($other_authors as $other_author)
                            <h2 class="mt-4 font-bold text-xl text-gray-800 leading-tight">
                                {{ __('Other authors') }}
                            </h2>
                            <div class="border-l-4 border-gray-500 p-4 mt-4" role="alert">
                            <?php $loop_count = $loop->iteration+1;?>
                                <p class="font-semibold">Author {{$loop_count }}:</p> 
                                <p>{{ $other_author->name }} {{ $other_author->lastname }}</p>

                                <p class="mt-4 font-semibold">Author {{$loop_count }} affiliation:</p> 
                                <p>{{ $other_author->affiliation }}, {{ $other_author->country }}, {{ $other_author->city }}</p>

                                <p class="mt-4 font-semibold">Author  {{ $loop_count }} email:</p> 
                                <p>{{ $other_author->email }}</p>
                            </div>
                        @endforeach
                    @endif
                    </div>
                </div>
            </div>
            
        </div>


        <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white border-b border-gray-200 mt-4">
                <h2 class="mt-4 font-bold text-xl text-gray-800 leading-tight">
                    {{ __('Status logs') }}
                </h2>
                <div class="w-full py-6">
                <div class="flex">
                    <div class="w-1/4">
                    <div class="relative mb-2">
                        <div class="w-10 h-10 mx-auto bg-green-400 border-2 border-gray-200 rounded-full text-lg text-white flex items-center">
                        <span class="text-center text-white w-full">
                            <svg class="w-full fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                            <path class="heroicon-ui" d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-2.3-8.7l1.3 1.29 3.3-3.3a1 1 0 0 1 1.4 1.42l-4 4a1 1 0 0 1-1.4 0l-2-2a1 1 0 0 1 1.4-1.42z"/>
                            </svg>
                        </span>
                        </div>
                    </div>

                    <div class="text-xs text-center md:text-base"><p>Submited</p><p class="text-sm">{{date('Y-m-d', strtotime($created_at)) }}</p></div>
                    </div>
                        @foreach ($logs_info as $log_info)
                        @if($log_info->status != 1)
                            @if($log_info->status == 1) <?php $status_text = "Submited";$color = "bg-green-400";?>
                            @elseif($log_info->status == 2)<?php $status_text = "With Editor";$color = "bg-green-400";?>
                            @elseif($log_info->status == 3) <?php $status_text = "Under Review";$color = "bg-blue-400";?>
                            @elseif($log_info->status == 4) <?php $status_text  = "Minor Revision";$color = "bg-red-400";?>
                            @elseif($log_info->status == 5) <?php $status_text = "Major Revision";$color = "bg-red-400";?>
                            @elseif($log_info->status == 6) <?php $status_text = "Accepted";$color = "bg-green-400";?>
                            @elseif($log_info->status == 7) <?php $status_text = "Rejected"; $color = "bg-red-400";?>
                            @endif
                                <div class="w-1/4">
                                <div class="relative mb-2">
                                    <div class="absolute flex align-center items-center align-middle content-center" style="width: calc(100% - 2.5rem - 1rem); top: 50%; transform: translate(-50%, -50%)">
                                    <div class="w-full bg-gray-400 rounded items-center align-middle align-center flex-1">
                                        <div class="w-0 bg-green-300 py-1 rounded" style="width: 0%;"></div>
                                    </div>
                                    </div> 
                                    
                                    <div class="w-10 h-10 mx-auto <?php echo $color;?> border-2 border-gray-200 rounded-full text-lg text-white flex items-center">
                                    <span class="text-center text-white w-full">
                                        <svg class="w-full fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                        <path class="heroicon-ui" d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-2.3-8.7l1.3 1.29 3.3-3.3a1 1 0 0 1 1.4 1.42l-4 4a1 1 0 0 1-1.4 0l-2-2a1 1 0 0 1 1.4-1.42z"/>
                                        </svg>
                                    </span>
                                    </div>
                                </div>

                                <div class="text-xs text-center md:text-base"><p>{{$status_text}}</p> <p class="text-sm">{{$log_info->date}}</p></div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @if(Auth::user()->permission == 0)
        <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white border-b border-gray-200 mt-4">
                <h2 class="mt-4 font-bold text-xl text-gray-800 leading-tight">
                    {{ __('Reviews') }}
                </h2>
                <div class="border-l-4 border-gray-500 p-4 mt-4" role="alert">
                    <?php
                        $reviewers = DB::table('reviewer_formulars')->where('paper_id', '=', $paper_global_id)->get();
                    ?>
                    @foreach ($reviewers as $reviewer)
                        <p class="mt-2">Reviewer {{ $loop->iteration }}.
                        @if($reviewer->reviewer_acceptance == 1)
                        <a href="/reviewer_response/{{$reviewer->id}}"><span class="px-1 py-1 bg-green-400 border border-transparent rounded-md font-semibold text-white text-xs">See response</span></a>
                        @endif
                        </p>
                    @endforeach
                </div>
            </div>
        </div>
        @elseif (Auth::user()->permission == 1 OR Auth::user()->permission == 2)
        <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white border-b border-gray-200 mt-4">
                <h2 class="mt-4 font-bold text-xl text-gray-800 leading-tight">
                    {{ __('Administration for this paper') }}
                </h2>
                <div class="border-l-4 border-gray-500 p-4 mt-4" role="alert">
                    <p class="font-semibold">Editor:</p> 
                    <?php 
                        $editor_id = DB::table('editor_formulars')->where('paper_id', '=', $paper_global_id)->value('editor_id');
                        $editor_name = DB::table('users')->where('id', '=', $editor_id)->value('name');
                        $editor_lastname = DB::table('users')->where('id', '=', $editor_id)->value('lastname');
                    ?>
                    <p>{{$editor_name}} {{$editor_lastname}}</p> 
                    <?php
                        $reviewers = DB::table('reviewer_formulars')->where('paper_id', '=', $paper_global_id)->get();
                    ?>
                    <p class="mt-4 font-semibold">Reviewer:</p> 
                    @foreach ($reviewers as $reviewer)
                        
                        <p class="mt-2">{{ $loop->iteration }}. {{User::find($reviewer->reviewer_id)->name}} {{User::find($reviewer->reviewer_id)->lastname}} 
                        @if($reviewer->reviewer_acceptance == 1)
                        <a href="/reviewer_response/{{$reviewer->id}}"><span class="px-1 py-1 bg-green-400 border border-transparent rounded-md font-semibold text-white text-xs">Accepted ({{$reviewer->date_of_acceptance}})</span></a>
                        @elseif($reviewer->reviewer_acceptance == 2)
                        <span class="px-1 py-1 bg-red-400 border border-transparent rounded-md font-semibold text-white text-xs">Decline</span>
                        @else
                        <span class="px-1 py-1 bg-blue-400 border border-transparent rounded-md font-semibold text-white text-xs">Waiting</span>
                        @endif
                        </p>
                    @endforeach
                </div>
            </div>
        </div>
        @elseif (Auth::user()->permission == 3)
        <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white border-b border-gray-200 mt-4">
                <h2 class="mt-4 font-bold text-xl text-gray-800 leading-tight">
                    {{ __('Administration for this paper') }}
                </h2>
                <div class="border-l-4 border-gray-500 p-4 mt-4" role="alert">
                    <?php
                        $reviewers = DB::table('reviewer_formulars')->where('paper_id', '=', $paper_global_id)->get();
                    ?>
                    <p class="mt-4 font-semibold">Reviewer:</p> 
                    @foreach ($reviewers as $reviewer)
                        <p class="mt-2">{{ $loop->iteration }}. {{User::find($reviewer->reviewer_id)->name}} {{User::find($reviewer->reviewer_id)->lastname}} 
                        @if($reviewer->reviewer_acceptance == 1)
                        <a href="/reviewer_response/{{$reviewer->id}}"><span class="px-1 py-1 bg-green-400 border border-transparent rounded-md font-semibold text-white text-xs">Accepted ({{$reviewer->date_of_acceptance}})</span></a>
                        @elseif($reviewer->reviewer_acceptance == 2)
                        <span class="px-1 py-1 bg-red-400 border border-transparent rounded-md font-semibold text-white text-xs">Decline</span>
                        @else
                        <span class="px-1 py-1 bg-blue-400 border border-transparent rounded-md font-semibold text-white text-xs">Waiting</span>
                        @endif
                        </p>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 bg-white border-b border-gray-200 mt-4">
                <h2 class="mt-4 font-bold text-xl text-gray-800 leading-tight">
                        {{ __('Paper logs') }}
                    </h2>
                    @if (Auth::user()->permission == 4) 
                    <?php
                            $reviewer_finished = DB::table('reviewer_formulars')->where([
                                ['paper_id', '=', $paper_global_id],
                                ['reviewer_id', '=', Auth::user()->id],
                                ])->get();
                        ?>
                        @foreach($reviewer_finished as $rev_finished)
                            @if($rev_finished->reviewer_acceptance == 1)
                                @foreach($paper_files as $paper_file)
                                <div class="w-full py-6">
                                <div class="flex">
                                    <div class="w-1/1">
                                    </div>
                                    <form class="mt-2" method="POST" action="/download_pdf">
                                        @csrf
                                        <x-input id="paper_id" class="block mt-1 w-full" type="hidden" name="paper_id" value="{{$paper_file->paper_id}}" autofocus />
                                        <x-input id="paper_number" class="block mt-1 w-full" type="hidden" name="paper_number" value="{{$paper_file->paper_number}}" autofocus />
                                        <x-input id="paper_file" class="block mt-1 w-full" type="hidden" name="paper_file" value="{{$paper_file->file}}" autofocus />
                                        <x-button>
                                            <p>{{ $paper_file->file }}</p> - <p>{{ date('d.m.Y', strtotime($paper_file->date))}}</p>
                                        </x-button>
                                    </form> 
                                </div>
                                @endforeach
                            @endif
                        @endforeach
                    @else
                        @foreach($paper_files as $paper_file)
                        <div class="w-full py-6">
                        <div class="flex">
                            <div class="w-1/1">
                            </div>
                            <form class="mt-2" method="POST" action="/download_pdf">
                                @csrf
                                <x-input id="paper_id" class="block mt-1 w-full" type="hidden" name="paper_id" value="{{$paper_file->paper_id}}" autofocus />
                                <x-input id="paper_number" class="block mt-1 w-full" type="hidden" name="paper_number" value="{{$paper_file->paper_number}}" autofocus />
                                <x-input id="paper_file" class="block mt-1 w-full" type="hidden" name="paper_file" value="{{$paper_file->file}}" autofocus />
                                <x-button>
                                    <p>{{ $paper_file->file }}</p> - <p>{{ date('d.m.Y', strtotime($paper_file->date))}}</p>
                                </x-button>
                            </form> 
                        </div>
                        @endforeach 
                    @endif
                    <div class="mt-4" align="right">
                    @if (Auth::user()->permission == 0) 
                        @if ($paper_global_file == 0)
                        <form class="mt-2 mr-4 inline" method="POST" action="/paper_upload">
                            @csrf
                            <x-input id="paper_type" class="block mt-1 w-full" type="hidden" name="paper_type" value="1" autofocus />
                            <x-input id="paper_id" class="block mt-1 w-full" type="hidden" name="paper_id" value="{{$paper_global_id}}" autofocus />
                            <x-input id="paper_number" class="block mt-1 w-full" type="hidden" name="paper_number" value="{{$paper_global_number}}" autofocus />
                            <x-button>
                                {{ __('Upload full paper') }}
                            </x-button>
                        </form>
                        @endif
                        @if ($paper_status_global == 6)
                        <form class="mt-2 mr-4 inline" method="POST" action="/paper_upload">
                            @csrf
                            <x-input id="paper_type" class="block mt-1 w-full" type="hidden" name="paper_type" value="4" autofocus />
                            <x-input id="paper_id" class="block mt-1 w-full" type="hidden" name="paper_id" value="{{$paper_global_id}}" autofocus />
                            <x-input id="paper_number" class="block mt-1 w-full" type="hidden" name="paper_number" value="{{$paper_global_number}}" autofocus />
                            <x-button>
                                {{ __('Upload final paper') }}
                            </x-button>
                        </form>
                        @endif
                    @elseif (Auth::user()->permission == 2) 
                    
                        <form class="mt-2 mr-4 inline" method="POST" action="/paper_upload">
                            @csrf
                            <x-input id="paper_type" class="block mt-1 w-full" type="hidden" name="paper_type" value="2" autofocus />
                            <x-input id="paper_id" class="block mt-1 w-full" type="hidden" name="paper_id" value="{{$paper_global_id}}" autofocus />
                            <x-input id="paper_number" class="block mt-1 w-full" type="hidden" name="paper_number" value="{{$paper_global_number}}" autofocus />
                            <x-button>
                                {{ __('Upload paper for review') }}
                            </x-button>
                        </form>
                        @if($paper_status_global == 1 OR $paper_status_global == 4 OR $paper_status_global == 5)
                            <form class="mt-4 inline" method="POST" action="/assign_editor">
                                @csrf
                                <x-input id="paper_id" class="block mt-1 w-full" type="hidden" name="paper_id" value="{{$paper_global_id}}" autofocus />
                                <x-input id="paper_number" class="block mt-1 w-full" type="hidden" name="paper_number" value="{{$paper_global_number}}" autofocus />
                                <x-input id="conference" class="block mt-1 w-full" type="hidden" name="conference" value="{{$conference}}" autofocus />
                                <x-button>
                                    {{ __('Assign to Editor') }}
                                </x-button>
                            </form>
                        @endif
                    
                    @elseif(Auth::user()->permission == 3)
                        <?php
                            $editor_finished = DB::table('editor_formulars')->where([
                                ['paper_id', '=', $paper_global_id],
                                ['editor_id', '=', Auth::user()->id],
                                ])->get();
                        ?>
                        @foreach($editor_finished as $ed_finished)
                            @if($ed_finished->status != 1)
                            <form class="mt-2 inline" method="POST" action="/assign_reviewer">
                                @csrf
                                <x-input id="paper_id" class="block mt-1 w-full" type="hidden" name="paper_id" value="{{$paper_global_id}}" autofocus />
                                <x-input id="paper_number" class="block mt-1 w-full" type="hidden" name="paper_number" value="{{$paper_global_number}}" autofocus />
                                <x-input id="conference" class="block mt-1 w-full" type="hidden" name="conference" value="{{$conference}}" autofocus />
                                <x-button>
                                    {{ __('Assign to Reviewer') }}
                                </x-button>
                            </form>
                            <form class="mt-2 inline" method="POST" action="/editor_decision">
                                @csrf
                                <x-input id="paper_id" class="block mt-1 w-full" type="hidden" name="paper_id" value="{{$paper_global_id}}" autofocus />
                                <x-input id="paper_number" class="block mt-1 w-full" type="hidden" name="paper_number" value="{{$paper_global_number}}" autofocus />
                                <x-input id="conference" class="block mt-1 w-full" type="hidden" name="conference" value="{{$conference}}" autofocus />
                                <x-button>
                                    {{ __('Make a decision') }}
                                </x-button>
                            </form>
                            @endif
                        @endforeach
                    @elseif(Auth::user()->permission == 4)
                        <?php
                            $reviewer_finished = DB::table('reviewer_formulars')->where([
                                ['paper_id', '=', $paper_global_id],
                                ['reviewer_id', '=', Auth::user()->id],
                                ])->get();
                        ?>
                        @foreach($reviewer_finished as $rev_finished)
                            @if($rev_finished->reviewer_acceptance == 1)
                                @if($rev_finished->status != 1)
                                <form class="mt-2 inline" method="POST" action="/review">
                                    @csrf
                                    <x-input id="paper_id" class="block mt-1 w-full" type="hidden" name="paper_id" value="{{$paper_global_id}}" autofocus />
                                    <x-input id="paper_number" class="block mt-1 w-full" type="hidden" name="paper_number" value="{{$paper_global_number}}" autofocus />
                                    <x-input id="conference" class="block mt-1 w-full" type="hidden" name="conference" value="{{$conference}}" autofocus />
                                    <x-button>
                                        {{ __('Review') }}
                                    </x-button>
                                </form>
                                @endif
                            @else
                            <form class="mt-2 inline" method="POST" action="/accept_review">
                                @csrf
                                <x-input id="paper_id" class="block mt-1 w-full" type="hidden" name="paper_id" value="{{$paper_global_id}}" autofocus />
                                <x-input id="review_formular_id" class="block mt-1 w-full" type="hidden" name="review_formular_id" value="{{$rev_finished->id}}" autofocus />
                                <x-button>
                                    {{ __('Accept') }}
                                </x-button>
                            </form>
                            @endif
                        @endforeach
                    @endif
                </div>
    </div>
</x-app-layout>
