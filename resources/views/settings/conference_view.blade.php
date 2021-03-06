<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ URL::previous() }}" class="btn btn-warning inline" align="left"> <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M2.117 12l7.527 6.235-.644.765-9-7.521 9-7.479.645.764-7.529 6.236h21.884v1h-21.883z"/></svg></i></a>
            <div class="p-6 bg-white border-b border-gray-200 mt-4">
                <div class="grid grid-cols-1 gap-4">
                    <div class="...">
                    @foreach ($conferences as $conference)
                    @if($conference->status==1)
                        <form class="mt-4 mb-4" method="GET" align="right" action="/deactivate_conference/{{$conference->id}}">
                            @csrf
                            <x-button class="bg-red-400">
                                {{ __('Deactivate') }}
                            </x-button>
                        </form>
                        @elseif($conference->status==2)
                        <form class="mt-4 mb-4" method="GET" align="right" action="/activate_conference/{{$conference->id}}">
                            @csrf
                            <x-button class="bg-green-400">
                                {{ __('Activate') }}
                            </x-button>
                        </form>
                        @endif
                        <form method="POST" action="/update_conference/{{$conference->id}}">
                            @csrf
                            <!-- Title -->
                            <div>
                                <x-label for="name" :value="__('Name')" />

                                <x-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $conference->name }}" required autofocus />
                            </div>

                            <!-- Acronym -->
                            <div class="mt-4">
                                <x-label for="acronym" :value="__('Acronym')" />

                                <x-input id="acronym" class="block mt-1 w-full" type="text" name="acronym" value="{{ $conference->acronym }}" required autofocus />
                            </div>
                            <!-- StartDate -->
                            <div class="mt-4">
                                <x-label for="start_date" :value="__('Start date')" />

                                <x-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" value="{{ $conference->start_date }}" autofocus />
                            </div>

                            <!-- EndDate -->
                            <div class="mt-4">
                                <x-label for="end_date" :value="__('End date')" />

                                <x-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" value="{{ $conference->end_date }}" autofocus />
                            </div>

                            <!-- abstract_submission_date -->
                            <div class="mt-4">
                                <x-label for="abstract_submission_date" :value="__('Abstract submission date')" />

                                <x-input id="abstract_submission_date" class="block mt-1 w-full" type="date" name="abstract_submission_date" value="{{ $conference->abstract_submission_date }}" autofocus />
                            </div>

                            <!-- Full paper date -->
                            <div class="mt-4">
                                <x-label for="full_paper_date" :value="__('Full paper date')" />

                                <x-input id="full_paper_date" class="block mt-1 w-full" type="date" name="full_paper_date" value="{{ $conference->full_paper_date }}" autofocus />
                            </div>
                            
                            <!-- Acceptance Date -->
                            <div class="mt-4">
                                <x-label for="acceptance_notification_date" :value="__('Acceptance notification date')" />

                                <x-input id="acceptance_notification_date" class="block mt-1 w-full" type="date" name="acceptance_notification_date" value="{{ $conference->acceptance_notification_date }}" autofocus />
                            </div>

                            <!-- Place -->
                            <div class="mt-4">
                                <x-label for="place" :value="__('Place')" />

                                <x-input id="place" class="block mt-1 w-full" type="text" name="place" value="{{ $conference->place }}" autofocus />
                            </div>

                            <!-- Logo -->
                            <div class="mt-4">
                                <x-label for="logo" :value="__('Logo')" />

                                <x-input id="logo" class="block mt-1 w-full" type="text" name="logo" value="{{ $conference->logo }}" autofocus />
                            </div>

                            <div class="flex items-center justify-end mt-4 mb-4">
                            <x-button class="ml-4">
                                {{ __('Update') }}
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
