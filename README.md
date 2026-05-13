# Bharatdarshan

A premium cultural heritage platform celebrating India's monuments, festivals, and states. Built with Laravel 13, Filament admin, and Spatie MediaLibrary.

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 13, PHP 8.3 |
| Database | MySQL 8+ |
| Admin Panel | Filament v4 |
| Media | Spatie MediaLibrary v11 |
| Frontend | Vanilla CSS, Vanilla JS, Alpine.js |
| Build Tool | Vite |
| Deployment | Docker (Nginx + PHP-FPM + Supervisor) |

---

## Requirements

- PHP 8.3+
- Composer 2+
- Node.js 20+ and npm
- MySQL 8+
- Git

---

## Local Setup

### 1. Clone the repository

```bash
git clone https://github.com/your-username/bharatdarshan.git
cd bharatdarshan
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install Node dependencies

```bash
npm install
```

### 4. Configure environment

```bash
cp .env.example .env
php artisan key:generate
```

Open `.env` and update the database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bharatdarshan
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Create the database

In MySQL:

```sql
CREATE DATABASE bharatdarshan CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 6. Run migrations

```bash
php artisan migrate
```

### 7. Seed the database

```bash
php artisan db:seed
```

This will populate:
- All 5 states (Kerala, Punjab, Rajasthan, Tamil Nadu, West Bengal) with culture, food, and traditions data
- 10 heritage monuments with highlights and tips
- 15 festivals with rituals and tips
- Admin user (`admin@bharatdarshan.com` / `password`)

### 8. Create the storage symlink

```bash
php artisan storage:link
```

### 9. Build frontend assets

For development (with hot reload):
```bash
npm run dev
```

For production:
```bash
npm run build
```

### 10. Start the development server

```bash
php artisan serve
```

The application will be available at **http://localhost:8000**

---

## Admin Panel

| Field | Value |
|---|---|
| URL | http://localhost:8000/admin |
| Email | admin@bharatdarshan.com |
| Password | password |

> Change the admin password after first login in production.

---

## Static Image Assets

The project uses static images stored in `public/images/`. These are committed to the repository and served directly — no additional setup required.

```
public/images/
├── Dashboard/          # Home page monument cards
├── Heritage/           # Monument portrait + landscape photos
│   ├── *Portorate.jpg  # Card cover images
│   └── *Landscape.jpg  # Hero background images
├── Festival/           # Festival photos
│   ├── *Portorate.jpg  # Card cover images
│   └── *landscape.jpg  # Hero background images
└── states/             # State photos
    ├── *Portrate*.jpg  # State card cover images
    └── *Landscape.jpg  # State detail hero images
```

---

## Running All at Once (Development)

Open two terminal tabs:

**Tab 1 — Laravel:**
```bash
php artisan serve
```

**Tab 2 — Vite:**
```bash
npm run dev
```

---

## Docker Deployment

The project includes a production-ready Docker setup with Nginx, PHP-FPM, and Supervisor.

### Build the image

```bash
docker build -t bharatdarshan .
```

### Run the container

```bash
docker run -p 80:80 \
  -e APP_KEY=your_app_key \
  -e APP_URL=https://yourdomain.com \
  -e DB_HOST=your_db_host \
  -e DB_DATABASE=bharatdarshan \
  -e DB_USERNAME=your_db_user \
  -e DB_PASSWORD=your_db_password \
  bharatdarshan
```

On first boot the container automatically:
1. Waits for the database to be reachable
2. Runs `php artisan migrate`
3. Seeds the database if the states table is empty
4. Creates the admin user (`admin@bharatdarshan.com`)
5. Starts Nginx and PHP-FPM via Supervisor

### Environment variables for production

| Variable | Description |
|---|---|
| `APP_KEY` | Laravel app key — generate with `php artisan key:generate --show` |
| `APP_ENV` | Set to `production` |
| `APP_DEBUG` | Set to `false` |
| `APP_URL` | Your public domain (e.g. `https://bharatdarshan.com`) |
| `DB_HOST` | Database host |
| `DB_DATABASE` | Database name |
| `DB_USERNAME` | Database user |
| `DB_PASSWORD` | Database password |

---

## Useful Artisan Commands

```bash
# Clear all caches
php artisan optimize:clear

# Re-cache for production
php artisan optimize

# Re-run seeders without dropping tables
php artisan db:seed

# Fresh migration + seed (drops all data)
php artisan migrate:fresh --seed

# Open interactive shell
php artisan tinker
```

---

## Project Structure

```
app/
├── Http/Controllers/       # StateController, MonumentController, FestivalController
├── Models/                 # State, Monument, Festival and related models
└── Filament/Resources/     # Admin panel resource definitions

database/
├── migrations/             # All table schemas
└── seeders/                # StateSeeder, MonumentSeeder, FestivalSeeder

resources/views/
├── layouts/app.blade.php   # Global layout (nav, fonts, CSS vars, footer)
├── home/                   # Homepage
├── states/                 # States index + detail
├── monuments/              # Heritage index + detail
└── festivals/              # Festivals index + detail

public/images/              # Static photo assets
.claude/skills/SKILL.md     # Frontend design system reference
```

---

## License

Private project. All rights reserved.
