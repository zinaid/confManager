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
                    Fill these fields for paper review.
                </div>
                <div class="mt-4 mx-auto sm:px-6 lg:px-8">
                <!-- Validation Errors -->
                @if(session()->has('message'))
                <div class="bg-green-100 border border-green-400 mt-4 mb-4 px-4 py-3 rounded relative">
                    <span class="block sm:inline">{{ session()->get('message') }}</span>
                </div>
                @endif
                <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <form method="POST" action="/review_submission" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="paper_id" value="{{$paper_id}}" name="paper_id" class="h-2 w-2 text-gray-600 px-2 py-2 border rounded mr-2">
                        <input type="hidden" id="paper_number" value="{{$paper_number}}" name="paper_number" class="h-2 w-2 text-gray-600 px-2 py-2 border rounded mr-2">

                        <!-- Paper instructions -->
                        <div class="mt-4">
                        <x-label for="instructions" :value="__('The paper is written according to the Instructions for Authors ?')" />
                            <div class="flex mt-1">
                                <div class="flex items-center mb-2 mr-4">
                                    <input type="radio" id="radio-instructions-1" value="0" name="instructions" class="h-2 w-2 text-gray-600 px-2 py-2 border rounded mr-2">
                                    <label for="radio-instructions-1" class="text-gray-600 text-sm">No</label>
                                </div>
                                <div class="flex items-center mb-2 mr-4">
                                    <input type="radio" id="radio-instructions-2" value="1" name="instructions" class="h-2 w-2 text-gray-600 px-2 py-2 border rounded mr-2">
                                    <label for="radio-instructions-2" class="text-gray-600 text-sm">Yes</label>
                                </div>
                            </div>
                        </div>

                        <!-- Paper type -->
                        <div class="mt-4">
                        <x-label for="paper_type" :value="__('The paper is classified as ?')" />
                            <div class="flex mt-1">
                                <div class="flex items-center mb-2 mr-4">
                                    <input type="radio" id="radio-paper-1" value="0" name="paper_type" class="h-2 w-2 text-gray-600 px-2 py-2 border rounded mr-2">
                                    <label for="radio-paper-1" class="text-gray-600 text-sm">Original scientific paper</label>
                                </div>
                                <div class="flex items-center mb-2 mr-4">
                                    <input type="radio" id="radio-paper-2" value="1" name="paper_type" class="h-2 w-2 text-gray-600 px-2 py-2 border rounded mr-2">
                                    <label for="radio-paper-2" class="text-gray-600 text-sm">Preliminary communication</label>
                                </div>
                                <div class="flex items-center mb-2 mr-4">
                                    <input type="radio" id="radio-paper-3" value="3" name="paper_type" class="h-2 w-2 text-gray-600 px-2 py-2 border rounded mr-2">
                                    <label for="radio-paper-3" class="text-gray-600 text-sm">Review paper</label>
                                </div>
                                <div class="flex items-center mb-2">
                                    <input type="radio" id="radio-paper-4" value="4" name="paper_type" class="h-2 w-2 text-gray-600 px-2 py-2 border rounded mr-2">
                                    <label for="radio-paper-4" class="text-gray-600 text-sm	">Professional paper</label>
                                </div>
                            </div>
                        </div>

                        <!-- Paper contribution -->
                        <div class="mt-4">
                        <x-label for="contribution" :value="__('The paper containes a contribution to the scientific or professional area/discipline ?')" />
                            <div class="flex mt-1">
                                <div class="flex items-center mb-2 mr-4">
                                    <input type="radio" id="radio-contribution-1" value="0" name="contribution" class="h-2 w-2 text-gray-600 px-2 py-2 border rounded mr-2">
                                    <label for="radio-contribution-1" class="text-gray-600 text-sm">No</label>
                                </div>
                                <div class="flex items-center mb-2 mr-4">
                                    <input type="radio" id="radio-contribution-2" value="1" name="contribution" class="h-2 w-2 text-gray-600 px-2 py-2 border rounded mr-2">
                                    <label for="radio-contribution-2" class="text-gray-600 text-sm">Yes</label>
                                </div>
                            </div>
                        </div>

                        <!-- Paper interest -->
                        <div class="mt-4">
                        <x-label for="interest" :value="__('The paper is interesting for wide, narrow or very narrow circle of experts ?')" />
                            <div class="flex mt-1">
                                <div class="flex items-center mb-2 mr-4">
                                    <input type="radio" id="radio-interest-1" value="0" name="interest" class="h-2 w-2 text-gray-600 px-2 py-2 border rounded mr-2">
                                    <label for="radio-interest-1" class="text-gray-600 text-sm">Wide</label>
                                </div>
                                <div class="flex items-center mb-2 mr-4">
                                    <input type="radio" id="radio-interest-2" value="1" name="interest" class="h-2 w-2 text-gray-600 px-2 py-2 border rounded mr-2">
                                    <label for="radio-interest-2" class="text-gray-600 text-sm">Narrow</label>
                                </div>
                                <div class="flex items-center mb-2 mr-4">
                                    <input type="radio" id="radio-interest-3" value="2" name="interest" class="h-2 w-2 text-gray-600 px-2 py-2 border rounded mr-2">
                                    <label for="radio-interest-3" class="text-gray-600 text-sm">Very Narrow</label>
                                </div>
                            </div>
                        </div>

                        <!-- Paper structure -->
                        <div class="mt-4">
                        <x-label for="structure" :value="__('The paper has abstract, keywords, introduction, substantial part, conclusion and reference ?')" />
                            <div class="flex mt-1">
                                <div class="flex items-center mb-2 mr-4">
                                    <input type="radio" id="radio-structure-1" value="0" name="structure" class="h-2 w-2 text-gray-600 px-2 py-2 border rounded mr-2">
                                    <label for="radio-structure-1" class="text-gray-600 text-sm">No</label>
                                </div>
                                <div class="flex items-center mb-2 mr-4">
                                    <input type="radio" id="radio-structure-2" value="1" name="structure" class="h-2 w-2 text-gray-600 px-2 py-2 border rounded mr-2">
                                    <label for="radio-structure-2" class="text-gray-600 text-sm">Yes</label>
                                </div>
                            </div>
                        </div>

                        <!-- Paper supplementary -->
                        <div class="mt-4">
                        <x-label for="supplementary" :value="__('Figures, tables, and photographs are corresponding ?')" />
                            <div class="flex mt-1">
                                <div class="flex items-center mb-2 mr-4">
                                    <input type="radio" id="radio-supplementary-1" value="0" name="supplementary" class="h-2 w-2 text-gray-600 px-2 py-2 border rounded mr-2">
                                    <label for="radio-supplementary-1" class="text-gray-600 text-sm">No</label>
                                </div>
                                <div class="flex items-center mb-2 mr-4">
                                    <input type="radio" id="radio-supplementary-2" value="1" name="supplementary" class="h-2 w-2 text-gray-600 px-2 py-2 border rounded mr-2">
                                    <label for="radio-supplementary-2" class="text-gray-600 text-sm">Yes</label>
                                </div>
                            </div>
                        </div>

                        <!-- Paper terminology -->
                        <div class="mt-4">
                        <x-label for="terminology" :value="__('Terminology, style and language are corresponding ?')" />
                            <div class="flex mt-1">
                                <div class="flex items-center mb-2 mr-4">
                                    <input type="radio" id="radio-terminology-1" value="0" name="terminology" class="h-2 w-2 text-gray-600 px-2 py-2 border rounded mr-2">
                                    <label for="radio-terminology-1" class="text-gray-600 text-sm">No</label>
                                </div>
                                <div class="flex items-center mb-2 mr-4">
                                    <input type="radio" id="radio-terminology-2" value="1" name="terminology" class="h-2 w-2 text-gray-600 px-2 py-2 border rounded mr-2">
                                    <label for="radio-terminology-2" class="text-gray-600 text-sm">Yes</label>
                                </div>
                            </div>
                        </div>

                        <!-- Paper decision -->
                        <div class="mt-4">
                        <x-label for="decision" :value="__('Decision for this paper ?')" />
                            <div class="flex mt-1">
                                <div class="flex items-center mb-2 mr-4">
                                    <input type="radio" id="radio-decision-1" value="7" name="decision" class="h-2 w-2 text-gray-600 px-2 py-2 border rounded mr-2">
                                    <label for="radio-decision-1" class="text-gray-600 text-sm">Reject</label>
                                </div>
                                <div class="flex items-center mb-2 mr-4">
                                    <input type="radio" id="radio-decision-2" value="6" name="decision" class="h-2 w-2 text-gray-600 px-2 py-2 border rounded mr-2">
                                    <label for="radio-decision-2" class="text-gray-600 text-sm">Accept</label>
                                </div>
                                <div class="flex items-center mb-2 mr-4">
                                    <input type="radio" id="radio-decision-3" value="5" name="decision" class="h-2 w-2 text-gray-600 px-2 py-2 border rounded mr-2">
                                    <label for="radio-decision-3" class="text-gray-600 text-sm">Accept with Major Revision</label>
                                </div>
                                <div class="flex items-center mb-2 mr-4">
                                    <input type="radio" id="radio-decision-" value="4" name="decision" class="h-2 w-2 text-gray-600 px-2 py-2 border rounded mr-2">
                                    <label for="radio-decision-4" class="text-gray-600 text-sm">Accept with Minor Revision</label>
                                </div>
                            </div>
                        </div>

                        <p class="text-sm mt-4 inline-flex items-center px-4 color-white py-2 bg-gray-300 border border-transparent rounded-md font-semibold">
                            If any answer is "no", a commentary in the section "Reviewer's Comment" is obligatory.
                        </p>

                        <p class="text-sm mt-4 inline-flex items-center px-4 color-white py-2 bg-gray-300 border border-transparent rounded-md font-semibold">
                            If the paper is "accepted" conditionally (Minor or Major Revision), a commentary for all needed corrections of paper is obligatory. Write all comments in the section "Reviewer's Comment". 
                        </p>

                        <div class="mt-4">
                            <x-label for="comment" :value="__('Reviewer\'s Comment')" />

                            <textarea class="block mt-1 w-full" name="comment" value="old('comment')"></textarea>
                            <script>
                                CKEDITOR.replace( 'comment' );
                            </script>

                            <!--<x-input id="abstract" class="block mt-1 w-full" type="text" name="abstract" :value="old('abstract')" required autofocus />-->
                        </div>
                        
                        <!-- File question -->
                        <div class="mt-4">
                            <x-label for="file_question" :value="__('Do you want to submit a file ?')" />
                            <div class="flex mt-1">
                                <div class="flex items-center mb-2 mr-4">
                                    <input type="radio" id="radio-file-1" value="0" checked name="file_question" class="h-2 w-2 text-gray-700 px-2 py-2 border rounded mr-2">
                                    <label for="radio-file-1" class="text-gray-600 text-sm">No</label>
                                </div>
                                <div class="flex items-center mb-2">
                                    <input type="radio" id="radio-file-2" value="1" name="file_question" class="h-2 w-2 text-gray-700 px-2 py-2 border rounded mr-2">
                                    <label for="radio-file-2" class="text-gray-600 text-sm">Yes</label>
                                </div>
                            </div>
                        </div>

                        <script>
                            $(document).ready(function() {
                                $('#radio-file-2').click(function() {
                                    if ($('#radio-file-2').is(':checked')) { 
                                        $('.file_upload_div').addClass('block').removeClass('hidden'); 
                                    }else{
                                        alert("it's not checked YES");
                                        $('.file_upload_div').addClass('hidden').removeClass('block'); 
                                    }
                                });

                                $('#radio-file-1').click(function() {
                                    if ($('#radio-file-1').is(':checked')) { 
                                        $('.file_upload_div').addClass('hidden').removeClass('block'); 
                                    }else{
                                        $('.file_upload_div').addClass('block').removeClass('hidden'); 
                                    }
                                });

                            }); 
                        </script>

                        <!-- File -->
                        <div class="mt-4 hidden file_upload_div">
                            <x-label for="review_file" :value="__('File (.docx)')" />

                            <x-input id="review_file" class="block mt-1 w-full" type="file" name="review_file" :value="old('review_file')" autofocus />
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
</x-app-layout>
