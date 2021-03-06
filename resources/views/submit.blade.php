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
                @if($paper_counter < 2)
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
                    <form method="POST" action="/paper_submission" enctype="multipart/form-data">
                        @csrf

                        <!-- Title -->
                        <div>

                            <x-input id="conference" class="block mt-1 w-full" type="hidden" name="conference" value="{{$conference}}" required autofocus />
                        </div>

                        <!-- Title -->
                        <div>
                            <x-label for="title" :value="__('Paper Title')" />

                            <x-input id="title" class="block mt-1 w-full" type="text" name="title" placeholder="E.g. Rotation averaging algorithms" :value="old('title')" required autofocus />
                        </div>

                        <!-- Abstract -->
                        <div class="mt-4">
                            <x-label for="abstract" :value="__('Paper Abstract')" />

                            <textarea class="block mt-1 w-full" name="abstract" value="old('abstract')" required></textarea>
                            <script>
                                CKEDITOR.replace( 'abstract' );
                            </script>

                            <!--<x-input id="abstract" class="block mt-1 w-full" type="text" name="abstract" :value="old('abstract')" required autofocus />-->
                        </div>

                        <!-- Keywords -->
                        <div class="mt-4">
                            <x-label for="keywords" :value="__('Keywords')" />
                            <x-input id="keywords" class="block mt-1 w-full" type="text" placeholder="Algorithm, Rotation, Matrix" name="keywords" :value="old('keywords')" required autofocus />
                        </div>

                        <!-- Paper type -->
                        <div class="mt-4">
                        <x-label for="paper_type" :value="__('The paper is classified as')" />
                            <div class="flex mt-1">
                                <div class="flex items-center mb-2 mr-4">
                                    <input type="radio" id="radio-paper-1" value="0" name="paper_type" class="h-2 w-2 text-gray-600 px-2 py-2 border rounded mr-2">
                                    <label for="radio-paper-1" class="text-gray-600 text-sm">Original scientific paper</label>
                                </div>
                                <div class="flex items-center mb-2 mr-4">
                                    <input type="radio" id="radio-paper-2" value="1" name="paper_type" class="h-2 w-2 text-gray-600 px-2 py-2 border rounded mr-2">
                                    <label for="radio-paper-2" class="text-gray-600 text-sm">Preliminary notes</label>
                                </div>
                                <div class="flex items-center mb-2 mr-4">
                                    <input type="radio" id="radio-paper-3" value="3" name="paper_type" class="h-2 w-2 text-gray-600 px-2 py-2 border rounded mr-2">
                                    <label for="radio-paper-3" class="text-gray-600 text-sm">Subject review</label>
                                </div>
                                <div class="flex items-center mb-2">
                                    <input type="radio" id="radio-paper-4" value="4" name="paper_type" class="h-2 w-2 text-gray-600 px-2 py-2 border rounded mr-2">
                                    <label for="radio-paper-4" class="text-gray-600 text-sm	">Professional paper</label>
                                </div>
                            </div>
                        </div>

                        <!-- Paper student -->
                        <!--
                        <div class="mt-4">
                        <x-label for="paper_student" :value="__('Student paper')" />
                            <div class="flex mt-1">
                                <div class="flex items-center mb-2 mr-4">
                                    <input type="radio" id="radio-student-1" value="1" name="paper_student" class="h-2 w-2 text-gray-600 px-2 py-2 border rounded mr-2">
                                    <label for="radio-student-1" class="text-gray-600 text-sm">Yes</label>
                                </div>
                                <div class="flex items-center mb-2">
                                    <input type="radio" id="radio-student-2" value="0" name="paper_student" class="h-2 w-2 text-gray-600 px-2 py-2 border rounded mr-2">
                                    <label for="radio-student-2" class="text-gray-600 text-sm">No</label>
                                </div>
                            </div>
                        </div>
                        -->

                        <!-- Section -->
                        <div class="mt-4">
                        <x-label for="section" :value="__('Section')" />
                            <select id="section" name="section" class="block border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full mt-1 bg-white rounded outline-none" name="section"  required autofocus>
                            <option value="NULL" class="py-1 text-sm">Choose an option</option>
                                @foreach($sections as $section)
                                    <option value="{{$section->id}}" class="py-1 text-sm">{{$section->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <script>
                        $(document).ready(function() {
                            $("#section").change(function(e){
                                e.preventDefault();
                                var _token = $("input[name='_token']").val();
                                var section_id = $("#section").val();
                                $.ajax({
                                    url: "{{ route('ajax.topics') }}",
                                    type:'POST',
                                    data: {_token:_token, section:section_id},
                                    success: function(response) {
                                        var $select = $('#topic');
                                        $select.find('option').remove();
                                        $.each(response, function(i, item) {
                                            $select.append('<option class="text-sm" value='+response[i].id+'>'+response[i].name+'</option>');
                                        });
                                    }
                                });
                            });
                        }); 
                        </script>
                        <!-- Research topic -->
                        <div class="mt-4">
                        <x-label for="topic" :value="__('Research topic')" />
                            <select id="topic" name="topic" class="block border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full mt-1 bg-white rounded outline-none" name="title"  required autofocus>
                                <option value="NULL" class="py-1 text-sm">Choose an option</option>
                            </select>
                        </div>

                        <!-- Authors question -->
                        <div class="mt-4">
                            <x-label for="more_authors" :value="__('Are there any more authors')" />
                            <div class="flex mt-1">
                                <div class="flex items-center mb-2 mr-4">
                                    <input type="radio" id="radio-authors-1" value="0" checked name="more_authors" class="h-2 w-2 text-gray-700 px-2 py-2 border rounded mr-2">
                                    <label for="radio-authors-1" class="text-gray-600 text-sm">No</label>
                                </div>
                                <div class="flex items-center mb-2">
                                    <input type="radio" id="radio-authors-2" value="1" name="more_authors" class="h-2 w-2 text-gray-700 px-2 py-2 border rounded mr-2">
                                    <label for="radio-authors-2" class="text-gray-600 text-sm">Yes</label>
                                </div>
                            </div>
                        </div>
                        
                        <script>
                            $(document).ready(function() {
                                $('#radio-authors-2').click(function() {
                                    if ($('#radio-authors-2').is(':checked')) { 
                                        $('#author-number-div').addClass('block').removeClass('hidden'); 
                                    }else{
                                        alert("it's not checked YES");
                                        $('#author-number-div').addClass('hidden').removeClass('block'); 
                                    }
                                });

                                $('#radio-authors-1').click(function() {
                                    if ($('#radio-authors-1').is(':checked')) { 
                                        $('#author-number-div').addClass('hidden').removeClass('block'); 
                                    }else{
                                        $('#author-number-div').addClass('block').removeClass('hidden'); 
                                    }
                                });

                            }); 
                        </script>
                        
                        <!-- Author number -->
                        <div class="mt-4 hidden" id="author-number-div">
                            <x-label for="author_number" :value="__('How many authors')" />
                            <x-input id="author_number" class="block mt-1 w-full text-sm" type="number" max="5" name="author_number" :value="old('author_number')" autofocus />
                        </div>

                        <script>
                            $(document).ready(function() {
                                $("#author_number").on("keyup change", function(e) {
                                    var author_number = $("#author_number").val();
                                    $( "#div-for-authors" ).empty();
                                    var html;
                                    if(author_number > 5){
                                        alert("Maximum 6 authors (5 authors + corresponding author/submitter)");
                                        $("#author_number").val("0");
                                    }else{
                                        for(var i=0;i<author_number;i++){
                                            $("#div-for-authors").append('<div class="mt-4" id="author-number-div">'+
                                            '<h4>Autor '+(i+1)+'</h4>'+
                                            '<input id="author_name'+i+'" class="inline mr-1 mt-1 w-1/4 text-sm" type="text" placeholder="Author name" name="author_name'+i+'" autofocus></input>'+
                                            '<input id="author_lastname'+i+'" class="inline mr-1 mt-1 w-1/4 text-sm" type="text" placeholder="Author lastname" name="author_lastname'+i+'" autofocus></input>'+
                                            '<input id="author_email'+i+'" class="inline mr-1 mt-1 w-1/4 text-sm" type="text" placeholder="Author email" name="author_email'+i+'" autofocus></input>'+
                                            '<input id="author_affiliation'+i+'" class="inline mr-1 mt-1 w-1/4 text-sm" type="text" placeholder="Author affiliation" name="author_affiliation'+i+'" autofocus></input>'+
                                            '<input id="author_country'+i+'" class="inline mr-1 mt-1 w-1/4 text-sm" type="text" placeholder="Author country" name="author_country'+i+'" autofocus></input>'+
                                            '<input id="author_city'+i+'" class="inline mr-1 mt-1 w-1/4 text-sm" type="text" placeholder="Author city" name="author_city'+i+'" autofocus></input>'+
                                            '</div>');
                                        }
                                    }
                                })
                            }); 
                        </script>

                        <!-- Authors -->
                        <div class="mt-4" id="div-for-authors"></div>
                        
                        <!-- Full paper question -->
                        <div class="mt-4">
                            <x-label for="full_paper_question" :value="__('Do you want to submit full paper ?')" />
                            <div class="flex mt-1">
                                <div class="flex items-center mb-2 mr-4">
                                    <input type="radio" id="radio-fullpaper-1" value="0" checked name="full_paper_question" class="h-2 w-2 text-gray-700 px-2 py-2 border rounded mr-2">
                                    <label for="radio-fullpaper-1" class="text-gray-600 text-sm">No</label>
                                </div>
                                <div class="flex items-center mb-2">
                                    <input type="radio" id="radio-fullpaper-2" value="1" name="full_paper_question" class="h-2 w-2 text-gray-700 px-2 py-2 border rounded mr-2">
                                    <label for="radio-fullpaper-2" class="text-gray-600 text-sm">Yes</label>
                                </div>
                            </div>
                        </div>

                        <script>
                            $(document).ready(function() {
                                $('#radio-fullpaper-2').click(function() {
                                    if ($('#radio-fullpaper-2').is(':checked')) { 
                                        $('.file_upload_div').addClass('block').removeClass('hidden'); 
                                    }else{
                                        alert("it's not checked YES");
                                        $('.file_upload_div').addClass('hidden').removeClass('block'); 
                                    }
                                });

                                $('#radio-fullpaper-1').click(function() {
                                    if ($('#radio-fullpaper-1').is(':checked')) { 
                                        $('.file_upload_div').addClass('hidden').removeClass('block'); 
                                    }else{
                                        $('.file_upload_div').addClass('block').removeClass('hidden'); 
                                    }
                                });

                            }); 
                        </script>

                        <!-- File -->
                        <div class="mt-4 hidden file_upload_div">
                            <x-label for="paper_file" :value="__('File (.docx)')" />

                            <x-input id="paper_file" class="block mt-1 w-full" type="file" name="paper_file" :value="old('paper_file')" autofocus />
                        </div>

                        <p class="text-sm mt-4 inline-flex items-center px-4 color-white py-2 bg-gray-300 border border-transparent rounded-md font-semibold">
                            Clicking on submit you confirm that your paper is original and has not been previously presented in the submitted form at any conference or published in any scientific publications.
                        </p>
                        
                        <div class="flex items-center justify-end mt-4 mb-4">
                            <x-button class="ml-4">
                                {{ __('Save') }}
                            </x-button>
                        </div>
                    </form>
                @else
                <div class="mt-4 mx-auto sm:px-6 lg:px-8">
                    You already have 2 submited papers. 
                    <form class="mt-4 mb-4" method="GET" action="/papers">
                        @csrf
                        <x-button>
                            {{ __('See papers') }}
                        </x-button>
                    </form>
                @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
