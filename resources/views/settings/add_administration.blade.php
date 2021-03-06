<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ URL::previous() }}" class="btn btn-warning inline" align="left"> <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M2.117 12l7.527 6.235-.644.765-9-7.521 9-7.479.645.764-7.529 6.236h21.884v1h-21.883z"/></svg></i></a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <form method="POST" action="{{ route('add_administration_submit') }}">
                        @csrf

                        <!-- Conference -->
                        <div>

                            <x-input id="conference" class="block mt-1 w-full" type="hidden" name="conference" value="{{$conference}}" required autofocus />
                        </div>

                        <!-- Permission -->
                        <div>

                            <x-input id="permission" class="block mt-1 w-full" type="hidden" name="permission" value="{{$permission}}" required autofocus />
                        </div>

                        <!-- Name -->
                        <div>
                            <x-label for="name" :value="__('Name')" />

                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                        </div>

                        <!-- Lastname -->
                        <div class="mt-4">
                            <x-label for="lastname" :value="__('Lastname')" />

                            <x-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')" required autofocus />
                        </div>

                        <!-- Title -->
                        <div class="mt-4">
                        <x-label for="title" :value="__('Title')" />
                            <select id="title" class="block border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full mt-1 bg-white rounded outline-none" name="title"  required autofocus>
                                <option class="py-1">Prof.dr.</option>
                                <option class="py-1">Dr.</option>
                                <option class="py-1">Msc.</option>
                                <option class="py-1">Bsc.</option>
                            </select>
                        </div>
                        <!-- Title -->
                        <!--<div class="mt-4">
                            <x-label for="title" :value="__('Title')" />

                            <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                        </div>-->

                        <!-- Country -->
                        <div class="mt-4">
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
                        <!--
                        <div class="mt-4">
                            <x-label for="affiliation_country" :value="__('Affiliation country')" />

                            <x-input id="affiliation_country" class="block mt-1 w-full" type="text" name="affiliation_country" :value="old('affiliation_country')" required autofocus/>
                        </div>
                        -->
                        <!-- Affiliation City -->
                        <!--
                        <div class="mt-4">
                            <x-label for="affiliation_city" :value="__('Affiliation city')" />

                            <x-input id="affiliation_city" class="block mt-1 w-full" type="text" name="affiliation_city" :value="old('affiliation_city')" required autofocus/>
                        </div>
                        -->

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-label for="email" :value="__('Email')" />

                            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-label for="password" :value="__('Password')" />

                            <x-input id="password" class="block mt-1 w-full"
                                            type="password"
                                            name="password"
                                            required autocomplete="new-password" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mt-4">
                            <x-label for="password_confirmation" :value="__('Confirm Password')" />

                            <x-input id="password_confirmation" class="block mt-1 w-full"
                                            type="password"
                                            name="password_confirmation" required />
                        </div>

                        <div class="flex items-center justify-end mt-4">

                            <x-button class="ml-4">
                                {{ __('Save') }}
                            </x-button>
                        </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
