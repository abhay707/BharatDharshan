@extends('layouts.app')
@section('title', '404 — Page Not Found')
@section('content')
<section style="min-height: 80vh; display: flex; align-items: center; justify-content: center; background: var(--ink); text-align: center; padding: 80px 40px;">
  <div>
    <div style="font-family:'Cormorant Garamond',serif; font-weight:700; font-style:italic; font-size:clamp(8rem,18vw,16rem); line-height:0.85; color:var(--gold); opacity:0.22; pointer-events:none; user-select:none;">404</div>
    <h1 style="font-family:'Cormorant Garamond',serif; font-weight:600; font-style:italic; font-size:clamp(2rem,4vw,3rem); color:var(--parchment); margin-top:-20px; margin-bottom:20px;">Page Not Found</h1>
    <p style="font-family:'DM Sans',sans-serif; font-weight:300; font-size:1.05rem; color:rgba(245,237,216,0.55); max-width:440px; margin:0 auto 40px; line-height:1.8;">The page you're looking for has wandered off the map of India.</p>
    <div style="display:flex; gap:14px; justify-content:center; flex-wrap:wrap;">
      <a href="{{ route('home') }}" class="btn btn-secondary" style="display:inline-flex;">
        ← Return Home
      </a>
      <a href="{{ route('states.index') }}" class="btn btn-primary" style="display:inline-flex;">
        Explore States <span class="arrow">→</span>
      </a>
    </div>
  </div>
</section>
@endsection
