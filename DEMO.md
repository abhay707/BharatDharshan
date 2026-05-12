# Bharatdarshan — Demo Guide

A cultural heritage platform celebrating India's states, monuments, festivals, and cuisine.

---

## Quick Start

```bash
php artisan serve
```

Open **http://localhost:8000**

---

## Auto-Login (Local Only)

Visit **http://localhost:8000/demo** to instantly log in as the admin and redirect to the Filament dashboard — no credentials needed during a demo.

---

## Admin Panel

URL: **http://localhost:8000/admin**

| Field    | Value                        |
|----------|------------------------------|
| Email    | admin@bharatdarshan.com      |
| Password | password                     |

---

## Pages to Demo

| Page               | URL                                      | What to Show                                               |
|--------------------|------------------------------------------|------------------------------------------------------------|
| Homepage           | `/`                                      | Hero, state cards, heritage spotlight, festival calendar   |
| States             | `/states`                                | Grouped by region, search/filter                           |
| State Detail       | `/states/rajasthan`                      | Cover image, monuments, festivals, cuisine tab             |
| Heritage           | `/heritage`                              | Featured strip, full grid with filters                     |
| Monument Detail    | `/heritage/amber-fort`                   | Gallery, map, related monuments                            |
| Festivals          | `/festivals`                             | Calendar view, featured ticker, mosaic grid                |
| Festival Detail    | `/festivals/diwali`                      | Hero, celebrating states, related festivals                |
| Cuisine            | `/cuisine`                               | Filter by state, meal type, vegetarian toggle              |
| Admin Dashboard    | `/admin`                                 | Filament CRUD for all modules                              |

---

## Presentation Seed

To ensure featured content is visible:

```bash
php artisan db:seed --class=PresentationSeeder
```

---

## Tech Stack

- **Backend**: Laravel 13, PHP 8.5, Filament v3 admin
- **Frontend**: Claude Design System (Cormorant Garamond + DM Sans, Alpine.js)
- **Database**: MySQL with Eloquent ORM
- **Media**: Spatie MediaLibrary, picsum.photos seeded fallbacks
- **Features**: Slug-based routing, region grouping, festival calendar, cuisine filters
