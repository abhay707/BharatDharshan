@extends('layouts.app')
@section('title', ($monument->name ?? 'Monument') . ' · Bharatdarshan')
@section('body_class', 'page-dark')

@section('styles')
<style>
  a { color: inherit; text-decoration: none; }
  img { display: block; max-width: 100%; }

  /* ============ HERO ============ */
  @php
    $heroGradients = [
      'Fort'     => 'linear-gradient(160deg,#C9901A 0%,#E8580A 25%,#8B1A1A 55%,#4A0404 80%,#0D0500 100%)',
      'Temple'   => 'linear-gradient(160deg,#8B1A1A 0%,#4A0404 30%,#1A0500 70%,#0D0500 100%)',
      'Palace'   => 'linear-gradient(160deg,#E8580A 0%,#C9901A 30%,#8B1A1A 65%,#0D0500 100%)',
      'Cave'     => 'linear-gradient(160deg,#1B4F8A 0%,#0D2A50 40%,#0D0500 80%,#0D0500 100%)',
      'Memorial' => 'linear-gradient(160deg,#1B4F8A 0%,#2D6A4F 40%,#1A0A00 75%,#0D0500 100%)',
      'Mosque'   => 'linear-gradient(160deg,#2D6A4F 0%,#1B4F8A 35%,#0D2030 70%,#0D0500 100%)',
      'Stupa'    => 'linear-gradient(160deg,#C9901A 0%,#8B6914 35%,#4A3000 70%,#0D0500 100%)',
      'Stepwell' => 'linear-gradient(160deg,#0D4A3A 0%,#1B4F8A 40%,#0D2030 75%,#0D0500 100%)',
    ];
    $heroGradient = $heroGradients[$monument->type] ?? 'linear-gradient(160deg,#8B1A1A 0%,#4A0404 40%,#1A0500 75%,#0D0500 100%)';

    $landscapeImages = [
      'amber-fort'               => '/images/Heritage/Amber Fort Landscape.jpg',
      'bekal-fort'               => '/images/Heritage/Bekal Fort Image Landscape.jpg',
      'brihadeeswarar-temple'    => '/images/Heritage/Brihadeeswarar Temple landscape.jpg',
      'dakshineswar-kali-temple' => '/images/Heritage/Dakshineswar Kali Temple Landscape.jpg',
      'golden-temple'            => '/images/Heritage/Golden Temple Image Landscape.jpg',
      'hawa-mahal'               => '/images/Heritage/Hawa Mahal Landscape.jpg',
      'padmanabhapuram-palace'   => '/images/Heritage/Padmanabhapuram Palace Landscape.jpg',
      'qila-mubarak-patiala'     => '/images/Heritage/Qila Mubarak Patiala Landspace.jpg',
      'shore-temple-mahabalipuram' => '/images/Heritage/Shore Temple Mahabalipuram Landscape.jpg',
      'victoria-memorial'        => '/images/Heritage/Victoria Memorial Image Landscape.jpg',
    ];
    $heroImg = $landscapeImages[$monument->slug] ?? null;
  @endphp

  .hero {
    position: relative;
    min-height: 100vh;
    width: 100%;
    overflow: hidden;
    background-color: #0D0500;
    @if($heroImg)
    background-image:
      linear-gradient(to top, rgba(13,5,0,0.95) 0%, rgba(13,5,0,0.6) 40%, rgba(13,5,0,0.2) 100%),
      url('{{ $heroImg }}');
    background-size: cover;
    background-position: center 35%;
    @else
    background: {{ $heroGradient }};
    @endif
    color: #fff;
    display: flex; flex-direction: column; justify-content: flex-end;
  }
  .hero::before {
    content: "";
    position: absolute; inset: 0;
    background:
      radial-gradient(ellipse at 70% 40%, rgba(255,200,120,0.18), transparent 55%),
      radial-gradient(ellipse at 20% 90%, rgba(0,0,0,0.45), transparent 60%);
    pointer-events: none;
  }
  .hero-letter {
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    font-family: var(--serif);
    font-weight: 700;
    font-style: italic;
    font-size: 50vw;
    line-height: 0.8;
    color: rgba(255,255,255,0.04);
    pointer-events: none;
    user-select: none;
  }
  .hero-fort {
    position: absolute;
    right: -40px;
    bottom: 0;
    width: 55%;
    max-width: 820px;
    opacity: 0.06;
    pointer-events: none;
  }
  .breadcrumb {
    position: absolute;
    top: 96px; left: 80px;
    font-family: var(--sans);
    font-weight: 300; font-size: 0.75rem;
    color: rgba(245,237,216,0.5);
    letter-spacing: 0.02em;
    z-index: 5;
  }
  .breadcrumb a { transition: color 0.2s; }
  .breadcrumb a:hover { color: var(--gold); text-decoration: underline; text-underline-offset: 4px; }
  .breadcrumb .sep { color: rgba(245,237,216,0.3); margin: 0 8px; }
  .breadcrumb .here { color: rgba(245,237,216,0.75); }

  .hero-content {
    position: relative; z-index: 5;
    padding: 0 80px 80px 80px;
    max-width: 1100px;
  }
  .badges { display: flex; gap: 10px; margin-bottom: 26px; }
  .badge {
    font-family: var(--sans); font-size: 0.72rem;
    letter-spacing: 0.18em; text-transform: uppercase;
    padding: 8px 16px;
    border-radius: 999px;
  }
  .badge.outline { border: 1px solid var(--gold); color: var(--gold); }
  .badge.fill { background: var(--saffron); color: #fff; }
  .hero h1 {
    font-family: var(--serif);
    font-style: italic;
    font-weight: 700;
    font-size: clamp(4rem, 8vw, 7rem);
    line-height: 1;
    letter-spacing: -0.01em;
    color: #fff;
  }
  .gold-line { width: 80px; height: 2px; background: var(--gold); margin: 22px 0 18px; }
  .hero-meta {
    font-family: var(--sans); font-weight: 300;
    color: rgba(245,237,216,0.78);
    font-size: 0.95rem; letter-spacing: 0.03em;
  }
  .hero-meta .dot { color: var(--gold); margin: 0 10px; }

  .scroll-ind {
    position: absolute;
    bottom: 28px; left: 50%; transform: translateX(-50%);
    display: flex; flex-direction: column; align-items: center; gap: 10px;
    z-index: 5;
  }
  .scroll-ind span { font-family: var(--sans); font-size: 0.65rem; letter-spacing: 0.32em; text-transform: uppercase; color: rgba(245,237,216,0.55); }
  .scroll-ind svg { animation: bounceArrow 1.8s ease-in-out infinite; }
  @keyframes bounceArrow { 0%, 100% { transform: translateY(0); opacity: 0.6; } 50% { transform: translateY(8px); opacity: 1; } }

  .anim { opacity: 0; transform: translateY(18px); animation: fadeUp 0.9s cubic-bezier(.2,.7,.2,1) forwards; }
  @keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }

  /* ============ QUICK FACTS STRIP ============ */
  .facts {
    background: var(--parchment);
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    border-top: 1px solid rgba(201,144,26,0.25);
    border-bottom: 1px solid rgba(201,144,26,0.25);
    color: var(--ink);
  }
  .fact { padding: 36px 40px; text-align: center; border-right: 1px solid rgba(201,144,26,0.25); transition: background 0.2s; }
  .fact:last-child { border-right: none; }
  .fact:hover { background: rgba(201,144,26,0.05); }
  .fact-icon { font-family: var(--serif); font-weight: 600; color: var(--saffron); font-size: 1.5rem; line-height: 1; margin-bottom: 10px; font-style: italic; }
  .fact-label { font-family: var(--sans); font-size: 0.68rem; letter-spacing: 0.22em; text-transform: uppercase; color: rgba(13,5,0,0.5); margin-bottom: 8px; }
  .fact-value { font-family: var(--serif); font-weight: 600; font-size: 1.8rem; color: var(--ink); line-height: 1.1; }

  /* ============ MAIN CONTENT ============ */
  .main { background: var(--cream); padding: 80px 32px; color: var(--ink); }
  .main-grid { max-width: 1400px; margin: 0 auto; display: grid; grid-template-columns: 65fr 35fr; gap: 60px; }

  .section-label {
    font-family: var(--sans); font-size: 0.72rem; letter-spacing: 0.32em;
    text-transform: uppercase; color: var(--gold); margin-bottom: 14px; display: inline-block;
    background: linear-gradient(90deg, #C9901A 0%, #E8580A 50%, #C9901A 100%);
    background-size: 200% 100%;
    -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;
    animation: shimmer 4s linear infinite;
  }
  @keyframes shimmer { to { background-position: -200% 0; } }

  .h2 { font-family: var(--serif); font-weight: 700; font-size: 2.5rem; line-height: 1.05; color: var(--ink); letter-spacing: -0.01em; }
  .h3 { font-family: var(--serif); font-weight: 600; font-size: 2rem; color: var(--ink); letter-spacing: -0.005em; }
  .gold-underline { width: 60px; height: 2px; background: var(--gold); margin: 14px 0 28px; }

  .prose p { font-family: var(--sans); font-weight: 300; font-size: 1rem; line-height: 1.9; color: rgba(13,5,0,0.82); margin-bottom: 22px; }
  .prose p:last-child { margin-bottom: 0; }
  .prose strong { font-weight: 500; color: var(--ink); }

  .ornament { text-align: center; color: var(--gold); letter-spacing: 0.5em; margin: 60px 0; font-family: var(--serif); font-size: 1.1rem; }

  /* highlights */
  .highlights { display: flex; flex-direction: column; gap: 8px; }
  .hl { position: relative; padding: 22px 24px 22px 110px; border-top: 1px solid rgba(13,5,0,0.08); }
  .hl:last-child { border-bottom: 1px solid rgba(13,5,0,0.08); }
  .hl-num { position: absolute; left: 0; top: 50%; transform: translateY(-50%); font-family: var(--serif); font-weight: 700; font-style: italic; font-size: 4rem; color: var(--gold); opacity: 0.18; line-height: 1; width: 100px; text-align: center; }
  .hl p { font-family: var(--sans); font-weight: 400; font-size: 0.98rem; line-height: 1.7; color: rgba(13,5,0,0.88); }
  .hl em { font-style: italic; color: var(--ink); font-weight: 500; }

  /* tips */
  .tips { display: grid; grid-template-columns: repeat(2, 1fr); gap: 14px; }
  .tip { background: #fff; border-left: 4px solid var(--c, var(--gold)); padding: 22px; transition: transform 0.25s, background 0.25s, border-left-width 0.25s, box-shadow 0.25s; }
  .tip:hover { transform: translateY(-3px); background: #FFFBF1; border-left-width: 8px; box-shadow: 0 14px 32px -22px rgba(13,5,0,0.4); }
  .tip-cat { font-family: var(--sans); font-size: 0.62rem; letter-spacing: 0.24em; text-transform: uppercase; color: var(--c, var(--gold)); font-weight: 500; margin-bottom: 8px; }
  .tip-title { font-family: var(--serif); font-weight: 600; font-size: 1.25rem; color: var(--ink); margin-bottom: 8px; line-height: 1.2; }
  .tip-body { font-family: var(--sans); font-weight: 300; font-size: 0.88rem; line-height: 1.6; color: rgba(13,5,0,0.7); }

  /* sidebar */
  .sidebar { position: sticky; top: 96px; align-self: start; display: flex; flex-direction: column; gap: 18px; }
  .map-card { border: 2px solid rgba(201,144,26,0.3); aspect-ratio: 4 / 3; overflow: hidden; background: var(--parchment); }
  .map-card iframe { width: 100%; height: 100%; border: 0; display: block; }
  .addr-card { background: var(--parchment); padding: 22px; }
  .addr-card .label { font-family: var(--sans); font-size: 0.65rem; letter-spacing: 0.24em; text-transform: uppercase; color: rgba(13,5,0,0.5); margin-bottom: 10px; display: flex; align-items: center; gap: 8px; }
  .pin { color: var(--saffron); font-size: 1rem; }
  .addr-card p { font-family: var(--sans); font-weight: 300; font-size: 0.92rem; line-height: 1.55; color: var(--ink); margin-bottom: 16px; }
  .map-btn { display: block; text-align: center; font-family: var(--sans); font-size: 0.72rem; letter-spacing: 0.22em; text-transform: uppercase; color: var(--saffron); border: 1px solid var(--saffron); padding: 12px 16px; transition: background 0.2s, color 0.2s; }
  .map-btn:hover { background: var(--saffron); color: #fff; }
  .info-card { background: #fff; padding: 4px 22px; }
  .info-row { display: flex; justify-content: space-between; align-items: center; padding: 18px 0; border-bottom: 1px solid rgba(201,144,26,0.3); }
  .info-row:last-child { border-bottom: none; }
  .info-row .lab { font-family: var(--sans); font-size: 0.65rem; letter-spacing: 0.24em; text-transform: uppercase; color: rgba(13,5,0,0.5); }
  .info-row .val { font-family: var(--sans); font-weight: 400; font-size: 0.92rem; color: var(--ink); }

  /* ============ GALLERY ============ */
  .gallery { background: var(--parchment); padding: 80px 32px; text-align: center; color: var(--ink); }
  .gallery-head { max-width: 1400px; margin: 0 auto 50px; }
  .gallery-grid { max-width: 1400px; margin: 0 auto; column-count: 3; column-gap: 16px; }
  .gal-item { break-inside: avoid; margin-bottom: 16px; position: relative; overflow: hidden; cursor: pointer; transition: transform 0.25s; border: 1px solid transparent; }
  .gal-item:hover { transform: scale(1.02); border-color: var(--gold); }
  .gal-mark { position: absolute; bottom: 18px; left: 22px; font-family: var(--serif); font-style: italic; font-weight: 500; font-size: 1.4rem; color: rgba(255,255,255,0.18); letter-spacing: 0.02em; pointer-events: none; }
  .gal-tag { position: absolute; top: 18px; right: 18px; font-family: var(--sans); font-size: 0.6rem; letter-spacing: 0.22em; text-transform: uppercase; color: rgba(255,255,255,0.65); background: rgba(0,0,0,0.25); padding: 6px 10px; backdrop-filter: blur(4px); }
  .g-amber { background: linear-gradient(160deg, #E8580A, #8B1A1A); height: 420px; }
  .g-crimson { background: linear-gradient(160deg, #8B1A1A, #4A0404); height: 260px; }
  .g-gold { background: linear-gradient(160deg, #C9901A, #E8580A); height: 260px; }
  .g-teal { background: linear-gradient(160deg, #0e6e6e, #14B8A6); height: 340px; }
  .g-rose { background: linear-gradient(160deg, #F43F5E, #8B1A1A); height: 320px; }
  .g-slate { background: linear-gradient(160deg, #334155, #0f172a); height: 380px; }

  /* ============ RELATED ============ */
  .related { background: var(--ink); color: var(--parchment); padding: 80px 32px 100px; }
  .related-inner { max-width: 1400px; margin: 0 auto; }
  .related-head { text-align: center; margin-bottom: 56px; }
  .related h2 { font-family: var(--serif); font-style: italic; font-weight: 700; font-size: 2.5rem; color: #fff; letter-spacing: -0.01em; }
  .rel-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
  .rel-card { background: rgba(255,255,255,0.04); overflow: hidden; transition: transform 0.3s; cursor: pointer; display: block; }
  .rel-card:hover { transform: translateY(-4px); }
  .rel-top { height: 220px; position: relative; overflow: hidden; }
  .rel-top::after { content: ""; position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.2) 35%, transparent 60%); transition: background 0.3s; }
  .rel-card:hover .rel-top::after { background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.4) 50%, rgba(0,0,0,0.1) 100%); }
  .rel-bg { position: absolute; inset: 0; transition: transform 0.5s; }
  .rel-card:hover .rel-bg { transform: scale(1.05); }
  .rel-letter { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-family: var(--serif); font-weight: 700; font-style: italic; font-size: 11rem; color: rgba(255,255,255,0.1); line-height: 0.8; }
  .rel-badge { position: absolute; top: 14px; right: 14px; font-family: var(--sans); font-size: 0.6rem; letter-spacing: 0.22em; text-transform: uppercase; color: #fff; background: rgba(13,5,0,0.45); backdrop-filter: blur(4px); padding: 6px 12px; z-index: 2; }
  .rel-foot { position: absolute; left: 22px; bottom: 18px; z-index: 2; }
  .rel-name { font-family: var(--serif); font-weight: 700; font-style: italic; font-size: 1.45rem; color: #fff; line-height: 1.1; margin-bottom: 4px; }
  .rel-sub { font-family: var(--sans); font-size: 0.65rem; letter-spacing: 0.22em; text-transform: uppercase; color: var(--gold); }
  .rel-bottom { padding: 22px; }
  .rel-desc { font-family: var(--sans); font-weight: 300; font-size: 0.86rem; line-height: 1.6; color: rgba(245,237,216,0.65); margin-bottom: 14px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
  .rel-link { font-family: var(--sans); font-size: 0.72rem; letter-spacing: 0.22em; text-transform: uppercase; color: var(--saffron); transition: gap 0.2s; display: inline-flex; gap: 6px; }
  .rel-link:hover { gap: 12px; }
  .view-all { display: block; width: max-content; margin: 56px auto 0; font-family: var(--sans); font-size: 0.78rem; letter-spacing: 0.24em; text-transform: uppercase; color: var(--gold); border: 1px solid var(--gold); padding: 16px 32px; transition: background 0.2s, color 0.2s; }
  .view-all:hover { background: var(--gold); color: var(--ink); }

  .g-rose-cr { background: linear-gradient(150deg, #F43F5E 0%, #8B1A1A 100%); }
  .g-amber-go { background: linear-gradient(150deg, #E8580A 0%, #C9901A 100%); }
  .g-gold-am  { background: linear-gradient(150deg, #C9901A 0%, #4A0404 100%); }
  .g-blue-tl  { background: linear-gradient(150deg, #1B4F8A 0%, #2D6A4F 100%); }
  .g-jade-dk  { background: linear-gradient(150deg, #2D6A4F 0%, #0D0500 100%); }
  .g-slate-dk { background: linear-gradient(150deg, #334155 0%, #0D0500 100%); }

  /* reveal on scroll */
  .reveal { opacity: 0; transform: translateY(20px); transition: opacity 0.9s ease, transform 0.9s cubic-bezier(.2,.7,.2,1); }
  .reveal.in { opacity: 1; transform: none; }

  @media (max-width: 900px) {
    .hero-content { padding: 0 24px 60px; }
    .breadcrumb { left: 22px; top: 76px; }
    .facts { grid-template-columns: 1fr 1fr; }
    .fact { border-right: 1px solid rgba(201,144,26,0.25); border-bottom: 1px solid rgba(201,144,26,0.25); }
    .fact:nth-child(2n) { border-right: none; }
    .fact:nth-last-child(-n+2) { border-bottom: none; }
    .main { padding: 60px 22px; }
    .main-grid { grid-template-columns: 1fr; gap: 50px; }
    .sidebar { position: static; }
    .tips { grid-template-columns: 1fr; }
    .gallery, .related { padding: 60px 22px; }
    .gallery-grid { column-count: 1; }
    .rel-grid { grid-template-columns: 1fr; }
    .hl { padding-left: 90px; }
    .hl-num { font-size: 3rem; width: 80px; }
    .related h2, .gallery .h2 { font-size: 2rem; }
  }
</style>
@endsection

@section('content')

@php
  $relGradients = [
    'Fort'     => 'g-amber-go',
    'Temple'   => 'g-rose-cr',
    'Palace'   => 'g-gold-am',
    'Cave'     => 'g-slate-dk',
    'Memorial' => 'g-blue-tl',
    'Mosque'   => 'g-jade-dk',
    'Stepwell' => 'g-rose-cr',
    'Stupa'    => 'g-amber-go',
  ];
  $tipColors = [
    'General'     => '#0EA5E9',
    'Photography' => '#8B5CF6',
    'Transport'   => '#14B8A6',
    'Timing'      => '#F59E0B',
    'Clothing'    => '#F43F5E',
    'Food'        => '#10B981',
    'Safety'      => '#EF4444',
    'Best_Spots'  => '#C9901A',
  ];
@endphp

<!-- HERO -->
<section class="hero">
  <div class="hero-letter" aria-hidden="true">{{ substr($monument->name, 0, 1) }}</div>
  <svg class="hero-fort" viewBox="0 0 800 500" fill="none" stroke="#C9901A" stroke-width="1.2" aria-hidden="true">
    <path d="M0 480 L40 480 L40 380 L80 380 L80 410 L120 410 L120 340 L160 340 L150 300 L170 300 L160 270 L180 270 L170 230 L200 230 L200 280 L240 280 L240 320 L280 320 L280 240 L320 240 L320 200 L360 200 L360 170 L400 170 L400 140 L440 140 L440 180 L480 180 L480 230 L520 230 L520 290 L560 290 L560 250 L600 250 L600 320 L640 320 L640 280 L680 280 L680 360 L720 360 L720 400 L760 400 L760 480 L800 480"/>
    <path d="M180 270 L180 230 L190 220 L200 230"/>
    <path d="M390 170 L400 150 L410 170"/>
    <circle cx="400" cy="155" r="3"/>
    <path d="M80 380 L80 350 L100 340 L120 350 L120 380"/>
    <path d="M240 280 L240 250 L260 240 L280 250 L280 280"/>
  </svg>

  <div class="breadcrumb anim" style="animation-delay:0ms">
    <a href="{{ route('home') }}">Home</a><span class="sep">/</span>
    <a href="{{ route('monuments.index') }}">Heritage</a><span class="sep">/</span>
    <a href="{{ route('monuments.by-state', ['stateSlug' => $monument->state->slug]) }}">{{ $monument->state->name }}</a><span class="sep">/</span>
    <span class="here">{{ $monument->name }}</span>
  </div>

  <div class="hero-content">
    <div class="badges anim" style="animation-delay:100ms">
      <span class="badge outline">{{ $monument->type }}</span>
      <span class="badge fill">{{ str_replace('_', ' ', $monument->category) }}</span>
    </div>
    <h1 class="anim" style="animation-delay:200ms">{{ $monument->name }}</h1>
    <div class="gold-line anim" style="animation-delay:350ms"></div>
    <div class="hero-meta anim" style="animation-delay:450ms">
      {{ $monument->state->name }}
      @if($monument->dynasty_or_period)
        <span class="dot">·</span>{{ $monument->dynasty_or_period }}
      @endif
      @if($monument->built_by)
        <span class="dot">·</span>Built by {{ $monument->built_by }}
      @endif
      @if($monument->built_in_year)
        <span class="dot">·</span>{{ $monument->built_in_year }} CE
      @endif
    </div>
  </div>

  <div class="scroll-ind anim" style="animation-delay:800ms">
    <span>Scroll to explore</span>
    <svg width="14" height="22" viewBox="0 0 14 22" fill="none" stroke="#C9901A" stroke-width="1.5">
      <path d="M7 2 V18 M2 13 L7 18 L12 13" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
  </div>
</section>

<!-- QUICK FACTS -->
<section class="facts">
  <div class="fact">
    <div class="fact-icon">₹</div>
    <div class="fact-label">Indian Visitors</div>
    <div class="fact-value" data-count="{{ (int)($monument->entry_fee_indian ?? 25) }}" data-prefix="₹ ">₹ {{ (int)($monument->entry_fee_indian ?? 25) }}</div>
  </div>
  <div class="fact">
    <div class="fact-icon">$</div>
    <div class="fact-label">Foreign Visitors</div>
    <div class="fact-value" data-count="{{ (int)($monument->entry_fee_foreign ?? 500) }}" data-prefix="₹ ">₹ {{ (int)($monument->entry_fee_foreign ?? 500) }}</div>
  </div>
  <div class="fact">
    <div class="fact-icon">✦</div>
    <div class="fact-label">Best Time to Visit</div>
    <div class="fact-value" style="font-size:1.1rem">{{ $monument->best_time_to_visit ?? 'October to March' }}</div>
  </div>
  <div class="fact">
    <div class="fact-icon">◷</div>
    <div class="fact-label">Visiting Hours</div>
    <div class="fact-value" style="font-size:1.1rem">{{ $monument->visiting_hours ?? '8:00 AM – 5:30 PM' }}</div>
  </div>
</section>

<!-- MAIN -->
<section class="main">
  <div class="main-grid">
    <div class="left">

      <div class="reveal">
        <div class="section-label">✦ &nbsp;About the Monument&nbsp; ✦</div>
        <h2 class="h2">About {{ $monument->name }}</h2>
        <div class="gold-underline"></div>
        <div class="prose">
          {!! $monument->full_description ?? '<p>No description available.</p>' !!}
        </div>
      </div>

      <div class="ornament reveal">── ✦ ──</div>

      <div class="reveal">
        <h2 class="h3">Key Highlights</h2>
        <div class="gold-underline"></div>
        <div class="highlights">
          @if($monument->highlights->count() > 0)
            @foreach($monument->highlights as $i => $h)
              <div class="hl reveal">
                <div class="hl-num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</div>
                <p>{{ $h->highlight }}</p>
              </div>
            @endforeach
          @else
            <div class="hl reveal"><div class="hl-num">01</div><p>An architectural masterpiece blending multiple traditions found nowhere else in India.</p></div>
            <div class="hl reveal"><div class="hl-num">02</div><p>Listed among India's most significant protected monuments by the Archaeological Survey of India.</p></div>
            <div class="hl reveal"><div class="hl-num">03</div><p>A living heritage site — still visited and revered by millions of pilgrims and travellers each year.</p></div>
          @endif
        </div>
      </div>

      <div class="ornament reveal">── ✦ ──</div>

      <div class="reveal">
        <h2 class="h3">Visitor Tips</h2>
        <div class="gold-underline"></div>
        <div class="tips">
          @if($tipsByType->count() > 0)
            @foreach($tipsByType as $type => $tips)
              @foreach($tips as $tip)
                <div class="tip reveal" style="--c:{{ $tipColors[$type] ?? '#C9901A' }}">
                  <div class="tip-cat">{{ str_replace('_', ' ', $type) }}</div>
                  <div class="tip-title">{{ $tip->tip }}</div>
                </div>
              @endforeach
            @endforeach
          @else
            <div class="tip reveal" style="--c:#0EA5E9;"><div class="tip-cat">General</div><div class="tip-title">Arrive Early</div><div class="tip-body">Visit in the morning to enjoy the monument before crowds and midday heat.</div></div>
            <div class="tip reveal" style="--c:#8B5CF6;"><div class="tip-cat">Photography</div><div class="tip-title">Best Light at Sunrise</div><div class="tip-body">Early morning light creates dramatic shadows across the architecture.</div></div>
            <div class="tip reveal" style="--c:#14B8A6;"><div class="tip-cat">Transport</div><div class="tip-title">Getting There</div><div class="tip-body">Auto-rickshaws and local buses connect the monument to the nearest town centre.</div></div>
            <div class="tip reveal" style="--c:#F59E0B;"><div class="tip-cat">Timing</div><div class="tip-title">Allow 2–3 Hours</div><div class="tip-body">The monument is larger than it appears. Audio guides are available at the entrance.</div></div>
            <div class="tip reveal" style="--c:#F43F5E;"><div class="tip-cat">Clothing</div><div class="tip-title">Dress Modestly</div><div class="tip-body">Comfortable shoes are essential. Cover shoulders when entering sacred spaces.</div></div>
            <div class="tip reveal" style="--c:#10B981;"><div class="tip-cat">Food</div><div class="tip-title">Eat Nearby</div><div class="tip-body">Several good local restaurants are within walking distance of the entrance.</div></div>
          @endif
        </div>
      </div>

    </div>

    <aside class="sidebar">
      <div class="map-card reveal">
        <iframe loading="lazy"
          src="https://maps.google.com/maps?q={{ $monument->latitude ?? '20.5937' }},{{ $monument->longitude ?? '78.9629' }}&z=15&output=embed"
          title="Map of {{ $monument->name }}"></iframe>
      </div>
      <div class="addr-card reveal">
        <div class="label"><span class="pin">⚲</span> Address</div>
        <p>{{ $monument->address ?? $monument->state->name . ', India' }}</p>
        <a class="map-btn"
          href="https://maps.google.com/?q={{ $monument->latitude ?? '20.5937' }},{{ $monument->longitude ?? '78.9629' }}"
          target="_blank" rel="noopener">
          View on Google Maps →
        </a>
      </div>
      <div class="info-card reveal">
        <div class="info-row">
          <div class="lab">Timings</div>
          <div class="val">{{ $monument->visiting_hours ?? '8:00 AM – 5:30 PM' }}</div>
        </div>
        <div class="info-row">
          <div class="lab">Best Time</div>
          <div class="val">{{ $monument->best_time_to_visit ?? 'October to March' }}</div>
        </div>
        <div class="info-row">
          <div class="lab">Duration</div>
          <div class="val">2 – 3 hours</div>
        </div>
        @if($monument->built_in_year)
        <div class="info-row">
          <div class="lab">Built</div>
          <div class="val">{{ $monument->built_in_year }} CE</div>
        </div>
        @endif
      </div>
    </aside>
  </div>
</section>

<!-- GALLERY -->
<section class="gallery">
  <div class="gallery-head reveal">
    <div class="section-label">✦ &nbsp;Photo Gallery&nbsp; ✦</div>
    <h2 class="h2">{{ $monument->name }} in Pictures</h2>
    <div class="gold-underline" style="margin:14px auto 0;"></div>
  </div>
  <div class="gallery-grid">
    <div class="gal-item g-amber reveal"><span class="gal-tag">Exterior</span><span class="gal-mark">{{ $monument->name }}</span></div>
    <div class="gal-item g-gold reveal"><span class="gal-tag">Interior</span><span class="gal-mark">{{ $monument->name }}</span></div>
    <div class="gal-item g-rose reveal"><span class="gal-tag">Details</span><span class="gal-mark">{{ $monument->name }}</span></div>
    <div class="gal-item g-crimson reveal"><span class="gal-tag">Architecture</span><span class="gal-mark">{{ $monument->name }}</span></div>
    <div class="gal-item g-teal reveal"><span class="gal-tag">Surroundings</span><span class="gal-mark">{{ $monument->name }}</span></div>
    <div class="gal-item g-slate reveal"><span class="gal-tag">Dusk</span><span class="gal-mark">{{ $monument->name }}</span></div>
  </div>
</section>

<!-- RELATED -->
<section class="related">
  <div class="related-inner">
    <div class="related-head reveal">
      <div class="section-label">✦ &nbsp;More from {{ $monument->state->name }}&nbsp; ✦</div>
      <h2>Continue Exploring</h2>
    </div>
    <div class="rel-grid">
      @if($related->count() > 0)
        @foreach($related as $r)
          @php $rGrad = $relGradients[$r->type] ?? 'g-amber-go'; @endphp
          <a class="rel-card reveal" href="{{ route('monuments.show', $r->slug) }}">
            <div class="rel-top">
              <div class="rel-bg {{ $rGrad }}"></div>
              <div class="rel-letter">{{ substr($r->name, 0, 1) }}</div>
              <span class="rel-badge">{{ $r->type }}</span>
              <div class="rel-foot">
                <div class="rel-name">{{ $r->name }}</div>
                <div class="rel-sub">{{ $r->state->name ?? $monument->state->name }} · {{ $r->type }}</div>
              </div>
            </div>
            <div class="rel-bottom">
              <p class="rel-desc">{{ $r->short_description }}</p>
              <span class="rel-link">Explore →</span>
            </div>
          </a>
        @endforeach
      @else
        <div class="rel-card reveal" style="padding:40px;text-align:center;color:rgba(245,237,216,0.5);">
          <p style="font-family:var(--serif);font-style:italic;">More monuments from {{ $monument->state->name }} coming soon.</p>
        </div>
      @endif
    </div>
    <a class="view-all" href="{{ route('monuments.by-state', ['stateSlug' => $monument->state->slug]) }}">
      View All {{ $monument->state->name }} Monuments →
    </a>
  </div>
</section>

@push('scripts')
<script>
  // Scroll reveal
  const io = new IntersectionObserver((entries) => {
    entries.forEach((e, i) => {
      if (e.isIntersecting) {
        const delay = e.target.dataset.delay || (i * 60);
        setTimeout(() => e.target.classList.add('in'), parseInt(delay));
        io.unobserve(e.target);
      }
    });
  }, { threshold: 0.12 });
  document.querySelectorAll('.reveal').forEach(el => io.observe(el));

  // Stagger animations
  function stagger(selector, step) {
    document.querySelectorAll(selector).forEach((el, i) => { el.dataset.delay = i * step; });
  }
  stagger('.hl.reveal', 80);
  stagger('.tip.reveal', 40);
  stagger('.gal-item.reveal', 80);
  stagger('.rel-card.reveal', 120);

  // Count-up animation for entry fees
  function animateCount(el) {
    const target = parseFloat(el.dataset.count);
    const prefix = el.dataset.prefix || '';
    const dur = 1200;
    const start = performance.now();
    function tick(now) {
      const t = Math.min(1, (now - start) / dur);
      const eased = 1 - Math.pow(1 - t, 3);
      el.textContent = prefix + Math.round(target * eased);
      if (t < 1) requestAnimationFrame(tick);
    }
    requestAnimationFrame(tick);
  }
  const countIO = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) { animateCount(e.target); countIO.unobserve(e.target); }
    });
  }, { threshold: 0.5 });
  document.querySelectorAll('[data-count]').forEach(el => countIO.observe(el));
</script>
@endpush

@endsection
