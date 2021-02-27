<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form class="mb-4" method="GET" action="/add_conference" align="right">
                    @csrf
                    <x-button class="bg-green-400">
                        {{ __('Add Conference') }}
                    </x-button>
            </form>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                
                <div class="p-6 bg-white border-b border-gray-200">
                    Welcome {{ Auth::user()->name }}. 
                    This is the main section for conference settings.
                    @foreach ($conferences as $conference)
                    <div class="p-6 bg-white border-b border-gray-200 mt-4">
                    @if($conference->status == 1)
                        <div class="border-l-4 border-gray-500 p-4" role="alert">
                            <p class="font-bold">Active Conference | {{ $conference->name }}</p>
                            <p class="mt-4"> {{ $loop->iteration	 }}. {{ Str::limit($conference->name, 70, ' ...') }}</p>
                        </div>
                    @elseif($conference->status == 2)
                        <div class="border-l-4 border-red-500 p-4" role="alert">
                            <p class="font-bold">Inactive Conference | {{ $conference->name }}</p>
                            <p class="mt-4"> {{ $loop->iteration	 }}. {{ Str::limit($conference->name, 70, ' ...') }}</p>
                        </div>
                    @endif
                        <div align="right">
                            @if (\Request::is('administration'))  
                            <form class="inline" method="GET" action="/view_administration/{{$conference->id}}" align="right">
                                @csrf
                                <x-button class="bg-blue-400">
                                    {{ __('View administration') }}
                                </x-button>
                            </form>
                            @endif
                            @if (\Request::is('settings'))
                            <form class="inline" method="GET" action="/view_sections/{{$conference->id}}" align="right">
                                @csrf
                                <x-button class="bg-blue-400">
                                    {{ __('View sections') }}
                                </x-button>
                            </form>
                            <form class="inline" method="GET" action="/add_section/{{$conference->id}}" align="right">
                                @csrf
                                <x-button class="bg-green-400">
                                    {{ __('Add section') }}
                                </x-button>
                            </form>
                            @endif
                            @if (\Request::is('mail_settings'))
                            <form class="inline" method="GET" action="/view_mail_settings/{{$conference->id}}" align="right">
                                @csrf
                                <x-button class="bg-green-400">
                                    {{ __('Add mail template') }}
                                </x-button>
                            </form>
                            @endif
                            <form class="inline" method="GET" action="/conferences/{{$conference->id}}" align="right">
                                @csrf
                                <x-button>
                                    {{ __('See more') }}
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
