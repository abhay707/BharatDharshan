@extends('layouts.app')

@section('title', 'Bharatdarshan — States')
@section('body_class', 'page-light')

@section('styles')
<style>

  

  

  

  .text-label {
    font-family: "DM Sans", sans-serif;
    font-size: 0.65rem;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    font-weight: 500;
  }

  

  /* ============ HERO ============ */
  .hero {
    position: relative;
    min-height: 100vh;
    height: 100vh;
    background: linear-gradient(135deg, #0D0500 0%, #8B1A1A 55%, #E8580A 100%);
    clip-path: polygon(0 0, 100% 0, 100% 88%, 0 100%);
    padding: 128px 80px 120px;
    display: grid;
    grid-template-columns: 1.1fr 0.9fr;
    align-items: center;
    gap: 64px;
    overflow: hidden;
  }
  .hero::before {
    /* subtle warm noise */
    content: "";
    position: absolute;
    inset: 0;
    pointer-events: none;
    opacity: 0.4;
    mix-blend-mode: overlay;
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='200' height='200'><filter id='n'><feTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='2' stitchTiles='stitch'/><feColorMatrix values='0 0 0 0 0.85  0 0 0 0 0.65  0 0 0 0 0.3  0 0 0 0.18 0'/></filter><rect width='100%' height='100%' filter='url(%23n)'/></svg>");
  }
  .hero::after {
    /* faint mandala */
    content: "";
    position: absolute;
    right: -120px;
    top: 50%;
    transform: translateY(-50%);
    width: 700px; height: 700px;
    pointer-events: none;
    opacity: 0.07;
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 600 600'><g fill='none' stroke='%23F5EDD8' stroke-width='0.7'><circle cx='300' cy='300' r='280'/><circle cx='300' cy='300' r='220'/><circle cx='300' cy='300' r='160'/><circle cx='300' cy='300' r='100'/><circle cx='300' cy='300' r='40'/><g transform='translate(300 300)'><g id='p'><path d='M0 -280 Q 60 -200 0 -160 Q -60 -200 0 -280Z'/></g><use href='%23p' transform='rotate(30)'/><use href='%23p' transform='rotate(60)'/><use href='%23p' transform='rotate(90)'/><use href='%23p' transform='rotate(120)'/><use href='%23p' transform='rotate(150)'/><use href='%23p' transform='rotate(180)'/><use href='%23p' transform='rotate(210)'/><use href='%23p' transform='rotate(240)'/><use href='%23p' transform='rotate(270)'/><use href='%23p' transform='rotate(300)'/><use href='%23p' transform='rotate(330)'/></g></g></svg>");
    background-size: contain;
    background-repeat: no-repeat;
  }

  .hero-left { position: relative; z-index: 2; max-width: 640px; }

  .pill {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    border: 1px solid var(--gold);
    padding: 7px 16px;
    font-family: "DM Sans", sans-serif;
    font-size: 10px;
    letter-spacing: 0.22em;
    color: var(--gold);
    text-transform: uppercase;
    margin-bottom: 32px;
    opacity: 0;
    animation: fadeUp 0.9s ease forwards;
    animation-delay: 100ms;
  }
  .pill .star { font-size: 10px; }

  .hero h1 {
    font-family: "Cormorant Garamond", serif;
    line-height: 0.95;
    letter-spacing: -0.01em;
    color: var(--parchment);
  }
  .hero h1 .l1, .hero h1 .l2 {
    display: block;
    opacity: 0;
    transform: translateY(28px);
    animation: fadeUp 1s cubic-bezier(0.2, 0.7, 0.2, 1) forwards;
  }
  .hero h1 .l1 {
    font-weight: 700;
    font-size: clamp(2.4rem, 4.4vw, 4rem);
    color: var(--parchment);
    animation-delay: 200ms;
  }
  .hero h1 .l2 {
    font-weight: 700;
    font-style: italic;
    font-size: clamp(4.2rem, 8vw, 7rem);
    color: var(--gold);
    margin-left: -4px;
    animation-delay: 380ms;
    line-height: 0.95;
  }

  .hero-divider {
    width: 60px; height: 1px;
    background: var(--gold);
    margin: 24px 0;
    opacity: 0;
    animation: fadeIn 0.9s ease forwards;
    animation-delay: 520ms;
  }

  .hero-sub {
    font-family: "DM Sans", sans-serif;
    font-weight: 300;
    font-size: 1.05rem;
    line-height: 1.8;
    color: rgba(245, 237, 216, 0.75);
    max-width: 480px;
    opacity: 0;
    animation: fadeUp 1s ease forwards;
    animation-delay: 600ms;
  }
  .hero-sub em {
    font-family: "Cormorant Garamond", serif;
    font-style: italic;
    color: var(--parchment);
  }

  .hero-meta {
    display: flex;
    gap: 28px;
    margin-top: 36px;
    align-items: center;
    opacity: 0;
    animation: fadeUp 1s ease forwards;
    animation-delay: 760ms;
  }
  .hero-meta .num {
    font-family: "Cormorant Garamond", serif;
    font-weight: 600;
    font-size: 1.6rem;
    color: var(--gold);
    line-height: 1;
  }
  .hero-meta .lbl {
    font-family: "DM Sans", sans-serif;
    font-size: 0.62rem;
    letter-spacing: 0.2em;
    color: rgba(245, 237, 216, 0.55);
    text-transform: uppercase;
    margin-top: 4px;
  }
  .hero-meta .vrule {
    width: 1px; height: 32px;
    background: linear-gradient(to bottom, transparent, rgba(245, 237, 216, 0.4), transparent);
  }

  /* hero card stack */
  .hero-right {
    position: relative;
    z-index: 2;
    height: 360px;
  }
  .mini-stack {
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    width: 380px; height: 380px;
    animation: floatStack 4.5s ease-in-out infinite alternate;
  }
  .mini-card {
    position: absolute;
    border: 1px solid rgba(245, 237, 216, 0.1);
    box-shadow: 0 18px 48px rgba(0, 0, 0, 0.45);
    overflow: hidden;
    opacity: 0;
    transform: scale(0.85) translateY(20px);
    transition: transform 0.5s cubic-bezier(0.2, 0.7, 0.2, 1);
  }
  .mini-card::after {
    content: "";
    position: absolute; inset: 0;
    background: linear-gradient(180deg, transparent 35%, rgba(0, 0, 0, 0.55) 100%);
    pointer-events: none;
  }
  .mini-card .glyph {
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -55%);
    font-family: "Cormorant Garamond", serif;
    font-weight: 700;
    font-style: italic;
    font-size: 220px;
    line-height: 1;
    color: rgba(245, 237, 216, 0.18);
    pointer-events: none;
  }
  .mini-card .ml {
    position: absolute;
    bottom: 16px; left: 18px;
    font-family: "Cormorant SC", serif;
    font-weight: 600;
    font-size: 12px;
    letter-spacing: 0.22em;
    color: var(--gold);
    z-index: 2;
  }
  .mc-1 { /* Rajasthan */
    width: 220px; height: 300px;
    top: 30px; left: 80px;
    background: linear-gradient(160deg, #E8580A 0%, #8B1A1A 65%, #4a0a0a 100%);
    z-index: 4;
    animation: cardIn1 1.1s cubic-bezier(0.2, 0.7, 0.2, 1) forwards;
    animation-delay: 350ms;
  }
  .mc-2 { /* Kerala */
    width: 200px; height: 270px;
    top: 0; left: 0;
    background: linear-gradient(160deg, #2a7a5e 0%, #0e3429 100%);
    z-index: 3;
    animation: cardIn2 1.1s cubic-bezier(0.2, 0.7, 0.2, 1) forwards;
    animation-delay: 500ms;
  }
  .mc-3 { /* Tamil Nadu */
    width: 200px; height: 270px;
    bottom: 0; right: 0;
    background: linear-gradient(160deg, #2a4f8a 0%, #0c1d3d 100%);
    z-index: 2;
    animation: cardIn3 1.1s cubic-bezier(0.2, 0.7, 0.2, 1) forwards;
    animation-delay: 650ms;
  }
  @keyframes cardIn1 { to { opacity: 1; transform: scale(1) translateY(0) rotate(0deg); } }
  @keyframes cardIn2 { to { opacity: 1; transform: scale(1) translateY(0) rotate(-7deg); } }
  @keyframes cardIn3 { to { opacity: 1; transform: scale(1) translateY(0) rotate(6deg); } }
  .mc-2 { transform: scale(0.85) translateY(20px) rotate(-7deg); }
  .mc-3 { transform: scale(0.85) translateY(20px) rotate(6deg); }

  /* ============ SEARCH / FILTER BAR ============ */
  /* Matches Heritage filter bar exactly */
  .search-wrap {
    position: sticky;
    top: 64px;
    z-index: 90;
    background: white;
    color: #1A0A00;
    --faint: rgba(13,5,0,0.40);
    --muted: rgba(13,5,0,0.62);
    --hairline: rgba(13,5,0,0.10);
    box-shadow: 0 28px 70px rgba(13,5,0,0.22), 0 4px 12px rgba(13,5,0,0.06);
    border-top: 1px solid rgba(201,144,26,0.25);
    transition: box-shadow 0.3s ease;
  }
  .search-wrap.past-hero {
    box-shadow: 0 8px 40px rgba(13,5,0,0.24), 0 2px 10px rgba(13,5,0,0.10);
    border-top-color: rgba(201,144,26,0.4);
  }
  .search-inner {
    max-width: 1440px;
    margin: 0 auto;
    padding: 24px 80px;
    display: grid;
    grid-template-columns: 2fr 1fr 1fr auto;
    gap: 28px;
    align-items: end;
  }
  /* Reuse Heritage .f / .f-label / .f-select classes */
  .f { display: flex; flex-direction: column; gap: 6px; }
  .f-label { font-family: "DM Sans", sans-serif; font-size: 0.6rem; letter-spacing: 0.24em; color: var(--faint); text-transform: uppercase; font-weight: 500; }
  .f-select { appearance: none; -webkit-appearance: none; background: transparent; border: none; border-bottom: 1.5px solid var(--hairline); padding: 6px 24px 6px 0; font-family: "Cormorant Garamond", serif; font-weight: 500; font-size: 1.1rem; color: var(--ink); cursor: pointer; transition: border-color 0.35s ease; background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='none' stroke='%23C9901A' stroke-width='1.5'><path d='M3 6 L8 11 L13 6'/></svg>"); background-repeat: no-repeat; background-position: right center; background-size: 14px; outline: none; }
  .f-select:focus { border-bottom-color: var(--gold); }
  .f-input { background: transparent; border: none; border-bottom: 1.5px solid var(--hairline); padding: 6px 24px 6px 20px; font-family: "Cormorant Garamond", serif; font-weight: 500; font-size: 1.1rem; color: var(--ink); outline: none; width: 100%; transition: border-color 0.35s ease; }
  .f-input::placeholder { color: rgba(13,5,0,0.35); font-style: italic; }
  .f-input:focus { border-bottom-color: var(--gold); }
  .f-input-wrap { position: relative; }
  .f-input-wrap .f-icon { position: absolute; left: 0; top: 50%; transform: translateY(-50%); width: 14px; height: 14px; color: var(--gold); pointer-events: none; }
  .f-count { font-family: "DM Sans", sans-serif; font-size: 0.75rem; color: rgba(13,5,0,0.45); padding-bottom: 8px; align-self: end; white-space: nowrap; }
  .f-count strong { color: #1A0A00; font-weight: 500; }


  /* ============ REGION SECTION ============ */
  .states-content {
    padding: 80px 64px 100px;
    max-width: 1440px;
    margin: 0 auto;
    background: #FAF6EE;
    color: #1A0A00;
    --muted: rgba(13, 5, 0, 0.62);
    --faint: rgba(13, 5, 0, 0.40);
    --hairline: rgba(13, 5, 0, 0.10);
  }

  .region {
    position: relative;
    margin-bottom: 96px;
    opacity: 0;
    transform: translateY(40px);
    transition: opacity 1s ease, transform 1s cubic-bezier(0.2, 0.7, 0.2, 1);
  }
  .region.in-view { opacity: 1; transform: translateY(0); }

  .region-header {
    position: relative;
    display: flex;
    align-items: flex-end;
    gap: 24px;
    margin-bottom: 48px;
    padding-top: 24px;
  }
  .region-ord {
    position: absolute;
    top: -40px;
    left: -10px;
    font-family: "Cormorant Garamond", serif;
    font-weight: 700;
    font-size: 9rem;
    line-height: 1;
    color: var(--ink);
    opacity: 0.05;
    letter-spacing: -0.04em;
    pointer-events: none;
    user-select: none;
  }
  .region-meta {
    position: relative;
    display: flex;
    flex-direction: column;
    gap: 6px;
    z-index: 2;
  }
  .region-eyebrow {
    font-family: "DM Sans", sans-serif;
    font-size: 0.65rem;
    letter-spacing: 0.28em;
    text-transform: uppercase;
    color: var(--gold);
    font-weight: 500;
  }
  .region-title {
    font-family: "Cormorant Garamond", serif;
    font-weight: 600;
    font-size: 2.6rem;
    color: #1A0A00;
    line-height: 1;
  }
  .region-title em {
    font-style: italic;
    color: var(--saffron);
  }
  .region-badge {
    background: var(--saffron);
    color: white;
    font-family: "DM Sans", sans-serif;
    font-size: 0.65rem;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    padding: 6px 12px;
    font-weight: 500;
    align-self: center;
    margin-bottom: 6px;
  }
  .region-rule {
    flex: 1;
    height: 1px;
    background: linear-gradient(to right, var(--gold) 0%, var(--gold) 30%, var(--hairline) 100%);
    margin-bottom: 12px;
  }
  .region-tag {
    font-family: "Cormorant Garamond", serif;
    font-style: italic;
    font-size: 1rem;
    color: var(--muted);
    margin-bottom: 12px;
  }

  /* ============ STATE GRID ============ */
  .state-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
  }

  .state-card {
    position: relative;
    background: white;
    box-shadow: 0 4px 14px rgba(13, 5, 0, 0.04);
    border-bottom: 1px solid var(--hairline);
    cursor: pointer;
    opacity: 0;
    transform: translateY(24px);
    transition: opacity 0.7s ease, transform 0.7s cubic-bezier(0.2, 0.7, 0.2, 1), box-shadow 0.5s ease;
    display: flex;
    flex-direction: column;
  }
  .region.in-view .state-card { opacity: 1; transform: translateY(0); }
  .state-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 24px 60px rgba(13, 5, 0, 0.18);
  }
  .state-card:hover .img-wrap > .gradient { transform: scale(1.08); }
  .state-card:hover .state-cta .arrow { transform: translateX(5px); }

  .img-wrap {
    position: relative;
    aspect-ratio: 4 / 4.5;
    overflow: hidden;
  }
  .img-wrap .gradient {
    position: absolute;
    inset: 0;
    transition: transform 0.8s cubic-bezier(0.2, 0.7, 0.2, 1);
  }
  .img-wrap .gradient::after {
    content: "";
    position: absolute; inset: 0;
    background: linear-gradient(180deg, transparent 40%, rgba(13, 5, 0, 0.45) 100%);
  }
  .img-wrap .glyph {
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -55%);
    font-family: "Cormorant Garamond", serif;
    font-weight: 700;
    font-style: italic;
    font-size: 16rem;
    line-height: 1;
    color: rgba(255, 255, 255, 0.13);
    pointer-events: none;
    user-select: none;
  }
  .img-wrap .pattern {
    position: absolute; inset: 0;
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='80' height='80'><g fill='none' stroke='white' stroke-width='0.4' opacity='0.6'><path d='M40 5 L 75 40 L 40 75 L 5 40 Z'/><circle cx='40' cy='40' r='28'/><circle cx='40' cy='40' r='14'/></g></svg>");
    background-size: 80px;
    opacity: 0.18;
    mix-blend-mode: overlay;
    pointer-events: none;
  }
  .img-wrap .region-tag-pill {
    position: absolute;
    top: 16px; left: 16px;
    z-index: 3;
    font-family: "DM Sans", sans-serif;
    font-size: 0.6rem;
    font-weight: 500;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    color: white;
    padding: 5px 10px;
    background: rgba(13, 5, 0, 0.55);
    backdrop-filter: blur(4px);
    border: 1px solid rgba(255, 255, 255, 0.18);
  }
  .img-wrap .corner-mark {
    position: absolute;
    top: 16px; right: 16px;
    z-index: 3;
    font-family: "Cormorant Garamond", serif;
    font-style: italic;
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.7);
  }
  .img-wrap .state-name-overlay {
    position: absolute;
    bottom: 14px; left: 16px; right: 16px;
    z-index: 3;
    font-family: "Cormorant SC", serif;
    font-weight: 600;
    font-size: 0.8rem;
    letter-spacing: 0.22em;
    color: rgba(255, 255, 255, 0.9);
  }

  /* region-specific gradients */
  .grad-north { background: linear-gradient(160deg, #E8580A 0%, #C9901A 55%, #6b3c08 100%); }
  .grad-south { background: linear-gradient(160deg, #2a7a5e 0%, #1F5C4D 55%, #0e3429 100%); }
  .grad-west  { background: linear-gradient(160deg, #C7325A 0%, #8B1A1A 55%, #3a0a0a 100%); }
  .grad-east  { background: linear-gradient(160deg, #6b3aa0 0%, #3d1d63 55%, #170937 100%); }
  .grad-northeast { background: linear-gradient(160deg, #2a7a5e 0%, #6b3aa0 55%, #170937 100%); }
  .grad-central { background: linear-gradient(160deg, #E8580A 0%, #8B1A1A 55%, #4a0a0a 100%); }

  .state-body {
    padding: 18px 16px 0;
    display: flex;
    flex-direction: column;
    flex: 1;
    background: #FFFFFF;
    color: #1A0A00;
  }
  .state-name {
    font-family: "Cormorant Garamond", serif;
    font-weight: 600;
    font-size: 1.55rem;
    color: #1A0A00;
    line-height: 1.1;
    letter-spacing: -0.005em;
  }
  .state-meta {
    font-family: "DM Sans", sans-serif;
    font-weight: 300;
    font-size: 0.85rem;
    color: #6B5B47;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .state-meta .gdot {
    width: 4px; height: 4px;
    background: #C9901A;
    border-radius: 50%;
  }
  .state-pop {
    font-family: "DM Sans", sans-serif;
    font-size: 0.62rem;
    letter-spacing: 0.2em;
    color: #E8580A;
    text-transform: uppercase;
    font-weight: 600;
    margin-top: 2px;
  }
  .state-desc {
    font-family: "DM Sans", sans-serif;
    font-weight: 300;
    font-size: 0.85rem;
    line-height: 1.55;
    color: #8B7355;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin: 4px 0 8px;
  }
  .state-cta {
    background: var(--saffron);
    color: white;
    border: none;
    font-family: "DM Sans", sans-serif;
    font-weight: 500;
    font-size: 0.78rem;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    padding: 12px 16px;
    width: 100%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: background 0.3s ease;
  }
  .state-cta:hover { background: var(--gold); }
  .state-cta .arrow {
    display: inline-block;
    transition: transform 0.35s ease;
  }

  /* ============ BOTTOM CTA ============ */
  .bottom-cta {
    position: relative;
    background: var(--ink);
    color: var(--parchment);
    padding: 96px 64px;
    text-align: center;
    overflow: hidden;
  }
  .bottom-cta::before {
    content: "";
    position: absolute; inset: 0;
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 600 600'><g fill='none' stroke='%23C9901A' stroke-width='0.6' opacity='0.5'><circle cx='300' cy='300' r='280'/><circle cx='300' cy='300' r='220'/><circle cx='300' cy='300' r='160'/><circle cx='300' cy='300' r='100'/><g transform='translate(300 300)'><g id='p2'><path d='M0 -280 Q 60 -200 0 -160 Q -60 -200 0 -280Z'/></g><use href='%23p2' transform='rotate(30)'/><use href='%23p2' transform='rotate(60)'/><use href='%23p2' transform='rotate(90)'/><use href='%23p2' transform='rotate(120)'/><use href='%23p2' transform='rotate(150)'/><use href='%23p2' transform='rotate(180)'/><use href='%23p2' transform='rotate(210)'/><use href='%23p2' transform='rotate(240)'/><use href='%23p2' transform='rotate(270)'/><use href='%23p2' transform='rotate(300)'/><use href='%23p2' transform='rotate(330)'/></g></g></svg>");
    background-size: 700px;
    background-repeat: no-repeat;
    background-position: center;
    opacity: 0.06;
    pointer-events: none;
  }
  .bottom-cta-inner { position: relative; max-width: 720px; margin: 0 auto; z-index: 1; }
  .bottom-cta .pill-d {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    border: 1px solid var(--gold);
    padding: 7px 16px;
    font-family: "DM Sans", sans-serif;
    font-size: 10px;
    letter-spacing: 0.22em;
    color: var(--gold);
    text-transform: uppercase;
    margin-bottom: 28px;
  }
  .bottom-cta h2 {
    font-family: "Cormorant Garamond", serif;
    font-weight: 700;
    font-size: clamp(2.4rem, 4.4vw, 3.6rem);
    line-height: 1.05;
    color: var(--gold);
    margin-bottom: 12px;
    letter-spacing: -0.01em;
  }
  .bottom-cta h2 em {
    font-style: italic;
    color: var(--parchment);
  }
  .bottom-cta p {
    font-family: "DM Sans", sans-serif;
    font-weight: 300;
    font-size: 1.05rem;
    color: rgba(245, 237, 216, 0.7);
    line-height: 1.7;
    margin-bottom: 32px;
  }
  .bottom-cta-btns { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }
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
  .btn .arrow { display: inline-block; transition: transform 0.35s ease; }
  .btn:hover .arrow { transform: translateX(4px); }
  .btn-primary { background: var(--saffron); color: white; }
  .btn-primary:hover { background: var(--gold); }
  .btn-secondary { background: transparent; color: var(--gold); border: 1.5px solid var(--gold); }
  .btn-secondary:hover { background: var(--gold); color: var(--ink); }

  

  /* ============ ANIMATIONS ============ */
  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(28px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  @keyframes fadeIn {
    from { opacity: 0; }
    to   { opacity: 1; }
  }
  @keyframes floatStack {
    from { transform: translateY(calc(-50% - 4px)); }
    to   { transform: translateY(calc(-50% + 4px)); }
  }

  /* ============ RESPONSIVE ============ */
  @media (max-width: 1100px) {
    .hero { grid-template-columns: 1fr; padding: 128px 48px 96px; }
    .hero-right { display: none; }
    .search-inner { padding: 20px 32px; grid-template-columns: 1fr 1fr; }
    .states-content { padding: 64px 32px 80px; }
  }
  @media (max-width: 720px) {
    .nav { padding: 0 20px; gap: 16px; }
    .nav-links { display: none; }
    .hero { padding: 112px 28px 80px; }
    .search-inner { padding: 16px 20px; grid-template-columns: 1fr; gap: 16px; }
    .region-header { flex-direction: column; align-items: flex-start; gap: 8px; }
    .region-rule { width: 100%; }
    .states-content { padding: 48px 20px 60px; }
    .bottom-cta { padding: 72px 24px; }
    footer { flex-direction: column; gap: 12px; padding: 24px; text-align: center; }
  }

</style>
@endsection

@section('content')
<!-- HERO -->
<section class="hero" data-screen-label="01 States Hero">
  <div class="hero-left">
    <div class="pill">
      <span class="star">✦</span>
      <span>Explore by State</span>
      <span class="star">✦</span>
    </div>
    <h1>
      <span class="l1">The 28 Faces of</span>
      <span class="l2">India</span>
    </h1>
    <div class="hero-divider"></div>
    <p class="hero-sub">
      From snow-bound Himalayan kingdoms to coral-fringed coasts. Each state a <em>language, a cuisine, a thousand-year story</em> unto itself — woven into a single, restless civilization.
    </p>
    <div class="hero-meta">
      <div>
        <div class="num">28</div>
        <div class="lbl">States</div>
      </div>
      <div class="vrule"></div>
      <div>
        <div class="num">8</div>
        <div class="lbl">Union Territories</div>
      </div>
      <div class="vrule"></div>
      <div>
        <div class="num">22</div>
        <div class="lbl">Official Languages</div>
      </div>
    </div>
  </div>
  <div class="hero-right">
    <div class="mini-stack">
      <div class="mini-card mc-2">
        <div class="glyph">K</div>
        <div class="ml">KERALA</div>
      </div>
      <div class="mini-card mc-3">
        <div class="glyph">T</div>
        <div class="ml">TAMIL NADU</div>
      </div>
      <div class="mini-card mc-1">
        <div class="glyph">R</div>
        <div class="ml">RAJASTHAN</div>
      </div>
    </div>
  </div>
</section>

<!-- SEARCH / FILTER BAR — matches Heritage style -->
<div class="search-wrap" id="states-filter-bar">
  <div class="search-inner">
    <div class="f">
      <span class="f-label">Search</span>
      <div class="f-input-wrap">
        <svg class="f-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <circle cx="11" cy="11" r="7"/><line x1="20" y1="20" x2="16.65" y2="16.65"/>
        </svg>
        <input id="state-search" type="text" class="f-input" placeholder="Search any Indian state…" autocomplete="off" />
      </div>
    </div>
    <div class="f">
      <span class="f-label">Region</span>
      <select id="region-filter" class="f-select" onchange="applyStateFilters()">
        <option value="all">All Regions</option>
        <option value="north">North India</option>
        <option value="south">South India</option>
        <option value="east">East India</option>
        <option value="west">West India</option>
        <option value="northeast">Northeast India</option>
        <option value="central">Central India</option>
      </select>
    </div>
    <div class="f">
      <span class="f-label">Sort By</span>
      <select id="sort-filter" class="f-select" onchange="applyStateFilters()">
        <option value="default">Default Order</option>
        <option value="name">Name A–Z</option>
        <option value="population">Population</option>
      </select>
    </div>
    <div class="f-count">
      <strong id="state-count">28</strong> States shown
    </div>
  </div>
</div>


<div class="states-content">
  @foreach($grouped_by_region as $region => $states)
    <section class="region" data-region="{{ strtolower($region) }}">
      <header class="region-header">
        <div class="region-ord">{{ sprintf('%02d', $loop->iteration) }}</div>
        <div class="region-meta">
          <div class="region-eyebrow">Region &middot; {{ sprintf('%02d', $loop->iteration) }} of {{ count($grouped_by_region) }}</div>
          <h2 class="region-title">The <em>{{ $region }}</em></h2>
        </div>
        <div class="region-rule"></div>
        <div class="region-badge">{{ $states->count() }} States</div>
      </header>
      <div class="state-grid">
        @foreach($states as $state)
          <article class="state-card" data-region="{{ strtolower($region) }}" data-name="{{ strtolower($state->name) }}" onclick="window.location='{{ route('states.show', $state->slug) }}'">
            <div class="img-wrap">
              <div class="gradient grad-{{ strtolower($region) }}"></div>
              @php
                $portraitImages = [
                    'kerala'      => '/images/states/Kerala Image Portrate.jpg',
                    'punjab'      => '/images/states/Punjab Portrate.jpg',
                    'rajasthan'   => '/images/states/Rajasthan Portrate 2.jpg',
                    'tamil-nadu'  => '/images/states/Tamil Nadu Portrate.jpg',
                    'west-bengal' => '/images/states/West Bengal Portrate.jpg',
                ];
                $cardImg = $portraitImages[$state->slug] ?? null;
              @endphp
              @if($cardImg)<img src="{{ $cardImg }}" alt="{{ $state->name }}" class="absolute inset-0 w-full h-full object-cover" style="object-position: center 30%; mix-blend-mode: overlay; opacity: 0.7;" loading="lazy">@endif
              <div class="pattern"></div>
              <div class="glyph">{{ substr($state->name, 0, 1) }}</div>
              <div class="region-tag-pill">{{ $region }}</div>
              <div class="corner-mark">&numero; {{ sprintf('%02d', $loop->iteration) }}</div>
              <div class="state-name-overlay">{{ strtoupper($state->name) }}</div>
            </div>
            <div class="state-body">
              <h3 class="state-name">{{ $state->name }}</h3>
              <div class="state-meta">
                <span>{{ $state->capital }}</span>
                <span class="gdot"></span>
                <span>{{ $state->language }}</span>
              </div>
              <div class="state-pop">{{ number_format($state->population/1000000, 1) }}M people</div>
              <p class="state-desc">{{ Str::limit($state->description, 100) }}</p>
              <button class="state-cta">
                <span>Explore {{ $state->name }}</span>
                <span class="arrow">&rarr;</span>
              </button>
            </div>
          </article>
        @endforeach
      </div>
    </section>
  @endforeach
</div>

<!-- BOTTOM CTA -->
<section class="bottom-cta" data-screen-label="06 Bottom CTA">
  <div class="bottom-cta-inner">
    <div class="pill-d">
      <span>✦</span>
      <span>Continue the Journey</span>
      <span>✦</span>
    </div>
    <h2>Explore All <em>28 States</em> of India</h2>
    <p>Each one a chapter in the world's longest continuous civilization — its temples, its tongues, its kitchens. Begin where the spirit calls.</p>
    <div class="bottom-cta-btns">
      <button class="btn btn-primary" onclick="window.scrollTo({top:0, behavior:'smooth'})"><span>Back to Top</span><span class="arrow">&uarr;</span></button>
      <button class="btn btn-secondary" onclick="window.location='{{ route('monuments.index') }}'"><span>Open Heritage</span><span class="arrow">&rarr;</span></button>
    </div>
  </div>
</section>
@endsection

@section('scripts')
<script>

  // Nav active toggle (visual only)
  document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', (e) => {
      if (!link.getAttribute('href')) e.preventDefault();
    });
  });

  const regions = document.querySelectorAll('.region');
  const stateCountEl = document.getElementById('state-count');
  const searchInput = document.getElementById('state-search');
  const regionSelect = document.getElementById('region-filter');

  function applyStateFilters() {
    const q = (searchInput ? searchInput.value.trim().toLowerCase() : '');
    const region = (regionSelect ? regionSelect.value : 'all');
    let visible = 0;
    regions.forEach(sec => {
      const r = sec.getAttribute('data-region');
      let sectionVisible = false;
      sec.querySelectorAll('.state-card').forEach(card => {
        const matchRegion = region === 'all' || r === region;
        const matchSearch = !q || card.dataset.name.includes(q);
        const show = matchRegion && matchSearch;
        card.style.display = show ? '' : 'none';
        if (show) { visible++; sectionVisible = true; }
      });
      sec.style.display = sectionVisible ? '' : 'none';
    });
    if (stateCountEl) stateCountEl.textContent = visible;
  }

  if (searchInput) searchInput.addEventListener('input', applyStateFilters);

  // ⌘K focus
  document.addEventListener('keydown', (e) => {
    if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
      e.preventDefault();
      if (searchInput) searchInput.focus();
    }
  });

  // Sticky search bar — highlight when hero is scrolled past
  const heroEl = document.querySelector('.hero');
  const searchWrapEl = document.querySelector('.search-wrap');
  if (heroEl && searchWrapEl) {
    new IntersectionObserver(([entry]) => {
      searchWrapEl.classList.toggle('past-hero', !entry.isIntersecting);
    }, { threshold: 0 }).observe(heroEl);
  }

  // IntersectionObserver for region reveal + staggered card animation
  const io = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const region = entry.target;
        region.classList.add('in-view');
        const cards = region.querySelectorAll('.state-card');
        cards.forEach((card, i) => {
          card.style.transitionDelay = `${150 + i * 80}ms`;
        });
        io.unobserve(region);
      }
    });
  }, { threshold: 0.12, rootMargin: '0px 0px -60px 0px' });

  regions.forEach(r => io.observe(r));

</script>
@endsection
