<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Bharatdarshan — Discover Incredible India')</title>
  <meta name="description" content="@yield('meta_description', 'Explore India\'s 28 states — immerse yourself in ancient cultures, vibrant traditions, and legendary cuisine.')">

  {{-- Open Graph --}}
  <meta property="og:title" content="@yield('title', 'Bharatdarshan — Discover Incredible India')">
  <meta property="og:description" content="@yield('meta_description', 'Explore India\'s 28 states — immerse yourself in ancient cultures, vibrant traditions, and legendary cuisine.')">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="Bharatdarshan">

  {{-- Google Fonts: Cormorant Garamond + DM Sans + Cormorant SC --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&family=DM+Sans:wght@300;400;500&family=Cormorant+SC:wght@500;600&display=swap" rel="stylesheet">

  {{-- Alpine.js --}}
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <style>
    /* ── CSS CUSTOM PROPERTIES ── */
    :root {
      --ink:       #0D0500;
      --ink-soft:  #1A0D00;
      --saffron:   #E8580A;
      --gold:      #C9901A;
      --crimson:   #8B1A1A;
      --lapis:     #1B4F8A;
      --forest:    #2D6A4F;
      --parchment: #F5EDD8;
      --cream:     #FEFAF5;
      --muted:     rgba(245, 237, 216, 0.72);
      --faint:     rgba(13, 5, 0, 0.42);
      --hairline:  rgba(13, 5, 0, 0.1);
      --gold-line: rgba(201, 144, 26, 0.22);

      /* Legacy aliases for older views */
      --red:   #C0392B;
      --green: #16A34A;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }

    body {
      font-family: "DM Sans", sans-serif;
      background: var(--ink);
      color: var(--parchment);
      overflow-x: hidden;
      -webkit-font-smoothing: antialiased;
    }

    a { text-decoration: none; color: inherit; }
    img { max-width: 100%; display: block; }

    /* ── TYPOGRAPHY ── */
    .font-display { font-family: "Cormorant Garamond", serif; }
    .font-sc      { font-family: "Cormorant SC", serif; }
    .f-display    { font-family: "Cormorant Garamond", serif; }

    .text-hero    { font-family: "Cormorant Garamond", serif; font-weight: 700; font-size: clamp(3.5rem, 7vw, 6.5rem); line-height: 0.92; letter-spacing: -0.02em; }
    .text-display { font-family: "Cormorant Garamond", serif; font-weight: 600; font-size: clamp(2rem, 4vw, 3rem); line-height: 1.05; letter-spacing: -0.01em; }
    .text-title   { font-family: "Cormorant Garamond", serif; font-weight: 600; font-size: clamp(1.4rem, 2.5vw, 1.8rem); line-height: 1.2; }
    .text-label   { font-family: "DM Sans", sans-serif; font-size: 0.65rem; letter-spacing: 0.22em; text-transform: uppercase; font-weight: 500; }
    .section-label { font-family: "DM Sans", sans-serif; font-size: 0.65rem; letter-spacing: 0.28em; color: var(--gold); text-transform: uppercase; }

    /* ── BUTTONS ── */
    .btn { font-family: "DM Sans", sans-serif; font-weight: 500; font-size: 13px; letter-spacing: 0.1em; text-transform: uppercase; padding: 14px 32px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 10px; transition: background 0.35s ease, color 0.35s ease, border-color 0.35s ease; }
    .btn .arrow { display: inline-block; transition: transform 0.35s ease; }
    .btn:hover .arrow { transform: translateX(4px); }
    .btn-primary   { background: var(--saffron); color: white; }
    .btn-primary:hover { background: var(--gold); }
    .btn-secondary { background: transparent; color: var(--gold); border: 1.5px solid var(--gold); }
    .btn-secondary:hover { background: var(--gold); color: var(--ink); }

    /* ── SECTION COMPONENTS ── */
    .section-eye   { display: inline-flex; align-items: center; gap: 10px; font-family: "DM Sans", sans-serif; font-size: 0.65rem; letter-spacing: 0.28em; color: var(--gold); text-transform: uppercase; margin-bottom: 12px; }
    .section-title { font-family: "Cormorant Garamond", serif; font-weight: 600; font-size: clamp(1.8rem, 3.4vw, 2.4rem); color: var(--ink); line-height: 1.05; letter-spacing: -0.01em; }
    .section-title em { font-style: italic; color: var(--saffron); }
    .section-rule  { margin-top: 16px; width: 100%; height: 1px; background: linear-gradient(to right, var(--gold) 0%, var(--gold) 80px, var(--hairline) 80px, var(--hairline) 100%); margin-bottom: 36px; }

    /* Legacy saffron-rule for older views */
    .saffron-rule { height: 3px; border-radius: 9999px; background: linear-gradient(90deg, var(--saffron), var(--gold), transparent); }

    /* ── BADGES / CATEGORY COLORS ── */
    .cat-unesco    { background: var(--lapis); }
    .cat-asi       { background: var(--forest); }
    .cat-religious { background: var(--saffron); }
    .cat-natural   { background: var(--forest); }
    .cat-state     { background: var(--gold); }
    .cat-badge     { font-family: "DM Sans", sans-serif; font-size: 0.6rem; font-weight: 600; letter-spacing: 0.22em; text-transform: uppercase; padding: 5px 10px; color: white; }

    /* ── SCROLL REVEAL ── */
    .reveal { opacity: 0; transform: translateY(28px); transition: opacity 0.8s ease, transform 0.8s cubic-bezier(0.2, 0.7, 0.2, 1); }
    .reveal.revealed { opacity: 1; transform: translateY(0); }

    /* ── GLOBAL KEYFRAMES ── */
    @keyframes fadeUp    { from { opacity: 0; transform: translateY(28px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeIn    { from { opacity: 0; } to { opacity: 1; } }
    @keyframes bounce    { 0%, 100% { transform: rotate(45deg) translateY(0); } 50% { transform: rotate(45deg) translateY(4px); } }
    @keyframes shimmer   { 0% { background-position: -200% center; } 100% { background-position: 200% center; } }
    @keyframes floatStack { from { transform: translateY(0); } to { transform: translateY(-12px); } }
    @keyframes ticker    { from { transform: translateX(0); } to { transform: translateX(-50%); } }
    @keyframes rotate    { to { transform: translateY(-50%) rotate(360deg); } }
    @keyframes float     { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-6px); } }
    @keyframes slideUp   { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes rotateSlow { from { transform: translateY(-50%) rotate(0deg); } to { transform: translateY(-50%) rotate(360deg); } }

    /* ── PAGE BACKGROUND THEMES ── */
    body.page-light { background: #FAF6EE; }
    body.page-dark  { background: var(--ink); }

    /* ── NAV ── */
    #site-nav {
      position: fixed; top: 0; left: 0; right: 0; z-index: 100;
      height: 64px; display: flex; align-items: center; justify-content: space-between;
      padding: 0 40px;
      transition: background 0.4s ease, box-shadow 0.4s ease;
      background: rgba(13,5,0,0.92);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border-bottom: 1px solid rgba(201,144,26,0.15);
    }
    #site-nav.scrolled {
      background: rgba(13,5,0,0.98);
      box-shadow: 0 2px 24px rgba(0,0,0,0.5);
      border-bottom-color: rgba(201,144,26,0.25);
    }
    #site-nav a:hover { opacity: 1 !important; }

    .nav-links { display: flex; align-items: center; gap: 2px; }

    @media (max-width: 768px) {
      .nav-links { display: none !important; }
      .hamburger { display: flex !important; flex-direction: column; gap: 5px; background: none; border: none; cursor: pointer; padding: 4px; }
      .hamburger span { display: block; width: 22px; height: 1.5px; background: var(--parchment); }
      #site-nav { padding: 0 24px; }
    }

    /* ── FOOTER ── */
    @media (max-width: 900px) {
      .foot-grid-inner { grid-template-columns: 1fr 1fr !important; }
    }
    @media (max-width: 540px) {
      .foot-grid-inner { grid-template-columns: 1fr !important; }
      .foot-outer { padding: 48px 24px 0 !important; }
    }

    /* ── [x-cloak] ── */
    [x-cloak] { display: none !important; }
  </style>

  @yield('styles')
  @stack('styles')
</head>

<body class="min-h-screen @yield('body_class', '')" @yield('body_attrs', '')>

{{-- ══════════════ NAV ══════════════ --}}
<nav id="site-nav" x-data="{ open: false }">

  {{-- Brand --}}
  <a href="{{ route('home') }}" style="display:flex; align-items:baseline; gap:2px; text-decoration:none;">
    <span style="font-family:'Cormorant SC',serif; font-weight:600; font-size:1.15rem; color:var(--parchment); letter-spacing:0.08em;">BHARAT</span>
    <span style="font-family:'Cormorant SC',serif; font-weight:500; font-size:0.7rem; color:var(--gold); letter-spacing:0.18em; text-transform:uppercase;">·darshan</span>
  </a>

  {{-- Desktop links --}}
  @php
    $navLinks = [
      ['label'=>'Home',      'route'=>'home',           'pattern'=>'home'],
      ['label'=>'States',    'route'=>'states.index',   'pattern'=>'states.*'],
      ['label'=>'Heritage',  'route'=>'monuments.index','pattern'=>'monuments.*'],
      ['label'=>'Festivals', 'route'=>'festivals.index','pattern'=>'festivals.*'],
      ['label'=>'Cuisine',   'route'=>'cuisine.index',  'pattern'=>'cuisine.*'],
    ];
  @endphp
  <div class="nav-links">
    @foreach($navLinks as $nl)
      <a href="{{ route($nl['route']) }}"
         style="font-family:'DM Sans',sans-serif; font-size:0.65rem; letter-spacing:0.22em; text-transform:uppercase; color:var(--parchment); padding:8px 14px; position:relative; text-decoration:none; opacity:{{ request()->routeIs($nl['pattern']) ? '1' : '0.85' }}; transition:opacity 0.3s ease;">
        {{ $nl['label'] }}
        @if(request()->routeIs($nl['pattern']))
          <span style="position:absolute; bottom:0; left:14px; right:14px; height:1px; background:var(--gold);"></span>
        @endif
      </a>
    @endforeach
    <a href="{{ route('filament.admin.auth.login') }}"
       style="font-family:'DM Sans',sans-serif; font-size:0.65rem; letter-spacing:0.22em; text-transform:uppercase; color:var(--gold); padding:8px 16px; border:1px solid rgba(201,144,26,0.45); margin-left:8px; transition:background 0.3s ease, border-color 0.3s ease;">
      Admin ↗
    </a>
  </div>

  {{-- Mobile hamburger --}}
  <button @click="open = !open" style="display:none;" class="hamburger" aria-label="Menu">
    <span></span><span></span><span></span>
  </button>

  {{-- Mobile menu --}}
  <div x-show="open" x-cloak style="position:absolute; top:64px; left:0; right:0; background:var(--ink); padding:24px 40px; display:flex; flex-direction:column; gap:4px;">
    @foreach($navLinks as $nl)
      <a href="{{ route($nl['route']) }}" @click="open=false"
         style="font-family:'DM Sans',sans-serif; font-size:0.7rem; letter-spacing:0.22em; text-transform:uppercase; color:{{ request()->routeIs($nl['pattern']) ? 'var(--gold)' : 'var(--parchment)' }}; padding:12px 0; border-bottom:1px solid rgba(245,237,216,0.08);">
        {{ $nl['label'] }}
      </a>
    @endforeach
  </div>
</nav>

{{-- ══════════════ PAGE CONTENT ══════════════ --}}
<main style="padding-top: 0;">
  @yield('content')
</main>

{{-- ══════════════ FOOTER ══════════════ --}}
<footer class="foot-outer" style="background: var(--ink); padding: 80px 80px 40px; border-top: 1px solid rgba(201,144,26,0.18);">
  <div style="max-width: 1280px; margin: 0 auto;">
    <div class="foot-grid-inner" style="display: grid; grid-template-columns: 1.5fr 1fr 1fr 1fr; gap: 48px; margin-bottom: 56px;">

      {{-- Brand column --}}
      <div>
        <div style="margin-bottom: 20px;">
          <span style="font-family:'Cormorant SC',serif; font-weight:600; font-size:1.3rem; color:var(--parchment); letter-spacing:0.08em;">BHARAT</span>
          <span style="font-family:'Cormorant SC',serif; font-weight:500; font-size:0.75rem; color:var(--gold); letter-spacing:0.18em;">·darshan</span>
        </div>
        <p style="font-family:'DM Sans',sans-serif; font-weight:300; font-size:0.9rem; line-height:1.8; color:rgba(245,237,216,0.55); max-width:260px;">
          A living archive of India's cultural heritage — states, monuments, festivals, and flavours.
        </p>
        <div style="width:40px; height:1px; background:var(--gold); margin-top:24px; opacity:0.5;"></div>
      </div>

      {{-- Explore column --}}
      <div>
        <p style="font-family:'DM Sans',sans-serif; font-size:0.6rem; letter-spacing:0.28em; color:var(--gold); text-transform:uppercase; margin-bottom:20px;">Explore</p>
        @foreach([['States','states.index'],['Heritage','monuments.index'],['Festivals','festivals.index'],['Cuisine','cuisine.index']] as [$lbl,$rt])
        <a href="{{ route($rt) }}" style="display:block; font-family:'DM Sans',sans-serif; font-size:0.88rem; color:rgba(245,237,216,0.55); margin-bottom:12px; transition:color 0.3s ease;" onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='rgba(245,237,216,0.55)'">{{ $lbl }}</a>
        @endforeach
      </div>

      {{-- States column --}}
      <div>
        <p style="font-family:'DM Sans',sans-serif; font-size:0.6rem; letter-spacing:0.28em; color:var(--gold); text-transform:uppercase; margin-bottom:20px;">States</p>
        @foreach(\App\Models\State::active()->orderBy('name')->take(5)->get() as $fs)
        <a href="{{ route('states.show', $fs->slug) }}" style="display:block; font-family:'Cormorant Garamond',serif; font-size:1rem; color:rgba(245,237,216,0.55); margin-bottom:10px; transition:color 0.3s ease;" onmouseover="this.style.color='var(--parchment)'" onmouseout="this.style.color='rgba(245,237,216,0.55)'">{{ $fs->name }}</a>
        @endforeach
      </div>

      {{-- Admin column --}}
      <div>
        <p style="font-family:'DM Sans',sans-serif; font-size:0.6rem; letter-spacing:0.28em; color:var(--gold); text-transform:uppercase; margin-bottom:20px;">Admin</p>
        <a href="{{ route('filament.admin.auth.login') }}" style="display:block; font-family:'DM Sans',sans-serif; font-size:0.88rem; color:rgba(245,237,216,0.55); margin-bottom:12px;" onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='rgba(245,237,216,0.55)'">Admin Panel ↗</a>
        @if(app()->environment('local'))
        <a href="{{ route('demo') }}" style="display:block; font-family:'DM Sans',sans-serif; font-size:0.88rem; color:rgba(245,237,216,0.55); margin-bottom:12px;" onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='rgba(245,237,216,0.55)'">Quick Demo Login</a>
        @endif
      </div>
    </div>

    <div style="border-top: 1px solid rgba(201,144,26,0.15); padding-top: 28px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <p style="font-family:'DM Sans',sans-serif; font-size:0.75rem; color:rgba(245,237,216,0.3); letter-spacing:0.08em;">
        © {{ date('Y') }} Bharatdarshan · Celebrating India's Cultural Heritage
      </p>
      <p style="font-family:'Cormorant Garamond',serif; font-style:italic; font-size:0.9rem; color:rgba(201,144,26,0.4);">
        ✦ Discover · Explore · Celebrate ✦
      </p>
    </div>
  </div>
</footer>

<script>
  // Navbar scroll behavior
  (function(){
    const nav = document.getElementById('site-nav');
    if (!nav) return;
    window.addEventListener('scroll', () => {
      nav.classList.toggle('scrolled', window.scrollY > 60);
    }, {passive: true});
  })();

  // Scroll reveal (IntersectionObserver) — supports both .revealed and .in class names
  (function(){
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(e => {
        if (e.isIntersecting) {
          e.target.classList.add('revealed');
          e.target.classList.add('in');
          observer.unobserve(e.target);
        }
      });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
  })();
</script>

@yield('scripts')
@stack('scripts')

</body>
</html>
