<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
        <?xml version="1.0" encoding="utf-8"?>
        <svg viewBox="5198.421 827.429 8864.188 7905.149" height="300px" width="300px" xmlns="http://www.w3.org/2000/svg" xmlns:bx="https://boxy-svg.com">
          <defs>
            <clipPath id="id0">
              <path d="M19264 9262l-2 -9262 -19262 0 0 9263 19264 -1z" id="svg_2"/>
            </clipPath>
            <clipPath id="id2">
              <path d="M19264 9262l-2 -9262 -19262 0 0 9263 19264 -1z" id="svg_4"/>
            </clipPath>
            <style bx:fonts="Bahnschrift">@font-face { font-family: Bahnschrift; font-variant: normal; font-style: normal; }</style>
            <style type="text/css">.str2 { stroke: rgb(114, 114, 113); stroke-width: 20; }
              .str1 { stroke: rgb(114, 114, 113); stroke-width: 7.62; }
              .str0 { stroke: rgb(114, 114, 113); stroke-width: 9.28; }
              .str18 { stroke: rgb(114, 114, 113); stroke-width: 10.11; }
              .str4 { stroke: rgb(114, 114, 113); stroke-width: 10.11; }
              .str3 { stroke: rgb(254, 254, 254); stroke-width: 10.11; }
              .str19 { stroke: rgb(114, 114, 113); stroke-width: 10.11; }
              .str20 { stroke: rgb(114, 114, 113); stroke-width: 10.11; }
              .str17 { stroke: rgb(114, 114, 113); stroke-width: 10.11; }
              .str23 { stroke: rgb(114, 114, 113); stroke-width: 10.11; }
              .str22 { stroke: rgb(254, 254, 254); stroke-width: 10.11; }
              .str13 { stroke: rgb(114, 114, 113); stroke-width: 10.11; }
              .str15 { stroke: rgb(114, 114, 113); stroke-width: 10.11; }
              .str12 { stroke: rgb(114, 114, 113); stroke-width: 10.11; }
              .str9 { stroke: rgb(114, 114, 113); stroke-width: 10.11; }
              .str6 { stroke: rgb(114, 114, 113); stroke-width: 10.11; }
              .str7 { stroke: rgb(114, 114, 113); stroke-width: 10.11; }
              .str14 { stroke: rgb(114, 114, 113); stroke-width: 10.11; }
              .str5 { stroke: rgb(114, 114, 113); stroke-width: 10.11; }
              .str10 { stroke: rgb(114, 114, 113); stroke-width: 10.11; }
              .str11 { stroke: rgb(114, 114, 113); stroke-width: 10.11; }
              .str21 { stroke: rgb(254, 254, 254); stroke-width: 10.11; }
              .str16 { stroke: rgb(114, 114, 113); stroke-width: 10.11; }
              .str8 { stroke: rgb(114, 114, 113); stroke-width: 10.11; }
              .fil4 { fill: none; }
              .fil0 { fill: rgb(254, 254, 254); }
              .fil5 { fill: rgb(114, 114, 113); }
              .fil1 { fill: rgb(91, 91, 91); }
              .fil2 { fill: rgb(74, 195, 215); }
              .fil3 { fill: rgb(114, 114, 113); fill-rule: nonzero; }
              .fnt2 { font-weight: normal; font-size: 282.22px; font-family: Bahnschrift; }
              .fnt3 { font-weight: normal; font-size: 493.89px; font-family: Bahnschrift; }
              .fnt0 { font-weight: normal; font-size: 4516px; font-family: Bahnschrift; }
              .fnt1 { font-weight: bold; font-size: 4516px; font-family: Bahnschrift; }
              </style>
          </defs>
          <g class="currentLayer" style="">
            <title>Layer 1</title>
            <g style="clip-path:url(#id0)" id="svg_7" class=""/>
            <g style="clip-path:url(#id2)" id="svg_10" class=""/>
            <g id="_2241994942848" class="selected">
              <polygon class="fil0" points="8841.5,1355.4285888671875 9253.5,827.4285888671875 9253.5,3930.428466796875 8841.5,3930.428466796875 " id="svg_13"/>
              <path class="fil0" d="M10741.5,837.4285755157471 l-592,3093 c0,0 503,0 503,0 c0,0 458,-2407 458,-2407 l575,250 c0,0 0,1054 0,1054 c137,0 274,0 412,0 c0,0 0,-1054 0,-1054 l574,-250 c0,0 458,2407 458,2407 c0,0 503,0 503,0 l-592,-3093 l-943,411 l0,-356 l-412,0 l0,356 l-944,-411 z" id="svg_14"/>
              <path class="fil0" d="M5629.5,3930.428575515747 l479,0 l0,-390 l975,-617 l569,1007 l455,0 l-861,-1591 l-658,393 l1183,-1513 l0,-382 l-2142,0 l0,3093 zm479,-1272 l1,-1413 l1102,0 c0,0 -1103,1413 -1103,1413 z" id="svg_15"/>
            </g>
            <text x="1198.4285497665405" y="7801.5736627578735" class="fil1 fnt0 selected" id="svg_18" transform="matrix(1,0,0,1,3999.99951171875,-14.285712242126465) " style="white-space: pre;">20</text>
            <text x="10227.965103149414" y="7801.569200515747" class="fil2 fnt1 selected" id="svg_19" style="white-space: pre;">21</text>
            <g class="" id="svg_132"/>
          </g>
        </svg>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <!--@if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif-->

                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                    {{ __('Register') }}
                </a>

                <x-button class="ml-3">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
