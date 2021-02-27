<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ URL::previous() }}" class="btn btn-warning inline" align="left"> <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M2.117 12l7.527 6.235-.644.765-9-7.521 9-7.479.645.764-7.529 6.236h21.884v1h-21.883z"/></svg></i></a>
            <form class="mb-4" method="GET" action="/add_section/{{$conference}}" align="right">
                @csrf
                <x-button class="bg-green-400">
                    {{ __('Add New Section') }}
                </x-button>
            </form> 
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Welcome {{ Auth::user()->name }}. 
                    List of sections for conference {{$conference}}
                    @foreach ($sections as $section)
                    <div class="p-6 bg-white border-b border-gray-200 mt-4">
                        <div class="border-l-4 border-gray-500 p-4" role="alert">
                            <p class="font-bold">{{ $section->name }}</p>
                            <p class="mt-4"> {{ $loop->iteration	 }}. {{ Str::limit($section->name, 70, ' ...') }}</p>
                        </div>
                        <div align="right">
                            <form class="mt-4 inline" method="GET" action="/view_topics/{{$section->id}}">
                                @csrf
                                <x-button class="bg-blue-400">
                                    {{ __('View Topics') }}
                                </x-button>
                            </form> 
                            <form class="mt-4 inline" method="GET" action="/add_topic/{{$section->id}}">
                                @csrf
                                <x-button class="bg-green-400">
                                    {{ __('Add Topic') }}
                                </x-button>
                            </form>
                        </div> 
                    </div>
                    @endforeach
                </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
