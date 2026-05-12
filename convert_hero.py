import re

with open('Designs/Bharat Darshan Hero.html', 'r') as f:
    content = f.read()

# Extract body content between nav and footer
body_match = re.search(r'</nav>(.*?)<footer class="site-footer">', content, re.DOTALL)
body_html = body_match.group(1).strip() if body_match else ""

# Extract style
style_match = re.search(r'<style>(.*?)</style>', content, re.DOTALL)
style_css = style_match.group(1) if style_match else ""

# Remove common styles
# We just keep it all for now, or just remove :root, html, body, nav, footer
style_css = re.sub(r':root\s*\{[^}]+\}', '', style_css)
style_css = re.sub(r'\*\s*\{[^}]+\}', '', style_css)
style_css = re.sub(r'html,\s*body\s*\{[^}]+\}', '', style_css)
style_css = re.sub(r'body\s*\{[^}]+\}', '', style_css)
style_css = re.sub(r'/\*\s*============ NAV ============.*?(?=\/\*\s*============ HERO ============|\Z)', '', style_css, flags=re.DOTALL)
style_css = re.sub(r'/\*\s*FOOTER\s*\*\/.*?(?=\<\/style\>|\Z)', '', style_css, flags=re.DOTALL)

# Wire states
# For states, we need to replace the static articles in states-grid with a foreach loop
states_grid_pattern = r'<div class="states-grid reveal">(.*?)</div>\s*</section>'
states_grid_match = re.search(states_grid_pattern, body_html, re.DOTALL)
if states_grid_match:
    states_loop = """
    @foreach($featured_states as $state)
    <article class="state-card" onclick="window.location='{{ route('states.show', $state->slug) }}'">
      <div class="sc-img" style="background: {{ $gradients[$state->region] ?? 'linear-gradient(135deg, #C9901A, #E8580A)' }}">
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
    """
    body_html = body_html[:states_grid_match.start(1)] + states_loop + body_html[states_grid_match.end(1):]

# Wire heritage
mon_grid_pattern = r'<div class="mon-grid reveal">(.*?)</div>\s*<div class="type-pills reveal">'
mon_grid_match = re.search(mon_grid_pattern, body_html, re.DOTALL)
if mon_grid_match:
    mon_loop = """
    @foreach($featured_monuments as $monument)
    <article class="mon" onclick="window.location='{{ route('monuments.show', $monument->slug) }}'">
      <div class="mbg" style="background: linear-gradient(160deg, #C9901A, #8B1A1A, #4A0404);"></div>
      <span class="mon-glyph">{{ substr($monument->name, 0, 1) }}</span>
      <span class="cat-badge cb-asi">{{ $monument->category }}</span>
      <div class="mbody">
        <h3 class="mname">{{ $monument->name }}</h3>
        <div class="mmeta">{{ $monument->state->name ?? 'India' }} · {{ $monument->type }}</div>
        <p class="mdesc">{{ Str::limit($monument->description, 100) }}</p>
      </div>
    </article>
    @endforeach
    """
    body_html = body_html[:mon_grid_match.start(1)] + mon_loop + body_html[mon_grid_match.end(1):]

# Wire festivals
fest_grid_pattern = r'<div class="fest-grid reveal">(.*?)</div>\s*<h3 class="religion-h reveal">'
fest_grid_match = re.search(fest_grid_pattern, body_html, re.DOTALL)
if fest_grid_match:
    fest_loop = """
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
    """
    body_html = body_html[:fest_grid_match.start(1)] + fest_loop + body_html[fest_grid_match.end(1):]

# Wire facts
facts_pattern = r'<div class="facts-row">(.*?)</div>\s*</section>'
facts_match = re.search(facts_pattern, body_html, re.DOTALL)
if facts_match:
    facts_loop = """
    <div class="fbk"><div class="fbk-num" data-target="{{ $stats['states'] ?? 28 }}">0</div><div class="fbk-lab">States & Territories</div></div>
    <div class="fbk"><div class="fbk-num" data-target="{{ $stats['monuments'] ?? 40 }}">0</div><div class="fbk-lab">UNESCO Heritage Sites</div></div>
    <div class="fbk"><div class="fbk-num" data-target="{{ $stats['festivals'] ?? 365 }}">0</div><div class="fbk-lab">Festivals</div></div>
    <div class="fbk"><div class="fbk-num" data-target="{{ $stats['foods'] ?? 500 }}" data-suffix="+">0</div><div class="fbk-lab">Regional Dishes</div></div>
    """
    body_html = body_html[:facts_match.start(1)] + facts_loop + body_html[facts_match.end(1):]
    
# Link fixes in body
body_html = re.sub(r'href="BharatDarshan Heritage\.html"', 'href="{{ route(\'monuments.index\') }}"', body_html)
body_html = re.sub(r'href="BharatDarshan States\.html"', 'href="{{ route(\'states.index\') }}"', body_html)
body_html = re.sub(r'<button class="btn btn-primary"[^>]*>.*?Explore States.*?</button>', '<button class="btn btn-primary" onclick="window.location=\'{{ route(\'states.index\') }}\'"><span>Explore States</span><span class="arrow">→</span></button>', body_html, flags=re.DOTALL)
body_html = re.sub(r'<button class="btn btn-secondary"[^>]*>.*?View Heritage.*?</button>', '<button class="btn btn-secondary" onclick="window.location=\'{{ route(\'monuments.index\') }}\'"><span>View Heritage</span><span class="arrow">→</span></button>', body_html, flags=re.DOTALL)
body_html = re.sub(r'<button class="cbtn p"[^>]*>.*?Explore States.*?</button>', '<button class="cbtn p" onclick="window.location=\'{{ route(\'states.index\') }}\'"><span>Explore States</span><span class="arrow">→</span></button>', body_html, flags=re.DOTALL)
body_html = re.sub(r'<button class="cbtn s"[^>]*>.*?Visit Heritage.*?</button>', '<button class="cbtn s" onclick="window.location=\'{{ route(\'monuments.index\') }}\'"><span>Visit Heritage</span><span class="arrow">→</span></button>', body_html, flags=re.DOTALL)
body_html = re.sub(r'<button class="cbtn t"[^>]*>.*?Festival Calendar.*?</button>', '<button class="cbtn t" onclick="window.location=\'{{ route(\'festivals.index\') }}\'"><span>Festival Calendar</span><span class="arrow">→</span></button>', body_html, flags=re.DOTALL)

# Scripts
script_match = re.search(r'<script>(.*?)</script>.*?(<script>.*?</script>)?', content, re.DOTALL)
scripts = ""
for match in re.finditer(r'<script>(.*?)</script>', content, re.DOTALL):
    s = match.group(1)
    if "Nav active state" not in s:
        scripts += s + "\n"

blade_content = f"""@extends('layouts.app')

@section('title', 'Bharatdarshan — Discover Incredible India')

@section('styles')
<style>
{style_css}
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
@endphp
{body_html}
@endsection

@section('scripts')
<script>
{scripts}
</script>
@endsection
"""

import os
os.makedirs('resources/views/home', exist_ok=True)
with open('resources/views/home/index.blade.php', 'w') as f:
    f.write(blade_content)

print("Created home/index.blade.php")
