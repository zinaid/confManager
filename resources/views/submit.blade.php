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
                    Fill these fields for paper submission.
                </div>
                <div class="mt-4 mx-auto sm:px-6 lg:px-8">
                <!-- Validation Errors -->
                @if(session()->has('message'))
                <div class="bg-green-100 border border-green-400 mt-4 mb-4 px-4 py-3 rounded relative">
                    <span class="block sm:inline">{{ session()->get('message') }}</span>
                 </div>
                @endif
                <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <form method="POST" action="/paper_submission">
                        @csrf

                        <!-- Country -->
                        <div>
                            <x-label for="title" :value="__('Title')" />

                            <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                        </div>

                        <!-- City -->
                        <div class="mt-4">
                            <x-label for="abstract" :value="__('Abstract')" />

                            <x-input id="abstract" class="block mt-1 w-full" type="text" name="abstract" :value="old('abstract')" required autofocus />
                        </div>

                        <div class="flex items-center justify-end mt-4 mb-4">
                            <x-button class="ml-4">
                                {{ __('Save') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
