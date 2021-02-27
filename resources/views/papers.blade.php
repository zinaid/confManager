<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ URL::previous() }}" class="btn btn-warning inline" align="left"> <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M2.117 12l7.527 6.235-.644.765-9-7.521 9-7.479.645.764-7.529 6.236h21.884v1h-21.883z"/></svg></i></a>
            @foreach ($papers as $paper)
                <div class="p-6 bg-white border-b border-gray-200 mt-4">
                @if($paper->status == 1)
                    <div class="border-l-4 border-gray-500 p-4" role="alert">
                        <p class="font-bold">Submited | Paper is currently at Technical Director.</p>
                        <p class="mt-4"> {{ $loop->iteration	 }}. {{ Str::limit($paper->title, 70, ' ...') }} {{ date('d.m.Y', strtotime($paper->created_at)) }}</p>
                    </div>
                @elseif($paper->status == 2)
                    <div class="border-l-4 border-yellow-500 p-4" role="alert">
                        <p class="font-bold">Under Review | Paper is currently reviewed by Reviewers.</p>
                        <p class="mt-4"> {{ $loop->iteration	 }}. {{ Str::limit($paper->title, 70, ' ...') }} {{ date('d.m.Y', strtotime($paper->created_at)) }}</p>
                    </div>
                @elseif($paper->status == 3)
                    <div class="border-l-4 border-indigo-500 p-4" role="alert">
                        <p class="font-bold">Minor Revision | Paper needs a minor Revision.</p>
                        <p class="mt-4"> {{ $loop->iteration	 }}. {{ Str::limit($paper->title, 70, ' ...') }} {{ date('d.m.Y', strtotime($paper->created_at)) }}</p>
                    </div>
                @elseif($paper->status == 4)
                    <div class="border-l-4 border-purple-500 p-4" role="alert">
                        <p class="font-bold">Major Revision | Paper needs a major Revision.</p>
                        <p class="mt-4"> {{ $loop->iteration	 }}. {{ Str::limit($paper->title, 70, ' ...') }} {{ date('d.m.Y', strtotime($paper->created_at)) }}</p>
                    </div>
                @elseif($paper->status == 5)
                    <div class="border-l-4 border-green-500 p-4" role="alert">
                        <p class="font-bold">Accepted | Paper is accepted.</p>
                        <p class="mt-4"> {{ $loop->iteration	 }}. {{ Str::limit($paper->title, 70, ' ...') }} {{ date('d.m.Y', strtotime($paper->created_at)) }}</p>
                    </div>
                @elseif($paper->status == 5)
                <div class="border-l-4 border-red-500 p-4" role="alert">
                    <p class="font-bold">Rejected | Paper is rejected.</p>
                    <p class="mt-4"> {{ $loop->iteration	 }}. {{ Str::limit($paper->title, 70, ' ...') }} {{ date('d.m.Y', strtotime($paper->created_at)) }}</p>
                </div>
                @endif
                    <form method="GET" action="/papers/{{$paper->id}}" align="right">
                        @csrf
                        <x-button>
                            {{ __('See more') }}
                        </x-button>
                    </form>
                    <form class="mt-4" method="GET" action="/submit" align="right">
                        @csrf
                        <x-button>
                            {{ __('Download PDF') }}
                        </x-button>
                    </form>  
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
