<x-layouts.app>
    <div x-data="{ tab: 3 }">
        <div class="bg-white pt-12 px-24 constituency-tabs">
            <h1 class="text-4xl font-bold tracking-tight">
                {{ $constituency->name }}
            </h1>

            <p class="uppercase text-black/50 text-sm mt-4 font-bold tracking-tight">
                Westminster Parliamentary Constituency
            </p>

            <x-tabs.host class="mt-12">
                <x-tabs.tab :i="-1" active>
                    Overview
                </x-tabs.tab>

                <x-tabs.tab :i="0">
                    General
                </x-tabs.tab>

                <x-tabs.tab :i="1">
                    Local Authorities
                </x-tabs.tab>

                <x-tabs.tab :i="2">
                    Towns
                </x-tabs.tab>

                <x-tabs.tab :i="3">
                    Charities
                </x-tabs.tab>

                @if($constituency->dentists->isNotEmpty())
                    <x-tabs.tab :i="4">
                        Dentists
                    </x-tabs.tab>
                @endif

                @if($constituency->hospitals->isNotEmpty())
                    <x-tabs.tab :i="5">
                        Hospitals
                    </x-tabs.tab>
                @endif

                @if($constituency->schools->isNotEmpty())
                    <x-tabs.tab :i="6">
                        Schools
                    </x-tabs.tab>
                @endif
            </x-tabs.host>
        </div>

        <div class="flex flex-col py-12 px-24 [&_div]:prose [&_div]:max-w-none">
            <div x-show="tab === -1" class="not-prose">
                <x-stats.wrapper>
                    <x-stats.simple label="No. Local Authorities">
                        {{ $constituency->localAuthorities->count() }}
                    </x-stats.simple>

                    <x-stats.simple label="No. Towns">
                        {{ $constituency->towns->count() }}
                    </x-stats.simple>

                    <x-stats.simple label="No. Charities">
                        {{ $constituency->charities->count() }}
                    </x-stats.simple>

                    <x-stats.simple label="No. Dentists">
                        {{ $constituency->dentists->count() }}
                    </x-stats.simple>

                    <x-stats.simple label="No. Schools">
                        {{ $constituency->schools->count() }}
                    </x-stats.simple>
                </x-stats.wrapper>
            </div>

            <div x-show="tab === 0" x-cloak>
                <section class="bg-white p-4 border rounded-md border-neutral-300">
                    <ul class="!mt-0">
                        @foreach ($constituency->getAttributes() as $key => $value)
                            <li><strong>{{ $key }}:</strong> {{ $value }}</li>
                        @endforeach
                    </ul>
                </section>

                @if($constituency->oldConstituencies->isNotEmpty())
                    <h2>
                        Old Constituency Overlaps
                    </h2>

                    @foreach($constituency->oldConstituencies as $oldConstituency)
                        <x-disclosure-accordion :title="$oldConstituency->name" class="bg-white">
                            <dl class="space-y-1">
                                @foreach($oldConstituency->pivot->getAttributes() as $key => $value)
                                    <div class="space-y-0">
                                        <dt>{{ $key }}</dt>
                                        <dd>{{ $value }}</dd>
                                    </div>
                                @endforeach
                            </dl>
                        </x-disclosure-accordion>
                    @endforeach
                @endif
            </div>

            <div x-show="tab === 1" x-cloak>
                @foreach ($constituency->localAuthorities as $localAuthority)
                    <section class="bg-white p-4 mb-4 border border-neutral-300 rounded-md">
                        <h3 class="!mt-0">{{$localAuthority->name}}</h3>
                        @foreach ($localAuthority->getAttributes() as $key => $value)
                            <li><strong>{{ $key }}:</strong> {{ $value }}</li>
                        @endforeach
                        <h4>Relationship data:</h4>
                        @foreach ($localAuthority->pivot->getAttributes() as $key => $value)
                            <li><strong>{{ $key }}:</strong> {{ $value }}</li>
                        @endforeach
                    </section>
                @endforeach
            </div>

            <div x-show="tab === 2" x-cloak>
                @foreach ($constituency->towns->sortBy('name', SORT_NATURAL) as $town)
                    <section class="bg-white p-4 mb-4 border border-neutral-300 rounded-md">
                        <h3 class="!my-0">{{ $town->name }}</h3>
                    </section>
                @endforeach
            </div>

            <div x-show="tab === 3" x-cloak>
                <div class="rounded-lg border border-neutral-300 overflow-hidden">
                    <table class="bg-white">
                        <thead>
                            <tr class="[&_th]:text-left [&_th]:px-4 [&_th]:whitespace-nowrap [&_th]:py-2.5">
                                <th>Name</th>
                                <th>No. volunteers</th>
                                <th>Income (£)</th>
                                <th>Spending (£)</th>
                                <th>Address</th>
                                <th class="w-[40px]"></th>
                            </tr>
                        </thead>
                        <tbody x-data="{
                            state: {},
                            toggle(i) {
                                this.state[i] = !this.state[i];
                            }
                        }" class="[&_td]:px-4">
                            @foreach($constituency->charities->sortBy('name', SORT_NATURAL) as $i => $charity)
                                <tr class="cursor-pointer hover:bg-neutral-50/50 [&_td]:align-middle" x-on:click="toggle(@js($i))" title="{{ $charity->name }}">
                                    <td class="font-medium">{{ $charity->name }}</td>
                                    <td>{{ $charity->volunteers ? number_format($charity->volunteers) : App\mdash() }}</td>
                                    <td>{{ number_format($charity->income) }}</td>
                                    <td>{{ number_format($charity->spending) }}</td>
                                    <td>{{ $charity->formattedAddress() }}</td>
                                    <td>
                                        <button type="button" class="h-full flex items-center" x-on:click.stop="toggle(@js($i))">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>

                                <tr x-show="!!state[@js($i)]" class="bg-neutral-50/75" x-cloak>
                                    <td colspan="6">
                                        <div class="grid grid-cols-5 gap-x-2.5 gap-y-5 [&_p]:not-prose py-2.5">
                                            <div>
                                                <p class="font-medium text-sm !my-0">Ward</p>
                                                <p class="text-sm !mb-0 !mt-2">{{ $charity->ward }}</p>
                                            </div>

                                            <div>
                                                <p class="font-medium text-sm !my-0">Registered Date</p>
                                                <p class="text-sm !mb-0 !mt-2">{{ $charity->registered?->format('d/m/Y') ?? App\mdash() }}</p>
                                            </div>

                                            <div>
                                                <p class="font-medium text-sm !my-0">Funders</p>
                                                <p class="text-sm !mb-0 !mt-2">{{ $charity->funders ? number_format($charity->funders) : App\mdash() }}</p>
                                            </div>

                                            <div>
                                                <p class="font-medium text-sm !my-0">Email</p>
                                                <p class="text-sm !mb-0 !mt-2">{{ $charity->email ?? App\mdash() }}</p>
                                            </div>

                                            <div>
                                                <p class="font-medium text-sm !my-0">Phone</p>
                                                <p class="text-sm !mb-0 !mt-2">{{ $charity->phone ?? App\mdash() }}</p>
                                            </div>

                                            <div>
                                                <p class="font-medium text-sm !my-0">Website</p>
                                                <p class="text-sm !mb-0 !mt-2">{{ $charity->website ?? App\mdash() }}</p>
                                            </div>

                                            <div>
                                                <p class="font-medium text-sm !my-0">Facebook</p>
                                                <p class="text-sm !mb-0 !mt-2">{{ $charity->facebook ?? App\mdash() }}</p>
                                            </div>

                                            <div>
                                                <p class="font-medium text-sm !my-0">Instagram</p>
                                                <p class="text-sm !mb-0 !mt-2">{{ $charity->instagram ?? App\mdash() }}</p>
                                            </div>

                                            <div>
                                                <p class="font-medium text-sm !my-0">Twitter / X</p>
                                                <p class="text-sm !mb-0 !mt-2">{{ $charity->twitter ?? App\mdash() }}</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div x-show="tab === 4" x-cloak>
                @foreach ($constituency->dentists->sortBy('name', SORT_NATURAL) as $dentist)
                    <x-disclosure-accordion title="{{ $dentist->name }}" class="bg-white">
                        <ul>
                            <li><strong>Address:</strong> {{ implode(', ', array_filter($dentist->address)) }}</li>
                        </ul>
                    </x-disclosure-accordion>
                @endforeach
            </div>

            <div x-show="tab === 5" x-cloak>
                @foreach ($constituency->hospitals->sortBy('name', SORT_NATURAL) as $hospital)
                    <x-disclosure-accordion title="{{ $hospital->name }}" class="bg-white">
                        <ul>
                            <li><strong>Address:</strong> {{ implode(', ', array_filter($hospital->address)) }}</li>
                        </ul>
                    </x-disclosure-accordion>
                @endforeach
            </div>

            <div x-show="tab === 6" x-cloak>
                @foreach ($constituency->schools->sortBy('name', SORT_NATURAL) as $school)
                    <x-disclosure-accordion title="{{ $school->name }}" class="bg-white">
                        <ul>
                            @foreach($school->getAttributes() as $key => $value)
                                <li><strong>{{ $key }}:</strong> {{ $value }}</li>
                            @endforeach
                        </ul>
                    </x-disclosure-accordion>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.app>
