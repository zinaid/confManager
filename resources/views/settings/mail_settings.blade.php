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
            <h4 class="mb-4">Submission mail</h4>
            <?php $loop_count = 0;?>
            @foreach ($mail_settings as $mail_setting)
                @if($mail_setting->type == 1)
                <?php $loop_count = $loop_count+1;?>
                    <div class="border-l-4 border-gray-500 p-4" role="alert">
                        <p class="mt-4">{!! $mail_setting->text !!}</p>
                    </div>
                @endif
            @endforeach
            @if($loop_count != 0)
                <form class="mb-4" method="POST" action="/add_mail_settings" align="right">
                        @csrf
                        <x-input id="type" class="block mt-1 w-full" type="hidden" name="type" value="1" required />
                        <x-input id="conference" class="block mt-1 w-full" type="hidden" name="conference" value="{{$conference}}" required />
                        <x-button class="bg-green-400">
                            {{ __('Edit') }}
                        </x-button>
                </form>
                @else
                <form class="mb-4" method="POST" action="/add_mail_settings" align="right">
                        @csrf
                        <x-input id="type" class="block mt-1 w-full" type="hidden" name="type" value="1" required />
                        <x-input id="conference" class="block mt-1 w-full" type="hidden" name="conference" value="{{$conference}}" required />
                        <x-button class="bg-green-400">
                            {{ __('Add') }}
                        </x-button>
                </form>
            @endif
            </div>
            <div class="p-6 bg-white border-b border-gray-200 mt-4">
            <h4 class="mb-4">Mail for Submission without Full Paper</h4>
            <?php $loop_count = 0;?>
            @foreach ($mail_settings as $mail_setting)
                @if($mail_setting->type == 9)
                <?php $loop_count = $loop_count+1;?>
                    <div class="border-l-4 border-gray-500 p-4" role="alert">
                        <p class="mt-4">{!! $mail_setting->text !!}</p>
                    </div>
                @endif
            @endforeach
            @if($loop_count != 0)
                <form class="mb-4" method="POST" action="/add_mail_settings" align="right">
                        @csrf
                        <x-input id="type" class="block mt-1 w-full" type="hidden" name="type" value="9" required />
                        <x-input id="conference" class="block mt-1 w-full" type="hidden" name="conference" value="{{$conference}}" required />
                        <x-button class="bg-green-400">
                            {{ __('Edit') }}
                        </x-button>
                </form>
                @else
                <form class="mb-4" method="POST" action="/add_mail_settings" align="right">
                        @csrf
                        <x-input id="type" class="block mt-1 w-full" type="hidden" name="type" value="9" required />
                        <x-input id="conference" class="block mt-1 w-full" type="hidden" name="conference" value="{{$conference}}" required />
                        <x-button class="bg-green-400">
                            {{ __('Add') }}
                        </x-button>
                </form>
            @endif
            </div>
            <div class="p-6 bg-white border-b border-gray-200 mt-4">
            <h4 class="mb-4">Mail to secretar after submission</h4>
            <?php $loop_count = 0;?>
            @foreach ($mail_settings as $mail_setting)
                @if($mail_setting->type == 2)
                <?php $loop_count = $loop_count+1;?>
                    <div class="border-l-4 border-gray-500 p-4" role="alert">
                        <p class="mt-4">{!! $mail_setting->text !!}</p>
                    </div>
                @endif
            @endforeach
            @if($loop_count != 0)
                <form class="mb-4" method="POST" action="/add_mail_settings" align="right">
                        @csrf
                        <x-input id="type" class="block mt-1 w-full" type="hidden" name="type" value="2" required />
                        <x-input id="conference" class="block mt-1 w-full" type="hidden" name="conference" value="{{$conference}}" required />
                        <x-button class="bg-green-400">
                            {{ __('Edit') }}
                        </x-button>
                </form>
                @else
                <form class="mb-4" method="POST" action="/add_mail_settings" align="right">
                        @csrf
                        <x-input id="type" class="block mt-1 w-full" type="hidden" name="type" value="2" required />
                        <x-input id="conference" class="block mt-1 w-full" type="hidden" name="conference" value="{{$conference}}" required />
                        <x-button class="bg-green-400">
                            {{ __('Add') }}
                        </x-button>
                </form>
            @endif
            </div>
            <div class="p-6 bg-white border-b border-gray-200 mt-4">
            <h4 class="mb-4">Mail from Secretar to Editor</h4>
            <?php $loop_count = 0;?>
            @foreach ($mail_settings as $mail_setting)
                @if($mail_setting->type == 3)
                <?php $loop_count = $loop_count+1;?>
                    <div class="border-l-4 border-gray-500 p-4" role="alert">
                        <p class="mt-4">{!! $mail_setting->text !!}</p>
                    </div> 
                @endif
            @endforeach
            @if($loop_count != 0)
                <form class="mb-4" method="POST" action="/add_mail_settings" align="right">
                        @csrf
                        <x-input id="type" class="block mt-1 w-full" type="hidden" name="type" value="3" required />
                        <x-input id="conference" class="block mt-1 w-full" type="hidden" name="conference" value="{{$conference}}" required />
                        <x-button class="bg-green-400">
                            {{ __('Edit') }}
                        </x-button>
                </form>
                @else
                <form class="mb-4" method="POST" action="/add_mail_settings" align="right">
                        @csrf
                        <x-input id="type" class="block mt-1 w-full" type="hidden" name="type" value="3" required />
                        <x-input id="conference" class="block mt-1 w-full" type="hidden" name="conference" value="{{$conference}}" required />
                        <x-button class="bg-green-400">
                            {{ __('Add') }}
                        </x-button>
                </form>
            @endif
            </div>
            <div class="p-6 bg-white border-b border-gray-200 mt-4">
            <h4 class="mb-4">Mail from Editor to Reviewer</h4>
            <?php $loop_count = 0;?>
            @foreach ($mail_settings as $mail_setting)
                @if($mail_setting->type == 4)
                <?php $loop_count = $loop_count+1;?>
                    <div class="border-l-4 border-gray-500 p-4" role="alert">
                        <p class="mt-4">{!! $mail_setting->text !!}</p>
                    </div>
                @endif
            @endforeach
            @if($loop_count != 0)
                <form class="mb-4" method="POST" action="/add_mail_settings" align="right">
                        @csrf
                        <x-input id="type" class="block mt-1 w-full" type="hidden" name="type" value="4" required />
                        <x-input id="conference" class="block mt-1 w-full" type="hidden" name="conference" value="{{$conference}}" required />
                        <x-button class="bg-green-400">
                            {{ __('Edit') }}
                        </x-button>
                </form>
                @else
                <form class="mb-4" method="POST" action="/add_mail_settings" align="right">
                        @csrf
                        <x-input id="type" class="block mt-1 w-full" type="hidden" name="type" value="4" required />
                        <x-input id="conference" class="block mt-1 w-full" type="hidden" name="conference" value="{{$conference}}" required />
                        <x-button class="bg-green-400">
                            {{ __('Add') }}
                        </x-button>
                </form>
            @endif
            </div>
            <div class="p-6 bg-white border-b border-gray-200 mt-4">
            <h4 class="mb-4">Mail from Reviewer to Edtior</h4>
            <?php $loop_count = 0;?>
            @foreach ($mail_settings as $mail_setting)
                @if($mail_setting->type == 5)
                <?php $loop_count = $loop_count+1;?>
                    <div class="border-l-4 border-gray-500 p-4" role="alert">
                        <p class="mt-4">{!! $mail_setting->text !!}</p>
                    </div>
                @endif
            @endforeach
            @if($loop_count != 0)
                <form class="mb-4" method="POST" action="/add_mail_settings" align="right">
                        @csrf
                        <x-input id="type" class="block mt-1 w-full" type="hidden" name="type" value="5" required />
                        <x-input id="conference" class="block mt-1 w-full" type="hidden" name="conference" value="{{$conference}}" required />
                        <x-button class="bg-green-400">
                            {{ __('Edit') }}
                        </x-button>
                </form>
                @else
                <form class="mb-4" method="POST" action="/add_mail_settings" align="right">
                        @csrf
                        <x-input id="type" class="block mt-1 w-full" type="hidden" name="type" value="5" required />
                        <x-input id="conference" class="block mt-1 w-full" type="hidden" name="conference" value="{{$conference}}" required />
                        <x-button class="bg-green-400">
                            {{ __('Add') }}
                        </x-button>
                </form>
            @endif
            </div>
            <div class="p-6 bg-white border-b border-gray-200 mt-4">
            <h4 class="mb-4">Mail from Editor to Technical Secretar</h4>
            <?php $loop_count = 0;?>
            @foreach ($mail_settings as $mail_setting)
                @if($mail_setting->type == 6)
                <?php $loop_count = $loop_count+1;?>
                    <div class="border-l-4 border-gray-500 p-4" role="alert">
                        <p class="mt-4">{!! $mail_setting->text !!}</p>
                    </div>
                @endif
            @endforeach
            @if($loop_count != 0)
                <form class="mb-4" method="POST" action="/add_mail_settings" align="right">
                        @csrf
                        <x-input id="type" class="block mt-1 w-full" type="hidden" name="type" value="6" required />
                        <x-input id="conference" class="block mt-1 w-full" type="hidden" name="conference" value="{{$conference}}" required />
                        <x-button class="bg-green-400">
                            {{ __('Edit') }}
                        </x-button>
                </form>
                @else
                <form class="mb-4" method="POST" action="/add_mail_settings" align="right">
                        @csrf
                        <x-input id="type" class="block mt-1 w-full" type="hidden" name="type" value="6" required />
                        <x-input id="conference" class="block mt-1 w-full" type="hidden" name="conference" value="{{$conference}}" required />
                        <x-button class="bg-green-400">
                            {{ __('Add') }}
                        </x-button>
                </form>
            @endif
            </div>
            <div class="p-6 bg-white border-b border-gray-200 mt-4">
            <h4 class="mb-4">Mail for Review response</h4>
            <?php $loop_count = 0;?>
            @foreach ($mail_settings as $mail_setting)
                @if($mail_setting->type == 7)
                <?php $loop_count = $loop_count+1;?>
                    <div class="border-l-4 border-gray-500 p-4" role="alert">
                        <p class="mt-4">{!! $mail_setting->text !!}</p>
                    </div>
                @endif
            @endforeach
            @if($loop_count != 0)
                <form class="mb-4" method="POST" action="/add_mail_settings" align="right">
                        @csrf
                        <x-input id="type" class="block mt-1 w-full" type="hidden" name="type" value="7" required />
                        <x-input id="conference" class="block mt-1 w-full" type="hidden" name="conference" value="{{$conference}}" required />
                        <x-button class="bg-green-400">
                            {{ __('Edit') }}
                        </x-button>
                </form>
                @else
                <form class="mb-4" method="POST" action="/add_mail_settings" align="right">
                        @csrf
                        <x-input id="type" class="block mt-1 w-full" type="hidden" name="type" value="7" required />
                        <x-input id="conference" class="block mt-1 w-full" type="hidden" name="conference" value="{{$conference}}" required />
                        <x-button class="bg-green-400">
                            {{ __('Add') }}
                        </x-button>
                </form>
            @endif
            </div>
            <div class="p-6 bg-white border-b border-gray-200 mt-4">
            <h4 class="mb-4">Mail for Administration Registration</h4>
            <?php $loop_count = 0;?>
            @foreach ($mail_settings as $mail_setting)
                @if($mail_setting->type == 8)
                <?php $loop_count = $loop_count+1;?>
                    <div class="border-l-4 border-gray-500 p-4" role="alert">
                        <p class="mt-4">{!! $mail_setting->text !!}</p>
                    </div>
                @endif
            @endforeach
            @if($loop_count != 0)
                <form class="mb-4" method="POST" action="/add_mail_settings" align="right">
                        @csrf
                        <x-input id="type" class="block mt-1 w-full" type="hidden" name="type" value="8" required />
                        <x-input id="conference" class="block mt-1 w-full" type="hidden" name="conference" value="{{$conference}}" required />
                        <x-button class="bg-green-400">
                            {{ __('Edit') }}
                        </x-button>
                </form>
                @else
                <form class="mb-4" method="POST" action="/add_mail_settings" align="right">
                        @csrf
                        <x-input id="type" class="block mt-1 w-full" type="hidden" name="type" value="8" required />
                        <x-input id="conference" class="block mt-1 w-full" type="hidden" name="conference" value="{{$conference}}" required />
                        <x-button class="bg-green-400">
                            {{ __('Add') }}
                        </x-button>
                </form>
            @endif
            </div>
        </div>
    </div>
</x-app-layout>
