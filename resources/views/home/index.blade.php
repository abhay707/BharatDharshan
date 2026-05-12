@extends('layouts.app')

@section('title', 'Bharatdarshan — Discover Incredible India')

@section('styles')
<style>

  

  

  

  

  /* ============ NOISE + PATTERN OVERLAYS ============ */
  .noise {
    position: fixed;
    inset: 0;
    pointer-events: none;
    z-index: 1;
    opacity: 0.5;
    mix-blend-mode: overlay;
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='200' height='200'><filter id='n'><feTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='2' stitchTiles='stitch'/><feColorMatrix values='0 0 0 0 0.85  0 0 0 0 0.65  0 0 0 0 0.3  0 0 0 0.18 0'/></filter><rect width='100%' height='100%' filter='url(%23n)'/></svg>");
  }

  .mandala-bg {
    position: absolute;
    inset: 0;
    pointer-events: none;
    z-index: 1;
    opacity: 0.04;
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='600' height='600' viewBox='0 0 600 600'><g fill='none' stroke='%23C9901A' stroke-width='0.6'><circle cx='300' cy='300' r='280'/><circle cx='300' cy='300' r='220'/><circle cx='300' cy='300' r='160'/><circle cx='300' cy='300' r='100'/><circle cx='300' cy='300' r='40'/><g><line x1='300' y1='20' x2='300' y2='580'/><line x1='20' y1='300' x2='580' y2='300'/><line x1='102' y1='102' x2='498' y2='498'/><line x1='498' y1='102' x2='102' y2='498'/></g><g transform='translate(300 300)'><g id='petal'><path d='M0 -280 Q 60 -200 0 -160 Q -60 -200 0 -280Z'/></g><use href='%23petal' transform='rotate(30)'/><use href='%23petal' transform='rotate(60)'/><use href='%23petal' transform='rotate(90)'/><use href='%23petal' transform='rotate(120)'/><use href='%23petal' transform='rotate(150)'/><use href='%23petal' transform='rotate(180)'/><use href='%23petal' transform='rotate(210)'/><use href='%23petal' transform='rotate(240)'/><use href='%23petal' transform='rotate(270)'/><use href='%23petal' transform='rotate(300)'/><use href='%23petal' transform='rotate(330)'/></g></g></svg>");
    background-size: 900px 900px;
    background-position: center;
    background-repeat: no-repeat;
  }

  /* ============ HERO ============ */
  .hero {
    position: relative;
    min-height: 100vh;
    display: grid;
    grid-template-columns: 55% 45%;
    overflow: hidden;
    padding-top: 64px;
    background: #0D0500;
    /* Override --faint for dark hero context */
    --faint: rgba(245, 237, 216, 0.45);
  }

  .hero::before {
    content: "";
    position: absolute;
    top: 50%; right: 12%;
    width: 700px; height: 700px;
    transform: translate(0, -50%);
    background: radial-gradient(ellipse at center, rgba(201, 144, 26, 0.12) 0%, rgba(232, 88, 10, 0.04) 35%, transparent 70%);
    pointer-events: none;
    z-index: 1;
  }

  /* ============ LEFT ============ */
  .left {
    position: relative;
    z-index: 3;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 0 64px 0 100px;
    max-width: 760px;
  }

  .pill {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    align-self: flex-start;
    border: 1px solid var(--gold);
    padding: 7px 16px;
    font-family: "DM Sans", sans-serif;
    font-size: 10px;
    letter-spacing: 0.22em;
    color: var(--gold);
    text-transform: uppercase;
    margin-bottom: 36px;
    opacity: 0;
    animation: fadeUp 0.9s ease forwards;
    animation-delay: 100ms;
  }
  .pill .star { color: var(--gold); font-size: 10px; }

  h1.heading {
    font-family: "Cormorant Garamond", serif;
    line-height: 0.92;
    letter-spacing: -0.01em;
    margin-bottom: 28px;
  }
  h1.heading .l1, h1.heading .l2, h1.heading .l3 {
    display: block;
    opacity: 0;
    transform: translateY(28px);
    animation: fadeUp 1s cubic-bezier(0.2, 0.7, 0.2, 1) forwards;
  }
  h1.heading .l1 {
    font-weight: 700;
    font-style: italic;
    font-size: clamp(3rem, 5.4vw, 5rem);
    color: var(--parchment);
    animation-delay: 0ms;
  }
  h1.heading .l2 {
    font-weight: 700;
    font-style: normal;
    font-size: clamp(4.2rem, 7.8vw, 7rem);
    color: var(--gold);
    margin-left: -2px;
    line-height: 0.95;
    animation-delay: 200ms;
  }
  h1.heading .l3 {
    font-weight: 700;
    font-style: italic;
    font-size: clamp(3rem, 5.4vw, 5rem);
    color: var(--saffron);
    animation-delay: 400ms;
  }

  .divider {
    width: 60px;
    height: 1px;
    background: var(--gold);
    margin: 8px 0 28px;
    opacity: 0;
    animation: fadeIn 0.9s ease forwards;
    animation-delay: 500ms;
  }

  .subtext {
    font-family: "DM Sans", sans-serif;
    font-weight: 300;
    font-size: 1.1rem;
    line-height: 1.8;
    color: var(--muted);
    max-width: 460px;
    margin-bottom: 44px;
    opacity: 0;
    animation: fadeUp 1s ease forwards;
    animation-delay: 600ms;
  }
  .subtext em {
    color: var(--parchment);
    font-style: italic;
    font-family: "Cormorant Garamond", serif;
    font-size: 1.2rem;
  }

  .stats {
    display: flex;
    align-items: center;
    gap: 28px;
    margin-bottom: 44px;
    opacity: 0;
    animation: fadeUp 1s ease forwards;
    animation-delay: 800ms;
  }
  .stat {
    display: flex;
    flex-direction: column;
    gap: 4px;
  }
  .stat-num {
    font-family: "Cormorant Garamond", serif;
    font-weight: 600;
    font-size: 1.8rem;
    color: var(--gold);
    line-height: 1;
  }
  .stat-label {
    font-family: "DM Sans", sans-serif;
    font-size: 0.65rem;
    letter-spacing: 0.18em;
    color: var(--faint);
    text-transform: uppercase;
  }
  .stat-divider {
    width: 1px;
    height: 38px;
    background: linear-gradient(to bottom, transparent, var(--gold), transparent);
    opacity: 0.5;
  }

  .ctas {
    display: flex;
    gap: 14px;
    opacity: 0;
    animation: fadeUp 1s ease forwards;
    animation-delay: 1000ms;
  }
  .btn {
    font-family: "DM Sans", sans-serif;
    font-weight: 500;
    font-size: 13px;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    padding: 14px 32px;
    border: none;
    cursor: pointer;
    border-radius: 0;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: background 0.35s ease, color 0.35s ease, border-color 0.35s ease;
  }
  .btn .arrow {
    display: inline-block;
    transition: transform 0.35s ease;
  }
  .btn:hover .arrow { transform: translateX(4px); }

  .btn-primary {
    background: var(--saffron);
    color: white;
  }
  .btn-primary:hover { background: var(--gold); }

  .btn-secondary {
    background: transparent;
    color: var(--gold);
    border: 1.5px solid var(--gold);
  }
  .btn-secondary:hover {
    background: var(--gold);
    color: var(--ink);
  }

  /* ============ RIGHT — CARD STACK ============ */
  .right {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: center;
    padding-right: 80px;
  }

  .stack {
    position: relative;
    width: 480px;
    height: 520px;
    animation: floatStack 4s ease-in-out infinite alternate;
  }

  .card {
    position: absolute;
    border: 1px solid rgba(245, 237, 216, 0.08);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.55), 0 4px 12px rgba(0, 0, 0, 0.4);
    overflow: hidden;
    transform-origin: center center;
    opacity: 0;
    transform: scale(0.85) translateY(20px);
    animation: cardIn 1.2s cubic-bezier(0.2, 0.7, 0.2, 1) forwards;
    transition: transform 0.6s cubic-bezier(0.2, 0.7, 0.2, 1), box-shadow 0.6s ease, z-index 0s;
  }
  .card::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, transparent 35%, rgba(0, 0, 0, 0.55) 100%);
    pointer-events: none;
  }
  .card .glyph {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -55%);
    font-family: "Cormorant Garamond", serif;
    font-weight: 700;
    font-style: italic;
    font-size: 320px;
    line-height: 1;
    color: rgba(245, 237, 216, 0.16);
    pointer-events: none;
    user-select: none;
  }
  .card .label {
    position: absolute;
    bottom: 22px;
    left: 22px;
    right: 22px;
    z-index: 2;
    display: flex;
    flex-direction: column;
    gap: 4px;
  }
  .card .label .name {
    font-family: "Cormorant SC", serif;
    font-weight: 600;
    font-size: 14px;
    letter-spacing: 0.22em;
    color: var(--gold);
  }
  .card .label .meta {
    font-family: "DM Sans", sans-serif;
    font-size: 10px;
    letter-spacing: 0.18em;
    color: rgba(245, 237, 216, 0.6);
    text-transform: uppercase;
  }
  .card .corner {
    position: absolute;
    top: 14px;
    right: 14px;
    font-family: "DM Sans", sans-serif;
    font-size: 9px;
    letter-spacing: 0.22em;
    color: rgba(245, 237, 216, 0.55);
    text-transform: uppercase;
    z-index: 2;
  }

  /* card 4 — back, deep crimson, Punjab */
  .card-4 {
    width: 300px; height: 400px;
    top: 30px; left: 30px;
    transform: scale(0.85) translateY(20px) rotate(-3deg);
    background:
      radial-gradient(ellipse at 30% 20%, rgba(245, 237, 216, 0.07), transparent 60%),
      linear-gradient(160deg, #5a0e0e 0%, #2a0606 100%);
    animation-delay: 300ms;
    z-index: 1;
  }
  /* card 2 — top-left, jade, Kerala */
  .card-2 {
    width: 260px; height: 350px;
    top: 0; left: 70px;
    transform: scale(0.85) translateY(20px) rotate(-8deg);
    background:
      radial-gradient(ellipse at 30% 20%, rgba(245, 237, 216, 0.08), transparent 60%),
      linear-gradient(160deg, #2a7a5e 0%, #0e3429 100%);
    animation-delay: 450ms;
    z-index: 2;
  }
  /* card 3 — bottom-right, lapis, Tamil Nadu */
  .card-3 {
    width: 240px; height: 320px;
    bottom: 0; right: 30px;
    transform: scale(0.85) translateY(20px) rotate(6deg);
    background:
      radial-gradient(ellipse at 30% 20%, rgba(245, 237, 216, 0.07), transparent 60%),
      linear-gradient(160deg, #2a4f8a 0%, #0c1d3d 100%);
    animation-delay: 600ms;
    z-index: 3;
  }
  /* card 1 — center, saffron→crimson, Rajasthan */
  .card-1 {
    width: 280px; height: 380px;
    top: 60px; left: 110px;
    transform: scale(0.85) translateY(20px) rotate(0deg);
    background:
      radial-gradient(ellipse at 30% 20%, rgba(245, 237, 216, 0.09), transparent 60%),
      linear-gradient(160deg, #E8580A 0%, #8B1A1A 60%, #4a0a0a 100%);
    animation-delay: 750ms;
    z-index: 4;
  }

  .card:hover {
    transform: rotate(0deg) scale(1.03) translateY(-6px) !important;
    z-index: 10 !important;
    box-shadow: 0 30px 80px rgba(0, 0, 0, 0.7), 0 6px 16px rgba(232, 88, 10, 0.2);
  }

  /* faint pattern inside cards */
  .card-pattern {
    position: absolute;
    inset: 0;
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='80' height='80'><g fill='none' stroke='white' stroke-width='0.4' opacity='0.5'><path d='M40 5 L 75 40 L 40 75 L 5 40 Z'/><circle cx='40' cy='40' r='28'/><circle cx='40' cy='40' r='14'/></g></svg>");
    background-size: 80px;
    opacity: 0.18;
    mix-blend-mode: overlay;
  }

  /* ============ SCROLL INDICATOR ============ */
  .scroll {
    position: absolute;
    bottom: 26px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    z-index: 5;
    opacity: 0;
    animation: fadeIn 1.2s ease forwards;
    animation-delay: 1400ms;
  }
  .scroll-text {
    font-family: "DM Sans", sans-serif;
    font-size: 9.5px;
    letter-spacing: 0.32em;
    color: var(--faint);
    text-transform: uppercase;
  }
  .chev {
    width: 14px; height: 14px;
    border-right: 1.5px solid var(--gold);
    border-bottom: 1.5px solid var(--gold);
    transform: rotate(45deg);
    animation: bounce 1.8s ease-in-out infinite;
  }


  /* ============ ANIMATIONS ============ */
  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(28px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  @keyframes fadeIn {
    from { opacity: 0; }
    to   { opacity: 1; }
  }
  @keyframes cardIn {
    to { opacity: 1; }
  }
  .card-1 { animation-name: cardIn1; }
  .card-2 { animation-name: cardIn2; }
  .card-3 { animation-name: cardIn3; }
  .card-4 { animation-name: cardIn4; }
  @keyframes cardIn1 {
    to { opacity: 1; transform: scale(1) translateY(0) rotate(0deg); }
  }
  @keyframes cardIn2 {
    to { opacity: 1; transform: scale(1) translateY(0) rotate(-8deg); }
  }
  @keyframes cardIn3 {
    to { opacity: 1; transform: scale(1) translateY(0) rotate(6deg); }
  }
  @keyframes cardIn4 {
    to { opacity: 1; transform: scale(1) translateY(0) rotate(-3deg); }
  }
  @keyframes floatStack {
    from { transform: translateY(0); }
    to   { transform: translateY(-8px); }
  }
  @keyframes bounce {
    0%, 100% { transform: rotate(45deg) translate(0, 0); opacity: 0.4; }
    50%      { transform: rotate(45deg) translate(4px, 4px); opacity: 1; }
  }

  /* ============ RESPONSIVE ============ */
  @media (max-width: 1100px) {
    .hero { grid-template-columns: 60% 40%; }
    .left { padding: 0 32px 0 48px; }
    .right { padding-right: 32px; }
    .stack { transform: scale(0.85); }
  }
  @media (max-width: 860px) {
    .nav { padding: 0 24px; gap: 24px; }
    .nav-links { gap: 20px; }
    .nav-link { font-size: 11px; }
    .hero {
      grid-template-columns: 1fr;
      padding-top: 96px;
      padding-bottom: 80px;
    }
    .left { padding: 0 32px; max-width: 100%; }
    .right {
      padding: 40px 32px 0;
      justify-content: center;
    }
    .stack { width: 360px; height: 420px; transform: scale(0.75); }
    .edge-meta { display: none; }
  }
  @media (max-width: 540px) {
    .nav-links { display: none; }
    .stats { gap: 14px; flex-wrap: wrap; }
    .stat-divider { height: 28px; }
    .ctas { flex-direction: column; align-items: stretch; }
  }

  /* =================================================
     SECTIONS BELOW HERO
     ================================================= */
  .reveal { opacity: 0; transform: translateY(28px); transition: opacity 0.65s ease, transform 0.65s ease; }
  .reveal.revealed { opacity: 1; transform: none; }

  @keyframes shimmer {
    0% { background-position: 0% center; }
    100% { background-position: 200% center; }
  }
  .section-label {
    display: inline-block;
    font-family: "DM Sans", sans-serif;
    font-size: 0.65rem;
    font-weight: 600;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    background: linear-gradient(90deg, #C9901A, #F5D876, #C9901A);
    background-size: 200% auto;
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    color: transparent;
    animation: shimmer 3s linear infinite;
    margin-bottom: 14px;
  }
  .section-label.saffron-shimmer {
    background: linear-gradient(90deg, #E8580A, #f9a064, #E8580A);
    background-size: 200% auto;
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
  }
  .ornament {
    text-align: center;
    color: var(--gold);
    font-size: 1rem;
    letter-spacing: 0.3em;
    margin-bottom: 24px;
    opacity: 0.75;
  }
  .sec-title {
    font-family: "Cormorant Garamond", serif;
    font-weight: 700;
    font-size: clamp(2.2rem, 4vw, 3rem);
    color: #1A0A00;
    line-height: 1.05;
    letter-spacing: -0.01em;
    margin-bottom: 16px;
  }
  .sec-title.on-dark { color: white; }
  .sec-title em { font-style: italic; color: var(--gold); }
  .sec-sub {
    font-family: "DM Sans", sans-serif;
    font-weight: 300;
    font-size: 1.05rem;
    line-height: 1.75;
    color: rgba(13, 5, 0, 0.6);
    max-width: 620px;
    margin-bottom: 48px;
  }
  .sec-sub.on-dark { color: rgba(245, 237, 216, 0.6); }
  .sec-sub.italic-lead {
    font-family: "Cormorant Garamond", serif;
    font-style: italic;
    font-size: 1.2rem;
    color: rgba(13, 5, 0, 0.55);
  }
  .sec-head-row { display: flex; align-items: flex-end; justify-content: space-between; gap: 24px; margin-bottom: 36px; flex-wrap: wrap; }
  .sec-head-row .sec-sub { margin-bottom: 0; }
  .head-link {
    font-family: "DM Sans", sans-serif;
    font-size: 0.72rem;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    font-weight: 500;
    color: var(--gold);
    text-decoration: none;
    cursor: pointer;
    position: relative;
    padding-bottom: 4px;
    white-space: nowrap;
  }
  .head-link.saffron { color: var(--saffron); }
  .head-link::after {
    content: ""; position: absolute; left: 0; bottom: 0;
    width: 0; height: 1px; background: currentColor;
    transition: width 0.35s ease;
  }
  .head-link:hover::after { width: 100%; }
  .head-link .arrow { display: inline-block; transition: transform 0.3s ease; }
  .head-link:hover .arrow { transform: translateX(4px); }

  /* SECTION 2 — STATES */
  .sec-states {
    background: #FAF6EE;
    color: #1A0A00;
    padding: 100px 80px;
    position: relative;
    /* Restore ink-based --faint for light section */
    --faint: rgba(13, 5, 0, 0.42);
  }
  .states-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
  }
  .state-card {
    aspect-ratio: 1 / 1.45;
    background: white;
    display: flex;
    flex-direction: column;
    cursor: pointer;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden;
  }
  .state-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 24px 60px rgba(13, 5, 0, 0.18);
  }
  .state-card .sc-img {
    flex: 0 0 58%;
    position: relative;
    overflow: hidden;
  }
  .state-card .sc-img .sc-init {
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -55%);
    font-family: "Cormorant Garamond", serif;
    font-weight: 700;
    font-size: 7rem;
    color: white;
    opacity: 0.12;
  }
  .state-card .sc-region {
    position: absolute;
    top: 12px; left: 12px;
    background: rgba(0, 0, 0, 0.4);
    color: white;
    padding: 4px 10px;
    font-family: "DM Sans", sans-serif;
    font-size: 0.6rem;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    font-weight: 600;
    backdrop-filter: blur(4px);
  }
  .sc-pattern {
    position: absolute; inset: 0;
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='80' height='80'><g fill='none' stroke='white' stroke-width='0.4' opacity='0.5'><path d='M40 5 L 75 40 L 40 75 L 5 40 Z'/><circle cx='40' cy='40' r='28'/><circle cx='40' cy='40' r='14'/></g></svg>");
    background-size: 80px;
    opacity: 0.18;
    mix-blend-mode: overlay;
  }
  .g-state-pb { background: linear-gradient(135deg, #E8580A, #8B1A1A); }
  .g-state-kl { background: linear-gradient(135deg, #2D6A4F, #1B4F8A); }
  .g-state-rj { background: linear-gradient(135deg, #C9901A, #E8580A); }
  .g-state-tn { background: linear-gradient(135deg, #8B1A1A, #4A0404); }
  .g-state-wb { background: linear-gradient(135deg, #1B4F8A, #2D6A4F); }
  .g-state-mp { background: linear-gradient(135deg, #4A0404, #8B1A1A); }
  .sc-body { padding: 18px 16px 0; display: flex; flex-direction: column; flex: 1; }
  .sc-name {
    font-family: "Cormorant Garamond", serif;
    font-weight: 600;
    font-size: 1.5rem;
    color: #1A0A00;
    margin-bottom: 4px;
    line-height: 1.1;
  }
  .sc-meta {
    font-family: "DM Sans", sans-serif;
    font-weight: 300;
    font-size: 0.8rem;
    color: #6B5B47;
    display: flex; align-items: center; gap: 8px;
  }
  .sc-meta .gd { width: 4px; height: 4px; background: #C9901A; border-radius: 50%; }
  .sc-pop {
    font-family: "DM Sans", sans-serif;
    font-size: 0.6rem;
    font-weight: 600;
    letter-spacing: 0.22em;
    color: #E8580A;
    text-transform: uppercase;
    margin-top: 6px;
  }
  .sc-desc {
    font-family: "DM Sans", sans-serif;
    font-weight: 300;
    font-size: 0.82rem;
    line-height: 1.55;
    color: #8B7355;
    margin-top: 8px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
  .sc-cta {
    margin-top: auto;
    background: #E8580A;
    color: white;
    border: none;
    padding: 10px 14px;
    font-family: "DM Sans", sans-serif;
    font-weight: 500;
    font-size: 0.7rem;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: background 0.3s ease;
  }
  .sc-cta:hover { background: #C9901A; }
  .sc-cta .arrow { transition: transform 0.3s ease; }
  .sc-cta:hover .arrow { transform: translateX(5px); }

  /* SECTION 3 — HERITAGE */
  .sec-heritage {
    background: #0D0500;
    color: var(--parchment);
    padding: 100px 80px;
    position: relative;
  }
  .mon-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
  }
  .mon {
    position: relative;
    height: 280px;
    overflow: hidden;
    cursor: pointer;
  }
  .mon .mbg { position: absolute; inset: 0; transition: transform 0.7s cubic-bezier(0.2,0.7,0.2,1); }
  .mon:hover .mbg { transform: scale(1.05); }
  .mon::after {
    content: ""; position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(13,5,0,0.92) 0%, rgba(13,5,0,0.3) 60%, transparent 100%);
    transition: background 0.35s ease;
  }
  .mon:hover::after {
    background: linear-gradient(to top, rgba(13,5,0,0.85) 0%, rgba(13,5,0,0.22) 60%, transparent 100%);
  }
  .g-mon-amber { background: linear-gradient(160deg, #C9901A, #8B1A1A, #4A0404); }
  .g-mon-golden { background: linear-gradient(160deg, #C9901A, #E8580A, #1A0A00); }
  .g-mon-brihad { background: linear-gradient(160deg, #8B1A1A, #4A0404, #1A0A00); }
  .g-mon-vic { background: linear-gradient(160deg, #1B4F8A, #0D0500, #1A0A00); }
  .mon-glyph {
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -55%);
    font-family: "Cormorant Garamond", serif;
    font-weight: 700;
    font-style: italic;
    font-size: 11rem;
    color: rgba(255,255,255,0.13);
    pointer-events: none;
    z-index: 1;
  }
  .mon .cat-badge {
    position: absolute;
    top: 16px; right: 16px;
    z-index: 3;
    font-family: "DM Sans", sans-serif;
    font-size: 0.6rem;
    font-weight: 600;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    color: white;
    padding: 5px 10px;
  }
  .cb-unesco { background: #1B4F8A; }
  .cb-asi { background: #2D6A4F; }
  .cb-religious { background: #E8580A; }
  .mon .mbody {
    position: absolute; bottom: 0; left: 0; right: 0;
    padding: 20px; z-index: 3;
  }
  .mon .mname {
    font-family: "Cormorant Garamond", serif;
    font-weight: 700;
    font-style: italic;
    font-size: 1.6rem;
    line-height: 1.05;
    margin-bottom: 4px;
    transition: transform 0.35s ease;
    transform-origin: left bottom;
  }
  .mon:hover .mname { transform: scale(1.03); }
  .mon .mmeta {
    font-family: "DM Sans", sans-serif;
    font-size: 0.6rem;
    font-weight: 600;
    letter-spacing: 0.22em;
    color: var(--gold);
    text-transform: uppercase;
    margin-bottom: 6px;
  }
  .mon .mdesc {
    font-family: "DM Sans", sans-serif;
    font-weight: 300;
    font-size: 0.8rem;
    line-height: 1.5;
    color: rgba(245, 237, 216, 0.65);
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
  .type-pills {
    margin-top: 36px;
    display: flex; flex-wrap: wrap; gap: 10px; align-items: center;
  }
  .type-pills .lab {
    font-family: "DM Sans", sans-serif;
    font-size: 0.6rem;
    font-weight: 600;
    letter-spacing: 0.22em;
    color: rgba(245,237,216,0.45);
    text-transform: uppercase;
    margin-right: 8px;
  }
  .type-pill {
    font-family: "DM Sans", sans-serif;
    font-size: 0.7rem;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    font-weight: 500;
    color: var(--gold);
    border: 1px solid var(--gold);
    padding: 8px 14px;
    cursor: pointer;
    transition: background 0.2s ease, color 0.2s ease;
    background: transparent;
  }
  .type-pill:hover { background: var(--gold); color: var(--ink); }

  /* SECTION 4 — FESTIVALS */
  .sec-festivals {
    background: #F5EDD8;
    color: #1A0A00;
    padding: 100px 80px;
  }
  .fest-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 64px;
  }
  .fest-card {
    background: white;
    padding: 24px 22px;
    border-left: 4px solid var(--gold);
    display: flex;
    flex-direction: column;
    gap: 8px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
  }
  .fest-card:hover { transform: translateY(-4px); box-shadow: 0 18px 40px rgba(13,5,0,0.1); }
  .fc-onam { border-left-color: #2D6A4F; }
  .fc-ganesh { border-left-color: #E8580A; }
  .fc-durga { border-left-color: #C9901A; }
  .fc-eye {
    font-family: "DM Sans", sans-serif;
    font-size: 0.6rem;
    font-weight: 600;
    letter-spacing: 0.22em;
    color: rgba(13,5,0,0.4);
    text-transform: uppercase;
  }
  .fc-name {
    font-family: "Cormorant Garamond", serif;
    font-weight: 600;
    font-size: 1.4rem;
    color: #1A0A00;
    line-height: 1.05;
  }
  .fc-when {
    font-family: "DM Sans", sans-serif;
    font-size: 0.62rem;
    font-weight: 600;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    color: var(--saffron);
  }
  .fc-tag {
    font-family: "Cormorant Garamond", serif;
    font-style: italic;
    font-size: 1rem;
    color: #6B5B47;
    line-height: 1.5;
  }
  .fc-row { display: flex; align-items: center; justify-content: space-between; margin-top: 6px; }
  .fc-rel {
    font-family: "DM Sans", sans-serif;
    font-size: 0.55rem;
    font-weight: 600;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    color: white;
    padding: 4px 10px;
  }
  .fc-rel.r-hindu { background: #E8580A; }
  .fc-link {
    font-family: "DM Sans", sans-serif;
    font-size: 0.7rem;
    font-weight: 500;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: var(--saffron);
    cursor: pointer;
    text-decoration: none;
  }
  .fc-link .arrow { display: inline-block; transition: transform 0.3s ease; }
  .fc-link:hover .arrow { transform: translateX(4px); }

  .religion-h {
    font-family: "Cormorant Garamond", serif;
    font-weight: 600;
    font-size: 1.6rem;
    color: #1A0A00;
    margin-bottom: 18px;
  }
  .mosaic {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    grid-auto-rows: 120px;
    gap: 12px;
  }
  .tile {
    position: relative;
    overflow: hidden;
    padding: 18px 20px;
    color: white;
    cursor: pointer;
    transition: transform 0.3s ease, filter 0.3s ease;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
  }
  .tile:hover { transform: scale(1.02); filter: brightness(1.1); }
  .tile-pattern {
    position: absolute; inset: 0;
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='80' height='80'><g fill='none' stroke='white' stroke-width='0.4' opacity='0.5'><path d='M40 5 L 75 40 L 40 75 L 5 40 Z'/><circle cx='40' cy='40' r='28'/></g></svg>");
    background-size: 80px;
    opacity: 0.16;
    mix-blend-mode: overlay;
  }
  .tile-name {
    font-family: "Cormorant Garamond", serif;
    font-weight: 600;
    font-size: 1.4rem;
    color: white;
    line-height: 1.05;
    position: relative;
    z-index: 1;
  }
  .tile-count {
    font-family: "DM Sans", sans-serif;
    font-size: 0.6rem;
    font-weight: 600;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.75);
    margin-top: 4px;
    position: relative;
    z-index: 1;
  }
  .t-hindu { grid-column: span 2; background: linear-gradient(135deg, #E8580A, #C9901A); }
  .t-secular { grid-column: span 2; background: linear-gradient(135deg, #C9901A, #E8580A); }
  .t-muslim { background: linear-gradient(135deg, #2D6A4F, #1B4F8A); }
  .t-sikh { background: linear-gradient(135deg, #1B4F8A, #2D6A4F); }
  .t-christian { background: linear-gradient(135deg, #8B1A1A, #4A0404); }
  .t-buddhist { background: linear-gradient(135deg, #4A0404, #8B1A1A); }

  /* SECTION 5 — FACTS */
  .sec-facts {
    background: linear-gradient(135deg, #E8580A 0%, #8B1A1A 50%, #4A0404 100%);
    padding: 80px;
    position: relative;
  }
  .sec-facts::before {
    content: ""; position: absolute; inset: 0;
    opacity: 0.18; mix-blend-mode: overlay; pointer-events: none;
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='200' height='200'><filter id='n'><feTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='2' stitchTiles='stitch'/><feColorMatrix values='0 0 0 0 1 0 0 0 0 0.85 0 0 0 0 0.5 0 0 0 0.18 0'/></filter><rect width='100%' height='100%' filter='url(%23n)'/></svg>");
  }
  .facts-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0;
    align-items: center;
    position: relative;
    max-width: 1280px;
    margin: 0 auto;
  }
  .fbk { padding: 16px 32px; position: relative; text-align: center; }
  .fbk + .fbk::before {
    content: ""; position: absolute; left: 0; top: 50%;
    transform: translateY(-50%);
    width: 1px; height: 80px;
    background: rgba(201, 144, 26, 0.4);
  }
  .fbk-num {
    font-family: "Cormorant Garamond", serif;
    font-weight: 700;
    font-size: 4rem;
    color: var(--gold);
    line-height: 1;
    margin-bottom: 12px;
  }
  .fbk-lab {
    font-family: "DM Sans", sans-serif;
    font-weight: 300;
    font-size: 0.72rem;
    letter-spacing: 0.18em;
    color: white;
    text-transform: uppercase;
  }

  /* SECTION 6 — CTA */
  .sec-cta {
    background: #1A0A00;
    color: var(--parchment);
    padding: 100px 80px;
    text-align: center;
    position: relative;
  }
  .sec-cta .orn {
    font-size: 2rem;
    color: var(--gold);
    margin-bottom: 24px;
  }
  .sec-cta h2 {
    font-family: "Cormorant Garamond", serif;
    font-weight: 700;
    font-size: clamp(2.4rem, 4.4vw, 3.5rem);
    color: white;
    line-height: 1.05;
    letter-spacing: -0.01em;
    margin-bottom: 20px;
  }
  .sec-cta h2 em { font-style: italic; color: var(--gold); }
  .sec-cta p {
    font-family: "DM Sans", sans-serif;
    font-weight: 300;
    font-size: 1.05rem;
    line-height: 1.75;
    color: rgba(245, 237, 216, 0.65);
    max-width: 580px;
    margin: 0 auto 40px;
  }
  .cta-row { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }
  .cbtn {
    font-family: "DM Sans", sans-serif;
    font-weight: 500;
    font-size: 12px;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    padding: 14px 26px;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: background 0.3s ease, color 0.3s ease, border-color 0.3s ease;
  }
  .cbtn .arrow { display: inline-block; transition: transform 0.3s ease; }
  .cbtn:hover .arrow { transform: translateX(5px); }
  .cbtn.p { background: var(--saffron); color: white; }
  .cbtn.p:hover { background: var(--gold); }
  .cbtn.s { background: transparent; color: var(--gold); border: 1.5px solid var(--gold); }
  .cbtn.s:hover { background: var(--gold); color: var(--ink); }
  .cbtn.t { background: transparent; color: white; border: 1.5px solid rgba(255,255,255,0.6); }
  .cbtn.t:hover { background: white; color: var(--ink); }

  
</style>
@endsection

@section('content')
@php
  $gradients = [
    'North' => 'linear-gradient(135deg,#E8580A,#8B1A1A)',
    'South' => 'linear-gradient(135deg,#2D6A4F,#1B4F8A)',
    'East' => 'linear-gradient(135deg,#1B4F8A,#2D6A4F)',
    'West' => 'linear-gradient(135deg,#C9901A,#E8580A)',
    'Northeast' => 'linear-gradient(135deg,#4A0404,#8B1A1A)',
    'Central' => 'linear-gradient(135deg,#8B1A1A,#4A0404)',
  ];
  // Pre-fetch hero stack card images (hero collection = best photo per state)
  $heroImgs = \App\Models\State::whereIn('slug', ['rajasthan','kerala','punjab','tamil-nadu'])
    ->get(['slug'])->mapWithKeys(fn($s) => [$s->slug => $s->getFirstMediaUrl('hero') ?: $s->getFirstMediaUrl('gallery')]);
@endphp
<!-- HERO -->
<section class="hero" data-screen-label="01 Hero">
  <div class="mandala-bg"></div>

  <!-- LEFT -->
  <div class="left">
    <div class="pill">
      <span class="star">✦</span>
      <span>Celebrating India's Heritage</span>
      <span class="star">✦</span>
    </div>

    <h1 class="heading">
      <span class="l1">Discover</span>
      <span class="l2">Incredible</span>
      <span class="l3">India</span>
    </h1>

    <div class="divider"></div>

    <p class="subtext">
      Journey through <em>28 states</em> — their ancient temples, vibrant festivals, legendary cuisine, and the timeless stories that have shaped a civilization for five thousand years.
    </p>

    <div class="stats">
      <div class="stat">
        <span class="stat-num">28</span>
        <span class="stat-label">States &amp; Territories</span>
      </div>
      <div class="stat-divider"></div>
      <div class="stat">
        <span class="stat-num">3,691</span>
        <span class="stat-label">Heritage Monuments</span>
      </div>
      <div class="stat-divider"></div>
      <div class="stat">
        <span class="stat-num">5,000<span style="font-size:0.65em;">+</span></span>
        <span class="stat-label">Years of Civilization</span>
      </div>
    </div>

    <div class="ctas">
      <button class="btn btn-primary" onclick="window.location='{{ route('states.index') }}'"><span>Explore States</span><span class="arrow">→</span></button>
      <button class="btn btn-secondary" onclick="window.location='{{ route('monuments.index') }}'"><span>View Heritage</span><span class="arrow">→</span></button>
    </div>
  </div>

  <!-- RIGHT -->
  <div class="right">
    <div class="stack">
      <!-- card 4 (back) -->
      <div class="card card-4">
        @if(!empty($heroImgs['punjab']))<img src="{{ $heroImgs['punjab'] }}" alt="Punjab" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;mix-blend-mode:overlay;opacity:0.45;" loading="lazy">@endif
        <div class="card-pattern"></div>
        <div class="corner">04 · North</div>
        <div class="glyph">P</div>
        <div class="label">
          <span class="name">PUNJAB</span>
          <span class="meta">Land of Five Rivers</span>
        </div>
      </div>
      <!-- card 2 -->
      <div class="card card-2">
        @if(!empty($heroImgs['kerala']))<img src="{{ $heroImgs['kerala'] }}" alt="Kerala" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;mix-blend-mode:overlay;opacity:0.45;" loading="lazy">@endif
        <div class="card-pattern"></div>
        <div class="corner">02 · South</div>
        <div class="glyph">K</div>
        <div class="label">
          <span class="name">KERALA</span>
          <span class="meta">God's Own Country</span>
        </div>
      </div>
      <!-- card 3 -->
      <div class="card card-3">
        @if(!empty($heroImgs['tamil-nadu']))<img src="{{ $heroImgs['tamil-nadu'] }}" alt="Tamil Nadu" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;mix-blend-mode:overlay;opacity:0.45;" loading="lazy">@endif
        <div class="card-pattern"></div>
        <div class="corner">03 · South</div>
        <div class="glyph">T</div>
        <div class="label">
          <span class="name">TAMIL NADU</span>
          <span class="meta">Temple Country</span>
        </div>
      </div>
      <!-- card 1 (front) -->
      <div class="card card-1">
        @if(!empty($heroImgs['rajasthan']))<img src="{{ $heroImgs['rajasthan'] }}" alt="Rajasthan" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;mix-blend-mode:overlay;opacity:0.45;" loading="lazy">@endif
        <div class="card-pattern"></div>
        <div class="corner">01 · West</div>
        <div class="glyph">R</div>
        <div class="label">
          <span class="name">RAJASTHAN</span>
          <span class="meta">Land of Kings</span>
        </div>
      </div>
    </div>
  </div>

  <!-- SCROLL -->
  <div class="scroll">
    <span class="scroll-text">Scroll to Explore</span>
    <span class="chev"></span>
  </div>
</section>

<!-- ============ SECTION 2 — STATES ============ -->
<section class="sec-states" data-screen-label="02 States">
  <div class="ornament reveal">── ✦ ──</div>
  <div style="text-align: center;">
    <span class="section-label reveal">✦ Explore by State ✦</span>
    <h2 class="sec-title reveal">The 28 Faces of <em>India</em></h2>
    <p class="sec-sub reveal" style="margin: 0 auto 56px;">Every state is a universe — a distinct language, cuisine, art form, and way of life.</p>
  </div>

  <div class="states-grid reveal">
    @foreach($featured_states as $state)
    @php $cardImg = $state->getFirstMediaUrl('gallery'); @endphp
    <article class="state-card" onclick="window.location='{{ route('states.show', $state->slug) }}'">
      <div class="sc-img" style="background: {{ $gradients[$state->region] ?? 'linear-gradient(135deg, #C9901A, #E8580A)' }}">
        @if($cardImg)<img src="{{ $cardImg }}" alt="{{ $state->name }}" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;mix-blend-mode:overlay;opacity:0.55;" loading="lazy">@endif
        <div class="sc-pattern"></div>
        <span class="sc-region">{{ $state->region }}</span>
        <span class="sc-init">{{ substr($state->name, 0, 1) }}</span>
      </div>
      <div class="sc-body">
        <h3 class="sc-name">{{ $state->name }}</h3>
        <div class="sc-meta"><span>{{ $state->capital }}</span><span class="gd"></span><span>{{ $state->language }}</span></div>
        <span class="sc-pop">{{ number_format($state->population/1000000, 1) }}M Population</span>
        <p class="sc-desc">{{ Str::limit($state->description, 100) }}</p>
        <button class="sc-cta" onclick="window.location='{{ route('states.show', $state->slug) }}'"><span>Explore</span><span class="arrow">→</span></button>
      </div>
    </article>
    @endforeach
    </div>
</section>

<!-- ============ SECTION 3 — HERITAGE ============ -->
<section class="sec-heritage" data-screen-label="03 Heritage">
  <div class="sec-head-row">
    <div>
      <span class="section-label reveal">✦ Heritage of India ✦</span>
      <h2 class="sec-title on-dark reveal">Monuments of <em>A Civilization</em></h2>
      <p class="sec-sub on-dark reveal">Forts, temples, palaces and tombs — each stone a fragment of an unbroken story.</p>
    </div>
    <a class="head-link reveal" href="{{ route('monuments.index') }}">Explore All Heritage <span class="arrow">→</span></a>
  </div>

  <div class="mon-grid reveal">
    @php
    $monImages = [
        'amber-fort'              => '/images/Dashboard/Amber Fort.jpg',
        'hawa-mahal'              => '/images/Dashboard/Hawa Mahal.jpg',
        'padmanabhapuram-palace'  => '/images/Dashboard/Padmanabhapuram Palace.jpg',
        'golden-temple'           => '/images/Dashboard/Golden Temple.jpg',
    ];
    @endphp
    @foreach($featured_monuments as $monument)
    <article class="mon" onclick="window.location='{{ route('monuments.show', $monument->slug) }}'">
      <div class="mbg" style="background: linear-gradient(160deg, #C9901A, #8B1A1A, #4A0404);">
        @if(isset($monImages[$monument->slug]))
          <img src="{{ $monImages[$monument->slug] }}" alt="{{ $monument->name }}" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;mix-blend-mode:overlay;opacity:0.65;">
        @endif
      </div>
      <span class="mon-glyph">{{ substr($monument->name, 0, 1) }}</span>
      <span class="cat-badge cb-asi">{{ $monument->category }}</span>
      <div class="mbody">
        <h3 class="mname">{{ $monument->name }}</h3>
        <div class="mmeta">{{ $monument->state->name ?? 'India' }} · {{ $monument->type }}</div>
        <p class="mdesc">{{ Str::limit($monument->description, 100) }}</p>
      </div>
    </article>
    @endforeach
    </div>

  <div class="type-pills reveal">
    <span class="lab">Browse by Type:</span>
    <button class="type-pill">Forts</button>
    <button class="type-pill">Temples</button>
    <button class="type-pill">Caves</button>
    <button class="type-pill">Palaces</button>
    <button class="type-pill">Stepwells</button>
  </div>
</section>

<!-- ============ SECTION 4 — FESTIVALS ============ -->
<section class="sec-festivals" data-screen-label="04 Festivals">
  <div class="sec-head-row">
    <div>
      <span class="section-label saffron-shimmer reveal">✦ Festivals of India ✦</span>
      <h2 class="sec-title reveal">365 Days of <em>Celebration</em></h2>
      <p class="sec-sub italic-lead reveal">A tradition for every season. A festival for every soul.</p>
    </div>
    <a class="head-link saffron reveal">View Full Calendar <span class="arrow">→</span></a>
  </div>

  <div class="fest-grid reveal">
    @foreach($upcoming_festivals as $festival)
    <article class="fest-card" onclick="window.location='{{ route('festivals.show', $festival->slug) }}'">
      <span class="fc-eye">Upcoming</span>
      <h3 class="fc-name">{{ $festival->name }}</h3>
      <span class="fc-when">{{ $festival->month }} · {{ $festival->duration_days }} Days</span>
      <p class="fc-tag">{{ $festival->tagline }}</p>
      <div class="fc-row">
        <span class="fc-rel" style="background:#E8580A;">{{ $festival->religion }}</span>
        <a href="{{ route('festivals.show', $festival->slug) }}" class="fc-link">Learn More <span class="arrow">→</span></a>
      </div>
    </article>
    @endforeach
    </div>

  <h3 class="religion-h reveal">Celebrate Every Tradition</h3>
  <div class="mosaic reveal">
    <div class="tile t-hindu"><div class="tile-pattern"></div><div class="tile-name">Hindu</div><div class="tile-count">182 Festivals</div></div>
    <div class="tile t-muslim"><div class="tile-pattern"></div><div class="tile-name">Muslim</div><div class="tile-count">24 Festivals</div></div>
    <div class="tile t-sikh"><div class="tile-pattern"></div><div class="tile-name">Sikh</div><div class="tile-count">18 Festivals</div></div>
    <div class="tile t-christian"><div class="tile-pattern"></div><div class="tile-name">Christian</div><div class="tile-count">14 Festivals</div></div>
    <div class="tile t-secular"><div class="tile-pattern"></div><div class="tile-name">Secular</div><div class="tile-count">36 Festivals</div></div>
    <div class="tile t-buddhist"><div class="tile-pattern"></div><div class="tile-name">Buddhist</div><div class="tile-count">12 Festivals</div></div>
  </div>
</section>

<!-- ============ SECTION 5 — FACTS ============ -->
<section class="sec-facts" data-screen-label="05 Facts">
  <div class="facts-row">
    <div class="fbk"><div class="fbk-num" data-target="{{ $stats['states'] ?? 28 }}">0</div><div class="fbk-lab">States & Territories</div></div>
    <div class="fbk"><div class="fbk-num" data-target="{{ $stats['monuments'] ?? 40 }}">0</div><div class="fbk-lab">UNESCO Heritage Sites</div></div>
    <div class="fbk"><div class="fbk-num" data-target="{{ $stats['festivals'] ?? 365 }}">0</div><div class="fbk-lab">Festivals</div></div>
    <div class="fbk"><div class="fbk-num" data-target="{{ $stats['foods'] ?? 500 }}" data-suffix="+">0</div><div class="fbk-lab">Regional Dishes</div></div>
    </div>
</section>

<!-- ============ SECTION 6 — FINAL CTA ============ -->
<section class="sec-cta" data-screen-label="06 Final CTA">
  <div class="orn reveal">✦</div>
  <h2 class="reveal">Start Your Journey <em>Through India</em></h2>
  <p class="reveal">Explore states, discover monuments, and celebrate festivals — all in one place.</p>
  <div class="cta-row reveal">
    <button class="cbtn p" onclick="window.location='{{ route('states.index') }}'"><span>Explore States</span><span class="arrow">→</span></button>
    <button class="cbtn s" onclick="window.location='{{ route('monuments.index') }}'"><span>Visit Heritage</span><span class="arrow">→</span></button>
    <button class="cbtn t" onclick="window.location='{{ route('festivals.index') }}'"><span>Festival Calendar</span><span class="arrow">→</span></button>
  </div>
</section>

<!-- ============ FOOTER ============ -->
@endsection

@section('scripts')
<script>

  // Reveal on scroll
  const revealObs = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.classList.add('revealed');
        revealObs.unobserve(e.target);
      }
    });
  }, { threshold: 0.1 });
  document.querySelectorAll('.reveal').forEach(el => revealObs.observe(el));

  // Stagger state cards
  document.querySelectorAll('.state-card').forEach((el, i) => {
    el.classList.add('reveal');
    el.style.transitionDelay = (i * 60) + 'ms';
    revealObs.observe(el);
  });
  // Stagger monument cards
  document.querySelectorAll('.mon').forEach((el, i) => {
    el.classList.add('reveal');
    el.style.transitionDelay = (i * 80) + 'ms';
    revealObs.observe(el);
  });
  // Stagger festival cards
  document.querySelectorAll('.fest-card').forEach((el, i) => {
    el.classList.add('reveal');
    el.style.transitionDelay = (i * 80) + 'ms';
    revealObs.observe(el);
  });
  // Stagger mosaic tiles
  document.querySelectorAll('.tile').forEach((el, i) => {
    el.classList.add('reveal');
    el.style.transitionDelay = (i * 50) + 'ms';
    revealObs.observe(el);
  });

  // Count-up on facts
  const countObs = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        const el = e.target;
        const target = parseInt(el.dataset.target, 10);
        const suffix = el.dataset.suffix || '';
        const dur = 2000;
        const start = performance.now();
        function tick(now) {
          const t = Math.min(1, (now - start) / dur);
          const eased = 1 - Math.pow(1 - t, 3);
          const v = Math.round(eased * target);
          el.textContent = v.toLocaleString() + suffix;
          if (t < 1) requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);
        countObs.unobserve(el);
      }
    });
  }, { threshold: 0.4 });
  document.querySelectorAll('.fbk-num').forEach(el => countObs.observe(el));


</script>
@endsection
