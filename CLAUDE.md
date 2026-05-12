# Bharatdarshan — Claude Code Instructions

## Project
Laravel 13 / PHP 8.5 cultural heritage platform. Blade templating, Spatie MediaLibrary, Filament admin.

## Design System
Always follow `.claude/skills/SKILL.md` for every UI task — typography, color tokens, spacing, component patterns, and animation conventions are all defined there.

## Stack
- **Backend**: Laravel 13, PHP 8.5, MySQL
- **Frontend**: Vanilla CSS (no Tailwind), Vanilla JS (no React/Vue), framer-motion available
- **Fonts**: Cormorant Garamond + DM Sans (loaded via Google Fonts in layout)
- **Images**: Spatie MediaLibrary — collections: `hero`, `gallery`, `festival-cover`
- **Admin**: Filament v3

## Key Conventions
- Scripts go in `@push('scripts')` / `@endpush` — never `@section('scripts')`
- Styles go in `@section('styles')` / `@endsection`
- Body class: `@section('body_class', 'page-light')` or `'page-dark'`
- All sections need full-width `<section>` + inner `<div class="x-inner">` for content centering
- Never hide sections with bare `@if` — always include `@empty` fallback content
- Named route parameters must be explicit: `route('monuments.by-state', ['stateSlug' => $slug])`

## CSS Variables (global, defined in layout)
```
--ink:       #0D0500
--saffron:   #E8580A
--gold:      #C9901A
--parchment: #F5EDD8
--cream:     #FAF6EE
```
Define `--muted`, `--faint`, `--crimson` in page `@section('styles')` when needed.
