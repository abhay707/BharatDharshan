@extends('layouts.app')

@section('title', 'Heritage of India — Monuments & Heritage Sites')
@section('meta_description', 'Explore India\'s protected monuments — UNESCO World Heritage Sites, ASI forts, ancient temples, stepwells, caves and palaces across 28 states.')

@section('styles')
<style>

  
  
  
  .text-label { font-family: "DM Sans", sans-serif; font-size: 0.65rem; letter-spacing: 0.22em; text-transform: uppercase; font-weight: 500; }

  /* HERO */
  .hero { position: relative; min-height: 100vh; background: linear-gradient(to top, rgba(13,5,0,0.88) 0%, rgba(13,5,0,0.55) 45%, rgba(13,5,0,0.30) 100%), url('/images/heritage-hero.jpg') center center / cover no-repeat; padding: 128px 80px 96px; display: flex; align-items: center; overflow: hidden; }
  .hero::before { content: ""; position: absolute; inset: 0; opacity: 0.4; mix-blend-mode: overlay; pointer-events: none; background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='200' height='200'><filter id='n'><feTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='2' stitchTiles='stitch'/><feColorMatrix values='0 0 0 0 0.85  0 0 0 0 0.65  0 0 0 0 0.3  0 0 0 0.18 0'/></filter><rect width='100%' height='100%' filter='url(%23n)'/></svg>"); }
  .yantra { position: absolute; right: -80px; top: 50%; transform: translateY(-50%); width: 700px; height: 700px; opacity: 0.08; pointer-events: none; animation: rotate 60s linear infinite; }
  @keyframes rotate { to { transform: translateY(-50%) rotate(360deg); } }
  .hero-left { position: relative; z-index: 3; max-width: 720px; }
  .pill { display: inline-flex; align-items: center; gap: 10px; border: 1px solid var(--gold); padding: 7px 16px; font-family: "DM Sans", sans-serif; font-size: 10px; letter-spacing: 0.22em; color: var(--gold); text-transform: uppercase; margin-bottom: 32px; opacity: 0; animation: fadeUp 0.9s ease forwards; animation-delay: 100ms; }
  .hero h1 { font-family: "Cormorant Garamond", serif; line-height: 0.95; letter-spacing: -0.01em; }
  .hero h1 .l1, .hero h1 .l2 { display: block; opacity: 0; transform: translateY(28px); animation: fadeUp 1s cubic-bezier(0.2, 0.7, 0.2, 1) forwards; }
  .hero h1 .l1 { font-weight: 700; font-size: clamp(2.4rem, 4.4vw, 4rem); color: var(--parchment); animation-delay: 220ms; }
  .hero h1 .l2 { font-weight: 700; font-style: italic; font-size: clamp(4.2rem, 7vw, 6rem); color: var(--gold); margin-left: -4px; animation-delay: 380ms; }
  .gold-line { width: 80px; height: 2px; background: var(--gold); margin: 24px 0; opacity: 0; animation: fadeIn 0.8s ease forwards; animation-delay: 540ms; }
  .hero-sub { font-family: "DM Sans", sans-serif; font-weight: 300; font-size: 1.05rem; line-height: 1.85; color: rgba(245,237,216,0.78); max-width: 540px; margin-bottom: 28px; opacity: 0; animation: fadeUp 1s ease forwards; animation-delay: 640ms; }
  .hero-sub em { font-family: "Cormorant Garamond", serif; font-style: italic; color: var(--parchment); }
  .stat-pill { font-family: "DM Sans", sans-serif; font-size: 0.7rem; letter-spacing: 0.2em; color: var(--gold); text-transform: uppercase; border: 1px solid var(--gold); padding: 9px 16px; background: rgba(13,5,0,0.2); backdrop-filter: blur(4px); display: inline-flex; align-items: center; gap: 8px; opacity: 0; animation: fadeUp 1s ease forwards; animation-delay: 780ms; }
  .stat-pill .num { font-family: "Cormorant Garamond", serif; font-style: italic; font-size: 0.95rem; color: var(--parchment); letter-spacing: 0; }

  /* FILTER BAR */
  .filter-bar { position: sticky; top: 64px; z-index: 90; width: 100%; background: white; color: #1A0A00; --faint: rgba(13,5,0,0.40); --muted: rgba(13,5,0,0.62); --hairline: rgba(13,5,0,0.10); box-shadow: 0 28px 70px rgba(13,5,0,0.22), 0 4px 12px rgba(13,5,0,0.06); padding: 24px 80px; display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 28px; align-items: end; border-top: 1px solid rgba(201,144,26,0.25); transition: box-shadow 0.3s ease; }
  .filter-bar.past-hero { box-shadow: 0 8px 40px rgba(13,5,0,0.24), 0 2px 10px rgba(13,5,0,0.10); border-top-color: rgba(201,144,26,0.4); }
  @keyframes dropIn { to { opacity: 1; transform: translateY(0); } }
  .f { display: flex; flex-direction: column; gap: 6px; }
  .f-label { font-family: "DM Sans", sans-serif; font-size: 0.6rem; letter-spacing: 0.24em; color: var(--faint); text-transform: uppercase; font-weight: 500; }
  .f-select { appearance: none; -webkit-appearance: none; background: transparent; border: none; border-bottom: 1.5px solid var(--hairline); padding: 6px 24px 6px 0; font-family: "Cormorant Garamond", serif; font-weight: 500; font-size: 1.1rem; color: var(--ink); cursor: pointer; transition: border-color 0.35s ease; background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='none' stroke='%23C9901A' stroke-width='1.5'><path d='M3 6 L8 11 L13 6'/></svg>"); background-repeat: no-repeat; background-position: right center; background-size: 14px; outline: none; }
  .f-select:focus { border-bottom-color: var(--gold); }
  .clear { font-family: "DM Sans", sans-serif; font-size: 11px; font-weight: 500; letter-spacing: 0.18em; color: var(--saffron); text-transform: uppercase; background: none; border: none; cursor: pointer; padding: 8px 0; transition: color 0.3s ease; align-self: end; }
  .clear:hover { color: var(--gold); }

  /* SECTION */
  .heritage-content {
    max-width: 1280px;
    margin: 0 auto;
    padding: 80px 64px 0;
    background: #FAF6EE;
    color: #1A0A00;
    --muted: rgba(13, 5, 0, 0.62);
    --faint: rgba(13, 5, 0, 0.40);
    --hairline: rgba(13, 5, 0, 0.10);
  }
  .section-eye { display: inline-flex; align-items: center; gap: 10px; font-family: "DM Sans", sans-serif; font-size: 0.65rem; letter-spacing: 0.28em; color: #C9901A; text-transform: uppercase; margin-bottom: 12px; }
  .section-title { font-family: "Cormorant Garamond", serif; font-weight: 600; font-size: clamp(1.8rem, 3.4vw, 2.4rem); color: #1A0A00; line-height: 1.05; letter-spacing: -0.01em; }
  .section-title em { font-style: italic; color: #E8580A; }
  .section-rule { margin-top: 16px; width: 100%; height: 1px; background: linear-gradient(to right, var(--gold) 0%, var(--gold) 80px, var(--hairline) 80px, var(--hairline) 100%); margin-bottom: 36px; }

  /* FEATURED */
  .featured-section { margin-bottom: 80px; }
  .featured-row { display: flex; gap: 18px; overflow-x: auto; padding-bottom: 16px; scroll-snap-type: x mandatory; }
  .featured-row::-webkit-scrollbar { height: 6px; }
  .featured-row::-webkit-scrollbar-track { background: rgba(13,5,0,0.06); }
  .featured-row::-webkit-scrollbar-thumb { background: var(--gold); }
  .feat { flex: 0 0 380px; height: 260px; position: relative; overflow: hidden; cursor: pointer; scroll-snap-align: start; opacity: 0; transform: translateY(20px); transition: opacity 0.7s ease, transform 0.7s ease; }
  .feat.in { opacity: 1; transform: translateY(0); }
  .feat .bg { position: absolute; inset: 0; transition: transform 0.7s cubic-bezier(0.2,0.7,0.2,1); }
  .feat:hover .bg { transform: scale(1.06); }
  .feat .pattern { position: absolute; inset: 0; background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='80' height='80'><g fill='none' stroke='white' stroke-width='0.4' opacity='0.5'><path d='M40 5 L 75 40 L 40 75 L 5 40 Z'/><circle cx='40' cy='40' r='28'/><circle cx='40' cy='40' r='14'/></g></svg>"); background-size: 80px; opacity: 0.16; mix-blend-mode: overlay; pointer-events: none; }
  .feat .glyph { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -55%); font-family: "Cormorant Garamond", serif; font-weight: 700; font-style: italic; font-size: 12rem; line-height: 1; color: rgba(255,255,255,0.13); pointer-events: none; }
  .feat .overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(13,5,0,0.85) 0%, rgba(13,5,0,0.1) 70%); transition: background 0.4s ease; }
  .feat:hover .overlay { background: linear-gradient(to top, rgba(13,5,0,0.78) 0%, rgba(13,5,0,0.06) 70%); }
  .feat .cat-badge { position: absolute; top: 14px; right: 14px; z-index: 3; font-family: "DM Sans", sans-serif; font-size: 0.6rem; font-weight: 600; letter-spacing: 0.22em; text-transform: uppercase; padding: 5px 10px; color: white; }
  .cat-unesco { background: var(--lapis); }
  .cat-asi { background: var(--jade); }
  .cat-religious { background: var(--saffron); }
  .cat-state { background: rgba(13,5,0,0.55); border: 1px solid rgba(255,255,255,0.25); backdrop-filter: blur(4px); }
  .feat .body { position: absolute; bottom: 0; left: 0; right: 0; padding: 20px; z-index: 3; color: white; }
  .feat .name { font-family: "Cormorant Garamond", serif; font-weight: 700; font-style: italic; font-size: 1.6rem; line-height: 1.05; letter-spacing: -0.005em; transition: transform 0.4s ease; transform-origin: left bottom; margin-bottom: 6px; color: white; }
  .feat:hover .name { transform: scale(1.04); }
  .feat .meta { font-family: "DM Sans", sans-serif; font-size: 0.6rem; letter-spacing: 0.22em; color: #C9901A; text-transform: uppercase; font-weight: 500; margin-bottom: 8px; }
  .feat .desc { font-family: "DM Sans", sans-serif; font-weight: 300; font-size: 0.78rem; line-height: 1.5; color: rgba(255,255,255,0.72); display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

  /* gradients per monument */
  .g-amber { background: linear-gradient(160deg, #E8580A 0%, #C9901A 60%, #6b3c08 100%); }
  .g-rose { background: linear-gradient(160deg, #E8758C 0%, #8B1A1A 60%, #4a0a0a 100%); }
  .g-gold { background: linear-gradient(160deg, #f6c84a 0%, #C9901A 50%, #6b3c08 100%); }
  .g-slate { background: linear-gradient(160deg, #5a6f8a 0%, #1B3A6B 60%, #0c1d3d 100%); }
  .g-teal { background: linear-gradient(160deg, #2a7a5e 0%, #1F5C4D 60%, #0e3429 100%); }
  .g-crimson { background: linear-gradient(160deg, #C7325A 0%, #8B1A1A 60%, #3a0a0a 100%); }
  .g-emerald { background: linear-gradient(160deg, #3a8a6e 0%, #1F5C4D 60%, #0e3429 100%); }

  /* DIRECTORY GRID + SIDEBAR */
  .dir-wrap { display: grid; grid-template-columns: 1fr 280px; gap: 40px; align-items: flex-start; padding-bottom: 96px; }
  .dir-head { display: flex; align-items: flex-end; justify-content: space-between; gap: 24px; margin-bottom: 28px; flex-wrap: wrap; }
  .count { font-family: "DM Sans", sans-serif; font-weight: 300; font-size: 0.85rem; color: rgba(13,5,0,0.62); letter-spacing: 0.04em; }
  .count strong { color: #1A0A00; font-weight: 500; }

  .grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 22px; }
  .card { background: white; cursor: pointer; transition: transform 0.5s cubic-bezier(0.2,0.7,0.2,1), box-shadow 0.5s ease; opacity: 0; transform: translateY(24px); display: flex; flex-direction: column; }
  .card.in { opacity: 1; transform: translateY(0); }
  .card:hover { transform: translateY(-6px); box-shadow: 0 24px 60px rgba(13,5,0,0.16); }
  .card:hover .card-
  .card:hover .img .bg { filter: saturate(1.18) brightness(1.05); }
  .img { position: relative; aspect-ratio: 4/3; overflow: hidden; }
  .img .bg { position: absolute; inset: 0; transition: filter 0.5s ease, transform 0.6s ease; }
  .img .pattern { position: absolute; inset: 0; background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='80' height='80'><g fill='none' stroke='white' stroke-width='0.4' opacity='0.5'><path d='M40 5 L 75 40 L 40 75 L 5 40 Z'/><circle cx='40' cy='40' r='28'/><circle cx='40' cy='40' r='14'/></g></svg>"); background-size: 80px; opacity: 0.16; mix-blend-mode: overlay; }
  .img .glyph { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -55%); font-family: "Cormorant Garamond", serif; font-weight: 700; font-style: italic; font-size: 8rem; line-height: 1; color: rgba(255,255,255,0.14); }
  .img::after { content: ""; position: absolute; inset: 0; background: linear-gradient(180deg, transparent 50%, rgba(13,5,0,0.4) 100%); }
  .img .cat-badge { position: absolute; top: 14px; left: 14px; z-index: 3; font-family: "DM Sans", sans-serif; font-size: 0.58rem; font-weight: 600; letter-spacing: 0.22em; text-transform: uppercase; padding: 5px 10px; color: white; }
  .card-body { padding: 18px 16px 0; display: flex; flex-direction: column; flex: 1; background: #FFFFFF; color: #1A0A00; }
  .card-meta { display: flex; align-items: center; gap: 8px; font-family: "DM Sans", sans-serif; font-size: 0.62rem; letter-spacing: 0.22em; text-transform: uppercase; color: rgba(13,5,0,0.45); font-weight: 500; }
  .card-meta .gdot { width: 4px; height: 4px; background: #C9901A; border-radius: 50%; }
  .card-name { font-family: "Cormorant Garamond", serif; font-weight: 600; font-size: 1.3rem; color: #1A0A00; line-height: 1.1; letter-spacing: -0.005em; }
  .card-desc { font-family: "DM Sans", sans-serif; font-weight: 300; font-size: 0.85rem; line-height: 1.55; color: rgba(13,5,0,0.62); display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; margin-top: 2px; }
  .card-best { font-family: "DM Sans", sans-serif; font-size: 0.72rem; color: var(--saffron); display: inline-flex; align-items: center; gap: 6px; font-weight: 500; margin-top: 4px; }
  .card-cta { background: var(--saffron); color: white; border: none; font-family: "DM Sans", sans-serif; font-weight: 500; font-size: 0.74rem; letter-spacing: 0.16em; text-transform: uppercase; padding: 11px 14px; cursor: pointer; display: flex; justify-content: space-between; align-items: center; transition: background 0.3s ease; margin-top: 10px; }
  .card-cta:hover { background: var(--gold); }
  .card-cta .arrow { transition: transform 0.3s ease; }
  .card-cta:hover .arrow { transform: translateX(5px); }

  /* SIDEBAR WIDGET */
  .side-wrap { position: sticky; top: 88px; display: flex; flex-direction: column; gap: 24px; }
  .upcoming { background: var(--ink); color: var(--parchment); padding: 28px 24px 24px; position: relative; overflow: hidden; }
  .upcoming::before { content: ""; position: absolute; right: -80px; top: -80px; width: 240px; height: 240px; opacity: 0.07; pointer-events: none; background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 600 600'><g fill='none' stroke='%23C9901A' stroke-width='0.7'><circle cx='300' cy='300' r='280'/><circle cx='300' cy='300' r='220'/><circle cx='300' cy='300' r='160'/><circle cx='300' cy='300' r='100'/></g></svg>"); background-size: contain; }
  .up-h { font-family: "Cormorant Garamond", serif; font-weight: 600; font-style: italic; font-size: 1.4rem; color: var(--gold); margin-bottom: 4px; letter-spacing: -0.005em; position: relative; z-index: 1; }
  .up-sub { font-family: "DM Sans", sans-serif; font-size: 0.6rem; letter-spacing: 0.24em; color: rgba(245,237,216,0.45); text-transform: uppercase; margin-bottom: 18px; position: relative; z-index: 1; }
  .up-row { display: flex; align-items: center; gap: 12px; padding: 12px 12px; margin: 0 -12px; transition: background 0.3s ease; cursor: pointer; position: relative; z-index: 1; }
  .up-row:hover { background: rgba(201,144,26,0.1); }
  .up-row + .up-row { border-top: 1px solid rgba(245,237,216,0.08); }
  .up-row .rdot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
  .rd-hindu { background: var(--crimson); }
  .rd-sikh { background: #d97706; }
  .rd-folk { background: var(--jade); }
  .up-name { font-family: "Cormorant Garamond", serif; font-weight: 600; font-size: 1rem; color: var(--parchment); flex: 1; }
  .up-month { font-family: "DM Sans", sans-serif; font-size: 0.6rem; letter-spacing: 0.22em; color: rgba(245,237,216,0.6); text-transform: uppercase; font-weight: 500; }
  .up-link { display: block; margin-top: 18px; font-family: "DM Sans", sans-serif; font-size: 0.7rem; letter-spacing: 0.18em; color: var(--saffron); text-transform: uppercase; font-weight: 500; cursor: pointer; transition: color 0.3s ease; position: relative; z-index: 1; }
  .up-link:hover { color: var(--gold); }
  .up-link .arrow { display: inline-block; transition: transform 0.3s ease; }
  .up-link:hover .arrow { transform: translateX(4px); }

  .sb-stat { background: var(--parchment); padding: 24px; border-top: 3px solid var(--gold); }
  .sb-num { font-family: "Cormorant Garamond", serif; font-weight: 600; font-size: 2.4rem; color: var(--gold); line-height: 1; margin-bottom: 4px; }
  .sb-label { font-family: "DM Sans", sans-serif; font-size: 0.62rem; letter-spacing: 0.24em; color: var(--faint); text-transform: uppercase; font-weight: 500; }
  .sb-text { font-family: "Cormorant Garamond", serif; font-style: italic; font-size: 0.95rem; color: var(--muted); margin-top: 12px; line-height: 1.55; }

  

  @keyframes fadeUp { from { opacity: 0; transform: translateY(28px); } to { opacity: 1; transform: translateY(0); } }
  @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
  .reveal { opacity: 0; transform: translateY(24px); transition: opacity 0.9s ease, transform 0.9s cubic-bezier(0.2,0.7,0.2,1); }
  .reveal.in { opacity: 1; transform: translateY(0); }

  @media (max-width: 1100px) {
    .hero { padding: 128px 40px 96px; }
    .yantra { right: -200px; opacity: 0.05; }
    .filter-bar { padding: 20px 32px; grid-template-columns: 1fr 1fr; }
    .heritage-content { padding: 64px 32px 0; }
    .grid { grid-template-columns: repeat(2, 1fr); }
    .dir-wrap { grid-template-columns: 1fr; }
    .side-wrap { position: relative; top: 0; flex-direction: row; }
    .upcoming, .sb-stat { flex: 1; }
  }
  @media (max-width: 720px) {
    .nav { padding: 0 20px; gap: 16px; }
    .nav-links { display: none; }
    .hero { padding: 112px 24px 72px; }
    .heritage-content { padding: 48px 20px 0; }
    .filter-bar { padding: 16px 20px; grid-template-columns: 1fr; gap: 18px; }
    .grid { grid-template-columns: 1fr; }
    .side-wrap { flex-direction: column; }
    .feat { flex: 0 0 280px; }
    
  }

/* Pagination override for heritage theme */
nav[aria-label="Pagination Navigation"] span, nav[aria-label="Pagination Navigation"] a {
  color: var(--ink);
}
nav[aria-label="Pagination Navigation"] [aria-current="page"] span {
  background-color: var(--gold) !important;
  color: white !important;
  border-color: var(--gold) !important;
}
</style>
@endsection

@section('content')
<section class="hero" data-screen-label="01 Heritage Hero">
  <svg class="yantra" viewBox="0 0 600 600" fill="none" stroke="#C9901A" stroke-width="0.7" aria-hidden="true">
    <g transform="translate(300 300)">
      <polygon points="0,-260 184,-184 260,0 184,184 0,260 -184,184 -260,0 -184,-184" />
      <polygon points="0,-220 156,-156 220,0 156,156 0,220 -156,156 -220,0 -156,-156" />
      <polygon points="0,-180 127,-127 180,0 127,127 0,180 -127,127 -180,0 -127,-127" />
      <polygon points="0,-140 99,-99 140,0 99,99 0,140 -99,99 -140,0 -99,-99" />
      <polygon points="0,-100 71,-71 100,0 71,71 0,100 -71,71 -100,0 -71,-71" transform="rotate(22.5)" />
      <polygon points="0,-60 42,-42 60,0 42,42 0,60 -42,42 -60,0 -42,-42" />
      <circle cx="0" cy="0" r="280" />
      <circle cx="0" cy="0" r="20" />
      <line x1="-260" y1="0" x2="260" y2="0" />
      <line x1="0" y1="-260" x2="0" y2="260" />
      <line x1="-184" y1="-184" x2="184" y2="184" />
      <line x1="184" y1="-184" x2="-184" y2="184" />
    </g>
  </svg>
  <div class="hero-left">
    <div class="pill"><span>✦</span><span>Heritage of India</span><span>✦</span></div>
    <h1>
      <span class="l1">Monuments of</span>
      <span class="l2">A Civilization</span>
    </h1>
    <div class="gold-line"></div>
    <p class="hero-sub">Stones quarried five centuries before Rome, sandstone forts that watched empires rise and fall, and temple walls where dancers were carved in <em>continuous, breathing stone</em>. India's heritage is not behind glass — it is still walked, prayed in, lived.</p>
    <span class="stat-pill"><span>✦</span><span class="num">{{ number_format(\App\Models\Monument::active()->count()) }}</span><span>Protected Monuments · 28 States</span></span>
  </div>

</section>

<form method="GET" action="{{ route('monuments.index') }}" class="filter-bar" data-screen-label="02 Filters">
  <div class="f">
    <span class="f-label">State</span>
    <select name="state" onchange="this.form.submit()" class="f-select">
      <option value="">All States</option>
      @foreach($states as $stateOption)
        <option value="{{ $stateOption->slug }}" {{ request('state') == $stateOption->slug ? 'selected' : '' }}>{{ $stateOption->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="f">
    <span class="f-label">Type</span>
    <select name="type" onchange="this.form.submit()" class="f-select">
      <option value="">All Types</option>
      @foreach($types as $typeOption)
        <option value="{{ $typeOption }}" {{ request('type') == $typeOption ? 'selected' : '' }}>{{ $typeOption }}</option>
      @endforeach
    </select>
  </div>
  <div class="f">
    <span class="f-label">Category</span>
    <select name="category" onchange="this.form.submit()" class="f-select">
      <option value="">All Categories</option>
      @foreach($categories as $value => $label)
        <option value="{{ $value }}" {{ request('category') == $value ? 'selected' : '' }}>{{ $label }}</option>
      @endforeach
    </select>
  </div>
  @if(request()->hasAny(['state', 'type', 'category']))
    <button type="button" onclick="window.location='{{ route('monuments.index') }}'" class="clear">Clear Filters →</button>
  @else
    <div></div>
  @endif
</form>

<div style="width:100%;background:#FAF6EE;">
<div class="heritage-content">
  @if($featured->isNotEmpty() && !request()->hasAny(['state', 'type', 'category']))
<section class="featured-section" data-screen-label="03 Featured">
  <header>
    <div class="section-eye"><span>✦</span><span>Featured Monuments</span><span>✦</span></div>
    <h2 class="section-title">Hand-Picked <em>Gems</em></h2>
    <div class="section-rule"></div>
  </header>
  <div class="featured-row">
    @foreach($featured as $i => $m)
    @php
       $gClass = 'g-amber';
       if ($i % 5 == 1) $gClass = 'g-rose';
       if ($i % 5 == 2) $gClass = 'g-gold';
       if ($i % 5 == 3) $gClass = 'g-slate';
       if ($i % 5 == 4) $gClass = 'g-teal';
       
       $catClass = 'cat-state';
       if ($m->category == 'UNESCO') $catClass = 'cat-unesco';
       if ($m->category == 'ASI') $catClass = 'cat-asi';
       if ($m->category == 'Religious') $catClass = 'cat-religious';
    @endphp
    <article class="feat" onclick="window.location='{{ route('monuments.show', $m->slug) }}'">
      <div class="bg {{ $gClass }}">
         @if($m->getFirstMediaUrl('gallery'))
           <img src="{{ $m->getFirstMediaUrl('gallery') }}" class="absolute inset-0 w-full h-full object-cover mix-blend-overlay opacity-60" style="position: absolute; width: 100%; height: 100%; object-fit: cover; mix-blend-mode: overlay; opacity: 0.6;">
         @endif
      </div>
      <div class="pattern"></div>
      <span class="glyph">{{ substr($m->name, 0, 1) }}</span>
      <div class="overlay"></div>
      <span class="cat-badge {{ $catClass }}">{{ $m->category === 'State_Protected' ? 'State' : $m->category }}</span>
      <div class="body">
        <div class="name">{{ $m->name }}</div>
        <div class="meta">{{ $m->state->name }} · {{ $m->type }}</div>
        <p class="desc">{{ $m->short_description }}</p>
      </div>
    </article>
    @endforeach
  </div>
</section>
@endif

  <section class="dir-wrap" data-screen-label="04 Directory">
    <div>
      <header class="dir-head">
  <div>
    <div class="section-eye"><span>✦</span><span>The Full Directory</span><span>✦</span></div>
    <h2 class="section-title">All <em>Monuments</em></h2>
    <div class="section-rule"></div>
  </div>
  <div class="count">Showing <strong>{{ $monuments->count() }}</strong> of <strong>{{ number_format($monuments->total()) }}</strong> monuments</div>
</header>

      <div class="grid">
  @forelse($monuments as $i => $m)
    @php
       $gClass = 'g-amber';
       if ($i % 5 == 1) $gClass = 'g-rose';
       if ($i % 5 == 2) $gClass = 'g-gold';
       if ($i % 5 == 3) $gClass = 'g-slate';
       if ($i % 5 == 4) $gClass = 'g-teal';
       
       $catClass = 'cat-state';
       if ($m->category == 'UNESCO') $catClass = 'cat-unesco';
       if ($m->category == 'ASI') $catClass = 'cat-asi';
       if ($m->category == 'Religious') $catClass = 'cat-religious';
    @endphp
    <article class="card" onclick="window.location='{{ route('monuments.show', $m->slug) }}'">
      <div class="img">
        <div class="bg {{ $gClass }}">
           @if($m->getFirstMediaUrl('gallery'))
             <img src="{{ $m->getFirstMediaUrl('gallery') }}" class="absolute inset-0 w-full h-full object-cover mix-blend-overlay opacity-60" style="position: absolute; width: 100%; height: 100%; object-fit: cover; mix-blend-mode: overlay; opacity: 0.6;">
           @endif
        </div>
        <div class="pattern"></div>
        <span class="glyph">{{ substr($m->name, 0, 1) }}</span>
        <span class="cat-badge {{ $catClass }}">{{ $m->category === 'State_Protected' ? 'State' : $m->category }}</span>
      </div>
      <div class="card-body">
        <div class="card-meta"><span>{{ $m->state->name }}</span><span class="gdot"></span><span>{{ $m->type }}</span></div>
        <h3 class="card-name">{{ $m->name }}</h3>
        <p class="card-desc">{{ $m->short_description }}</p>
        @if($m->best_time_to_visit)
          <span class="card-best">✦ Best · {{ $m->best_time_to_visit }}</span>
        @else
          <span class="card-best">&nbsp;</span>
        @endif
        <button class="card-cta"><span>Explore Monument</span><span class="arrow">→</span></button>
      </div>
    </article>
  @empty
    <div style="grid-column: 1 / -1; text-align: center; padding: 40px;">
      <p style="font-family: 'DM Sans', sans-serif; color: var(--muted);">No monuments found matching your filters.</p>
    </div>
  @endforelse
</div>
<div style="margin-top: 40px; display: flex; justify-content: center; width: 100%;">
  {{ $monuments->links() }}
</div>
</div>{{-- close left-column div --}}
<aside class="side-wrap">
  @if(isset($upcomingFestivals) && $upcomingFestivals->isNotEmpty())
  <div class="upcoming">
    <h3 class="up-h">Upcoming Festivals</h3>
    <div class="up-sub">Calendar {{ date('Y') }}</div>
    @foreach($upcomingFestivals as $uf)
      @php
         $rdClass = 'rd-folk';
         if ($uf->religion == 'Hindu') $rdClass = 'rd-hindu';
         if ($uf->religion == 'Sikh') $rdClass = 'rd-sikh';
         if ($uf->religion == 'Muslim') $rdClass = 'rd-islam';
      @endphp
      <div class="up-row" onclick="window.location='{{ route('festivals.show', $uf->slug) }}'">
        <span class="rdot {{ $rdClass }}"></span>
        <span class="up-name">{{ $uf->name }}</span>
        <span class="up-month">{{ date('M', mktime(0, 0, 0, $uf->month, 1)) }}</span>
      </div>
    @endforeach
    <a href="{{ route('festivals.index') }}" class="up-link">View Full Calendar <span class="arrow">→</span></a>
  </div>
  @endif
  <div class="sb-stat">
    <div class="sb-num">{{ \App\Models\Monument::active()->where('category', 'UNESCO')->count() }}</div>
    <div class="sb-label">UNESCO World Heritage</div>
    <p class="sb-text">India holds the sixth-largest tally of inscribed sites — from the rock shelters of Bhimbetka to the Western Ghats.</p>
  </div>
  <div class="sb-stat" style="margin-top: -24px; border-top: 1px solid var(--hairline);">
    <div class="sb-num">{{ \App\Models\Monument::active()->where('category', 'ASI')->count() }}</div>
    <div class="sb-label">ASI Protected Sites</div>
    <p class="sb-text">Centuries of history preserved under the Archaeological Survey of India.</p>
  </div>
</aside>
  </section>
</div>
</div>
@endsection

@section('scripts')
<script>

  // Sticky filter bar — highlight when hero is scrolled past
  const heroEl = document.querySelector('.hero');
  const filterBarEl = document.querySelector('.filter-bar');
  if (heroEl && filterBarEl) {
    new IntersectionObserver(([entry]) => {
      filterBarEl.classList.toggle('past-hero', !entry.isIntersecting);
    }, { threshold: 0 }).observe(heroEl);
  }

  const io = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

  document.querySelectorAll('.feat').forEach((el, i) => {
    el.style.transitionDelay = (i * 80) + 'ms';
    io.observe(el);
  });
  document.querySelectorAll('.card').forEach((el, i) => {
    el.style.transitionDelay = (i * 40) + 'ms';
    io.observe(el);
  });
  document.querySelectorAll('.reveal').forEach(el => io.observe(el));

</script>
@endsection
