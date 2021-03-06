<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Welcome {{ Auth::user()->title }} {{ Auth::user()->name }}. 
                    @if (Auth::user()->status == 0)
                    Please fill these fields to finish your registration.
                    <form class="mt-4" method="POST" action="/finish_registration">
                        @csrf

                        <!-- Country -->
                        <div>
                            <x-label for="country" :value="__('Country')" />

                            <x-input id="country" class="block mt-1 w-full" type="text" name="country" :value="old('country')" placeholder="E.g. Bosnia and Herzegovina" required autofocus />
                        </div>

                        <!-- City -->
                        <div class="mt-4">
                            <x-label for="city" :value="__('City')" />

                            <x-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')" placeholder="E.g. Bihać" required autofocus />
                        </div>

                        <!-- Affiliation -->
                        <div class="mt-4">
                            <x-label for="affiliation" :value="__('Affiliation / Company')" />

                            <x-input id="affiliation" class="block mt-1 w-full" type="text" name="affiliation" :value="old('affiliation')" placeholder="E.g. Technical Faculty Bihać / Elektroprenos D.O.O" required autofocus />
                        </div>
                    
                        <!-- Affiliation Country -->
                        <!--
                        <div class="mt-4">
                            <x-label for="affiliation_country" :value="__('Affiliation country')" />

                            <x-input id="affiliation_country" class="block mt-1 w-full" type="text" name="affiliation_country" :value="old('affiliation_country')" placeholder="E.g. Bosnia and Herzegovina" required />
                        </div>
                        -->
                        
                        <!-- Affiliation City -->
                        <!--
                        <div class="mt-4">
                            <x-label for="affiliation_city" :value="__('Affiliation city')" />

                            <x-input id="affiliation_city" class="block mt-1 w-full" type="text" name="affiliation_city" :value="old('affiliation_city')" placeholder="E.g. Bihać" required />
                        </div>
                        -->
                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Update') }}
                            </x-button>
                        </div>
                    </form>
                    @else
                        @if (Auth::user()->permission == 0)
                            @if($paper_counter < 2)
                            <form class="mt-4" method="GET" action="/submit">
                                @csrf
                                <x-button>
                                    {{ __('Submit paper') }}
                                </x-button>
                            </form>
                            @else
                                You already have 2 submited papers. 
                                <form class="mt-4" method="GET" action="/papers">
                                    @csrf
                                    <x-button>
                                        {{ __('See papers') }}
                                    </x-button>
                                </form>
                            @endif
                        @elseif(Auth::user()->permission == 1 OR Auth::user()->permission == 2)
                            You are an admin in this software. Please advise to section General Settings to set conference details.
                            <form class="mt-4" method="GET" action="/settings">
                                @csrf
                                <x-button>
                                    {{ __('See settings') }}
                                </x-button>
                            </form>
                        @elseif(Auth::user()->permission == 3 OR Auth::user()->permission == 4)
                            You are @if(Auth::user()->permission == 3) an editor @else a reviewer @endif in this software. Please advise to section Papers.
                            <form class="mt-4" method="GET" action="/papers_list">
                                @csrf
                                <x-button>
                                    {{ __('List of papers') }}
                                </x-button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
