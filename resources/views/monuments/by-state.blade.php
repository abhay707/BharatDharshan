@php
    /* Pre-compute shared vars before any section runs */
    $total       = $monumentsByType->flatten()->count();
    $typeOrder   = ['Fort','Temple','Stepwell','Cave','Palace','Mosque',
                    'Church','Stupa','Lake','Park','Memorial','Other'];
    $typeConfig  = [
        'Fort'     => ['icon' => '🏰', 'plural' => 'Forts'],
        'Temple'   => ['icon' => '🛕', 'plural' => 'Temples'],
        'Stepwell' => ['icon' => '🪜', 'plural' => 'Stepwells'],
        'Cave'     => ['icon' => '🗻', 'plural' => 'Caves'],
        'Palace'   => ['icon' => '🏛️', 'plural' => 'Palaces'],
        'Mosque'   => ['icon' => '🕌', 'plural' => 'Mosques'],
        'Church'   => ['icon' => '⛪', 'plural' => 'Churches'],
        'Stupa'    => ['icon' => '☸️', 'plural' => 'Stupas'],
        'Lake'     => ['icon' => '🌊', 'plural' => 'Lakes & Water Bodies'],
        'Park'     => ['icon' => '🌳', 'plural' => 'Parks & Wildlife'],
        'Memorial' => ['icon' => '🗿', 'plural' => 'Memorials'],
        'Other'    => ['icon' => '🏗️', 'plural' => 'Other Heritage Sites'],
    ];
    /* Types that actually have monuments, in canonical order */
    $presentTypes = collect($typeOrder)->filter(fn ($t) => $monumentsByType->has($t));
@endphp

@extends('layouts.app')

@section('title', 'Heritage of ' . $state->name . ' — Monuments & Sites')
@section('meta_description', 'Explore ' . $total . ' protected monuments in ' . $state->name .
    ' — ' . $presentTypes->map(fn($t) => ($typeConfig[$t]['plural'] ?? $t))->join(', ') . '.')

@push('styles')
<style>
/* ── Scroll helpers ─────────────────────────────────────── */
.scroll-hide                    { scrollbar-width: none; -ms-overflow-style: none; }
.scroll-hide::-webkit-scrollbar { display: none; }

/* ── Category badges ────────────────────────────────────── */
.bdg-UNESCO          { background: #DBEAFE; color: #1E40AF; }
.bdg-ASI             { background: #DCFCE7; color: #15803D; }
.bdg-Religious       { background: #FFF7ED; color: #C2410C; }
.bdg-Natural         { background: #CCFBF1; color: #0F766E; }
.bdg-State_Protected { background: #F1F5F9; color: #475569; }

/* ── Monument type placeholder gradients ────────────────── */
.ph-fort     { background: linear-gradient(135deg, #FFF8E7 0%, #FFE0B2 100%); }
.ph-temple   { background: linear-gradient(135deg, #FFF5F5 0%, #FFE4E1 100%); }
.ph-cave     { background: linear-gradient(135deg, #F5F5F4 0%, #D6D3D1 100%); }
.ph-lake     { background: linear-gradient(135deg, #F0F9FF 0%, #BAE6FD 100%); }
.ph-park     { background: linear-gradient(135deg, #F0FDF4 0%, #BBF7D0 100%); }
.ph-memorial { background: linear-gradient(135deg, #FAF5FF 0%, #DDD6FE 100%); }
.ph-stepwell { background: linear-gradient(135deg, #EFF6FF 0%, #BFDBFE 100%); }
.ph-other    { background: linear-gradient(135deg, #FFFBEB 0%, #FDE68A 100%); }

/* ── Jump nav pill (sidebar) ────────────────────────────── */
.jump-link {
    display: flex;
    align-items: center;
    gap: .5rem;
    padding: .45rem .85rem;
    border-radius: 9999px;
    font-size: .78rem;
    font-weight: 600;
    color: #57534E;
    border: 1px solid #E7E5E4;
    background: #fff;
    transition: background .15s ease, color .15s ease, border-color .15s ease;
    white-space: nowrap;
}
.jump-link:hover {
    background: var(--saffron);
    color: #fff;
    border-color: var(--saffron);
}

/* ── Monument card ──────────────────────────────────────── */
.mon-card { transition: transform .2s ease, box-shadow .2s ease; }
.mon-card:hover { transform: translateY(-5px); box-shadow: 0 16px 30px -6px rgba(0,0,0,.16); }

/* ── CTA button ─────────────────────────────────────────── */
.btn-cta { transition: opacity .18s ease, transform .15s ease; }
.btn-cta:hover { opacity: .87; transform: translateY(-1px); }

/* ── Sidebar section card ───────────────────────────────── */
.sidebar-card {
    background: #fff;
    border: 1px solid #E7E5E4;
    border-radius: 1rem;
    padding: 1.25rem;
}
</style>
@endpush

@section('content')

{{-- ════════════════════════════════════════════════════════
     HERO
     ════════════════════════════════════════════════════════ --}}
<section class="hero-gradient relative overflow-hidden">

    {{-- Mandala --}}
    <svg class="absolute -right-16 -top-16 opacity-[.08] pointer-events-none"
         width="360" height="360" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
        <g transform="translate(100,100)" fill="none" stroke="white" stroke-width=".5">
            @for($r = 1; $r <= 8; $r++)
                <circle cx="0" cy="0" r="{{ $r * 11 }}"/>
            @endfor
            @for($i = 0; $i < 24; $i++)
                <line x1="0" y1="8" x2="0" y2="84"
                      transform="rotate({{ $i * 15 }})" stroke-width=".3"/>
                <ellipse cx="0" cy="{{ 28 + ($i % 4) * 10 }}" rx="3" ry="5"
                         transform="rotate({{ $i * 15 }})"/>
            @endfor
            <circle cx="0" cy="0" r="5" fill="white" opacity=".2"/>
        </g>
    </svg>

    {{-- State watermark --}}
    <div class="absolute inset-0 flex items-center justify-end pr-16 pointer-events-none overflow-hidden">
        <span class="f-display font-black text-white select-none leading-none"
              style="font-size: 16rem; opacity: .04;">
            {{ mb_substr($state->name, 0, 1) }}
        </span>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-14 pb-10">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-1.5 text-xs text-white/50 mb-6 font-medium">
            <a href="{{ route('states.index') }}"
               class="hover:text-white/90 transition-colors">Home</a>
            <span class="opacity-40">/</span>
            <a href="{{ route('monuments.index') }}"
               class="hover:text-white/90 transition-colors">Heritage</a>
            <span class="opacity-40">/</span>
            <span class="text-white/75">{{ $state->name }}</span>
        </nav>

        <p class="text-white/60 text-xs font-bold uppercase tracking-[.22em] mb-3">
            {{ $state->region }} India
        </p>

        <h1 class="f-display text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-tight mb-3"
            style="text-shadow: 0 2px 20px rgba(0,0,0,.3)">
            Heritage of {{ $state->name }}
        </h1>

        <p class="text-white/75 text-base sm:text-lg mb-8">
            @if($total > 0)
                {{ $total }} protected monument{{ $total !== 1 ? 's' : '' }}
                across {{ $presentTypes->count() }} categor{{ $presentTypes->count() !== 1 ? 'ies' : 'y' }}
            @else
                Documented heritage sites &amp; protected monuments
            @endif
        </p>

        {{-- Type pills strip --}}
        @if($presentTypes->isNotEmpty())
        <div class="flex flex-wrap gap-2">
            @foreach($presentTypes as $type)
                @php $cfg = $typeConfig[$type] ?? ['icon' => '🏛️', 'plural' => $type . 's']; @endphp
                <a href="#sec-{{ strtolower($type) }}"
                   class="inline-flex items-center gap-1.5 bg-white/15 backdrop-blur-sm
                          border border-white/25 text-white text-xs font-semibold
                          px-3 py-1.5 rounded-full hover:bg-white/25 transition-colors">
                    {{ $cfg['icon'] }}
                    {{ $cfg['plural'] }}
                    <span class="opacity-65">({{ $monumentsByType[$type]->count() }})</span>
                </a>
            @endforeach
        </div>
        @endif

    </div>
</section>

{{-- ════════════════════════════════════════════════════════
     BODY: TWO-COLUMN
     ════════════════════════════════════════════════════════ --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-[240px_1fr] gap-8 xl:gap-12 items-start">

        {{-- ════════ SIDEBAR ════════ --}}
        <aside class="space-y-4 lg:sticky lg:top-24">

            {{-- State quick info --}}
            <div class="sidebar-card">
                <p class="text-[.65rem] font-bold uppercase tracking-widest text-stone-400 mb-3">
                    State Info
                </p>
                <div class="space-y-2.5">
                    @if($state->capital)
                    <div class="flex items-center gap-2.5">
                        <span class="w-6 h-6 rounded-md flex items-center justify-center text-sm shrink-0"
                              style="background: linear-gradient(135deg, #FFF7ED, #FFEDD5)">🏛</span>
                        <div>
                            <p class="text-[.62rem] text-stone-400 font-medium uppercase tracking-wide">Capital</p>
                            <p class="text-sm font-semibold text-stone-700">{{ $state->capital }}</p>
                        </div>
                    </div>
                    @endif
                    @if($state->region)
                    <div class="flex items-center gap-2.5">
                        <span class="w-6 h-6 rounded-md flex items-center justify-center text-sm shrink-0"
                              style="background: linear-gradient(135deg, #FFF7ED, #FFEDD5)">🗺</span>
                        <div>
                            <p class="text-[.62rem] text-stone-400 font-medium uppercase tracking-wide">Region</p>
                            <p class="text-sm font-semibold text-stone-700">{{ $state->region }} India</p>
                        </div>
                    </div>
                    @endif
                    @if($state->language)
                    <div class="flex items-center gap-2.5">
                        <span class="w-6 h-6 rounded-md flex items-center justify-center text-sm shrink-0"
                              style="background: linear-gradient(135deg, #FFF7ED, #FFEDD5)">🗣</span>
                        <div>
                            <p class="text-[.62rem] text-stone-400 font-medium uppercase tracking-wide">Language</p>
                            <p class="text-sm font-semibold text-stone-700">{{ Str::before($state->language, ',') }}</p>
                        </div>
                    </div>
                    @endif
                    @if($total > 0)
                    <div class="flex items-center gap-2.5 pt-1 border-t border-stone-100 mt-1">
                        <span class="w-6 h-6 rounded-md flex items-center justify-center text-sm shrink-0"
                              style="background: linear-gradient(135deg, var(--saffron), var(--red))">🏛️</span>
                        <div>
                            <p class="text-[.62rem] text-stone-400 font-medium uppercase tracking-wide">Monuments</p>
                            <p class="text-sm font-bold text-stone-700">{{ $total }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Link to state culture page --}}
            <div class="sidebar-card">
                <p class="text-[.65rem] font-bold uppercase tracking-widest text-stone-400 mb-3">
                    Explore {{ $state->name }}
                </p>
                <a href="{{ route('states.show', $state->slug) }}"
                   class="flex items-center justify-between gap-2 w-full py-2.5 px-3.5 rounded-xl
                          text-sm font-semibold text-stone-700 bg-stone-50 border border-stone-200
                          hover:border-orange-300 hover:bg-orange-50 hover:text-orange-700 transition-colors">
                    <span class="flex items-center gap-2">
                        <span>🎭</span> Culture &amp; Food
                    </span>
                    <svg class="w-4 h-4 shrink-0 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="{{ route('monuments.index') }}"
                   class="flex items-center justify-between gap-2 w-full py-2.5 px-3.5 rounded-xl mt-2
                          text-sm font-semibold text-stone-700 bg-stone-50 border border-stone-200
                          hover:border-orange-300 hover:bg-orange-50 hover:text-orange-700 transition-colors">
                    <span class="flex items-center gap-2">
                        <span>🗺️</span> All Heritage
                    </span>
                    <svg class="w-4 h-4 shrink-0 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            {{-- Jump nav --}}
            @if($presentTypes->isNotEmpty())
            <div class="sidebar-card">
                <p class="text-[.65rem] font-bold uppercase tracking-widest text-stone-400 mb-3">
                    Jump to Type
                </p>
                <div class="flex flex-col gap-1.5">
                    @foreach($presentTypes as $type)
                        @php $cfg = $typeConfig[$type] ?? ['icon' => '🏛️', 'plural' => $type . 's']; @endphp
                        <a href="#sec-{{ strtolower($type) }}" class="jump-link group">
                            <span>{{ $cfg['icon'] }}</span>
                            <span class="flex-1">{{ $cfg['plural'] }}</span>
                            <span class="ml-auto text-[.65rem] font-bold text-stone-400
                                         group-hover:text-white/70 transition-colors">
                                {{ $monumentsByType[$type]->count() }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

        </aside>

        {{-- ════════ MAIN CONTENT ════════ --}}
        <main class="min-w-0 space-y-14">

            @if($monumentsByType->isEmpty())

                {{-- Empty state --}}
                <div class="flex flex-col items-center py-24 text-center">
                    <span class="text-8xl mb-5 opacity-30 select-none">🏛️</span>
                    <h2 class="f-display text-2xl font-semibold text-stone-600 mb-2">
                        No monuments documented yet
                    </h2>
                    <p class="text-stone-400 text-sm max-w-xs mb-6">
                        Heritage data for {{ $state->name }} is being added. Check back soon.
                    </p>
                    <a href="{{ route('monuments.index') }}"
                       class="btn-cta inline-flex items-center gap-2 px-5 py-2.5 rounded-full
                              text-sm font-semibold text-white"
                       style="background: linear-gradient(135deg, var(--saffron), var(--red))">
                        Browse All Heritage
                    </a>
                </div>

            @else

                {{-- Type sections in canonical order --}}
                @foreach($presentTypes as $type)
                    @php
                        $monuments = $monumentsByType[$type];
                        $cfg       = $typeConfig[$type] ?? ['icon' => '🏛️', 'plural' => $type . 's'];
                        $sectionId = 'sec-' . strtolower($type);
                    @endphp

                    <section id="{{ $sectionId }}" class="scroll-mt-28">

                        {{-- Section heading --}}
                        <div class="flex items-center justify-between mb-5">
                            <div>
                                <h2 class="f-display text-2xl font-semibold text-stone-800 flex items-center gap-2">
                                    <span>{{ $cfg['icon'] }}</span>
                                    {{ $cfg['plural'] }}
                                    <span class="text-base font-normal text-stone-400 ml-1">
                                        ({{ $monuments->count() }})
                                    </span>
                                </h2>
                                <div class="saffron-rule mt-1.5 w-16"></div>
                            </div>
                        </div>

                        {{-- Horizontal scroll card row --}}
                        <div class="flex gap-5 overflow-x-auto scroll-hide pb-3 -mx-1 px-1">
                            @foreach($monuments as $m)
                                @php
                                    $imgUrl  = $m->getFirstMediaUrl('gallery');
                                    $phClass = match($m->type) {
                                        'Fort', 'Palace'                         => 'ph-fort',
                                        'Temple', 'Stupa', 'Mosque', 'Church'    => 'ph-temple',
                                        'Cave'                                   => 'ph-cave',
                                        'Lake'                                   => 'ph-lake',
                                        'Park'                                   => 'ph-park',
                                        'Memorial'                               => 'ph-memorial',
                                        'Stepwell'                               => 'ph-stepwell',
                                        default                                  => 'ph-other',
                                    };
                                    $catLabel = $m->category === 'State_Protected' ? 'State' : $m->category;
                                @endphp

                                <article class="card mon-card shrink-0 flex flex-col overflow-hidden group"
                                         style="width: 272px;">

                                    {{-- Image / placeholder --}}
                                    <div class="h-44 relative overflow-hidden flex items-center justify-center {{ $phClass }}">
                                        @if($imgUrl)
                                            <img src="{{ $imgUrl }}" alt="{{ $m->name }}"
                                                 class="absolute inset-0 w-full h-full object-cover
                                                        group-hover:scale-105 transition-transform duration-500">
                                        @else
                                            <svg class="absolute inset-0 w-full h-full" viewBox="0 0 280 176"
                                                 xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path d="M12,12 h14 M12,12 v14 M268,12 h-14 M268,12 v14
                                                         M12,164 h14 M12,164 v-14 M268,164 h-14 M268,164 v-14"
                                                      stroke="rgba(0,0,0,.08)" stroke-width="1.5"
                                                      fill="none" stroke-linecap="square"/>
                                                <path d="M96,148 L96,98 A44,44 0 0 1 184,98 L184,148"
                                                      stroke="rgba(0,0,0,.09)" stroke-width="1.5" fill="rgba(0,0,0,.02)"/>
                                                <line x1="72" y1="148" x2="208" y2="148"
                                                      stroke="rgba(0,0,0,.08)" stroke-width="1"/>
                                                <text x="140" y="132" text-anchor="middle" dominant-baseline="middle"
                                                      font-family="Georgia,serif" font-size="68" font-weight="bold"
                                                      fill="rgba(0,0,0,.05)" letter-spacing="-3">{{ mb_substr($m->name, 0, 1) }}</text>
                                                <text x="140" y="88" text-anchor="middle" dominant-baseline="middle"
                                                      font-family="Georgia,serif" font-size="10" font-weight="bold"
                                                      letter-spacing="3.5" fill="rgba(0,0,0,.22)">{{ strtoupper($m->type) }}</text>
                                            </svg>
                                        @endif

                                        {{-- Category badge --}}
                                        <span class="absolute top-3 left-3 text-xs font-bold px-2.5 py-0.5
                                                     rounded-full bdg-{{ $m->category }}">
                                            {{ $catLabel }}
                                        </span>

                                        @if($m->is_featured)
                                            <span class="absolute top-3 right-3 bg-yellow-400/95 text-yellow-900
                                                         text-xs font-bold px-2 py-0.5 rounded-full">★</span>
                                        @endif
                                    </div>

                                    {{-- Card body --}}
                                    <div class="p-4 flex-1 flex flex-col">
                                        <h3 class="f-display font-semibold text-stone-800 leading-snug mb-2
                                                   line-clamp-2 group-hover:text-orange-600 transition-colors">
                                            {{ $m->name }}
                                        </h3>

                                        <p class="text-xs text-stone-500 leading-relaxed line-clamp-2 flex-1">
                                            {{ $m->short_description }}
                                        </p>

                                        @if($m->built_by || $m->built_in_year)
                                        <p class="text-[.68rem] text-stone-400 mt-2 flex items-center gap-1">
                                            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <circle cx="12" cy="12" r="10" stroke-width="2"/>
                                                <polyline points="12 6 12 12 16 14"
                                                          stroke-width="2" stroke-linecap="round"/>
                                            </svg>
                                            @if($m->built_by)
                                                {{ $m->built_by }}
                                                @if($m->built_in_year), @endif
                                            @endif
                                            @if($m->built_in_year){{ $m->built_in_year }}@endif
                                        </p>
                                        @endif

                                        <a href="{{ route('monuments.show', $m->slug) }}"
                                           class="btn-cta mt-3.5 inline-flex items-center justify-center
                                                  gap-1.5 w-full py-2 rounded-xl text-xs font-semibold text-white"
                                           style="background: linear-gradient(135deg, var(--saffron) 0%, var(--red) 100%)">
                                            Explore
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </div>

                                </article>
                            @endforeach
                        </div>

                    </section>
                @endforeach

            @endif

        </main>

    </div>
</div>

@endsection
