@extends('layouts.app')
@section('title', 'Cuisine of India — Regional Flavours')
@section('meta_description', 'Explore the rich culinary heritage of India — 500+ dishes across 28 states, from Rajasthani Dal Baati to Kerala Sadya.')

@section('styles')
<style>
  /* ── CUISINE PAGE STYLES ── */

  /* SHIMMER LABEL */
  @keyframes shimmer-gold { 0% { background-position: 0% center; } 100% { background-position: 200% center; } }
  .section-label-shine {
    display: inline-block;
    font-family: "DM Sans", sans-serif;
    font-size: 0.65rem; font-weight: 600;
    letter-spacing: 0.22em; text-transform: uppercase;
    background: linear-gradient(90deg, #C9901A, #F5D876, #C9901A);
    background-size: 200% auto;
    -webkit-background-clip: text; background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: shimmer-gold 3s linear infinite;
    margin-bottom: 14px;
  }
  .section-label-shine.saffron-shimmer {
    background: linear-gradient(90deg, #E8580A, #f9a064, #E8580A);
    background-size: 200% auto;
    -webkit-background-clip: text; background-clip: text;
    -webkit-text-fill-color: transparent;
  }

  /* HERO */
  .cuisine-hero {
    position: relative; min-height: 80vh;
    background: linear-gradient(160deg, #1A0500 0%, #4A1500 30%, #8B3A0A 60%, #C9901A 100%);
    padding: 128px 80px 120px;
    display: flex; align-items: center;
    overflow: hidden;
    color: white;
    clip-path: polygon(0 0, 100% 0, 100% 88%, 0 100%);
  }
  .cuisine-hero::before {
    content: ""; position: absolute; inset: 0; opacity: 0.4; mix-blend-mode: overlay; pointer-events: none;
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='200' height='200'><filter id='n'><feTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='2' stitchTiles='stitch'/><feColorMatrix values='0 0 0 0 0.85  0 0 0 0 0.65  0 0 0 0 0.3  0 0 0 0.18 0'/></filter><rect width='100%' height='100%' filter='url(%23n)'/></svg>");
  }
  .thali-svg {
    position: absolute; right: -40px; top: 50%; transform: translateY(-50%);
    width: 600px; height: 600px; opacity: 0.08; pointer-events: none;
    animation: rotate 20s linear infinite;
  }
  @keyframes rotate { to { transform: translateY(-50%) rotate(360deg); } }

  .hero-left { position: relative; z-index: 3; max-width: 720px; }
  .hero-pill { display: inline-flex; align-items: center; gap: 10px; border: 1px solid var(--gold); padding: 7px 16px; font-family: "DM Sans", sans-serif; font-size: 10px; letter-spacing: 0.22em; color: var(--gold); text-transform: uppercase; margin-bottom: 28px; opacity: 0; animation: fadeUp 0.9s ease forwards; animation-delay: 100ms; }
  .hero-h1 { font-family: "Cormorant Garamond", serif; line-height: 0.92; letter-spacing: -0.01em; }
  .hero-h1 .l1, .hero-h1 .l2 { display: block; opacity: 0; transform: translateY(28px); animation: fadeUp 1s cubic-bezier(0.2, 0.7, 0.2, 1) forwards; }
  .hero-h1 .l1 { font-weight: 700; font-style: italic; font-size: clamp(2.6rem, 4.6vw, 4.4rem); color: var(--parchment); animation-delay: 220ms; }
  .hero-h1 .l2 { font-weight: 700; font-size: clamp(4.4rem, 7.6vw, 6.6rem); color: var(--gold); animation-delay: 380ms; margin-left: -3px; }
  .gold-line { width: 80px; height: 2px; background: var(--gold); margin: 24px 0; opacity: 0; animation: fadeIn 0.8s ease forwards; animation-delay: 540ms; }
  .hero-sub { font-family: "DM Sans", sans-serif; font-weight: 300; font-size: 1.05rem; line-height: 1.85; color: rgba(245,237,216,0.78); max-width: 480px; margin-bottom: 24px; opacity: 0; animation: fadeUp 1s ease forwards; animation-delay: 640ms; }
  .hero-sub em { font-family: "Cormorant Garamond", serif; font-style: italic; color: var(--parchment); }
  .stat-line { font-family: "DM Sans", sans-serif; font-size: 0.65rem; font-weight: 600; letter-spacing: 0.22em; color: var(--gold); text-transform: uppercase; margin-bottom: 28px; opacity: 0; animation: fadeUp 1s ease forwards; animation-delay: 760ms; }
  .stat-line .num { font-family: "Cormorant Garamond", serif; font-style: italic; font-size: 1rem; color: var(--parchment); letter-spacing: 0; }

  /* SECTION */
  section.cs { padding: 100px 80px; position: relative; }
  .cs-inner { max-width: 1280px; margin: 0 auto; }
  .sec-h { font-family: "Cormorant Garamond", serif; font-weight: 700; font-size: clamp(2rem, 3.6vw, 3rem); color: var(--ink); line-height: 1.05; letter-spacing: -0.01em; margin-bottom: 16px; }
  .sec-h em { font-style: italic; color: var(--gold); }
  .sec-h.on-dark { color: white; }
  .sec-p { font-family: "DM Sans", sans-serif; font-weight: 300; font-size: 1.02rem; line-height: 1.75; color: rgba(13, 5, 0, 0.62); max-width: 620px; margin-bottom: 48px; }
  .sec-p.on-dark { color: rgba(245,237,216,0.6); }

  /* FLAVOUR PROFILES */
  .flavours { background: var(--ink); color: var(--parchment); }
  .flav-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; }
  .flav { overflow: hidden; cursor: pointer; opacity: 0; transform: translateY(24px); transition: opacity 0.7s ease, transform 0.7s ease; }
  .flav.in { opacity: 1; transform: translateY(0); }
  .flav:hover { transform: translateY(-6px); }
  .flav .top { position: relative; height: 180px; overflow: hidden; }
  .flav .top .bg { position: absolute; inset: 0; transition: transform 0.6s cubic-bezier(0.2,0.7,0.2,1); }
  .flav:hover .top .bg { transform: scale(1.05); }
  .flav .top .pattern { position: absolute; inset: 0; background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='80' height='80'><g fill='none' stroke='white' stroke-width='0.4' opacity='0.5'><path d='M40 5 L 75 40 L 40 75 L 5 40 Z'/><circle cx='40' cy='40' r='28'/></g></svg>"); background-size: 80px; opacity: 0.16; mix-blend-mode: overlay; }
  .flav .top .glyph { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -55%); font-family: "Cormorant Garamond", serif; font-weight: 700; font-style: italic; font-size: 5rem; color: rgba(255,255,255,0.1); white-space: nowrap; pointer-events: none; }
  .flav .top .badge { position: absolute; top: 14px; left: 14px; background: rgba(0,0,0,0.4); color: white; padding: 4px 10px; font-family: "DM Sans", sans-serif; font-size: 0.58rem; font-weight: 600; letter-spacing: 0.22em; text-transform: uppercase; backdrop-filter: blur(4px); z-index: 2; }
  .flav .body { background: rgba(255,255,255,0.04); padding: 22px; transition: background 0.3s ease; }
  .flav:hover .body { background: rgba(255,255,255,0.07); }
  .flav .name { font-family: "Cormorant Garamond", serif; font-weight: 700; font-style: italic; font-size: 1.5rem; color: white; line-height: 1.05; margin-bottom: 6px; }
  .flav .sub { font-family: "DM Sans", sans-serif; font-weight: 300; font-size: 0.85rem; color: var(--gold); margin-bottom: 14px; line-height: 1.5; }
  .flav .dish-chip { font-family: "DM Sans", sans-serif; font-weight: 300; font-size: 0.72rem; color: white; background: rgba(255,255,255,0.1); padding: 4px 10px; display: inline-block; margin: 3px; }
  .g-north     { background: linear-gradient(135deg, #C9901A 0%, #8B1A1A 100%); }
  .g-south     { background: linear-gradient(135deg, #2D6A4F 0%, #1F5C4D 100%); }
  .g-east      { background: linear-gradient(135deg, #1B4F8A 0%, #2c3e5c 100%); }
  .g-west      { background: linear-gradient(135deg, #E8580A 0%, #C7325A 100%); }
  .g-northeast { background: linear-gradient(135deg, #1f4a37 0%, #1d2b30 100%); }
  .g-central   { background: linear-gradient(135deg, #6b3c08 0%, #8B1A1A 100%); }

  /* FILTER BAR */
  .dishes-sec { background: var(--cream); }
  .filter-bar {
    background: white; padding: 22px 28px;
    box-shadow: 0 12px 40px rgba(13,5,0,0.06);
    display: flex; align-items: flex-end; gap: 32px; flex-wrap: wrap; margin-bottom: 36px;
    border-top: 1px solid rgba(201,144,26,0.2);
  }
  .f-group { display: flex; flex-direction: column; gap: 4px; min-width: 140px; }
  .f-label { font-family: "DM Sans", sans-serif; font-size: 0.58rem; letter-spacing: 0.24em; color: rgba(13,5,0,0.4); text-transform: uppercase; font-weight: 500; }
  .f-select {
    appearance: none; -webkit-appearance: none; background: transparent;
    border: none; border-bottom: 1.5px solid rgba(13,5,0,0.12);
    padding: 4px 24px 4px 0; font-family: "Cormorant Garamond", serif;
    font-weight: 500; font-size: 1rem; color: var(--ink); cursor: pointer;
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='none' stroke='%23C9901A' stroke-width='1.5'><path d='M3 6 L8 11 L13 6'/></svg>");
    background-repeat: no-repeat; background-position: right center; background-size: 14px; outline: none;
    transition: border-color 0.3s ease;
  }
  .f-select:focus { border-bottom-color: var(--gold); }
  .f-btn { font-family: "DM Sans", sans-serif; font-weight: 500; font-size: 0.7rem; letter-spacing: 0.18em; text-transform: uppercase; padding: 8px 18px; background: var(--saffron); color: white; border: none; cursor: pointer; transition: background 0.3s ease; }
  .f-btn:hover { background: var(--gold); }
  .f-clear { background: transparent; color: var(--gold); border: 1px solid var(--gold); margin-left: auto; }
  .f-clear:hover { background: var(--gold); color: var(--ink); }

  /* DISH GRID */
  .dish-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 22px; }
  .dish { background: white; cursor: pointer; opacity: 0; transform: translateY(24px); display: flex; flex-direction: column; transition: transform 0.5s cubic-bezier(0.2,0.7,0.2,1), box-shadow 0.5s ease; }
  .dish.in { opacity: 1; transform: translateY(0); }
  .dish:hover { transform: translateY(-6px); box-shadow: 0 24px 60px rgba(13,5,0,0.14); }
  .dish .img { position: relative; aspect-ratio: 4/3; overflow: hidden; background: linear-gradient(160deg, #C9901A, #8B1A1A); }
  .dish .img img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; transition: filter 0.4s ease; }
  .dish:hover .img img { filter: saturate(1.18); }
  .dish .img::after { content: ""; position: absolute; inset: 0; background: linear-gradient(180deg, transparent 60%, rgba(13,5,0,0.3) 100%); }
  .meal-badge { position: absolute; top: 14px; right: 14px; z-index: 3; font-family: "DM Sans", sans-serif; font-size: 0.58rem; font-weight: 600; letter-spacing: 0.22em; text-transform: uppercase; color: white; padding: 5px 10px; }
  .mb-breakfast { background: #C9901A; }
  .mb-lunch     { background: #E8580A; }
  .mb-dinner    { background: #8B1A1A; }
  .mb-snack     { background: #b07f17; }
  .mb-dessert   { background: #C7325A; }
  .mb-other     { background: #4A4A4A; }
  .veg-mark { position: absolute; top: 14px; left: 14px; z-index: 3; width: 18px; height: 18px; background: white; border: 1.5px solid #2D6A4F; display: flex; align-items: center; justify-content: center; }
  .veg-mark .vd { width: 8px; height: 8px; border-radius: 50%; background: #2D6A4F; }
  .veg-mark.nv { border-color: #8B1A1A; }
  .veg-mark.nv .vd { background: #8B1A1A; }
  .dish-body { padding: 18px 20px; border-left: 3px solid var(--saffron); display: flex; flex-direction: column; gap: 8px; flex: 1; }
  .dish-state { font-family: "DM Sans", sans-serif; font-size: 0.6rem; font-weight: 600; letter-spacing: 0.22em; color: var(--gold); text-transform: uppercase; }
  .dish-name  { font-family: "Cormorant Garamond", serif; font-weight: 600; font-size: 1.4rem; color: var(--ink); line-height: 1.05; }
  .dish-desc  { font-family: "DM Sans", sans-serif; font-weight: 300; font-size: 0.85rem; line-height: 1.55; color: rgba(13,5,0,0.62); }

  /* PAGINATION */
  .pagination-wrap { display: flex; justify-content: center; align-items: center; gap: 8px; margin-top: 48px; flex-wrap: wrap; }
  .pagination-wrap .page-link { font-family: "DM Sans", sans-serif; font-size: 0.75rem; letter-spacing: 0.1em; color: var(--ink); border: 1px solid rgba(13,5,0,0.15); padding: 8px 14px; transition: background 0.2s ease, color 0.2s ease; }
  .pagination-wrap .page-link:hover, .pagination-wrap .page-link.active { background: var(--gold); color: white; border-color: var(--gold); }
  .pagination-wrap .page-link[disabled] { opacity: 0.4; pointer-events: none; }

  /* EMPTY STATE */
  .empty-state { text-align: center; padding: 80px 40px; }
  .empty-state h3 { font-family: "Cormorant Garamond", serif; font-weight: 600; font-size: 2rem; color: var(--ink); margin-bottom: 12px; }
  .empty-state p { font-family: "DM Sans", sans-serif; font-weight: 300; color: rgba(13,5,0,0.55); margin-bottom: 28px; }

  /* FACTS */
  .facts-sec { background: var(--parchment); }
  .facts-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; margin-top: 36px; }
  .fcard { background: white; border-top: 4px solid var(--saffron); padding: 28px 22px; transition: border-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease; }
  .fcard:hover { border-top-color: var(--crimson); transform: translateY(-4px); box-shadow: 0 18px 40px rgba(13,5,0,0.1); }
  .fcard .num { font-family: "Cormorant Garamond", serif; font-weight: 700; font-size: 3rem; color: var(--gold); line-height: 1; margin-bottom: 14px; }
  .fcard .desc { font-family: "DM Sans", sans-serif; font-weight: 300; font-size: 0.92rem; line-height: 1.55; color: rgba(13,5,0,0.62); }
  .fcard .desc em { font-family: "Cormorant Garamond", serif; font-style: italic; color: var(--ink); }

  /* CTA */
  .cta-sec { background: #1A0A00; color: var(--parchment); padding: 100px 80px; text-align: center; }
  .cta-sec h2 { font-family: "Cormorant Garamond", serif; font-weight: 700; font-size: clamp(2.4rem, 4.4vw, 3.5rem); color: white; line-height: 1.05; margin-bottom: 20px; }
  .cta-sec h2 em { font-style: italic; color: var(--gold); }
  .cta-sec p { font-family: "DM Sans", sans-serif; font-weight: 300; font-size: 1.05rem; line-height: 1.75; color: rgba(245,237,216,0.65); max-width: 580px; margin: 0 auto 40px; }
  .cta-row { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }

  /* RESPONSIVE */
  @media (max-width: 1100px) {
    .cuisine-hero { padding: 128px 40px 120px; }
    section.cs { padding: 80px 40px; }
    .flav-grid { grid-template-columns: repeat(2, 1fr); }
    .dish-grid { grid-template-columns: repeat(2, 1fr); }
    .facts-grid { grid-template-columns: repeat(2, 1fr); }
    .cta-sec { padding: 80px 40px; }
  }
  @media (max-width: 720px) {
    .cuisine-hero { padding: 112px 24px 88px; }
    section.cs, .cta-sec { padding: 60px 24px; }
    .flav-grid { grid-template-columns: 1fr; }
    .dish-grid { grid-template-columns: 1fr; }
    .facts-grid { grid-template-columns: 1fr; }
    .filter-bar { gap: 18px; padding: 18px 20px; }
    .f-clear { margin-left: 0; }
  }
</style>
@endsection

@section('content')

{{-- ════════════════════════════════════════
     HERO
     ════════════════════════════════════════ --}}
<section class="cuisine-hero">
  <svg class="thali-svg" viewBox="0 0 600 600" fill="none" stroke="#C9901A" stroke-width="0.7" aria-hidden="true">
    <g transform="translate(300 300)">
      <circle cx="0" cy="0" r="280"/>
      <circle cx="0" cy="0" r="220"/>
      <circle cx="0" cy="0" r="120"/>
      <g>
        <circle cx="0" cy="-180" r="38"/><circle cx="127" cy="-127" r="38"/><circle cx="180" cy="0" r="38"/>
        <circle cx="127" cy="127" r="38"/><circle cx="0" cy="180" r="38"/><circle cx="-127" cy="127" r="38"/>
        <circle cx="-180" cy="0" r="38"/><circle cx="-127" cy="-127" r="38"/>
      </g>
      <line x1="-280" y1="0" x2="280" y2="0"/><line x1="0" y1="-280" x2="0" y2="280"/>
    </g>
  </svg>

  <div class="hero-left">
    <span class="hero-pill"><span>✦</span><span>Cuisines of India</span><span>✦</span></span>
    <h1 class="hero-h1">
      <span class="l1">A Billion Flavours</span>
      <span class="l2">One Table</span>
    </h1>
    <div class="gold-line"></div>
    <p class="hero-sub">From the fiery curries of Rajasthan to the coconut-kissed dishes of Kerala — every state has a cuisine <em>as distinct as its culture</em>.</p>
    <div class="stat-line">
      <span class="num">{{ \App\Models\StateFood::count() ?: '500+' }}</span> Dishes &nbsp;·&nbsp;
      <span class="num">28</span> Culinary Traditions &nbsp;·&nbsp;
      <span class="num">6</span> Regional Flavour Profiles
    </div>
  </div>
</section>

{{-- ════════════════════════════════════════
     FLAVOUR PROFILES (static editorial)
     ════════════════════════════════════════ --}}
<section class="cs flavours">
  <div class="cs-inner">
    <header class="reveal">
      <span class="section-label-shine">✦ Regional Flavours ✦</span>
      <h2 class="sec-h on-dark">Six Distinct <em>Palates</em> of India</h2>
      <p class="sec-p on-dark">A subcontinent's cuisine is not one tradition but six — each shaped by the soil, the climate, and the trade winds that touched its shores.</p>
    </header>

    <div class="flav-grid">
      @php
        $flavours = [
          ['region'=>'North',    'class'=>'g-north',     'sub'=>'Rich, creamy &amp; aromatic — the cuisine of the tandoor.',                      'chips'=>['Dal Makhani','Butter Chicken','Rogan Josh','Biryani']],
          ['region'=>'South',    'class'=>'g-south',     'sub'=>'Tangy, spicy &amp; coconut-rich — rice and the sea.',                             'chips'=>['Dosa','Sambar','Rasam','Fish Curry']],
          ['region'=>'East',     'class'=>'g-east',      'sub'=>'Subtle, mustard &amp; freshwater fish — the river\'s table.',                     'chips'=>['Macher Jhol','Rasgulla','Litti Chokha','Pitha']],
          ['region'=>'West',     'class'=>'g-west',      'sub'=>'Bold, sweet-spicy &amp; street food — the merchant\'s plate.',                    'chips'=>['Vada Pav','Dhokla','Dal Baati','Pav Bhaji']],
          ['region'=>'Northeast','class'=>'g-northeast', 'sub'=>'Fermented, smoky &amp; unique — bamboo, hill greens, river salt.',               'chips'=>['Jadoh','Thukpa','Smoked Pork','Bamboo Rice']],
          ['region'=>'Central',  'class'=>'g-central',   'sub'=>'Rustic, tribal &amp; earthy — the cooking of the sal forests.',                   'chips'=>['Poha','Bhutte ka Kees','Dal Bafla','Bhopali Gosht']],
        ];
      @endphp
      @foreach($flavours as $f)
      <article class="flav">
        <div class="top {{ $f['class'] }}"><div class="bg" style="position:absolute;inset:0;"></div><div class="pattern"></div><span class="badge">{{ $f['region'] }}</span><span class="glyph">{{ $f['region'] }}</span></div>
        <div class="body">
          <h3 class="name">{{ $f['region'] }} India</h3>
          <p class="sub">{!! $f['sub'] !!}</p>
          <div>@foreach($f['chips'] as $chip)<span class="dish-chip">{{ $chip }}</span>@endforeach</div>
        </div>
      </article>
      @endforeach
    </div>
  </div>
</section>

{{-- ════════════════════════════════════════
     DISHES BY STATE (live data)
     ════════════════════════════════════════ --}}
<section class="cs dishes-sec">
  <div class="cs-inner">
    <header class="reveal">
      <span class="section-label-shine saffron-shimmer">✦ State Cuisines ✦</span>
      <h2 class="sec-h">What Every State Puts <em>on the Table</em></h2>
      <p class="sec-p">Browse by meal, by diet, or by state — every dish a doorway into a regional way of life.</p>
    </header>

    {{-- Filter bar --}}
    <form method="GET" action="{{ route('cuisine.index') }}" class="filter-bar reveal">
      <div class="f-group">
        <span class="f-label">State</span>
        <select name="state" class="f-select" onchange="this.form.submit()">
          <option value="">All States</option>
          @foreach($states as $st)
            <option value="{{ $st->slug }}" {{ request('state') === $st->slug ? 'selected' : '' }}>{{ $st->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="f-group">
        <span class="f-label">Meal Type</span>
        <select name="meal_type" class="f-select" onchange="this.form.submit()">
          <option value="">All Meals</option>
          @foreach($mealTypes as $mt)
            <option value="{{ $mt }}" {{ request('meal_type') === $mt ? 'selected' : '' }}>{{ ucfirst($mt) }}</option>
          @endforeach
        </select>
      </div>
      <div class="f-group">
        <span class="f-label">Diet</span>
        <select name="vegetarian" class="f-select" onchange="this.form.submit()">
          <option value="">All Diets</option>
          <option value="true"  {{ request('vegetarian') === 'true'  ? 'selected' : '' }}>Vegetarian</option>
          <option value="false" {{ request('vegetarian') === 'false' ? 'selected' : '' }}>Non-Vegetarian</option>
        </select>
      </div>
      @if(request()->anyFilled(['state','meal_type','vegetarian']))
        <a href="{{ route('cuisine.index') }}" class="f-btn f-clear">Clear Filters ×</a>
      @endif
    </form>

    {{-- Dishes grid --}}
    @if($foods->isEmpty())
      <div class="empty-state">
        <h3>No dishes found</h3>
        <p>Try removing a filter to explore more of India's culinary heritage.</p>
        <a href="{{ route('cuisine.index') }}" class="btn btn-secondary">Clear Filters</a>
      </div>
    @else
      <div class="dish-grid">
        @foreach($foods as $food)
          @php
            $mealClass = 'mb-' . strtolower($food->meal_type ?? 'other');
            $imgUrl    = null;
            if (method_exists($food, 'getFirstMediaUrl')) {
              $imgUrl = $food->getFirstMediaUrl('gallery') ?: null;
            }
            if (!$imgUrl && isset($food->image) && $food->image) {
              $imgUrl = \Storage::url($food->image);
            }
            if (!$imgUrl) {
              $imgUrl = 'https://picsum.photos/seed/' . $food->slug . '/600/400';
            }
          @endphp
          <article class="dish">
            <div class="img">
              <img src="{{ $imgUrl }}" alt="{{ $food->name }}" loading="lazy">
              <span class="veg-mark {{ $food->is_vegetarian ? '' : 'nv' }}"><span class="vd"></span></span>
              @if($food->meal_type)
                <span class="meal-badge {{ $mealClass }}">{{ $food->meal_type }}</span>
              @endif
            </div>
            <div class="dish-body">
              @if($food->state)
                <span class="dish-state">{{ $food->state->name }}</span>
              @endif
              <h3 class="dish-name">{{ $food->name }}</h3>
              @if($food->description)
                <p class="dish-desc">{{ \Str::limit(strip_tags($food->description), 120) }}</p>
              @endif
            </div>
          </article>
        @endforeach
      </div>

      {{-- Pagination --}}
      @if($foods->hasPages())
        <div class="pagination-wrap">
          @if($foods->onFirstPage())
            <span class="page-link" style="opacity:0.4;">← Prev</span>
          @else
            <a href="{{ $foods->previousPageUrl() }}" class="page-link">← Prev</a>
          @endif

          @foreach($foods->getUrlRange(max(1, $foods->currentPage() - 2), min($foods->lastPage(), $foods->currentPage() + 2)) as $page => $url)
            <a href="{{ $url }}" class="page-link {{ $page === $foods->currentPage() ? 'active' : '' }}">{{ $page }}</a>
          @endforeach

          @if($foods->hasMorePages())
            <a href="{{ $foods->nextPageUrl() }}" class="page-link">Next →</a>
          @else
            <span class="page-link" style="opacity:0.4;">Next →</span>
          @endif
        </div>
        <p style="text-align:center; font-family:'DM Sans',sans-serif; font-size:0.75rem; color:rgba(13,5,0,0.4); margin-top:12px;">
          Showing {{ $foods->firstItem() }}–{{ $foods->lastItem() }} of {{ $foods->total() }} dishes
        </p>
      @endif
    @endif
  </div>
</section>

{{-- ════════════════════════════════════════
     FOOD FACTS
     ════════════════════════════════════════ --}}
<section class="cs facts-sec">
  <div class="cs-inner">
    <header class="reveal" style="text-align:center;">
      <span class="section-label-shine">✦ Food Facts ✦</span>
      <h2 class="sec-h">India at <em>the Table</em></h2>
      <p class="sec-p" style="margin-left:auto; margin-right:auto; text-align:center;">A subcontinent's appetite, in a few staggering figures.</p>
    </header>
    <div class="facts-grid">
      <div class="fcard reveal"><div class="num">75<span style="font-size:0.55em;">%</span></div><div class="desc">of India is <em>vegetarian-friendly</em> — the largest such cuisine on earth.</div></div>
      <div class="fcard reveal"><div class="num">8,000<span style="font-size:0.55em;">+</span></div><div class="desc">unique <em>regional recipes</em> documented across the twenty-eight states.</div></div>
      <div class="fcard reveal"><div class="num">29</div><div class="desc">UNESCO-recognised <em>culinary traditions</em>, from Lucknowi awadhi to Goan Catholic.</div></div>
      <div class="fcard reveal"><div class="num">6</div><div class="desc">distinct regional <em>cooking oils</em> — ghee, coconut, mustard, sesame, groundnut, sunflower.</div></div>
    </div>
  </div>
</section>

{{-- ════════════════════════════════════════
     CTA
     ════════════════════════════════════════ --}}
<section class="cta-sec">
  <div style="font-size:2rem; color:var(--gold); margin-bottom:24px;" class="reveal">✦</div>
  <h2 class="reveal">Hungry for <em>More</em>?</h2>
  <p class="reveal">Walk through every state's kitchen — its harvests, its hearths, its festival sweets.</p>
  <div class="cta-row reveal">
    <a href="{{ route('states.index') }}" class="btn btn-primary"><span>Explore States</span><span class="arrow">→</span></a>
    <a href="{{ route('festivals.index') }}" class="btn btn-secondary"><span>Festival Calendar</span><span class="arrow">→</span></a>
  </div>
</section>

@endsection

@section('scripts')
<script>
  // Animate flavour and dish cards on scroll
  (function(){
    const io = new IntersectionObserver((entries) => {
      entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); } });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('.flav').forEach((el, i) => {
      el.style.transitionDelay = (i * 60) + 'ms';
      io.observe(el);
    });
    document.querySelectorAll('.dish').forEach((el, i) => {
      el.style.transitionDelay = (i * 40) + 'ms';
      io.observe(el);
    });
    document.querySelectorAll('.fcard').forEach((el, i) => {
      el.style.transitionDelay = (i * 70) + 'ms';
      io.observe(el);
    });
  })();
</script>
@endsection
