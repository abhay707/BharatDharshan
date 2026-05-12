@extends('layouts.app')

@section('title', $festival->name . ' — BharatDarshan')
@section('meta_description', $festival->short_description)
@section('body_class', 'page-light')

@section('styles')
<style>

  :root {
    --muted: rgba(13, 5, 0, 0.65);
    --faint: rgba(13, 5, 0, 0.4);
    --crimson: #8B1A1A;
  }

  .text-label {
    font-family: "DM Sans", sans-serif;
    font-size: 0.65rem;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    font-weight: 500;
  }

  /* HERO */
  .hero {
    position: relative;
    height: 100vh;
    min-height: 720px;
    overflow: hidden;
    color: white;
  }
  .hero-bg {
    position: absolute;
    inset: 0;
    background:
      radial-gradient(ellipse at 50% 30%, rgba(232, 88, 10, 0.45) 0%, transparent 55%),
      radial-gradient(ellipse at 20% 80%, rgba(201, 144, 26, 0.25) 0%, transparent 50%),
      linear-gradient(160deg, #2a0a02 0%, #5a1408 35%, #8B1A1A 70%, #C9901A 100%);
  }
  .hero-bg::before {
    content: "";
    position: absolute; inset: 0;
    opacity: 0.4;
    mix-blend-mode: overlay;
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='200' height='200'><filter id='n'><feTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='2' stitchTiles='stitch'/><feColorMatrix values='0 0 0 0 0.85  0 0 0 0 0.65  0 0 0 0 0.3  0 0 0 0.18 0'/></filter><rect width='100%' height='100%' filter='url(%23n)'/></svg>");
  }
  .hero-darken {
    position: absolute; inset: 0;
    background: linear-gradient(to bottom,
      rgba(13,5,0,0.15) 0%,
      rgba(13,5,0,0.4) 45%,
      rgba(13,5,0,0.92) 88%,
      #0D0500 100%);
    pointer-events: none;
  }
  .mandala-hero {
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -55%);
    width: 720px; height: 720px;
    opacity: 0.07;
    pointer-events: none;
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 600 600'><g fill='none' stroke='%23F5EDD8' stroke-width='0.7'><circle cx='300' cy='300' r='280'/><circle cx='300' cy='300' r='220'/><circle cx='300' cy='300' r='160'/><circle cx='300' cy='300' r='100'/><g transform='translate(300 300)'><g id='p'><path d='M0 -280 Q 60 -200 0 -160 Q -60 -200 0 -280Z'/></g><use href='%23p' transform='rotate(30)'/><use href='%23p' transform='rotate(60)'/><use href='%23p' transform='rotate(90)'/><use href='%23p' transform='rotate(120)'/><use href='%23p' transform='rotate(150)'/><use href='%23p' transform='rotate(180)'/><use href='%23p' transform='rotate(210)'/><use href='%23p' transform='rotate(240)'/><use href='%23p' transform='rotate(270)'/><use href='%23p' transform='rotate(300)'/><use href='%23p' transform='rotate(330)'/></g></g></svg>");
    background-size: contain; background-repeat: no-repeat;
  }

  /* particles */
  .particles {
    position: absolute; inset: 0;
    pointer-events: none;
  }
  .particle {
    position: absolute;
    bottom: -10px;
    border-radius: 50%;
    background: radial-gradient(circle, #FFD480 0%, #C9901A 50%, transparent 100%);
    box-shadow: 0 0 8px rgba(255, 200, 100, 0.6);
    animation-name: floatUp;
    animation-timing-function: ease-out;
    animation-iteration-count: infinite;
  }
  @keyframes floatUp {
    0%   { transform: translateY(0) translateX(0); opacity: 0; }
    15%  { opacity: 0.8; }
    50%  { transform: translateY(-50vh) translateX(var(--drift, 0px)); opacity: 0.7; }
    100% { transform: translateY(-100vh) translateX(calc(var(--drift, 0px) * 2)); opacity: 0; }
  }

  .hero-inner {
    position: relative;
    z-index: 3;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-end;
    padding: 96px 32px 96px;
    text-align: center;
  }
  .religion-badge {
    background: var(--saffron);
    color: white;
    font-family: "DM Sans", sans-serif;
    font-size: 0.65rem;
    font-weight: 600;
    letter-spacing: 0.28em;
    padding: 7px 14px;
    margin-bottom: 28px;
    opacity: 0;
    animation: fadeUp 0.9s ease forwards;
    animation-delay: 200ms;
  }
  h1.fest-name {
    font-family: "Cormorant Garamond", serif;
    font-weight: 700;
    font-style: italic;
    font-size: clamp(4.5rem, 9vw, 8rem);
    line-height: 0.95;
    color: white;
    letter-spacing: -0.02em;
    margin-bottom: 16px;
    text-shadow: 0 4px 32px rgba(0, 0, 0, 0.5);
    opacity: 0;
    transform: translateY(30px);
    animation: fadeUp 1.1s cubic-bezier(0.2, 0.7, 0.2, 1) forwards;
    animation-delay: 350ms;
  }
  .tagline {
    font-family: "Cormorant Garamond", serif;
    font-style: italic;
    font-weight: 400;
    font-size: clamp(1.1rem, 1.7vw, 1.5rem);
    color: var(--gold);
    margin-bottom: 36px;
    letter-spacing: 0.01em;
    opacity: 0;
    animation: fadeUp 1s ease forwards;
    animation-delay: 580ms;
  }
  .tagline .star { margin: 0 14px; opacity: 0.6; }

  .hero-pills {
    display: flex; gap: 12px; flex-wrap: wrap; justify-content: center;
    opacity: 0;
    animation: fadeUp 1s ease forwards;
    animation-delay: 760ms;
  }
  .hero-pill {
    font-family: "DM Sans", sans-serif;
    font-size: 0.7rem;
    letter-spacing: 0.22em;
    color: var(--gold);
    text-transform: uppercase;
    border: 1px solid var(--gold);
    padding: 9px 16px;
    background: rgba(13, 5, 0, 0.25);
    backdrop-filter: blur(4px);
  }

  .scroll-cue {
    position: absolute;
    bottom: 28px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 4;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    opacity: 0;
    animation: fadeIn 1.2s ease forwards;
    animation-delay: 1100ms;
  }
  .scroll-cue .lbl {
    font-family: "DM Sans", sans-serif;
    font-size: 9.5px;
    letter-spacing: 0.32em;
    color: rgba(245, 237, 216, 0.55);
    text-transform: uppercase;
  }
  .chev {
    width: 14px; height: 14px;
    border-right: 1.5px solid var(--gold);
    border-bottom: 1.5px solid var(--gold);
    transform: rotate(45deg);
    animation: bounce 1.8s ease-in-out infinite;
  }

  /* ============ FACTS STRIP ============ */
  .facts {
    background: var(--parchment);
    padding: 32px 64px;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 24px;
    align-items: center;
    border-bottom: 1px solid rgba(201, 144, 26, 0.18);
  }
  .fact {
    position: relative;
    padding: 8px 24px;
  }
  .fact + .fact::before {
    content: "";
    position: absolute;
    left: 0; top: 50%;
    transform: translateY(-50%);
    width: 1px; height: 56px;
    background: linear-gradient(to bottom, transparent, var(--gold), transparent);
    opacity: 0.5;
  }
  .fact-label {
    font-family: "DM Sans", sans-serif;
    font-size: 0.6rem;
    letter-spacing: 0.24em;
    color: rgba(13, 5, 0, 0.4);
    text-transform: uppercase;
    font-weight: 500;
    margin-bottom: 6px;
  }
  .fact-value {
    font-family: "Cormorant Garamond", serif;
    font-weight: 600;
    font-size: 1.4rem;
    color: var(--ink);
    line-height: 1.1;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .fact-value .dot {
    width: 8px; height: 8px; border-radius: 50%;
    background: var(--saffron);
  }

  /* ============ ABOUT + SIDEBAR ============ */
  .about {
    background: var(--cream);
    width: 100%;
  }
  .about-inner {
    max-width: 1280px;
    margin: 0 auto;
    padding: 80px 64px;
    display: grid;
    grid-template-columns: 65% 35%;
    gap: 56px;
  }
  .section-eye {
    display: inline-flex; align-items: center; gap: 10px;
    font-family: "DM Sans", sans-serif;
    font-size: 0.65rem;
    letter-spacing: 0.28em;
    color: var(--gold);
    text-transform: uppercase;
    margin-bottom: 14px;
  }
  .section-eye.gold-shimmer {
    background: linear-gradient(90deg, var(--gold) 0%, #f6d27a 50%, var(--gold) 100%);
    background-size: 200% 100%;
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: shimmer 4s linear infinite;
  }
  @keyframes shimmer {
    0% { background-position: 0% 0; }
    100% { background-position: -200% 0; }
  }
  .section-title {
    font-family: "Cormorant Garamond", serif;
    font-weight: 700;
    font-size: clamp(2rem, 4vw, 2.7rem);
    color: var(--ink);
    line-height: 1.05;
    letter-spacing: -0.01em;
    margin-bottom: 24px;
  }
  .section-title em { font-style: italic; color: var(--saffron); }
  .section-title.on-dark { color: var(--gold); }
  .section-title.on-dark em { color: var(--parchment); }

  .body p {
    font-family: "DM Sans", sans-serif;
    font-weight: 300;
    font-size: 1rem;
    line-height: 1.9;
    color: rgba(13, 5, 0, 0.65);
    margin-bottom: 20px;
    max-width: 640px;
  }
  .body p .lead-em {
    font-family: "Cormorant Garamond", serif;
    font-style: italic;
    font-size: 1.15rem;
    color: var(--ink);
  }
  .dropcap::first-letter {
    font-family: "Cormorant Garamond", serif;
    font-weight: 700;
    font-style: italic;
    font-size: 4.6rem;
    line-height: 0.85;
    float: left;
    margin: 8px 12px 0 0;
    color: var(--saffron);
  }
  .sub-h {
    font-family: "Cormorant Garamond", serif;
    font-weight: 600;
    font-size: 1.8rem;
    color: var(--ink);
    margin: 36px 0 14px;
    letter-spacing: -0.005em;
  }
  .sub-h em { font-style: italic; color: var(--saffron); }

  .sidebar { display: flex; flex-direction: column; gap: 24px; position: sticky; top: 88px; align-self: start; }

  .quote-card {
    background: var(--ink);
    color: var(--parchment);
    padding: 36px 32px;
    position: relative;
    overflow: hidden;
  }
  .quote-card::before {
    content: "\201C";
    position: absolute;
    top: -10px; left: 14px;
    font-family: "Cormorant Garamond", serif;
    font-weight: 700;
    font-size: 7rem;
    color: var(--gold);
    opacity: 0.22;
    line-height: 1;
  }
  .quote-card .pattern {
    position: absolute; inset: 0;
    opacity: 0.05;
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 600 600'><g fill='none' stroke='%23C9901A' stroke-width='0.5'><circle cx='300' cy='300' r='280'/><circle cx='300' cy='300' r='220'/><circle cx='300' cy='300' r='160'/><circle cx='300' cy='300' r='100'/></g></svg>");
    background-size: contain;
    background-repeat: no-repeat;
    background-position: right -120px center;
  }
  .quote-text {
    font-family: "Cormorant Garamond", serif;
    font-weight: 500;
    font-style: italic;
    font-size: 1.15rem;
    line-height: 1.55;
    color: white;
    margin-bottom: 18px;
    position: relative;
    z-index: 1;
    margin-top: 24px;
  }
  .quote-attr {
    font-family: "DM Sans", sans-serif;
    font-size: 0.65rem;
    letter-spacing: 0.24em;
    color: var(--gold);
    text-transform: uppercase;
    font-weight: 500;
    position: relative;
    z-index: 1;
  }

  .states-card {
    background: var(--parchment);
    padding: 28px 28px;
    border-top: 3px solid var(--gold);
  }
  .states-card .h {
    font-family: "DM Sans", sans-serif;
    font-size: 0.65rem;
    letter-spacing: 0.24em;
    color: rgba(13, 5, 0, 0.4);
    text-transform: uppercase;
    font-weight: 600;
    margin-bottom: 16px;
  }
  .state-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid rgba(13, 5, 0, 0.08);
    font-family: "Cormorant Garamond", serif;
    font-weight: 500;
    font-size: 1.05rem;
    color: var(--ink);
  }
  .state-row:last-child { border-bottom: none; }
  .state-row a {
    font-family: "DM Sans", sans-serif;
    font-size: 0.65rem;
    letter-spacing: 0.2em;
    color: var(--gold);
    text-transform: uppercase;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
    display: inline-flex;
    gap: 6px;
  }
  .state-row a:hover { color: var(--saffron); }
  .state-row a .arrow { transition: transform 0.3s ease; }
  .state-row a:hover .arrow { transform: translateX(4px); }

  /* ============ TIMELINE ============ */
  .timeline-section {
    background: var(--parchment);
    padding: 96px 64px;
    border-top: 1px solid rgba(201, 144, 26, 0.2);
    border-bottom: 1px solid rgba(201, 144, 26, 0.2);
  }
  .timeline-inner { max-width: 1100px; margin: 0 auto; }
  .timeline-head { margin-bottom: 56px; }
  .timeline {
    position: relative;
    padding-left: 220px;
  }
  .timeline::before {
    content: "";
    position: absolute;
    left: 198px; top: 8px; bottom: 8px;
    width: 2px;
    background: var(--gold);
    opacity: 0.5;
  }
  .ritual {
    position: relative;
    padding-bottom: 44px;
    opacity: 0;
    transform: translateX(-20px);
    transition: opacity 0.7s ease, transform 0.7s cubic-bezier(0.2, 0.7, 0.2, 1);
  }
  .ritual.in { opacity: 1; transform: translateX(0); }
  .ritual::before {
    content: "";
    position: absolute;
    left: -32px; top: 8px;
    width: 14px; height: 14px;
    border-radius: 50%;
    background: var(--gold);
    box-shadow: 0 0 0 4px var(--parchment), 0 0 0 5px var(--gold);
  }
  .ritual-day {
    position: absolute;
    left: -220px; top: 4px;
    width: 170px;
    text-align: right;
    font-family: "DM Sans", sans-serif;
    font-size: 0.62rem;
    letter-spacing: 0.22em;
    color: var(--saffron);
    text-transform: uppercase;
    font-weight: 600;
  }
  .ritual-day .day-num {
    display: block;
    font-family: "Cormorant Garamond", serif;
    font-style: italic;
    font-size: 1.2rem;
    color: var(--gold);
    letter-spacing: 0;
    text-transform: none;
    margin-top: 2px;
    font-weight: 600;
  }
  .ritual-name {
    font-family: "Cormorant Garamond", serif;
    font-weight: 600;
    font-size: 1.4rem;
    color: var(--ink);
    line-height: 1.1;
    margin-bottom: 8px;
    letter-spacing: -0.005em;
  }
  .ritual-name em { font-style: italic; color: var(--saffron); }
  .ritual-desc {
    font-family: "DM Sans", sans-serif;
    font-weight: 300;
    font-size: 0.92rem;
    line-height: 1.65;
    color: rgba(13, 5, 0, 0.65);
    max-width: 580px;
  }

  /* ============ TIPS GRID (DARK) ============ */
  .tips-section {
    background: var(--ink);
    color: var(--parchment);
    padding: 96px 64px;
    position: relative;
    overflow: hidden;
  }
  .tips-section::before {
    content: "";
    position: absolute;
    top: 50%; right: -140px;
    transform: translateY(-50%);
    width: 600px; height: 600px;
    opacity: 0.05;
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 600 600'><g fill='none' stroke='%23C9901A' stroke-width='0.5'><circle cx='300' cy='300' r='280'/><circle cx='300' cy='300' r='220'/><circle cx='300' cy='300' r='160'/><circle cx='300' cy='300' r='100'/></g></svg>");
    background-size: contain;
    background-repeat: no-repeat;
    pointer-events: none;
  }
  .tips-inner { max-width: 1280px; margin: 0 auto; position: relative; z-index: 1; }
  .tips-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-top: 48px;
  }
  .tip {
    background: rgba(255, 255, 255, 0.04);
    border-left: 4px solid var(--accent);
    padding: 26px 24px 24px;
    position: relative;
    cursor: pointer;
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.6s ease, transform 0.6s ease, background 0.3s ease, border-left-width 0.3s ease, padding-left 0.3s ease;
  }
  .tip.in { opacity: 1; transform: translateY(0); }
  .tip::before {
    content: "";
    position: absolute;
    top: 0; left: 0;
    width: 60%; height: 1px;
    background: var(--accent);
    opacity: 0.7;
  }
  .tip:hover {
    background: rgba(255, 255, 255, 0.07);
    border-left-width: 8px;
    padding-left: 20px;
  }
  .tip-cat {
    font-family: "DM Sans", sans-serif;
    font-size: 0.6rem;
    letter-spacing: 0.24em;
    color: var(--accent);
    text-transform: uppercase;
    font-weight: 600;
    margin-bottom: 10px;
  }
  .tip-title {
    font-family: "Cormorant Garamond", serif;
    font-weight: 600;
    font-size: 1.25rem;
    color: white;
    line-height: 1.15;
    margin-bottom: 10px;
    letter-spacing: -0.005em;
  }
  .tip-body {
    font-family: "DM Sans", sans-serif;
    font-weight: 300;
    font-size: 0.9rem;
    line-height: 1.65;
    color: rgba(245, 237, 216, 0.65);
  }

  /* ============ GALLERY ============ */
  .gallery-section {
    background: var(--cream);
    padding: 96px 64px;
  }
  .gallery-inner { max-width: 1280px; margin: 0 auto; }
  .gallery-grid {
    column-count: 3;
    column-gap: 18px;
    margin-top: 48px;
  }
  .photo {
    position: relative;
    margin-bottom: 18px;
    break-inside: avoid;
    overflow: hidden;
    cursor: pointer;
    opacity: 0;
    transform: translateY(16px);
    transition: opacity 0.7s ease, transform 0.7s ease;
  }
  .photo.in { opacity: 1; transform: translateY(0); }
  .photo .ph {
    width: 100%;
    display: block;
    color: rgba(255,255,255,0.5);
    font-family: "DM Sans", sans-serif;
    font-size: 0.65rem;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    text-align: center;
    padding: 16px;
    transition: transform 0.6s cubic-bezier(0.2, 0.7, 0.2, 1);
  }
  .photo:hover .ph { transform: scale(1.05); }
  .photo .frame {
    position: absolute;
    inset: 12px;
    border: 1px solid var(--gold);
    opacity: 0;
    transition: opacity 0.4s ease;
    pointer-events: none;
  }
  .photo:hover .frame { opacity: 0.7; }
  .photo .ph-cap {
    position: absolute;
    bottom: 14px; left: 16px; right: 16px;
    font-family: "Cormorant Garamond", serif;
    font-style: italic;
    font-size: 1rem;
    color: white;
    z-index: 2;
    opacity: 0;
    transform: translateY(8px);
    transition: opacity 0.4s ease, transform 0.4s ease;
  }
  .photo:hover .ph-cap { opacity: 1; transform: translateY(0); }
  .photo .ph::after {
    content: "";
    position: absolute; inset: 0;
    background: linear-gradient(180deg, transparent 50%, rgba(13, 5, 0, 0.55) 100%);
  }
  .photo .glyph {
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -55%);
    font-family: "Cormorant Garamond", serif;
    font-weight: 700;
    font-style: italic;
    color: rgba(255, 255, 255, 0.18);
    pointer-events: none;
  }
  .ph-1 { background: linear-gradient(160deg, #E8580A 0%, #8B1A1A 100%); height: 360px; position: relative; }
  .ph-2 { background: linear-gradient(160deg, #C9901A 0%, #6b3c08 100%); height: 240px; position: relative; }
  .ph-3 { background: linear-gradient(160deg, #5a1408 0%, #2a0a02 100%); height: 300px; position: relative; }
  .ph-4 { background: linear-gradient(160deg, #f6c84a 0%, #C9901A 100%); height: 220px; position: relative; }
  .ph-5 { background: linear-gradient(160deg, #8B1A1A 0%, #4a0a0a 100%); height: 320px; position: relative; }
  .ph-6 { background: linear-gradient(160deg, #C9901A 0%, #E8580A 100%); height: 260px; position: relative; }
  .ph-7 { background: linear-gradient(160deg, #2a0a02 0%, #5a1408 100%); height: 280px; position: relative; }
  .ph-8 { background: linear-gradient(160deg, #E8580A 0%, #C9901A 100%); height: 200px; position: relative; }
  .ph-9 { background: linear-gradient(160deg, #6b3c08 0%, #2a0a02 100%); height: 340px; position: relative; }

  /* ============ RELATED ============ */
  .related-section {
    background: var(--parchment);
    padding: 80px 64px 96px;
    border-top: 1px solid rgba(201, 144, 26, 0.18);
  }
  .related-inner { max-width: 1280px; margin: 0 auto; }
  .related-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-top: 36px;
  }
  .rel-card {
    background: white;
    padding: 26px 24px;
    border-left: 4px solid var(--gold);
    display: flex;
    flex-direction: column;
    gap: 10px;
    transition: transform 0.4s ease, box-shadow 0.4s ease;
    cursor: pointer;
  }
  .rel-card:hover { transform: translateY(-4px); box-shadow: 0 18px 40px rgba(13,5,0,0.1); }
  .rel-card.b-hindu { border-left-color: var(--crimson); }
  .rel-card.b-sikh { border-left-color: #d97706; }
  .rel-eye {
    font-family: "DM Sans", sans-serif;
    font-size: 0.6rem;
    letter-spacing: 0.22em;
    color: var(--gold);
    text-transform: uppercase;
    font-weight: 600;
  }
  .rel-name {
    font-family: "Cormorant Garamond", serif;
    font-weight: 600;
    font-size: 1.45rem;
    color: var(--ink);
    line-height: 1.05;
    letter-spacing: -0.005em;
  }
  .rel-tag {
    font-family: "Cormorant Garamond", serif;
    font-style: italic;
    font-size: 0.95rem;
    color: rgba(13, 5, 0, 0.65);
    line-height: 1.5;
    margin-bottom: 4px;
  }
  .rel-link {
    margin-top: auto;
    font-family: "DM Sans", sans-serif;
    font-size: 0.7rem;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: var(--saffron);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding-top: 10px;
    font-weight: 500;
  }
  .rel-link .arrow { transition: transform 0.3s ease; }
  .rel-card:hover .rel-link .arrow { transform: translateX(4px); }

  /* ============ KEYFRAMES ============ */
  @keyframes fadeUp { from { opacity: 0; transform: translateY(28px); } to { opacity: 1; transform: translateY(0); } }
  @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
  @keyframes bounce {
    0%, 100% { transform: rotate(45deg) translate(0, 0); opacity: 0.4; }
    50%      { transform: rotate(45deg) translate(4px, 4px); opacity: 1; }
  }

  /* reveal */
  .reveal { opacity: 0; transform: translateY(24px); transition: opacity 0.9s ease, transform 0.9s cubic-bezier(0.2,0.7,0.2,1); }
  .reveal.in { opacity: 1; transform: translateY(0); }

  /* ============ RESPONSIVE ============ */
  @media (max-width: 1100px) {
    .about-inner { grid-template-columns: 1fr; gap: 40px; padding: 64px 40px; }
    .sidebar { position: relative; top: auto; }
    .tips-grid { grid-template-columns: repeat(2, 1fr); }
    .related-grid { grid-template-columns: repeat(2, 1fr); }
    .gallery-grid { column-count: 2; }
    .facts { grid-template-columns: repeat(2, 1fr); gap: 32px; padding: 32px; }
    .fact + .fact:nth-child(odd)::before { display: none; }
    .timeline { padding-left: 88px; }
    .timeline::before { left: 66px; }
    .ritual::before { left: -28px; }
    .ritual-day { left: -88px; width: 64px; font-size: 0.55rem; }
    .ritual-day .day-num { font-size: 1rem; }
  }
  @media (max-width: 720px) {
    .nav { padding: 0 20px; gap: 16px; }
    .nav-links { display: none; }
    .hero-inner { padding: 80px 20px 80px; }
    .facts, .timeline-section, .tips-section, .gallery-section, .related-section { padding-left: 24px; padding-right: 24px; }
    .about-inner { padding: 48px 24px; }
    .tips-grid { grid-template-columns: 1fr; }
    .related-grid { grid-template-columns: repeat(2, 1fr); }
    .gallery-grid { column-count: 1; }
  }

</style>
@endsection

@section('content')
<!-- HERO -->
<section class="hero" data-screen-label="01 Hero">
  <div class="hero-bg" @if($festival->getFirstMediaUrl('festival-cover')) style="background: radial-gradient(ellipse at 50% 30%, rgba(232, 88, 10, 0.45) 0%, transparent 55%), radial-gradient(ellipse at 20% 80%, rgba(201, 144, 26, 0.25) 0%, transparent 50%), linear-gradient(160deg, #2a0a02 0%, #5a1408 35%, #8B1A1A 70%, #C9901A 100%), url('{{ $festival->getFirstMediaUrl('festival-cover') }}') center/cover no-repeat;" @endif></div>
  <div class="mandala-hero"></div>
  <div class="particles" id="particles"></div>
  <div class="hero-darken"></div>

  <div class="hero-inner">
    <div class="religion-badge">{{ $festival->religion }}</div>
    <h1 class="fest-name">{{ $festival->name }}</h1>
    <div class="tagline"><span class="star">✦</span>{{ $festival->tagline ?? $festival->name }}<span class="star">✦</span></div>
    <div class="hero-pills">
      <span class="hero-pill">{{ $festival->month_name }}</span>
      <span class="hero-pill">{{ $festival->duration_days }} Days</span>
      <span class="hero-pill">{{ $festival->is_national ? 'Pan India' : ($festival->state ? $festival->state->name : '') }}</span>
    </div>
  </div>

  <div class="scroll-cue">
    <span class="lbl">Scroll to Explore</span>
    <span class="chev"></span>
  </div>
</section>

<!-- FACTS -->
<section class="facts" data-screen-label="02 Facts">
  <div class="fact">
    <div class="fact-label">Month</div>
    <div class="fact-value">{{ $festival->month_name }}</div>
  </div>
  <div class="fact">
    <div class="fact-label">Duration</div>
    <div class="fact-value">{{ $festival->duration_days }} Days</div>
  </div>
  <div class="fact">
    <div class="fact-label">Religion</div>
    <div class="fact-value"><span class="dot"></span>{{ $festival->religion }}</div>
  </div>
  <div class="fact">
    <div class="fact-label">Origin</div>
    <div class="fact-value">{{ $festival->is_national ? 'Pan India' : ($festival->state ? $festival->state->name : '') }}</div>
  </div>
</section>

<!-- ABOUT + SIDEBAR -->
<section class="about" data-screen-label="03 About">
<div class="about-inner">
  <div class="body reveal">
    <div class="section-eye"><span>✦</span><span>About the Festival</span><span>✦</span></div>
    <h2 class="section-title">The Festival of <em>{{ explode(' ', $festival->name)[0] }}</em></h2>

    <div style="font-family: 'DM Sans', sans-serif; font-weight: 300; font-size: 1rem; line-height: 1.9; color: rgba(13,5,0,0.65); max-width: 640px; margin-bottom: 20px;">
        {!! $festival->full_description !!}
    </div>

    @if($festival->significance)
    <h3 class="sub-h">Spiritual <em>Significance</em></h3>
    <div style="font-family: 'DM Sans', sans-serif; font-weight: 300; font-size: 1rem; line-height: 1.9; color: rgba(13,5,0,0.65); max-width: 640px; margin-bottom: 20px;">
        {!! $festival->significance !!}
    </div>
    @endif

    @if($festival->how_celebrated)
    <h3 class="sub-h">How It Is <em>Celebrated</em></h3>
    <div style="font-family: 'DM Sans', sans-serif; font-weight: 300; font-size: 1rem; line-height: 1.9; color: rgba(13,5,0,0.65); max-width: 640px; margin-bottom: 20px;">
        {!! $festival->how_celebrated !!}
    </div>
    @endif
  </div>

  <aside class="sidebar reveal">
    <div class="quote-card">
      <div class="pattern"></div>
      <p class="quote-text">{{ $festival->short_description }}</p>
      <div class="quote-attr">— {{ $festival->name }}</div>
    </div>

    @if($festival->celebratingStates->isNotEmpty())
    <div class="states-card">
      <div class="h">Celebrated Across</div>
      @foreach($festival->celebratingStates as $cState)
      <div class="state-row">
        <span>{{ $cState->name }}</span>
        <a href="{{ route('states.show', $cState->slug) }}">View State <span class="arrow">→</span></a>
      </div>
      @endforeach
    </div>
    @elseif($festival->state)
    <div class="states-card">
      <div class="h">Origin State</div>
      <div class="state-row">
        <span>{{ $festival->state->name }}</span>
        <a href="{{ route('states.show', $festival->state->slug) }}">View State <span class="arrow">→</span></a>
      </div>
    </div>
    @endif
  </aside>
</div>
</section>

<!-- TIMELINE -->
<section class="timeline-section" data-screen-label="04 Rituals">
  <div class="timeline-inner">
    <header class="timeline-head reveal">
      <div class="section-eye"><span>✦</span><span>Key Rituals &amp; Traditions</span><span>✦</span></div>
      <h2 class="section-title">Sacred <em>Rituals</em> of {{ $festival->name }}</h2>
    </header>

    <div class="timeline">
      @forelse($festival->rituals as $i => $ritual)
      <div class="ritual">
        <span class="ritual-day">Day {{ $ritual->day_number }}<span class="day-num">{{ $ritual->name }}</span></span>
        <h3 class="ritual-name">Ritual <em>{{ $i + 1 }}</em></h3>
        <p class="ritual-desc">{{ $ritual->description }}</p>
      </div>
      @empty
      @php
        $fallbackRituals = [
          ['day' => 'Day 1', 'name' => 'Preparation', 'n' => 1, 'title' => 'Sacred Preparation', 'desc' => 'Homes and hearts are cleansed and decorated in readiness — an act of devotion before the celebration begins.'],
          ['day' => 'Day 2', 'name' => 'Main Celebration', 'n' => 2, 'title' => 'The Grand Gathering', 'desc' => 'Families and communities unite for prayer, music, and feasting at the heart of the festival.'],
          ['day' => 'Day 3', 'name' => 'Gratitude', 'n' => 3, 'title' => 'Farewell & Blessings', 'desc' => 'The festival closes with gratitude offerings, prayers for the year ahead, and communal farewells.'],
        ];
      @endphp
      @foreach($fallbackRituals as $fr)
      <div class="ritual">
        <span class="ritual-day">{{ $fr['day'] }}<span class="day-num">{{ $fr['name'] }}</span></span>
        <h3 class="ritual-name">Ritual <em>{{ $fr['n'] }}</em></h3>
        <p class="ritual-desc">{{ $fr['desc'] }}</p>
      </div>
      @endforeach
      @endforelse
    </div>
  </div>
</section>

<!-- TIPS -->
<section class="tips-section" data-screen-label="05 Tips">
  <div class="tips-inner">
    <header class="reveal">
      <div class="section-eye gold-shimmer"><span>✦</span><span>Your Complete Festival Guide</span><span>✦</span></div>
      <h2 class="section-title on-dark">Everything You <em>Need to Know</em></h2>
    </header>

    <div class="tips-grid">
      @php
        $colors = ['#E8758C', '#F2B53A', '#6FB7E8', '#B27CE3', '#E5523A', '#3FA89B', '#2A8551', '#C9901A'];
      @endphp
      @forelse($festival->tips as $i => $tip)
      <article class="tip" style="--accent: {{ $colors[$i % count($colors)] }};">
        <div class="tip-cat">{{ str_replace('_', ' ', $tip->tip_category) }}</div>
        <h4 class="tip-title">{{ $tip->tip }}</h4>
        <p class="tip-body"></p>
      </article>
      @empty
      @php
        $fallbackTips = [
          ['cat' => 'Best Time',    'color' => '#F2B53A', 'title' => 'Choose the Right Day',      'body' => 'The main day is the most vibrant — arrive early to witness the morning rituals before crowds build.'],
          ['cat' => 'Dress Code',   'color' => '#B27CE3', 'title' => 'Wear Traditional Attire',   'body' => 'Bright festive colours show respect and help you feel part of the celebration.'],
          ['cat' => 'Food',         'color' => '#E5523A', 'title' => 'Try the Festival Sweets',   'body' => 'Every festival has its signature treats — ask a local vendor for the must-try item of the season.'],
          ['cat' => 'Photography',  'color' => '#6FB7E8', 'title' => 'Capture Respectfully',      'body' => 'Always seek permission before photographing rituals or people. Golden-hour light is magical.'],
          ['cat' => 'Safety',       'color' => '#3FA89B', 'title' => 'Stay Aware in Crowds',      'body' => 'Keep valuables secure, stay with your group, and note the exit routes at large gatherings.'],
          ['cat' => 'Transport',    'color' => '#C9901A', 'title' => 'Plan Your Journey Early',   'body' => 'Festival days see heavy traffic — book transport well in advance and allow extra travel time.'],
        ];
      @endphp
      @foreach($fallbackTips as $i => $ft)
      <article class="tip" style="--accent: {{ $ft['color'] }};">
        <div class="tip-cat">{{ $ft['cat'] }}</div>
        <h4 class="tip-title">{{ $ft['title'] }}</h4>
        <p class="tip-body">{{ $ft['body'] }}</p>
      </article>
      @endforeach
      @endforelse
    </div>
  </div>
</section>

<!-- GALLERY -->
@if($festival->hasMedia("gallery"))
<section class="gallery-section" data-screen-label="06 Gallery">
  <div class="gallery-inner">
    <header class="reveal">
      <div class="section-eye"><span>✦</span><span>Festival Gallery</span><span>✦</span></div>
      <h2 class="section-title">{{ $festival->name }} in <em>Pictures</em></h2>
    </header>

    <div class="gallery-grid">
      @foreach($festival->getMedia('gallery') as $i => $media)
      @php
        $phClass = 'ph-' . (($i % 9) + 1);
        $glyphs = ['A','B','C','D','E','F','G','H','I'];
        $glyph = $glyphs[$i % 9];
      @endphp
      <div class="photo">
        <div class="ph {{ $phClass }}" style="background: url('{{ $media->getUrl() }}') center/cover no-repeat;">
          <span class="glyph" style="font-size: 6rem;">{{ $glyph }}</span>
          <span class="ph-cap">{{ $media->custom_properties['caption'] ?? $festival->name }}</span>
        </div>
        <div class="frame"></div>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- RELATED -->
@if($related->isNotEmpty())
<section class="related-section" data-screen-label="07 Related">
  <div class="related-inner">
    <header class="reveal">
      <div class="section-eye"><span>✦</span><span>Continue the Calendar</span><span>✦</span></div>
      <h2 class="section-title">You Might Also <em>Like</em></h2>
    </header>

    <div class="related-grid">
      @foreach($related as $rel)
      @php
        $bClass = 'b-hindu';
        if($rel->religion === 'Sikh') $bClass = 'b-sikh';
        elseif($rel->religion === 'Muslim') $bClass = 'b-muslim';
      @endphp
      <article class="rel-card {{ $bClass }}" onclick="window.location='{{ route('festivals.show', $rel->slug) }}'">
        <span class="rel-eye">{{ $rel->religion }} · {{ $rel->month_name }}</span>
        <h4 class="rel-name">{{ $rel->name }}</h4>
        <p class="rel-tag">{{ $rel->short_description }}</p>
        <a href="{{ route('festivals.show', $rel->slug) }}" class="rel-link">Know More <span class="arrow">→</span></a>
      </article>
      @endforeach
    </div>
  </div>
</section>
@endif
@endsection

@push('scripts')
<script>
  // PARTICLES
  (function makeParticles() {
    const wrap = document.getElementById('particles');
    if (!wrap) return;
    const N = 24;
    for (let i = 0; i < N; i++) {
      const p = document.createElement('span');
      p.className = 'particle';
      const size = 3 + Math.random() * 3;
      p.style.width = size + 'px';
      p.style.height = size + 'px';
      p.style.left = (Math.random() * 100) + '%';
      const dur = 4 + Math.random() * 4;
      const delay = Math.random() * 6;
      p.style.animationDuration = dur + 's';
      p.style.animationDelay = '-' + delay + 's';
      p.style.setProperty('--drift', (Math.random() * 60 - 30) + 'px');
      p.style.opacity = (0.4 + Math.random() * 0.4).toFixed(2);
      wrap.appendChild(p);
    }
  })();

  // REVEAL + STAGGER
  const reveals = document.querySelectorAll('.reveal');
  const rituals = document.querySelectorAll('.ritual');
  const tips = document.querySelectorAll('.tip');
  const photos = document.querySelectorAll('.photo');

  const io = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('in');
        io.unobserve(entry.target);
      }
    });
  }, { threshold: 0.12, rootMargin: '0px 0px -60px 0px' });

  reveals.forEach(el => io.observe(el));

  rituals.forEach((el, i) => {
    el.style.transitionDelay = (i * 100) + 'ms';
    io.observe(el);
  });
  tips.forEach((el, i) => {
    el.style.transitionDelay = (i * 30) + 'ms';
    io.observe(el);
  });
  photos.forEach((el, i) => {
    el.style.transitionDelay = (i * 60) + 'ms';
    io.observe(el);
  });
</script>
@endpush
