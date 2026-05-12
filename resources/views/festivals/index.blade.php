@extends('layouts.app')
@section('title', 'Festival Calendar — Bharatdarshan')
@section('body_class', 'page-dark')

@section('styles')
<style>
  /* ============ SHIMMER LABEL ============ */
  @keyframes shimmer { 0% { background-position: 0% center; } 100% { background-position: 200% center; } }
  .section-label {
    display: inline-block;
    font-family: var(--sans); font-size: 0.72rem;
    letter-spacing: 0.32em; text-transform: uppercase;
    background: linear-gradient(90deg, #C9901A, #F5D876, #C9901A);
    background-size: 200% auto;
    -webkit-background-clip: text; background-clip: text;
    -webkit-text-fill-color: transparent; color: transparent;
    animation: shimmer 3s linear infinite;
    margin-bottom: 14px;
  }

  /* ============ HERO ============ */
  .hero {
    position: relative;
    min-height: 100vh; width: 100%;
    color: #fff;
    background: radial-gradient(ellipse at 60% 40%,
      #8B3A0A 0%, #4A1500 35%,
      #1A0500 65%, #0D0500 100%);
    overflow: hidden;
    display: grid;
    grid-template-columns: 60fr 40fr;
    align-items: center;
    padding: 128px 80px 100px;
    clip-path: polygon(0 0, 100% 0, 100% 92%, 0 100%);
  }
  .hero::before {
    content: "";
    position: absolute; inset: 0;
    background:
      radial-gradient(ellipse at 80% 20%, rgba(232,88,10,0.18), transparent 50%),
      radial-gradient(ellipse at 10% 90%, rgba(201,144,26,0.12), transparent 55%);
    pointer-events: none;
  }
  .particles { position: absolute; inset: 0; pointer-events: none; z-index: 1; }
  .p { position: absolute; border-radius: 50%; background: var(--gold);
       box-shadow: 0 0 6px rgba(201,144,26,0.6); opacity: 0;
       animation: floatUp linear infinite; }
  .p.s { background: var(--saffron); box-shadow: 0 0 8px rgba(232,88,10,0.5); }
  @keyframes floatUp {
    0% { transform: translateY(0); opacity: 0; }
    10% { opacity: 0.6; }
    90% { opacity: 0.3; }
    100% { transform: translateY(-100vh); opacity: 0; }
  }

  .hero-left { position: relative; z-index: 5; max-width: 560px; }
  .hero-pill {
    display: inline-flex; align-items: center; gap: 8px;
    border: 1px solid var(--gold);
    color: var(--gold);
    font-family: var(--serif-sc); font-weight: 500;
    font-size: 0.7rem; letter-spacing: 0.2em;
    padding: 8px 18px; text-transform: uppercase;
    margin-bottom: 30px;
  }
  .hero h1 { font-family: var(--serif); line-height: 1; letter-spacing: -0.01em; }
  .hero h1 .l1 { display: block; font-weight: 700; font-size: clamp(3rem,5vw,5rem); color: #fff; }
  .hero h1 .l2 { display: block; font-weight: 700; font-style: italic; font-size: clamp(4rem,7vw,7rem); color: var(--gold); margin-top: 4px; text-shadow: 0 0 60px rgba(201,144,26,0.35); }
  .gold-line { width: 80px; height: 2px; background: var(--gold); margin: 28px 0 22px; }
  .hero-sub {
    font-family: var(--serif); font-style: italic;
    font-weight: 400; font-size: 1.3rem;
    color: rgba(245,237,216,0.7);
    line-height: 1.5; max-width: 440px;
  }
  .stats { display: flex; gap: 36px; margin-top: 38px; }
  .stat { position: relative; padding-right: 36px; }
  .stat:not(:last-child)::after {
    content: ""; position: absolute; right: 0; top: 8px; bottom: 8px;
    width: 1px; background: rgba(201,144,26,0.35);
  }
  .stat .num { font-family: var(--serif); font-weight: 600; font-size: 2rem; color: var(--gold); line-height: 1; }
  .stat .lab { font-family: var(--sans); font-size: 0.65rem; letter-spacing: 0.18em; text-transform: uppercase; color: rgba(245,237,216,0.55); margin-top: 6px; }

  .anim { opacity: 0; transform: translateY(18px); animation: fadeUp 0.85s cubic-bezier(.2,.7,.2,1) forwards; }
  @keyframes fadeUp { to { opacity: 1; transform: none; } }

  .cal-preview {
    position: relative; z-index: 5;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;
    opacity: 0;
    animation: fadeUp 1s 0.6s cubic-bezier(.2,.7,.2,1) forwards;
    max-width: 420px;
    justify-self: end;
  }
  .cal-cell {
    border: 1px solid rgba(201,144,26,0.08);
    background: rgba(255,255,255,0.02);
    padding: 16px 14px;
    aspect-ratio: 1 / 0.85;
    display: flex; flex-direction: column; justify-content: space-between;
    transition: background 0.25s, border-color 0.25s;
    cursor: pointer;
  }
  .cal-cell.has { background: rgba(201,144,26,0.08); border-color: rgba(201,144,26,0.2); }
  .cal-cell:hover { background: rgba(232,88,10,0.12); border-color: var(--saffron); }
  .cal-cell .m { font-family: var(--serif-sc); font-weight: 600; font-size: 0.85rem; color: var(--gold); letter-spacing: 0.08em; }
  .cal-cell .dots { display: flex; gap: 4px; align-items: center; height: 8px; }
  .cal-cell .dots span { width: 6px; height: 6px; border-radius: 50%; background: var(--saffron); }

  .scroll-ind { position: absolute; bottom: 38px; left: 50%; transform: translateX(-50%);
    display: flex; flex-direction: column; align-items: center; gap: 10px; z-index: 5;
    opacity: 0; animation: fadeUp 1s 1.1s forwards; }
  .scroll-ind span { font-family: var(--sans); font-size: 0.62rem; letter-spacing: 0.32em; text-transform: uppercase; color: rgba(245,237,216,0.55); }
  .scroll-ind svg { animation: bounceArrow 1.8s ease-in-out infinite; }
  @keyframes bounceArrow { 0%, 100% { transform: translateY(0); opacity: 0.6; } 50% { transform: translateY(8px); opacity: 1; } }

  /* ============ FILTER BAR ============ */
  .filter-bar {
    position: sticky; top: 64px; z-index: 100;
    width: 100%;
    background: rgba(255,255,255,0.98);
    backdrop-filter: blur(12px);
    box-shadow: 0 4px 30px rgba(13,5,0,0.1);
    padding: 20px 80px;
    display: grid; grid-template-columns: 1.5fr 1fr 1fr 0.9fr;
    gap: 36px; align-items: end;
    opacity: 0; transform: translateY(-20px);
    transition: opacity 0.45s ease, transform 0.45s ease;
  }
  .filter-bar.in { opacity: 1; transform: none; }
  .f-label { display: block; font-family: var(--sans); font-size: 0.62rem; letter-spacing: 0.24em; text-transform: uppercase; color: rgba(13,5,0,0.45); margin-bottom: 8px; }
  .f-input, .f-select {
    width: 100%;
    font-family: var(--sans); font-weight: 400; font-size: 0.95rem;
    color: var(--ink);
    background: transparent;
    border: none;
    border-bottom: 1.5px solid rgba(201,144,26,0.3);
    padding: 8px 0 8px 26px;
    appearance: none;
    transition: border-color 0.2s;
  }
  .f-input:focus, .f-select:focus { outline: none; border-bottom-color: var(--gold); }
  .f-search { position: relative; }
  .f-search::before { content: ""; position: absolute; left: 0; bottom: 12px; width: 14px; height: 14px; border: 1.5px solid var(--gold); border-radius: 50%; }
  .f-search::after { content: ""; position: absolute; left: 11px; bottom: 6px; width: 6px; height: 1.5px; background: var(--gold); transform: rotate(45deg); transform-origin: left; }
  .f-sel { position: relative; }
  .f-sel::after { content: ""; position: absolute; right: 4px; bottom: 14px; width: 7px; height: 7px; border-right: 1.5px solid var(--gold); border-bottom: 1.5px solid var(--gold); transform: rotate(45deg); pointer-events: none; }
  .f-count { font-family: var(--serif); font-style: italic; font-weight: 500; color: var(--gold); font-size: 1.1rem; }
  .f-clear { display: block; margin-top: 6px; font-family: var(--sans); font-size: 0.7rem; letter-spacing: 0.18em; color: var(--saffron); text-transform: uppercase; cursor: pointer; }

  /* ============ TICKER ============ */
  .ticker { background: var(--ink); padding: 24px 0; overflow: hidden; }
  .ticker-label { text-align: center; font-family: var(--serif-sc); font-size: 0.72rem; letter-spacing: 0.32em; color: var(--gold); text-transform: uppercase; margin-bottom: 14px; }
  .ticker-track { display: flex; gap: 60px; width: max-content; align-items: center; animation: ticker 35s linear infinite; }
  .ticker-track:hover { animation-play-state: paused; }
  @keyframes ticker { from { transform: translateX(0); } to { transform: translateX(-50%); } }
  .t-item { display: flex; align-items: center; gap: 14px; white-space: nowrap; }
  .t-name { font-family: var(--serif); font-weight: 600; font-size: 1.1rem; color: #fff; }
  .t-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--c, #fff); display: inline-block; }
  .t-meta { font-family: var(--sans); font-size: 0.7rem; letter-spacing: 0.18em; text-transform: uppercase; color: rgba(245,237,216,0.5); }
  .t-sep { color: var(--gold); font-family: var(--serif); }

  /* ============ CALENDAR SECTION ============ */
  .calendar-section { background: var(--cream); padding: 80px; color: var(--ink); }
  .cal-head { max-width: 1400px; margin: 0 auto 50px; display: flex; justify-content: space-between; align-items: flex-end; gap: 24px; flex-wrap: wrap; }
  .cal-head-left h2 { font-family: var(--serif); font-weight: 700; font-size: 3rem; color: var(--ink-2, #1A0A00); line-height: 1.05; letter-spacing: -0.01em; }
  .view-toggle { display: flex; }
  .vt { font-family: var(--sans); font-size: 0.72rem; letter-spacing: 0.18em; text-transform: uppercase; padding: 10px 18px; border: 1px solid var(--gold); color: var(--gold); background: transparent; cursor: pointer; transition: all 0.2s; }
  .vt.active { background: var(--saffron); color: #fff; border-color: var(--saffron); }
  .vt:first-child { border-right: none; }

  .months { max-width: 1400px; margin: 0 auto; }
  .month-section { position: relative; padding: 48px 0 24px; }
  .month-big-num { position: absolute; left: 0; top: 0; font-family: var(--serif); font-weight: 700; font-size: 9rem; line-height: 1; color: #1A0A00; opacity: 0.04; pointer-events: none; z-index: 0; }
  .month-head { position: relative; z-index: 1; display: flex; align-items: center; gap: 16px; margin-bottom: 28px; }
  .month-name { font-family: var(--sans); font-weight: 500; font-size: 0.78rem; letter-spacing: 0.3em; text-transform: uppercase; color: var(--saffron); }
  .month-rule { flex-grow: 1; height: 1px; background: rgba(201,144,26,0.25); }
  .month-count { background: var(--saffron); color: #fff; font-family: var(--sans); font-weight: 500; font-size: 0.7rem; letter-spacing: 0.1em; padding: 4px 12px; text-transform: uppercase; }
  .month-empty { font-family: var(--serif); font-style: italic; font-weight: 300; font-size: 0.95rem; color: rgba(13,5,0,0.4); padding: 4px 0 16px; }
  .month-section.dim .month-name { color: rgba(201,144,26,0.5); }
  .month-section.dim .month-big-num { opacity: 0.025; }

  .cards-row { display: flex; gap: 20px; overflow-x: auto; padding-bottom: 16px; scrollbar-width: none; }
  .cards-row::-webkit-scrollbar { display: none; }

  .festival-card {
    flex: 0 0 260px; background: #fff; overflow: hidden; cursor: pointer;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    display: flex; flex-direction: column;
    color: var(--ink); text-decoration: none;
  }
  .festival-card:hover { transform: translateY(-5px); box-shadow: 0 16px 40px rgba(13,5,0,0.12); }
  .card-top { position: relative; height: 130px; overflow: hidden; }
  .card-top .first-word { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; font-family: var(--serif); font-style: italic; font-weight: 600; font-size: 4rem; color: #fff; opacity: 0.12; line-height: 1; pointer-events: none; letter-spacing: -0.02em; }
  .rel-badge { position: absolute; top: 10px; left: 10px; background: rgba(0,0,0,0.3); color: #fff; font-family: var(--sans); font-weight: 500; font-size: 0.62rem; letter-spacing: 0.18em; padding: 4px 10px; text-transform: uppercase; backdrop-filter: blur(4px); }
  .card-body { background: #fff; border-left: 3px solid var(--c, var(--gold)); padding: 16px 16px 18px; flex: 1; display: flex; flex-direction: column; gap: 4px; }
  .card-name { font-family: var(--serif); font-weight: 600; font-size: 1.2rem; color: #1A0A00; line-height: 1.2; }
  .card-meta { display: flex; gap: 12px; align-items: center; margin-top: 2px; }
  .card-state { font-family: var(--sans); font-weight: 300; font-size: 0.72rem; color: var(--gold); letter-spacing: 0.05em; }
  .card-dur { font-family: var(--sans); font-weight: 400; font-size: 0.72rem; color: var(--saffron); }
  .card-tag { font-family: var(--serif); font-style: italic; font-size: 0.92rem; line-height: 1.45; color: #6B5B47; margin-top: 10px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
  .card-link { font-family: var(--sans); font-weight: 500; font-size: 0.78rem; letter-spacing: 0.16em; color: var(--saffron); text-transform: uppercase; margin-top: 12px; display: inline-flex; gap: 6px; transition: gap 0.2s; }
  .festival-card:hover .card-link { gap: 12px; }

  .g-hindu { background: linear-gradient(135deg, #E8580A, #8B1A1A); }
  .g-muslim { background: linear-gradient(135deg, #2D6A4F, #1B4F8A); }
  .g-sikh { background: linear-gradient(135deg, #1B4F8A, #4A90D9); }
  .g-christian { background: linear-gradient(135deg, #8B1A1A, #C0392B); }
  .g-buddhist { background: linear-gradient(135deg, #4A0404, #8B1A1A); }
  .g-secular { background: linear-gradient(135deg, #C9901A, #E8580A); }
  .g-jain { background: linear-gradient(135deg, #8B6914, #C9901A); }
  .g-tribal { background: linear-gradient(135deg, #4A3000, #8B5A00); }

  /* ============ RELIGION MOSAIC ============ */
  .religions { background: var(--parchment); padding: 80px; color: var(--ink); }
  .religions-head { max-width: 1400px; margin: 0 auto 50px; text-align: center; }
  .religions-head h2 { font-family: var(--serif); font-weight: 700; font-size: 3rem; color: var(--ink); letter-spacing: -0.01em; }
  .religions-head p { font-family: var(--sans); font-weight: 300; font-size: 1.05rem; color: rgba(13,5,0,0.58); margin-top: 12px; max-width: 540px; margin-left: auto; margin-right: auto; }
  .mosaic { max-width: 1400px; margin: 0 auto; display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; grid-template-rows: 140px 140px; gap: 12px; }
  .tile { padding: 24px; display: flex; flex-direction: column; justify-content: flex-end; gap: 4px; cursor: pointer; transition: all 0.25s ease; color: #fff; position: relative; overflow: hidden; }
  .tile:hover { transform: scale(1.02); filter: brightness(1.1); z-index: 2; }
  .tile-name { font-family: var(--serif); font-weight: 700; font-size: 2rem; line-height: 1; }
  .tile-count { font-family: var(--sans); font-size: 0.7rem; letter-spacing: 0.22em; text-transform: uppercase; color: rgba(255,255,255,0.78); }
  .tile-arrow { position: absolute; top: 22px; right: 22px; color: rgba(255,255,255,0.6); font-family: var(--serif); font-size: 1.2rem; transition: transform 0.25s, color 0.25s; }
  .tile:hover .tile-arrow { transform: translate(4px, -4px); color: #fff; }
  .tile.hindu { grid-row: span 2; }
  .tile.secular-wide { grid-column: span 2; }

  /* ============ FINAL CTA ============ */
  .final-cta { background: var(--ink); padding: 100px 80px; text-align: center; }
  .final-cta .orn { color: var(--gold); font-family: var(--serif); font-size: 2rem; margin-bottom: 24px; }
  .final-cta h2 { font-family: var(--serif); font-weight: 700; font-size: 3.5rem; color: #fff; line-height: 1.05; letter-spacing: -0.01em; }
  .final-cta p { font-family: var(--sans); font-weight: 300; font-size: 1rem; color: rgba(245,237,216,0.6); max-width: 500px; margin: 22px auto 38px; line-height: 1.7; }
  .cta-btns { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; }
  .btn { font-family: var(--sans); font-weight: 500; font-size: 0.78rem; letter-spacing: 0.22em; padding: 16px 30px; text-transform: uppercase; cursor: pointer; transition: all 0.25s ease; display: inline-flex; align-items: center; gap: 8px; }
  .btn-fill { background: var(--saffron); color: #fff; border: 1px solid var(--saffron); }
  .btn-fill:hover { background: #ff6a1a; }
  .btn-line { background: transparent; border: 1px solid var(--gold); color: var(--gold); }
  .btn-line:hover { background: var(--gold); color: var(--ink); }

  /* ============ REVEAL ============ */
  .reveal { opacity: 0; transform: translateY(20px); transition: opacity 0.9s ease, transform 0.9s cubic-bezier(.2,.7,.2,1); }
  .reveal.in { opacity: 1; transform: none; }

  @media (max-width: 1024px) {
    .hero { grid-template-columns: 1fr; padding: 110px 32px 80px; }
    .cal-preview { justify-self: start; margin-top: 40px; max-width: 100%; }
    .calendar-section, .religions, .final-cta { padding: 60px 32px; }
    .filter-bar { padding: 16px 32px; grid-template-columns: 1fr 1fr; gap: 20px; }
    .festival-card { flex: 0 0 230px; }
    .mosaic { grid-template-columns: 2fr 1fr 1fr; grid-template-rows: 120px 120px 120px; }
    .tile.hindu { grid-row: span 2; }
    .tile.secular-wide { grid-column: span 1; }
  }
  @media (max-width: 768px) {
    .hero { padding: 100px 24px 80px; }
    .hero h1 .l1 { font-size: 3.5rem; }
    .hero h1 .l2 { font-size: 5rem; }
    .stats { gap: 18px; }
    .stat { padding-right: 18px; }
    .cal-preview { grid-template-columns: 1fr 1fr; }
    .filter-bar { grid-template-columns: 1fr 1fr; padding: 16px 22px; gap: 18px; }
    .calendar-section, .religions, .final-cta { padding: 60px 22px; }
    .month-big-num { font-size: 5rem; }
    .festival-card { flex: 0 0 200px; }
    .cal-head-left h2 { font-size: 2rem; }
    .mosaic { grid-template-columns: 1fr 1fr; grid-template-rows: repeat(4, 120px); }
    .tile.hindu, .tile.secular-wide { grid-row: auto; grid-column: auto; }
    .final-cta h2 { font-size: 2.2rem; }
  }
</style>
@endsection

@section('content')

<!-- HERO -->
<section class="hero" id="hero" data-screen-label="01 Hero">
  <div class="particles" id="particles" aria-hidden="true"></div>

  <div class="hero-left">
    <div class="hero-pill anim" style="animation-delay:0ms">
      <span>✦</span><span>Festivals of India</span><span>✦</span>
    </div>
    <h1>
      <span class="l1 anim" style="animation-delay:100ms">365 Days of</span>
      <span class="l2 anim" style="animation-delay:250ms">Celebration</span>
    </h1>
    <div class="gold-line anim" style="animation-delay:400ms"></div>
    <p class="hero-sub anim" style="animation-delay:500ms">A tradition for every season. A festival for every soul.</p>
    <div class="stats anim" style="animation-delay:700ms">
      <div class="stat">
        <div class="num">{{ $festivals->count() }}</div>
        <div class="lab">Festivals</div>
      </div>
      <div class="stat">
        <div class="num">{{ $festivals_by_religion->count() }}</div>
        <div class="lab">Traditions</div>
      </div>
      <div class="stat">
        <div class="num">12</div>
        <div class="lab">Months</div>
      </div>
    </div>
  </div>

  @php
    $calCells = collect(range(1, 12))->map(fn($m) => [
      'abbr' => \Carbon\Carbon::create()->month($m)->format('M'),
      'dots' => min(($grouped_by_month[$m] ?? collect())->count(), 3),
    ]);
  @endphp
  <div class="cal-preview" aria-hidden="true">
    @foreach($calCells as $cell)
      <div class="cal-cell {{ $cell['dots'] > 0 ? 'has' : '' }}">
        <div class="m">{{ strtoupper($cell['abbr']) }}</div>
        <div class="dots">@for($i = 0; $i < $cell['dots']; $i++)<span></span>@endfor</div>
      </div>
    @endforeach
  </div>

  <div class="scroll-ind">
    <span>Scroll to explore</span>
    <svg width="14" height="22" viewBox="0 0 14 22" fill="none" stroke="#C9901A" stroke-width="1.5">
      <path d="M7 2 V18 M2 13 L7 18 L12 13" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
  </div>
</section>

<!-- FILTER BAR -->
<form method="GET" action="{{ route('festivals.index') }}" class="filter-bar" id="filterBar">
  <div class="f-search">
    <label class="f-label" for="fsearch">Search</label>
    <input id="fsearch" class="f-input" type="text" name="search"
           value="{{ request('search') }}" placeholder="Search festivals…" />
  </div>
  <div class="f-sel">
    <label class="f-label" for="freligion">Religion</label>
    <select id="freligion" class="f-select" name="religion" onchange="this.form.submit()">
      <option value="">All Religions</option>
      @foreach(['Hindu','Muslim','Sikh','Christian','Buddhist','Secular','Tribal'] as $r)
        <option value="{{ $r }}" {{ request('religion') == $r ? 'selected' : '' }}>{{ $r }}</option>
      @endforeach
    </select>
  </div>
  <div class="f-sel">
    <label class="f-label" for="fmonth">Month</label>
    <select id="fmonth" class="f-select" name="month" onchange="this.form.submit()">
      <option value="">All Months</option>
      @foreach(range(1, 12) as $m)
        <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
          {{ \Carbon\Carbon::create()->month($m)->format('F') }}
        </option>
      @endforeach
    </select>
  </div>
  <div>
    <div class="f-count">{{ $festivals->count() }} {{ Str::plural('Festival', $festivals->count()) }}</div>
    @if(request()->hasAny(['search', 'religion', 'month']))
      <a class="f-clear" href="{{ route('festivals.index') }}">Clear →</a>
    @endif
  </div>
</form>

<!-- TICKER -->
<section class="ticker" data-screen-label="02 Featured Ticker">
  <div class="ticker-label">✦ &nbsp;Featured Festivals&nbsp; ✦</div>
  <div class="ticker-track">
    @php
      $religionColors = ['Hindu'=>'#E8580A','Muslim'=>'#2D6A4F','Sikh'=>'#1B4F8A','Christian'=>'#C0392B','Buddhist'=>'#4A0404','Secular'=>'#C9901A'];
      $tickerItems = array_merge($festivals->toArray(), $festivals->toArray());
    @endphp
    @foreach($tickerItems as $tf)
      <div class="t-item">
        <span class="t-name">{{ $tf['name'] }}</span>
        <span class="t-dot" style="--c:{{ $religionColors[$tf['religion']] ?? '#C9901A' }}"></span>
        <span class="t-meta">{{ $tf['religion'] }} · {{ \Carbon\Carbon::create()->month($tf['month'])->format('F') }}</span>
        <span class="t-sep">✦</span>
      </div>
    @endforeach
  </div>
</section>

<!-- CALENDAR -->
<section class="calendar-section" data-screen-label="03 Festival Calendar">
  <div class="cal-head reveal">
    <div class="cal-head-left">
      <span class="section-label">✦ &nbsp;Festival Calendar&nbsp; ✦</span>
      <h2>India's Year of Festivals</h2>
    </div>
    <div class="view-toggle">
      <button type="button" class="vt active">☰ Calendar View</button>
      <button type="button" class="vt">⊞ Grid View</button>
    </div>
  </div>

  <div class="months">
    @php
      $gradClasses = ['Hindu'=>'g-hindu','Muslim'=>'g-muslim','Sikh'=>'g-sikh','Christian'=>'g-christian','Buddhist'=>'g-buddhist','Secular'=>'g-secular','Jain'=>'g-jain','Tribal'=>'g-tribal'];
      $borderColors = ['Hindu'=>'#E8580A','Muslim'=>'#2D6A4F','Sikh'=>'#1B4F8A','Christian'=>'#C0392B','Buddhist'=>'#4A0404','Secular'=>'#C9901A','Jain'=>'#C9901A','Tribal'=>'#8B5A00'];
    @endphp

    @foreach(range(1, 12) as $monthNum)
      @php
        $monthFests = $grouped_by_month[$monthNum] ?? collect();
        $monthName  = \Carbon\Carbon::create()->month($monthNum)->format('F');
        $isEmpty    = $monthFests->count() === 0;
      @endphp

      <div class="month-section reveal {{ $isEmpty ? 'dim' : '' }}" data-month="{{ $monthNum }}">
        <div class="month-big-num">{{ str_pad($monthNum, 2, '0', STR_PAD_LEFT) }}</div>
        <div class="month-head">
          <span class="month-name">{{ strtoupper($monthName) }}</span>
          <div class="month-rule"></div>
          @if(!$isEmpty)
            <span class="month-count">{{ $monthFests->count() }} {{ Str::plural('Festival', $monthFests->count()) }} this month</span>
          @endif
        </div>

        @if(!$isEmpty)
          <div class="cards-row">
            @foreach($monthFests as $festival)
              <a href="{{ route('festivals.show', $festival->slug) }}"
                 class="festival-card"
                 style="--c:{{ $borderColors[$festival->religion] ?? '#C9901A' }}">
                <div class="card-top {{ $gradClasses[$festival->religion] ?? 'g-hindu' }}">
                  <span class="rel-badge">{{ $festival->religion }}</span>
                  <div class="first-word">{{ Str::words($festival->name, 1, '') }}</div>
                </div>
                <div class="card-body">
                  <div class="card-name">{{ $festival->name }}</div>
                  <div class="card-meta">
                    <span class="card-state">{{ $festival->is_national ? 'Pan India' : ($festival->state->name ?? 'India') }}</span>
                    <span style="color:rgba(13,5,0,0.15)">·</span>
                    <span class="card-dur">{{ $festival->duration_days }} {{ Str::plural('Day', $festival->duration_days) }}</span>
                  </div>
                  <div class="card-tag">{{ $festival->tagline }}</div>
                  <span class="card-link">Know More →</span>
                </div>
              </a>
            @endforeach
          </div>
        @else
          <div class="month-empty">No featured festivals this month</div>
        @endif
      </div>
    @endforeach
  </div>
</section>

<!-- RELIGION MOSAIC -->
<section class="religions" data-screen-label="04 Explore by Tradition">
  <div class="religions-head reveal">
    <span class="section-label">✦ &nbsp;Explore by Tradition&nbsp; ✦</span>
    <h2>Celebrate Every Faith</h2>
    <p>From the bonfire nights of Punjab to the harvest feasts of Kerala — every tradition has its own calendar of joy.</p>
  </div>
  <div class="mosaic">
    @php
      $tileGrads  = ['Hindu'=>'g-hindu','Muslim'=>'g-muslim','Sikh'=>'g-sikh','Christian'=>'g-christian','Buddhist'=>'g-buddhist','Secular'=>'g-secular','Jain'=>'g-jain','Tribal'=>'g-tribal'];
      $firstTile  = true;
      $secularDone = false;
    @endphp
    @foreach($festivals_by_religion as $religion => $count)
      @php
        $isHindu    = $firstTile;
        $isSecular  = ($religion === 'Secular' && !$secularDone);
        if ($isHindu)   $firstTile  = false;
        if ($isSecular) $secularDone = true;
        $extraClass = ($isHindu ? 'hindu ' : '') . ($isSecular ? 'secular-wide ' : '');
      @endphp
      <div class="tile {{ $extraClass }}{{ $tileGrads[$religion] ?? 'g-hindu' }} reveal"
           onclick="window.location='{{ route('festivals.index') }}?religion={{ urlencode($religion) }}'">
        <span class="tile-arrow">→</span>
        <div class="tile-name">{{ $religion }}</div>
        <div class="tile-count">{{ $count }} {{ Str::plural('Festival', $count) }}</div>
      </div>
    @endforeach
  </div>
</section>

<!-- FINAL CTA -->
<section class="final-cta" data-screen-label="05 Final CTA">
  <div class="orn reveal">✦</div>
  <h2 class="reveal">Never Miss a Festival Again</h2>
  <p class="reveal">Explore every tradition, every ritual, and every celebration across India's 28 states.</p>
  <div class="cta-btns reveal">
    <a class="btn btn-fill" href="{{ route('states.index') }}">Explore All States →</a>
    <a class="btn btn-line" href="{{ route('monuments.index') }}">View Heritage →</a>
  </div>
</section>

@push('scripts')
<script>
  // Particles
  (function () {
    const host = document.getElementById('particles');
    const rand = (a, b) => Math.random() * (b - a) + a;
    for (let i = 0; i < 22; i++) {
      const p = document.createElement('div');
      p.className = 'p' + (Math.random() < 0.4 ? ' s' : '');
      const sz = rand(2, 5);
      p.style.cssText = `width:${sz}px;height:${sz}px;left:${rand(0,100)}%;top:${rand(60,110)}%;animation-duration:${rand(6,12)}s;animation-delay:-${rand(0,8)}s`;
      host.appendChild(p);
    }
  })();

  // Filter bar appears when hero scrolls out
  const filterBar = document.getElementById('filterBar');
  const heroEl    = document.getElementById('hero');
  new IntersectionObserver((entries) => {
    filterBar.classList.toggle('in', !entries[0].isIntersecting);
  }, { threshold: 0, rootMargin: '-200px 0px 0px 0px' }).observe(heroEl);

  // Scroll reveal
  const revealIO = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        setTimeout(() => e.target.classList.add('in'), parseInt(e.target.dataset.delay || 0));
        revealIO.unobserve(e.target);
      }
    });
  }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
  document.querySelectorAll('.reveal').forEach(el => revealIO.observe(el));

  // Card stagger
  document.querySelectorAll('.cards-row').forEach(row => {
    const cardIO = new IntersectionObserver((entries) => {
      if (entries[0].isIntersecting) {
        [...entries[0].target.children].forEach((c, i) => {
          c.style.transition = `opacity 0.6s ease ${i*60}ms, transform 0.6s cubic-bezier(.2,.7,.2,1) ${i*60}ms`;
          c.style.opacity = '1';
          c.style.transform = 'none';
        });
        cardIO.disconnect();
      }
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
    [...row.children].forEach(c => { c.style.opacity = '0'; c.style.transform = 'translateY(14px)'; });
    cardIO.observe(row);
  });

  // View toggle (visual only)
  document.querySelectorAll('.vt').forEach(b => {
    b.addEventListener('click', () => {
      document.querySelectorAll('.vt').forEach(x => x.classList.remove('active'));
      b.classList.add('active');
    });
  });

  // Search on Enter
  document.getElementById('fsearch').addEventListener('keydown', e => {
    if (e.key === 'Enter') e.target.closest('form').submit();
  });
</script>
@endpush

@endsection
