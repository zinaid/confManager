<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray overflow-hidden shadow-sm sm:rounded-lg">
            @foreach ($papers as $paper)
                <div class="p-6 bg-white border-b border-gray-200 mt-4">
                    {{ $loop->iteration	 }}. {{ $paper->title }} 
                    <form class="mt-4" method="GET" action="/papers/{{$paper->id}}">
                        @csrf
                        <x-button>
                            {{ __('See more') }}
                        </x-button>
                    </form>
                    <form class="mt-4" method="GET" action="/submit">
                        @csrf
                        <x-button>
                            {{ __('Download PDF') }}
                        </x-button>
                    </form>  
                </div>
            @endforeach
                
            </div>
        </div>
    </div>
</x-app-layout>
