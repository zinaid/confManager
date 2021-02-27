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
            <h4 class="mb-4">List of Technical Directors</h4>
            <?php $loop_count = 0;?>
            @foreach ($users as $user)
                @if($user->permission == 2)
                <?php $loop_count = $loop_count+1;?>
                    <div class="border-l-4 border-gray-500 p-4" role="alert">
                        <p class="font-bold">Technical Director {{ $loop_count }}.</p>
                        <p class="mt-4">{{ $user->name }} {{ $user->lastname }}</p>
                    </div>
                @endif
            @endforeach
            <form class="mb-4" method="POST" action="/add_administration" align="right">
                    @csrf
                    <x-input id="permission" class="block mt-1 w-full" type="hidden" name="permission" value="2" required />
                    <x-input id="conference" class="block mt-1 w-full" type="hidden" name="conference" value="{{$conference}}" required />
                    <x-button class="bg-green-400">
                        {{ __('Add') }}
                    </x-button>
            </form>
            </div>
            <div class="p-6 bg-white border-b border-gray-200 mt-4">
            <h4 class="mb-4">List of Editors</h4>
            <?php $loop_count = 0;?>
            @foreach ($users as $user)
                @if($user->permission == 3)
                <?php $loop_count = $loop_count+1;?>
                    <div class="border-l-4 border-gray-500 p-4" role="alert">
                        <p class="font-bold">Editor  {{ $loop_count }}.</p>
                        <p class="mt-4"> {{ $user->name }} {{ $user->lastname }}</p>
                    </div>
                @endif
            @endforeach
            <form class="mb-4" method="POST" action="/add_administration" align="right">
                    @csrf
                    <x-input id="permission" class="block mt-1 w-full" type="hidden" name="permission" value="3" required />
                    <x-input id="conference" class="block mt-1 w-full" type="hidden" name="conference" value="{{$conference}}" required />
                    <x-button class="bg-green-400">
                        {{ __('Add') }}
                    </x-button>
            </form>
            </div>
            <div class="p-6 bg-white border-b border-gray-200 mt-4">
            <h4 class="mb-4">List of Reviewers</h4>
            <?php $loop_count = 0;?>
            @foreach ($users as $user)
                @if($user->permission == 4)
                <?php $loop_count = $loop_count+1;?>
                    <div class="border-l-4 border-gray-500 p-4" role="alert">
                        <p class="font-bold">Reviewer {{ $loop_count }}.</p>
                        <p class="mt-4"> {{ $user->name }} {{ $user->lastname }}</p>
                    </div>
                @endif
            @endforeach
            <form class="mb-4" method="POST" action="/add_administration" align="right">
                    @csrf
                    <x-input id="permission" class="block mt-1 w-full" type="hidden" name="permission" value="4" required />
                    <x-input id="conference" class="block mt-1 w-full" type="hidden" name="conference" value="{{$conference}}" required />
                    <x-button class="bg-green-400">
                        {{ __('Add') }}
                    </x-button>
            </form>
            </div>
        </div>
    </div>
</x-app-layout>
