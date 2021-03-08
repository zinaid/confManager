<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Return paper for Change') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ URL::previous() }}" class="btn btn-warning inline" align="left"> <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M2.117 12l7.527 6.235-.644.765-9-7.521 9-7.479.645.764-7.529 6.236h21.884v1h-21.883z"/></svg></i></a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 bg-white border-b border-gray-200">
                    Enter commentar for a paper {{$paper_number}}
                </div>
                <div class="mt-4 mx-auto sm:px-6 lg:px-8">
                <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <form method="POST" action="/return_paper_submit">
                        @csrf
                        <x-input id="paper_id" class="block mt-1 w-full" type="hidden" name="paper_id" value="{{$paper_id}}" required autofocus />
                        <x-input id="paper_number" class="block mt-1 w-full" type="hidden" name="paper_number" value="{{$paper_number}}" required autofocus />

                         <!-- Abstract -->
                         <div class="mt-4">
                            <x-label for="comment" :value="__('Comment')" />

                            <textarea class="block mt-1 w-full" name="comment" value="old('comment')" required></textarea>
                            <script>
                                CKEDITOR.replace( 'comment' );
                            </script>
                        </div>


                        <div class="flex items-center justify-end mt-4 mb-4">
                            <x-button class="ml-4">
                                {{ __('Send Email') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
