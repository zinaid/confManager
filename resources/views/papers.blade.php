<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ URL::previous() }}" class="btn btn-warning inline" align="left"> <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M2.117 12l7.527 6.235-.644.765-9-7.521 9-7.479.645.764-7.529 6.236h21.884v1h-21.883z"/></svg></i></a>
            @forelse ($papers as $paper)
                <div class="p-6 bg-white border-b border-gray-200 mt-4">
                @if($paper->status == 1)
                    <div class="border-l-4 border-gray-500 p-4" role="alert">
                        <p class="font-bold">Submited | Paper is currently with Technical Director.</p>
                        <p class="mt-4"> {{ $loop->iteration	 }}. {{ Str::limit($paper->title, 70, ' ...') }} {{ date('d.m.Y', strtotime($paper->created_at)) }}</p>
                        @if ($paper->file == 1) <p class="mt-4">Full paper is uploaded</p>
                        @else <p class="mt-4">Full paper is not uploaded</p>
                        @endif
                    </div>
                @elseif($paper->status == 2)
                    <div class="border-l-4 border-yellow-500 p-4" role="alert">
                        <p class="font-bold">With Editor | Paper is with Editor.</p>
                        <p class="mt-4"> {{ $loop->iteration	 }}. {{ Str::limit($paper->title, 70, ' ...') }} {{ date('d.m.Y', strtotime($paper->created_at)) }}</p>
                        @if ($paper->file == 1) <p class="mt-4">Full paper is uploaded</p>
                        @else <p class="mt-4">Full paper is not uploaded</p>
                        @endif
                    </div>
                @elseif($paper->status == 3)
                    <div class="border-l-4 border-indigo-500 p-4" role="alert">
                        <p class="font-bold">Under Review | Paper is currently under Review.</p>
                        <p class="mt-4"> {{ $loop->iteration	 }}. {{ Str::limit($paper->title, 70, ' ...') }} {{ date('d.m.Y', strtotime($paper->created_at)) }}</p>
                        @if ($paper->file == 1) <p class="mt-4">Full paper is uploaded</p>
                        @else <p class="mt-4">Full paper is not uploaded</p>
                        @endif
                    </div>
                @elseif($paper->status == 4)
                    <div class="border-l-4 border-purple-500 p-4" role="alert">
                        <p class="font-bold">Minor Revision | Paper needs a minor Revision.</p>
                        <p class="mt-4"> {{ $loop->iteration	 }}. {{ Str::limit($paper->title, 70, ' ...') }} {{ date('d.m.Y', strtotime($paper->created_at)) }}</p>
                        @if ($paper->file == 1) <p class="mt-4">Full paper is uploaded</p>
                        @else <p class="mt-4">Full paper is not uploaded</p>
                        @endif
                    </div>
                @elseif($paper->status == 5)
                    <div class="border-l-4 border-purple-500 p-4" role="alert">
                        <p class="font-bold">Major Revision | Paper needs a major Revision.</p>
                        <p class="mt-4"> {{ $loop->iteration	 }}. {{ Str::limit($paper->title, 70, ' ...') }} {{ date('d.m.Y', strtotime($paper->created_at)) }}</p>
                        @if ($paper->file == 1) <p class="mt-4">Full paper is uploaded</p>
                        @else <p class="mt-4">{Full paper is not uploaded</p>
                        @endif
                    </div>
                @elseif($paper->status == 6)
                <div class="border-l-4 border-green-500 p-4" role="alert">
                    <p class="font-bold">Accepted | Paper is Rejected.</p>
                    <p class="mt-4"> {{ $loop->iteration	 }}. {{ Str::limit($paper->title, 70, ' ...') }} {{ date('d.m.Y', strtotime($paper->created_at)) }}</p>
                    @if ($paper->file == 1) <p class="mt-4">Full paper is uploaded</p>
                    @else <p class="mt-4">{Full paper is not uploaded</p>
                    @endif
                </div>
                @elseif($paper->status == 7)
                <div class="border-l-4 border-red-500 p-4" role="alert">
                    <p class="font-bold">Rejected | Paper is Rejected.</p>
                    <p class="mt-4"> {{ $loop->iteration	 }}. {{ Str::limit($paper->title, 70, ' ...') }} {{ date('d.m.Y', strtotime($paper->created_at)) }}</p>
                    @if ($paper->file == 1) <p class="mt-4">Full paper is uploaded</p>
                    @else <p class="mt-4">{Full paper is not uploaded</p>
                    @endif
                </div>
                @endif
                    <form method="GET" action="/papers/{{$paper->id}}" align="right">
                        @csrf
                        <x-button>
                            {{ __('See more') }}
                        </x-button>
                    </form> 
                </div>
            @empty
            <div class="p-6 bg-white border-b border-gray-200 mt-4">
                There are no papers by this author.
            </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
