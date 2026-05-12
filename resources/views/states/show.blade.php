@extends('layouts.app')

@section('title', $state->name)
@section('meta_description', Str::limit($state->description, 160))
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
    height: 85vh;
    min-height: 640px;
    background: linear-gradient(160deg, #0D0500 0%, #8B1A1A 40%, #E8580A 80%, #C9901A 100%);
    overflow: hidden;
    padding: 96px 80px 64px;
    display: flex;
    flex-direction: column;
  }
  .hero::before {
    content: "";
    position: absolute; inset: 0;
    pointer-events: none;
    opacity: 0.15;
    mix-blend-mode: overlay;
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='200' height='200'><filter id='n'><feTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='2' stitchTiles='stitch'/><feColorMatrix values='0 0 0 0 0.85  0 0 0 0 0.65  0 0 0 0 0.3  0 0 0 0.18 0'/></filter><rect width='100%' height='100%' filter='url(%23n)'/></svg>");
  }
  .giant-letter {
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    font-family: "Cormorant Garamond", serif;
    font-weight: 700;
    font-style: italic;
    font-size: 50vw;
    line-height: 0.85;
    color: var(--gold);
    opacity: 0.06;
    pointer-events: none;
    user-select: none;
    z-index: 1;
  }
  .mandala-overlay {
    position: absolute;
    top: -10%; right: -15%;
    width: 800px; height: 800px;
    pointer-events: none;
    opacity: 0.06;
    z-index: 1;
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 600 600'><g fill='none' stroke='%23F5EDD8' stroke-width='0.8'><circle cx='300' cy='300' r='280'/><circle cx='300' cy='300' r='220'/><circle cx='300' cy='300' r='160'/><circle cx='300' cy='300' r='100'/><g transform='translate(300 300)'><g id='p'><path d='M0 -280 Q 60 -200 0 -160 Q -60 -200 0 -280Z'/></g><use href='%23p' transform='rotate(30)'/><use href='%23p' transform='rotate(60)'/><use href='%23p' transform='rotate(90)'/><use href='%23p' transform='rotate(120)'/><use href='%23p' transform='rotate(150)'/><use href='%23p' transform='rotate(180)'/><use href='%23p' transform='rotate(210)'/><use href='%23p' transform='rotate(240)'/><use href='%23p' transform='rotate(270)'/><use href='%23p' transform='rotate(300)'/><use href='%23p' transform='rotate(330)'/></g></g></svg>");
    background-size: contain;
    background-repeat: no-repeat;
  }
  .breadcrumb {
    position: relative;
    z-index: 3;
    display: flex;
    gap: 8px;
    align-items: center;
    opacity: 0;
    animation: fadeUp 0.9s ease forwards;
    animation-delay: 100ms;
  }
  .crumb {
    font-family: "DM Sans", sans-serif;
    font-size: 0.65rem;
    letter-spacing: 0.22em;
    color: var(--gold);
    text-transform: uppercase;
    text-decoration: none;
    position: relative;
    padding-bottom: 2px;
  }
  .crumb::after {
    content: "";
    position: absolute;
    left: 0; bottom: 0;
    width: 0; height: 1px;
    background: var(--gold);
    transition: width 0.35s ease;
  }
  .crumb:hover::after { width: 100%; }
  .crumb-sep {
    color: rgba(201, 144, 26, 0.5);
    font-family: "Cormorant Garamond", serif;
    font-style: italic;
  }

  .hero-bottom {
    position: relative;
    z-index: 3;
    margin-top: auto;
    max-width: 720px;
  }
  .hero-eyebrow {
    font-family: "DM Sans", sans-serif;
    font-size: 0.65rem;
    letter-spacing: 0.32em;
    color: rgba(245, 237, 216, 0.7);
    text-transform: uppercase;
    margin-bottom: 12px;
    opacity: 0;
    animation: fadeUp 0.9s ease forwards;
    animation-delay: 250ms;
  }
  .hero-eyebrow .star { color: var(--gold); margin: 0 8px; }
  h1.state-name {
    font-family: "Cormorant Garamond", serif;
    font-weight: 700;
    font-style: italic;
    font-size: clamp(4rem, 8vw, 7rem);
    line-height: 0.95;
    color: white;
    letter-spacing: -0.02em;
    opacity: 0;
    transform: translateY(28px);
    animation: fadeUp 1s cubic-bezier(0.2, 0.7, 0.2, 1) forwards;
    animation-delay: 380ms;
  }
  .gold-line {
    width: 80px; height: 2px;
    background: var(--gold);
    margin: 24px 0 24px;
    opacity: 0;
    animation: fadeIn 0.8s ease forwards;
    animation-delay: 600ms;
  }
  .hero-meta-line {
    font-family: "DM Sans", sans-serif;
    font-weight: 300;
    font-size: 0.95rem;
    color: rgba(245, 237, 216, 0.8);
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 18px;
    opacity: 0;
    animation: fadeUp 1s ease forwards;
    animation-delay: 720ms;
  }
  .hero-meta-line strong { color: var(--parchment); font-weight: 400; }
  .hero-meta-line .gdot { width: 4px; height: 4px; background: var(--gold); border-radius: 50%; }

  .hero-desc {
    font-family: "DM Sans", sans-serif;
    font-weight: 300;
    font-size: 1rem;
    line-height: 1.9;
    color: rgba(245, 237, 216, 0.78);
    max-width: 600px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: 24px;
    opacity: 0;
    animation: fadeUp 1s ease forwards;
    animation-delay: 840ms;
    position: relative;
  }
  .hero-desc::after {
    content: "";
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 28px;
    background: linear-gradient(to bottom, transparent, rgba(232,88,10,0.15));
    pointer-events: none;
  }

  .stat-pills {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    opacity: 0;
    animation: fadeUp 1s ease forwards;
    animation-delay: 960ms;
  }
  .stat-pill {
    font-family: "DM Sans", sans-serif;
    font-size: 0.7rem;
    letter-spacing: 0.18em;
    color: var(--gold);
    text-transform: uppercase;
    border: 1px solid var(--gold);
    padding: 9px 16px;
    background: rgba(13, 5, 0, 0.18);
    backdrop-filter: blur(4px);
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }
  .stat-pill .star { color: var(--gold); }

  /* ============ TAB BAR ============ */
  .tabs {
    position: sticky;
    top: 64px;
    background: white;
    border-bottom: 1px solid var(--hairline);
    z-index: 30;
    display: flex;
    align-items: center;
    height: 60px;
    padding: 0 80px;
    gap: 8px;
    box-shadow: 0 6px 24px rgba(13, 5, 0, 0.06);
    overflow-x: auto;
  }
  .tab {
    font-family: "Cormorant Garamond", serif;
    font-weight: 500;
    font-size: 1.05rem;
    color: var(--ink);
    background: transparent;
    border: none;
    padding: 18px 22px;
    cursor: pointer;
    position: relative;
    height: 100%;
    display: flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
    transition: color 0.3s ease;
  }
  .tab.active { color: var(--saffron); }
  .tab::after {
    content: "";
    position: absolute;
    left: 22px; right: 22px;
    bottom: 0;
    height: 3px;
    background: var(--saffron);
    transform: scaleX(0);
    transform-origin: center;
    transition: transform 0.4s cubic-bezier(0.2, 0.7, 0.2, 1);
  }
  .tab.active::after { transform: scaleX(1); }
  .tab .glyph { font-size: 1rem; }
  .tab-meta {
    margin-left: auto;
    font-family: "DM Sans", sans-serif;
    font-size: 0.65rem;
    letter-spacing: 0.22em;
    color: var(--faint);
    text-transform: uppercase;
  }

  /* ============ CONTENT WRAPS ============ */
  .show-content {
    max-width: 1440px;
    margin: 0 auto;
    padding: 64px 64px 0;
    background: var(--cream);
    color: var(--ink);
    --muted: rgba(13, 5, 0, 0.62);
    --faint: rgba(13, 5, 0, 0.40);
  }
  .tabs {
    --muted: rgba(13, 5, 0, 0.62);
    --faint: rgba(13, 5, 0, 0.40);
  }
  .panel { display: none; }
  .panel.active {
    display: block;
    animation: panelIn 0.5s cubic-bezier(0.2, 0.7, 0.2, 1);
  }
  @keyframes panelIn {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  /* ============ SECTION HEADER ============ */
  .section-head {
    margin-bottom: 40px;
  }
  .section-eye {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-family: "DM Sans", sans-serif;
    font-size: 0.65rem;
    letter-spacing: 0.28em;
    color: var(--gold);
    text-transform: uppercase;
    margin-bottom: 12px;
  }
  .section-eye .star { color: var(--gold); }
  .section-title {
    font-family: "Cormorant Garamond", serif;
    font-weight: 600;
    font-size: clamp(2rem, 4vw, 3rem);
    color: #1A0A00;
    line-height: 1.05;
    letter-spacing: -0.01em;
  }
  .section-title em { font-style: italic; color: var(--saffron); }
  .section-rule {
    margin-top: 16px;
    width: 100%;
    height: 1px;
    background: linear-gradient(to right, var(--gold) 0%, var(--gold) 80px, var(--hairline) 80px, var(--hairline) 100%);
  }

  /* ============ CULTURE GRID ============ */
  .culture-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 40px;
  }
  .culture-card {
    background: white;
    color: var(--ink);
    padding: 28px 24px 26px;
    border-bottom: 1px solid var(--hairline);
    position: relative;
    cursor: pointer;
    overflow: hidden;
    min-height: 220px;
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.5s ease, transform 0.5s ease, box-shadow 0.4s ease;
  }
  .panel.active .culture-card { opacity: 1; transform: translateY(0); }
  .culture-card::before {
    content: "";
    position: absolute;
    top: 0; left: 0;
    width: 50px; height: 4px;
    background: var(--saffron);
    transition: width 0.4s cubic-bezier(0.2, 0.7, 0.2, 1);
  }
  .culture-card:hover { box-shadow: 0 18px 44px rgba(13, 5, 0, 0.12); transform: translateY(-4px); }
  .culture-card:hover::before { width: 100%; }
  .culture-cat {
    font-family: "DM Sans", sans-serif;
    font-size: 0.6rem;
    letter-spacing: 0.22em;
    color: rgba(13, 5, 0, 0.45);
    text-transform: uppercase;
    font-weight: 500;
    margin-top: 8px;
    margin-bottom: 12px;
  }
  .culture-num {
    color: rgba(13, 5, 0, 0.3);
  }
  .culture-title {
    font-family: "Cormorant Garamond", serif;
    font-weight: 600;
    font-size: 1.25rem;
    color: #1A0A00;
    margin-bottom: 10px;
    letter-spacing: -0.005em;
    line-height: 1.15;
  }
  .culture-desc {
    font-family: "DM Sans", sans-serif;
    font-weight: 300;
    font-size: 0.85rem;
    line-height: 1.65;
    color: rgba(13, 5, 0, 0.62);
  }
  .culture-num {
    position: absolute;
    top: 16px; right: 18px;
    font-family: "Cormorant Garamond", serif;
    font-style: italic;
    font-size: 0.85rem;
    color: var(--faint);
  }

  /* ============ FOOD ============ */
  .food-filters {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 32px;
  }
  .food-filter {
    font-family: "DM Sans", sans-serif;
    font-size: 11px;
    font-weight: 500;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    padding: 8px 16px;
    background: transparent;
    border: 1px solid var(--gold);
    color: var(--gold);
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }
  .food-filter:hover { background: rgba(201, 144, 26, 0.1); }
  .food-filter.active { background: var(--saffron); border-color: var(--saffron); color: white; }
  .vd-veg { width: 8px; height: 8px; border-radius: 50%; background: #2a8551; }
  .vd-nv  { width: 8px; height: 8px; border-radius: 50%; background: var(--crimson); }

  .food-list { margin-bottom: 40px; }
  .food-row {
    display: grid;
    grid-template-columns: 160px 1fr;
    gap: 28px;
    background: white;
    padding: 20px;
    align-items: stretch;
    border-bottom: 1px solid rgba(201, 144, 26, 0.25);
    transition: box-shadow 0.4s ease;
    opacity: 0;
    transform: translateX(-20px);
  }
  .panel.active .food-row { animation: slideInL 0.6s cubic-bezier(0.2, 0.7, 0.2, 1) forwards; }
  @keyframes slideInL {
    to { opacity: 1; transform: translateX(0); }
  }
  .food-row:hover { box-shadow: 0 16px 36px rgba(13, 5, 0, 0.1); }
  .food-img {
    width: 100%;
    height: 140px;
    position: relative;
    overflow: hidden;
  }
  .food-img .glyph {
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -55%);
    font-family: "Cormorant Garamond", serif;
    font-weight: 700;
    font-style: italic;
    font-size: 6rem;
    line-height: 1;
    color: rgba(255, 255, 255, 0.22);
    pointer-events: none;
  }
  .food-img.g1 { background: linear-gradient(160deg, #E8580A 0%, #8B1A1A 100%); }
  .food-img.g2 { background: linear-gradient(160deg, #C9901A 0%, #6b3c08 100%); }
  .food-img.g3 { background: linear-gradient(160deg, #2a7a5e 0%, #0e3429 100%); }
  .food-content { display: flex; flex-direction: column; min-width: 0; padding-right: 12px; }
  .food-top { display: flex; align-items: flex-start; gap: 12px; margin-bottom: 6px; }
  .food-veg-row { display: flex; align-items: center; gap: 8px; flex: 1; min-width: 0; }
  .food-name {
    font-family: "Cormorant Garamond", serif;
    font-weight: 600;
    font-size: 1.35rem;
    color: var(--ink);
    line-height: 1.1;
    letter-spacing: -0.005em;
  }
  .meal-badge {
    font-family: "DM Sans", sans-serif;
    font-size: 0.6rem;
    font-weight: 500;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    padding: 5px 10px;
    color: white;
    align-self: flex-start;
  }
  .meal-breakfast { background: var(--gold); }
  .meal-lunch { background: var(--saffron); }
  .meal-dinner { background: var(--crimson); }
  .food-desc {
    font-family: "DM Sans", sans-serif;
    font-weight: 300;
    font-size: 0.88rem;
    line-height: 1.55;
    color: var(--muted);
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: 10px;
  }
  .food-accordions { display: flex; gap: 24px; margin-top: auto; flex-wrap: wrap; }
  .acc {
    border: none;
    background: none;
    font-family: "DM Sans", sans-serif;
    font-size: 0.72rem;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: var(--gold);
    cursor: pointer;
    padding: 4px 0;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: color 0.3s ease;
  }
  .acc .plus {
    width: 14px; height: 14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid var(--gold);
    font-family: "DM Sans", sans-serif;
    font-size: 12px;
    line-height: 1;
    transition: transform 0.4s ease, background 0.3s ease, color 0.3s ease;
  }
  .acc.open .plus { transform: rotate(45deg); background: var(--gold); color: white; }
  .acc:hover { color: var(--saffron); }
  .acc-body { max-height: 0; overflow: hidden; opacity: 0; transition: max-height 0.4s ease, opacity 0.4s ease, padding 0.3s ease; font-family: "DM Sans", sans-serif; font-size: 0.85rem; line-height: 1.65; color: var(--muted); }
  .acc-body.open { max-height: 280px; opacity: 1; padding: 16px 4px 4px; }
  .acc-body em { font-family: "Cormorant Garamond", serif; font-style: italic; color: var(--ink); }

  /* ============ TRADITIONS ============ */
  .traditions-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 24px;
    margin-bottom: 40px;
  }
  .trad-card {
    display: grid;
    grid-template-columns: 40% 60%;
    min-height: 320px;
    background: white;
    box-shadow: 0 4px 18px rgba(13, 5, 0, 0.06);
    overflow: hidden;
  }
  .trad-left {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 28px 20px;
    overflow: hidden;
  }
  .trad-left .pattern {
    position: absolute; inset: 0;
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='80' height='80'><g fill='none' stroke='white' stroke-width='0.4' opacity='0.6'><path d='M40 5 L 75 40 L 40 75 L 5 40 Z'/><circle cx='40' cy='40' r='28'/><circle cx='40' cy='40' r='14'/></g></svg>");
    background-size: 80px;
    opacity: 0.18;
    mix-blend-mode: overlay;
  }
  .trad-left::after {
    content: "";
    position: absolute; inset: 0;
    background: linear-gradient(180deg, transparent 50%, rgba(13, 5, 0, 0.35) 100%);
  }
  .trad-name-big {
    font-family: "Cormorant Garamond", serif;
    font-style: italic;
    font-weight: 700;
    font-size: clamp(2rem, 3.6vw, 3rem);
    color: white;
    line-height: 1;
    text-align: center;
    letter-spacing: -0.01em;
    z-index: 2;
    text-shadow: 0 2px 14px rgba(0, 0, 0, 0.3);
  }
  .grad-lohri { background: linear-gradient(160deg, #E8580A 0%, #8B1A1A 100%); }
  .grad-vaisakhi { background: linear-gradient(160deg, #C9901A 0%, #6b3c08 100%); }
  .trad-right {
    padding: 28px 28px;
    display: flex;
    flex-direction: column;
    gap: 12px;
  }
  .cat-badge {
    font-family: "DM Sans", sans-serif;
    font-size: 0.6rem;
    font-weight: 500;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    padding: 5px 10px;
    color: white;
    background: var(--crimson);
    align-self: flex-start;
  }
  .trad-name {
    font-family: "Cormorant Garamond", serif;
    font-weight: 600;
    font-size: 1.45rem;
    color: var(--ink);
    line-height: 1.1;
    letter-spacing: -0.005em;
  }
  .trad-desc {
    font-family: "DM Sans", sans-serif;
    font-weight: 300;
    font-size: 0.9rem;
    line-height: 1.65;
    color: var(--muted);
  }
  .significance {
    border-left: 3px solid var(--gold);
    padding: 4px 0 4px 14px;
    margin-top: auto;
  }
  .sig-label {
    font-family: "DM Sans", sans-serif;
    font-size: 0.6rem;
    letter-spacing: 0.22em;
    color: var(--gold);
    text-transform: uppercase;
    font-weight: 600;
    margin-bottom: 4px;
  }
  .sig-text {
    font-family: "Cormorant Garamond", serif;
    font-style: italic;
    font-size: 0.95rem;
    color: var(--ink);
    line-height: 1.5;
  }

  /* ============ HERITAGE STRIP ============ */
  .heritage-strip {
    background: var(--ink);
    color: var(--parchment);
    padding: 56px 80px;
    margin-top: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 32px;
    flex-wrap: wrap;
    position: relative;
    overflow: hidden;
  }
  .heritage-strip::before {
    content: "";
    position: absolute;
    right: -120px; top: 50%;
    transform: translateY(-50%);
    width: 400px; height: 400px;
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 600 600'><g fill='none' stroke='%23C9901A' stroke-width='0.5'><circle cx='300' cy='300' r='280'/><circle cx='300' cy='300' r='220'/><circle cx='300' cy='300' r='160'/><circle cx='300' cy='300' r='100'/></g></svg>");
    background-size: contain;
    opacity: 0.1;
    pointer-events: none;
  }
  .heritage-left { position: relative; z-index: 1; }
  .heritage-eye {
    font-family: "DM Sans", sans-serif;
    font-size: 0.62rem;
    letter-spacing: 0.28em;
    color: rgba(245,237,216,0.55);
    text-transform: uppercase;
    margin-bottom: 8px;
  }
  .heritage-h {
    font-family: "Cormorant Garamond", serif;
    font-weight: 600;
    font-size: clamp(1.6rem, 3vw, 2.4rem);
    color: var(--gold);
    line-height: 1.1;
  }
  .heritage-h em { font-style: italic; color: var(--parchment); }

  .btn {
    font-family: "DM Sans", sans-serif;
    font-weight: 500;
    font-size: 13px;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    padding: 14px 28px;
    border: none;
    cursor: pointer;
    border-radius: 0;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: background 0.35s ease, color 0.35s ease;
    z-index: 1;
    position: relative;
  }
  .btn .arrow { display: inline-block; transition: transform 0.35s ease; }
  .btn:hover .arrow { transform: translateX(4px); }
  .btn-secondary { background: transparent; color: var(--gold); border: 1.5px solid var(--gold); }
  .btn-secondary:hover { background: var(--gold); color: var(--ink); }
  .btn-primary { background: var(--saffron); color: white; }
  .btn-primary:hover { background: var(--gold); }

  /* ============ FESTIVAL STRIP ============ */
  .festival-strip {
    background: var(--parchment);
    color: var(--ink);
    padding: 64px 80px 80px;
    position: relative;
    --muted: rgba(13, 5, 0, 0.62);
    --faint: rgba(13, 5, 0, 0.40);
  }
  .fest-head {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 24px;
    margin-bottom: 32px;
    flex-wrap: wrap;
  }
  .fest-h {
    font-family: "Cormorant Garamond", serif;
    font-weight: 600;
    font-size: clamp(1.6rem, 3vw, 2.4rem);
    color: var(--ink);
    line-height: 1.1;
  }
  .fest-h em { font-style: italic; color: var(--saffron); }
  .fest-meta {
    font-family: "DM Sans", sans-serif;
    font-size: 0.7rem;
    letter-spacing: 0.22em;
    color: var(--faint);
    text-transform: uppercase;
  }
  .fest-scroll {
    display: flex;
    gap: 18px;
    overflow-x: auto;
    padding-bottom: 16px;
    scroll-snap-type: x mandatory;
  }
  .fest-scroll::-webkit-scrollbar { height: 6px; }
  .fest-scroll::-webkit-scrollbar-track { background: rgba(13,5,0,0.06); }
  .fest-scroll::-webkit-scrollbar-thumb { background: var(--gold); }

  .fest-card {
    flex: 0 0 280px;
    background: white;
    padding: 24px 22px;
    border-left: 4px solid var(--gold);
    scroll-snap-align: start;
    display: flex;
    flex-direction: column;
    gap: 8px;
    transition: transform 0.4s ease, box-shadow 0.4s ease;
    cursor: pointer;
  }
  .fest-card:hover { transform: translateY(-4px); box-shadow: 0 18px 40px rgba(13,5,0,0.1); }
  .fest-card.b-sikh { border-left-color: #d97706; }
  .fest-card.b-hindu { border-left-color: var(--crimson); }
  .fest-card.b-folk { border-left-color: var(--jade); }
  .fest-card.b-islam { border-left-color: #1F5C4D; }

  .fest-eye {
    font-family: "DM Sans", sans-serif;
    font-size: 0.6rem;
    letter-spacing: 0.22em;
    color: var(--gold);
    text-transform: uppercase;
    font-weight: 600;
  }
  .fest-name {
    font-family: "Cormorant Garamond", serif;
    font-weight: 600;
    font-size: 1.4rem;
    color: var(--ink);
    line-height: 1.05;
    letter-spacing: -0.005em;
  }
  .fest-tag {
    font-family: "Cormorant Garamond", serif;
    font-style: italic;
    font-size: 0.95rem;
    color: var(--muted);
    line-height: 1.5;
  }
  .fest-link {
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
  .fest-link .arrow { transition: transform 0.3s ease; }
  .fest-card:hover .fest-link .arrow { transform: translateX(4px); }

  

  /* ============ ANIMATIONS ============ */
  @keyframes fadeUp { from { opacity: 0; transform: translateY(28px); } to { opacity: 1; transform: translateY(0); } }
  @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

  /* reveal */
  .reveal { opacity: 0; transform: translateY(24px); transition: opacity 0.9s ease, transform 0.9s cubic-bezier(0.2,0.7,0.2,1); }
  .reveal.in { opacity: 1; transform: translateY(0); }

  /* ============ RESPONSIVE ============ */
  @media (max-width: 1100px) {
    .culture-grid { grid-template-columns: repeat(2, 1fr); }
    .traditions-grid { grid-template-columns: 1fr; }
    .hero, .tabs, main, .heritage-strip, .festival-strip { padding-left: 40px; padding-right: 40px; }
  }
  @media (max-width: 720px) {
    .nav { padding: 0 20px; gap: 16px; }
    .nav-links { display: none; }
    .hero, .tabs, main, .heritage-strip, .festival-strip { padding-left: 24px; padding-right: 24px; }
    .culture-grid { grid-template-columns: 1fr; }
    .food-row { grid-template-columns: 1fr; }
    .food-img { height: 180px; }
    .trad-card { grid-template-columns: 1fr; }
    .trad-left { min-height: 180px; }
    footer { flex-direction: column; gap: 12px; padding: 24px; text-align: center; }
  }

</style>
@endsection

@section('content')
@php
$landscapeImages = [
    'kerala'      => '/images/states/Kerala Landscape.jpg',
    'punjab'      => '/images/states/Punjab Landscape.jpg',
    'rajasthan'   => '/images/states/Rajasthan Landscape.jpg',
    'tamil-nadu'  => '/images/states/Tamil Nadu landscape.jpg',
    'west-bengal' => '/images/states/West Bengal Landscape.jpg',
];
$heroImg = $landscapeImages[$state->slug] ?? null;
@endphp
<!-- HERO -->
<section class="hero{{ $heroImg ? ' has-photo' : '' }}" data-screen-label="01 State Hero"@if($heroImg) style="background-image: linear-gradient(to top, rgba(13,5,0,0.88) 0%, rgba(13,5,0,0.5) 40%, rgba(13,5,0,0.12) 100%), url('{{ $heroImg }}'); background-size: cover; background-position: center 40%;"@endif>
  @if(!$heroImg)<div class="giant-letter">{{ substr($state->name, 0, 1) }}</div>@endif
  @if(!$heroImg)<div class="mandala-overlay"></div>@endif

  <div class="breadcrumb">
    <a class="crumb" href="{{ route('states.index') }}">All States</a>
    <span class="crumb-sep">/</span>
    <a class="crumb">{{ $state->region }} India</a>
    <span class="crumb-sep">/</span>
    <span class="crumb" style="color: rgba(245,237,216,0.7);">{{ $state->name }}</span>
  </div>

  <div class="hero-bottom">
    <div class="hero-eyebrow"><span class="star">✦</span>{{ $state->tagline ?? ($state->region . ' India') }}<span class="star">✦</span></div>
    <h1 class="state-name">{{ $state->name }}</h1>
    <div class="gold-line"></div>
    <div class="hero-meta-line">
      <span><strong>Capital:</strong> {{ $state->capital }}</span>
      <span class="gdot"></span>
      <span><strong>Language:</strong> {{ $state->language }}</span>
      <span class="gdot"></span>
      <span><strong>Region:</strong> {{ $state->region }} India</span>
    </div>
    <p class="hero-desc">{{ $state->description }}</p>
    
    <div class="stat-pills">
      @if($state->established_date)<span class="stat-pill"><span class="star">✦</span>Est. {{ \Carbon\Carbon::parse($state->established_date)->format('Y') }}</span>@endif
      @if($state->population)<span class="stat-pill"><span class="star">✦</span>{{ number_format($state->population/1000000, 1) }}M People</span>@endif
      @if($state->area_sq_km)<span class="stat-pill"><span class="star">✦</span>{{ number_format($state->area_sq_km) }} km²</span>@endif
    </div>

  </div>
</section>

<div class="show-content">
<!-- TABS -->
<div class="tabs" data-screen-label="02 Tabs">
  <button class="tab active" data-tab="culture"><span class="glyph">🏛</span><span>Culture</span></button>
  <button class="tab" data-tab="food"><span class="glyph">🍛</span><span>Food</span></button>
  <button class="tab" data-tab="traditions"><span class="glyph">🎭</span><span>Traditions</span></button>
  <span class="tab-meta">{{ $state->name }} · Chapter I</span>
</div>

<main>

  <!-- CULTURE PANEL -->
  <section class="panel active" data-panel="culture" data-screen-label="03 Culture">
    <header class="section-head reveal">
      <div class="section-eye"><span class="star">✦</span><span>Culture &amp; Arts</span><span class="star">✦</span></div>
      <h2 class="section-title">The Soul of <em>{{ $state->name }}</em></h2>
      <div class="section-rule"></div>
    </header>

    
    <div class="culture-grid">
      @if($state->culture)
        @php
          $cultureItems = [
            ['Classical Dance', $state->culture->classical_dance],
            ['Music Forms', $state->culture->music_forms],
            ['Male Dress', $state->culture->traditional_dress_male],
            ['Female Dress', $state->culture->traditional_dress_female],
            ['Art Forms', $state->culture->art_forms],
            ['Handicrafts', $state->culture->handicrafts],
            ['Language', $state->culture->language_script],
            ['Figures', $state->culture->notable_personalities]
          ];
          $index = 1;
        @endphp
        @foreach($cultureItems as $item)
          @if($item[1])
            @php
              preg_match('/^([^(\-—]+)/', $item[1], $titleMatch);
              $cardTitle = trim($titleMatch[1] ?? $item[1]);
              if (strlen($cardTitle) > 35) $cardTitle = Str::limit($cardTitle, 35);
            @endphp
            <article class="culture-card">
              <span class="culture-num">{{ sprintf('%02d', $index++) }}</span>
              <div class="culture-cat">{{ $item[0] }}</div>
              <h3 class="culture-title">{{ $cardTitle }}</h3>
              <p class="culture-desc">{{ $item[1] }}</p>
            </article>
          @endif
        @endforeach
      @endif
    </div>
  </section>


  <!-- FOOD PANEL -->
  <section class="panel" data-panel="food" data-screen-label="04 Food">
    <header class="section-head reveal">
      <div class="section-eye"><span class="star">✦</span><span>Cuisine of Punjab</span><span class="star">✦</span></div>
      <h2 class="section-title">A Table for <em>Everyone</em></h2>
      <div class="section-rule"></div>
    </header>

    <div class="food-filters">
      <button class="food-filter active" data-fil="all">All</button>
      <button class="food-filter" data-fil="veg"><span class="vd-veg"></span>Veg</button>
      <button class="food-filter" data-fil="nv"><span class="vd-nv"></span>Non-Veg</button>
      <button class="food-filter" data-fil="breakfast">Breakfast</button>
      <button class="food-filter" data-fil="lunch">Lunch</button>
      <button class="food-filter" data-fil="dinner">Dinner</button>
      <button class="food-filter" data-fil="snack">Snack</button>
    </div>

    
    <div class="food-list">
      @foreach($foods as $i => $food)
      @php
         $vt = $food->is_vegetarian ? 'veg' : 'nv';
         $mealClass = 'meal-' . strtolower($food->meal_type);
         $grad = 'g' . (($i % 3) + 1);
      @endphp
      <article class="food-row" data-meal="{{ strtolower($food->meal_type) }}" data-vt="{{ $vt }}" style="animation-delay: {{ $i * 100 }}ms;">
        <div class="food-img {{ $grad }}">
           @if($food->image)
             <x-state-image :item="$food" collection="gallery" class="absolute inset-0 w-full h-full object-cover mix-blend-overlay opacity-60" />
           @else
             <span class="glyph">{{ substr($food->name, 0, 1) }}</span>
           @endif
        </div>
        <div class="food-content">
          <div class="food-top">
            <div class="food-veg-row">
              <span class="{{ $food->is_vegetarian ? 'vd-veg' : 'vd-nv' }}"></span>
              <h3 class="food-name">{{ $food->name }}</h3>
            </div>
            <span class="meal-badge {{ $mealClass }}">{{ $food->meal_type }}</span>
          </div>
          <p class="food-desc">{{ $food->description }}</p>
          <div class="food-accordions">
            @if($food->ingredients)<button class="acc" data-acc="ing-{{ $food->id }}"><span class="plus">+</span>Ingredients</button>@endif
            @if($food->origin_story)<button class="acc" data-acc="ori-{{ $food->id }}"><span class="plus">+</span>Origin Story</button>@endif
          </div>
          @if($food->ingredients)<div class="acc-body" data-body="ing-{{ $food->id }}">{{ $food->ingredients }}</div>@endif
          @if($food->origin_story)<div class="acc-body" data-body="ori-{{ $food->id }}">{{ $food->origin_story }}</div>@endif
        </div>
      </article>
      @endforeach
    </div>
  </section>


  <!-- TRADITIONS PANEL -->
  <section class="panel" data-panel="traditions" data-screen-label="05 Traditions">
    <header class="section-head reveal">
      <div class="section-eye"><span class="star">✦</span><span>Traditions &amp; Rites</span><span class="star">✦</span></div>
      <h2 class="section-title">Rhythms of the <em>Year</em></h2>
      <div class="section-rule"></div>
    </header>

    
    <div class="traditions-grid">
      @foreach($state->traditions as $trad)
      @php
         $gradClass = $loop->iteration % 2 == 0 ? 'grad-vaisakhi' : 'grad-lohri';
      @endphp
      <article class="trad-card">
        <div class="trad-left {{ $gradClass }}">
          <div class="pattern"></div>
          <h3 class="trad-name-big">{{ $trad->name }}</h3>
        </div>
        <div class="trad-right">
          <span class="cat-badge">{{ $trad->category }}</span>
          <h3 class="trad-name">{{ $trad->name }}</h3>
          <p class="trad-desc">{{ $trad->description }}</p>
          @if($trad->significance)
          <div class="significance">
            <div class="sig-label">Significance</div>
            <div class="sig-text">{{ $trad->significance }}</div>
          </div>
          @endif
        </div>
      </article>
      @endforeach
    </div>
  </section>


</main>

<!-- HERITAGE STRIP -->

@if(!empty($monumentCount) && $monumentCount > 0)
<section class="heritage-strip reveal" data-screen-label="06 Heritage Strip">
  <div class="heritage-left">
    <div class="heritage-eye">Heritage in {{ $state->name }}</div>
    <h3 class="heritage-h"><em>{{ $monumentCount }} Heritage Sites</em> in {{ $state->name }}</h3>
  </div>
  <button class="btn btn-secondary" onclick="window.location='{{ route('monuments.by-state', $state->slug) }}'">
    <span>Explore Heritage Sites</span>
    <span class="arrow">→</span>
  </button>
</section>
@endif


<!-- FESTIVAL STRIP -->

@if(isset($stateFestivals) && $stateFestivals->isNotEmpty())
<section class="festival-strip reveal" data-screen-label="07 Festivals">
  <header class="fest-head">
    <h3 class="fest-h">Festivals of <em>{{ $state->name }}</em></h3>
    <span class="fest-meta">{{ $stateFestivals->count() }} festivals celebrated</span>
  </header>
  <div class="fest-scroll">
    @foreach($stateFestivals as $sf)
    @php
       $bClass = 'b-folk';
       if ($sf->religion == 'Hindu') $bClass = 'b-hindu';
       if ($sf->religion == 'Sikh') $bClass = 'b-sikh';
       if ($sf->religion == 'Muslim') $bClass = 'b-islam';
    @endphp
    <article class="fest-card {{ $bClass }}" onclick="window.location='{{ route('festivals.show', $sf->slug) }}'">
      <span class="fest-eye">{{ $sf->religion }} · {{ date('F', mktime(0, 0, 0, $sf->month, 1)) }}</span>
      <h4 class="fest-name">{{ $sf->name }}</h4>
      <p class="fest-tag">{{ $sf->tagline }}</p>
      <a href="{{ route('festivals.show', $sf->slug) }}" class="fest-link">View Festival <span class="arrow">→</span></a>
    </article>
    @endforeach
  </div>
</section>
@endif
</div>

@endsection

@section('scripts')
<script>

  // TABS
  const tabs = document.querySelectorAll('.tab');
  const panels = document.querySelectorAll('.panel');
  tabs.forEach(t => {
    t.addEventListener('click', () => {
      const target = t.getAttribute('data-tab');
      tabs.forEach(x => x.classList.remove('active'));
      t.classList.add('active');
      panels.forEach(p => {
        if (p.getAttribute('data-panel') === target) {
          p.classList.add('active');
        } else {
          p.classList.remove('active');
        }
      });
      // re-trigger reveal scan
      requestAnimationFrame(scanReveals);
    });
  });

  // CULTURE STAGGER (re-applied on panel switch)
  function staggerCulture() {
    document.querySelectorAll('.panel.active .culture-card').forEach((c, i) => {
      c.style.transitionDelay = `${i * 50}ms`;
    });
  }
  staggerCulture();
  document.querySelectorAll('.tab').forEach(t => t.addEventListener('click', () => setTimeout(staggerCulture, 30)));

  // FOOD FILTERS
  const foodFilters = document.querySelectorAll('.food-filter');
  const foodRows = document.querySelectorAll('.food-row');
  foodFilters.forEach(f => {
    f.addEventListener('click', () => {
      foodFilters.forEach(x => x.classList.remove('active'));
      f.classList.add('active');
      const fil = f.getAttribute('data-fil');
      foodRows.forEach(row => {
        const meal = row.getAttribute('data-meal');
        const vt = row.getAttribute('data-vt');
        let show = false;
        if (fil === 'all') show = true;
        else if (fil === 'veg' || fil === 'nv') show = vt === fil;
        else show = meal === fil;
        row.style.display = show ? '' : 'none';
      });
    });
  });

  // FOOD ACCORDIONS
  document.querySelectorAll('.acc').forEach(a => {
    a.addEventListener('click', () => {
      const id = a.getAttribute('data-acc');
      const body = document.querySelector(`.acc-body[data-body="${id}"]`);
      const isOpen = a.classList.toggle('open');
      if (body) body.classList.toggle('open', isOpen);
    });
  });

  // REVEAL ON SCROLL
  function scanReveals() {
    const els = document.querySelectorAll('.reveal:not(.in)');
    els.forEach(el => {
      const r = el.getBoundingClientRect();
      if (r.top < window.innerHeight - 60) el.classList.add('in');
    });
  }
  scanReveals();
  window.addEventListener('scroll', scanReveals, { passive: true });
  window.addEventListener('resize', scanReveals);

</script>
@endsection
