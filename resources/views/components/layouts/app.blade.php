<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="{{ asset('favicon.png') }}">

        <x-layouts.meta />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">

        <script defer src="https://unpkg.com/@alpinejs/ui@3.14.1-beta.0/dist/cdn.min.js"></script>
        {{-- <script defer src="https://unpkg.com/@alpinejs/collapse@3.14.1/dist/cdn.min.js"></script>
        <script defer src="https://unpkg.com/alpinejs@3.14.1/dist/cdn.min.js"></script> --}}

        <x-bunny-fonts />
        @livewireStyles()
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body
        class="bg-primary-background flex flex-col min-h-screen"
        x-data="{ modal: null }"
        x-bind:class="{
            'overflow-hidden': modal !== null,
        }"
    >
        <header class="bg-white py-6 border-b border-primary-border">
            <nav class="w-full px-6 md:px-10 2xl:px-24 flex items-center justify-between">
                <a href="{{ route('index') }}" class="font-medium text-black text-xl flex items-center gap-x-4 md:gap-x-6">
                    <x-icon class="size-5 md:size-auto" />
                    <p class="font-semibold md:font-bold text-sm">Constituency Explorer</p>
                </a>

                <div class="flex items-center lg:gap-x-2.5">
                    <button
                        type="button"
                        class="appearance-none text-black font-medium hover:bg-black/5 px-2.5 lg:px-4 py-2 rounded-lg transition-colors ease-in-out duration-200"
                        x-on:click="modal = 'about'"
                    >
                        <span class="hidden lg:inline">About</span>
                        <x-icons.question-mark-circle class="size-5 lg:hidden" />
                    </button>

                    {{-- <button type="button" class="appearance-none text-black font-medium hover:bg-black/5 px-2.5 lg:px-4 py-2 rounded-lg transition-colors ease-in-out duration-200" x-on:click="modal = 'download'">
                        <span class="hidden lg:inline">Download</span>
                        <x-icons.download class="size-4 lg:hidden" />
                    </button> --}}
                </div>
            </nav>
        </header>

        <main class="flex-1">
            {{ $slot }}
        </main>

        <footer class="bg-white py-6 px-6 md:px-10 2xl:px-24">
            <p class="text-xs text-muted-foreground">Constituency Explorer is a collaborative project between Campaign Lab and C6 Digital.</p>
        </footer>

        <div class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-show="modal !== null" x-cloak>
            <div
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                x-show="modal !== null"
            ></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                    <x-modal id="about" class="max-w-lg">
                        <h3 class="font-semibold tracking-tight text-xl">
                            About
                        </h3>

                        <div class="mt-4 space-y-2.5 text-sm text-neutral-700">
                            <p>Constituency Explorer is an exploratory project between Campaign Lab and C6 Digital.</p>

                            <p>We believe that it can help people run better local campaigns, by using local data.</p>

                            <p>We have started with the data sets that we think are useful / easy to obtain and are currently in consultation with friends & colleagues to get their feedback.  If you have any feedback please let us know by emailing me (Jack): <a href="mailto:jack@c6digital.io" target="_blank">jack@c6digital.io</a></p>

                            <p>The data has been mapped to the new constituencies using various resources:</p>

                            <ul class="space-y-2.5 list-disc pl-4">
                                <li><a href="https://postcodes.io/" target="_blank" class="underline font-medium">postcodes.io</a>: API service that returns geo data for a postcode</li>
                                <li><a href="https://mapped.commonknowledge.coop/" target="_blank" class="underline font-medium">Mapped by Common Knowledge</a>: A great tool for uploading your postcodes and bulk returning data from postcodes.io</li>
                                <li><a href="https://pages.mysociety.org/2025-constituencies/postcode-converter" target="_blank" class="underline font-medium">MySociety converter</a>: Another great tool for uploading postcodes and bulk converting data using local data source (very fast!)</li>
                            </ul>
                        </div>
                    </x-modal>

                    <x-modal id="download" class="max-w-lg">
                        <h3 class="font-semibold tracking-tight text-xl">
                            Download
                        </h3>

                        <div class="mt-4 space-y-2.5 text-sm text-neutral-700">
                            <p>Lorem ipsum odor amet, consectetuer adipiscing elit. Proin inceptos dignissim sagittis himenaeos ipsum pulvinar facilisi porttitor? Tempor nec ex nostra pretium aenean eget metus. Orci facilisis malesuada; lacus pulvinar lacinia venenatis. Leo placerat non lacus montes gravida sodales elit ultrices hac. Vehicula aptent hac aliquam, sagittis accumsan risus. Iaculis placerat vivamus convallis rhoncus cursus magnis eu. Maximus primis molestie consectetur orci pretium egestas.</p>

                            <p>Magna lectus maecenas ac enim dignissim hendrerit hendrerit egestas duis. Per eget consectetur proin mus venenatis libero donec imperdiet. Curabitur rutrum tempus class pretium magnis cursus torquent. Eleifend sodales nam taciti netus pulvinar cras purus. Sociosqu quisque nisi laoreet purus elementum pellentesque. Molestie at class dignissim nullam duis odio fermentum. Rhoncus dui ullamcorper natoque ornare natoque diam.</p>
                        </div>
                    </x-modal>
                </div>
            </div>
        </div>

        @livewireScriptConfig()
    </body>
</html>
