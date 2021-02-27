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
                            <p>{{ $paper->type }}</p>
                            
                            <p class="mt-4 font-semibold">Topic Area:</p> 
                            <p>{{ $paper->topic_area }}</p>
                        </div>
                    @endforeach
                    </div>
                    <div class="...">
                    @foreach ($main_authors as $main_author)
                        <h2 class="font-bold text-xl text-gray-800 leading-tight">
                            {{ __('Author info') }}
                        </h2>
                        <div class="border-l-4 border-gray-500 p-4 mt-4" role="alert">
                            <p class="font-semibold">Corresponding author:</p> 
                            <p>{{ $main_author->name }} {{ $main_author->lastname }}</p>

                            <p class="mt-4 font-semibold">Corresponding authors affiliation:</p> 
                            <p>{{ $main_author->affiliation }}, {{ $main_author->affiliation_country }}, {{ $main_author->affiliation_city }}</p>

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
                    </div>
                </div>
                <form class="mt-4" method="GET" action="/submit" align="right">
                    @csrf
                    <x-button>
                        {{ __('Download PDF') }}
                    </x-button>
                </form> 
            </div>
            
        </div>


        <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white border-b border-gray-200 mt-4">
                <h2 class="mt-4 font-bold text-xl text-gray-800 leading-tight">
                    {{ __('Status logs') }}
                </h2>
                @foreach ($logs_info as $log_info)
                        @if($log_info->status == 1) <?php $status_text = "Submited";?>
                        @elseif($log_info->status == 2)<?php $status_text = "At Editor";?>
                        @elseif($log_info->status == 3) <?php $status_text = "Under Review";?>
                        @elseif($log_info->status == 4) <?php $status_text  = "Minor Revision";?>
                        @elseif($log_info->status == 5) <?php $status_text = "Minor Revision";?>
                        @elseif($log_info->status == 6) <?php $status_text = "Major Revision";?>
                        @elseif($log_info->status == 7) <?php $status_text = "Accepted";?>
                        @elseif($log_info->status == 8) <?php $status_text = "Rejected";?>
                        @endif
                        <div class="border-l-4 border-gray-500 p-4 mt-4" role="alert">
                            <p class="font-semibold">Status: </p> 
                            <p>{{$status_text}}</p>

                            <p class="mt-4 font-semibold">Date:</p> 
                            <p>{{$log_info->date}}</p>

                        </div>
                    @endforeach
            </div>
            
        </div>
        
    </div>
</x-app-layout>
