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
                    Welcome {{ Auth::user()->name }}. 
                    @if (Auth::user()->status == 0)
                    Please fill these fields to finish your registration.
                    <form class="mt-4" method="POST" action="/finish_registration">
                        @csrf

                        <!-- Country -->
                        <div>
                            <x-label for="country" :value="__('Country')" />

                            <x-input id="country" class="block mt-1 w-full" type="text" name="country" :value="old('country')" required autofocus />
                        </div>

                        <!-- City -->
                        <div class="mt-4">
                            <x-label for="city" :value="__('City')" />

                            <x-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')" required autofocus />
                        </div>

                        <!-- Affiliation -->
                        <div class="mt-4">
                            <x-label for="affiliation" :value="__('Affiliation')" />

                            <x-input id="affiliation" class="block mt-1 w-full" type="text" name="affiliation" :value="old('affiliation')" required autofocus />
                        </div>

                        <!-- Affiliation Country -->
                        <div class="mt-4">
                            <x-label for="affiliation_country" :value="__('Affiliation country')" />

                            <x-input id="affiliation_country" class="block mt-1 w-full" type="text" name="affiliation_country" :value="old('affiliation_country')" required />
                        </div>

                        <!-- Affiliation City -->
                        <div class="mt-4">
                            <x-label for="affiliation_city" :value="__('Affiliation city')" />

                            <x-input id="affiliation_city" class="block mt-1 w-full" type="text" name="affiliation_city" :value="old('affiliation_city')" required />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Update') }}
                            </x-button>
                        </div>
                    </form>
                    @else
                    <form class="mt-4" method="GET" action="/submit">
                        @csrf
                        <x-button>
                            {{ __('Submit paper') }}
                        </x-button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
