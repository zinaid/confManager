<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ URL::previous() }}" class="btn btn-warning inline" align="left"> <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M2.117 12l7.527 6.235-.644.765-9-7.521 9-7.479.645.764-7.529 6.236h21.884v1h-21.883z"/></svg></i></a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 bg-white border-b border-gray-200">
                    Review results
                </div>
                <div class="mt-4 mx-auto sm:px-6 lg:px-8">
                <!-- Validation Errors -->
                @if(session()->has('message'))
                <div class="bg-green-100 border border-green-400 mt-4 mb-4 px-4 py-3 rounded relative">
                    <span class="block sm:inline">{{ session()->get('message') }}</span>
                </div>
                @endif
                <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <form method="POST" action="#" enctype="multipart/form-data">
                        @csrf
                        @foreach ($reviewer_formulars as $reviewer_formular)
                        <!-- Paper instructions -->
                        <div class="mt-4">
                        <x-label for="instructions" :value="__('The paper is written according to the Instructions for Authors ?')" />
                            <div class="flex mt-1">
                                @if($reviewer_formular->author_instructions == 1)
                                    <p>Yes</p>
                                @else
                                    <p>No</p>
                                @endif
                            </div>
                        </div>

                        <!-- Paper type -->
                        <div class="mt-4">
                        <x-label for="paper_type" :value="__('The paper is classified as ?')" />
                            <div class="flex mt-1">
                                @if($reviewer_formular->paper_type == 0)
                                    <p>Original scientific paper</p>
                                @elseif($reviewer_formular->paper_type == 1)
                                    <p>Preliminary communication</p>
                                @elseif($reviewer_formular->paper_type == 2)
                                    <p>Review paper</p>
                                @else
                                    <p>Professional paper</p>
                                @endif
                            </div>
                        </div>

                        <!-- Paper contribution -->
                        <div class="mt-4">
                        <x-label for="contribution" :value="__('The paper containes a contribution to the scientific or professional area/discipline ?')" />
                            <div class="flex mt-1">
                                @if($reviewer_formular->paper_contribution == 1)
                                    <p>Yes</p>
                                @else
                                    <p>No</p>
                                @endif
                            </div>
                        </div>

                        <!-- Paper interest -->
                        <div class="mt-4">
                        <x-label for="interest" :value="__('The paper is interesting for wide, narrow or very narrow circle of experts ?')" />
                            <div class="flex mt-1">
                                @if($reviewer_formular->paper_interest == 0)
                                    <p>Wide</p>
                                @elseif($reviewer_formular->paper_interest == 1)
                                    <p>Narrow</p>
                                @else
                                    <p>Very narrow</p>
                                @endif
                            </div>
                        </div>

                        <!-- Paper structure -->
                        <div class="mt-4">
                        <x-label for="structure" :value="__('The paper has abstract, keywords, introduction, substantial part, conclusion and reference ?')" />
                            <div class="flex mt-1">
                                @if($reviewer_formular->paper_structure == 1)
                                    <p>Yes</p>
                                @else
                                    <p>No</p>
                                @endif
                            </div>
                        </div>

                        <!-- Paper supplementary -->
                        <div class="mt-4">
                        <x-label for="supplementary" :value="__('Figures, tables, and photographs are corresponding ?')" />
                            <div class="flex mt-1">
                                @if($reviewer_formular->paper_supplementary_parts == 1)
                                    <p>Yes</p>
                                @else
                                    <p>No</p>
                                @endif
                            </div>
                        </div>

                        <!-- Paper terminology -->
                        <div class="mt-4">
                        <x-label for="terminology" :value="__('Terminology, style and language are corresponding ?')" />
                            <div class="flex mt-1">
                                @if($reviewer_formular->paper_terminology == 1)
                                    <p>Yes</p>
                                @else
                                    <p>No</p>
                                @endif
                            </div>
                        </div>

                        <!-- Paper decision -->
                        <div class="mt-4 mb-4">
                        <x-label for="decision" :value="__('Decision for this paper ?')" />
                            <div class="flex mt-1">
                                @if($reviewer_formular->decision == 7)
                                    <p>Rejected</p>
                                @elseif($reviewer_formular->decision == 6)
                                    <p>Accepted</p>
                                @elseif($reviewer_formular->decision == 5)
                                    <p>Accepted with Major Revision</p>
                                @elseif($reviewer_formular->decision == 4)
                                    <p>Accepted with Minor Revision</p>
                                @endif
                            </div>
                        </div>
                        @if($reviewer_formular->reviewer_comment != NULL)
                        <div class="mt-4 mb-4">
                            <x-label for="comment" :value="__('Reviewer\'s Comment')" />

                            <textarea class="block mt-1 w-full" name="comment" value="old('comment')">{{ $reviewer_formular->reviewer_comment }}</textarea>
                            <script>
                                CKEDITOR.replace( 'comment' );
                            </script>

                            <!--<x-input id="abstract" class="block mt-1 w-full" type="text" name="abstract" :value="old('abstract')" required autofocus />-->
                        </div>
                        @endif
                        @endforeach
                    </form>
            </div>
        </div>
    </div>
</x-app-layout>
