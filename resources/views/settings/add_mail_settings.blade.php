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
                    <form method="POST" action="{{ route('add_mail_settings_submit') }}">
                        @csrf

                        <!-- Conference -->
                        <div>

                            <x-input id="conference" class="block mt-1 w-full" type="hidden" name="conference" value="{{$conference}}" required autofocus />
                        </div>

                        <!-- Permission -->
                        <div>

                            <x-input id="type" class="block mt-1 w-full" type="hidden" name="type" value="{{$type}}" required autofocus />
                        </div>

                        @forelse ($mail_settings as $mail_setting)
                         <!-- Text -->
                         <div class="mt-4">
                            <x-label for="text" :value="__('Text')" />

                            <textarea id="text" class="block mt-1 w-full" name="text" value="" required>{{$mail_setting->text}}</textarea>
                            <script>
                                CKEDITOR.replace( 'text' );
                            </script>

                            <!--<x-input id="abstract" class="block mt-1 w-full" type="text" name="abstract" :value="old('abstract')" required autofocus />-->
                        </div>
                        @empty
                         <!-- Text -->
                         <div class="mt-4">
                            <x-label for="text" :value="__('Text')" />

                            <textarea id="text" class="block mt-1 w-full" name="text" value="" required></textarea>
                            <script>
                                CKEDITOR.replace( 'text' );
                            </script>

                            <!--<x-input id="abstract" class="block mt-1 w-full" type="text" name="abstract" :value="old('abstract')" required autofocus />-->
                        </div>
                        @endforelse

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
