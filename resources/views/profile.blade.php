<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray overflow-hidden shadow-sm sm:rounded-lg">
            @foreach ($users as $user)
                <div class="p-6 bg-white border-b border-gray-200 mt-4">
                <form method="POST" action="{{ route('update_profile') }}">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-label for="name" :value="__('Name')" />

                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{$user->name}}" required autofocus />
                    </div>

                    <!-- Lastname -->
                    <div class="mt-4">
                        <x-label for="lastname" :value="__('Lastname')" />

                        <x-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" value="{{$user->lastname}}" required autofocus />
                    </div>

                    <!-- Title -->
                    <div class="mt-4">
                        <x-label for="title" :value="__('Title')" />

                        <x-input id="title" class="block mt-1 w-full" type="text" name="title" value="{{$user->title}}" required autofocus />
                    </div>

                     <!-- Country -->
                     <div>
                        <x-label for="country" :value="__('Country')" />

                        <x-input id="country" class="block mt-1 w-full" type="text" name="country" value="{{$user->country}}" required autofocus />
                    </div>

                    <!-- City -->
                    <div class="mt-4">
                        <x-label for="city" :value="__('City')" />

                        <x-input id="city" class="block mt-1 w-full" type="text" name="city" value="{{$user->city}}" required autofocus />
                    </div>

                    <!-- Affiliation -->
                    <div class="mt-4">
                        <x-label for="affiliation" :value="__('Affiliation')" />

                        <x-input id="affiliation" class="block mt-1 w-full" type="text" name="affiliation" value="{{$user->affiliation}}" required autofocus />
                    </div>

                    <!-- Affiliation Country -->
                    <div class="mt-4">
                        <x-label for="affiliation_country" :value="__('Affiliation country')" />

                        <x-input id="affiliation_country" class="block mt-1 w-full" type="text" name="affiliation_country" value="{{$user->affiliation_country}}" required />
                    </div>

                    <!-- Affiliation City -->
                    <div class="mt-4">
                        <x-label for="affiliation_city" :value="__('Affiliation city')" />

                        <x-input id="affiliation_city" class="block mt-1 w-full" type="text" name="affiliation_city" value="{{$user->affiliation_city}}" required />
                    </div>


                    <div class="flex items-center justify-end mt-4">
                        <x-button class="ml-4">
                            {{ __('Update') }}
                        </x-button>
                    </div>
                </form> 
                </div>
            @endforeach
                
            </div>
        </div>
    </div>
</x-app-layout>
