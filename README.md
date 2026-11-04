# MedEquip Pro — Medical Equipment E-Commerce Platform

A professional, scalable medical equipment e-commerce and business management platform built with Laravel 11, Filament 3, Livewire 3, and Supabase PostgreSQL.

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 11, PHP 8.3 |
| Admin Panel | Filament 3 |
| Frontend | Blade, Livewire 3, Alpine.js, Tailwind CSS |
| Build Tool | Vite |
| Database | PostgreSQL (Supabase managed) |
| File Storage | Supabase Storage (S3-compatible) |
| Payments | Paystack, Flutterwave |
| Email | Resend |
| RBAC | spatie/laravel-permission |
| PDF | barryvdh/laravel-dompdf |

---

## Requirements

- PHP 8.3+
- Composer 2.x
- Node.js 18+ and npm
- PostgreSQL (via Supabase)

---

## Local Development Setup

### 1. Clone the repository
```bash
git clone https://github.com/your-org/medical-web.git
cd medical-web
```

### 2. Install PHP dependencies
```bash
composer install --no-security-blocking
```

### 3. Install Node dependencies
```bash
npm install
```

### 4. Environment configuration
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` with your Supabase credentials and API keys.

### 5. Database setup
Ensure your Supabase PostgreSQL credentials are in `.env`, then:
```bash
php artisan migrate --seed
```

### 6. Create admin user
```bash
php artisan make:filament-user
```

### 7. Storage link
```bash
php artisan storage:link
```

### 8. Build frontend assets
```bash
npm run dev
```

### 9. Start the development server
```bash
php artisan serve
```

Visit: http://localhost:8000
Admin panel: http://localhost:8000/admin

---

## Environment Variables

See `.env.example` for all required environment variables.

Key variables:
- `DB_*` — Supabase PostgreSQL connection
- `AWS_*` — Supabase Storage (S3-compatible)
- `PAYSTACK_*` — Paystack payment gateway
- `FLUTTERWAVE_*` — Flutterwave payment gateway
- `RESEND_API_KEY` — Resend transactional email

---

## Admin Panel

URL: `/admin`

Default roles:
- Super Admin
- Administrator
- Sales Manager
- Inventory Manager
- Order Manager
- Content Manager

---

## Production Deployment

See `docs/deployment.md` for full Ubuntu VPS deployment guide.

Quick summary:
1. Ubuntu 24.04 LTS VPS
2. Nginx + PHP-FPM 8.3
3. Supabase PostgreSQL (external)
4. Supervisor for queue workers
5. Laravel Scheduler via cron
6. Let's Encrypt SSL

---

## Development Phases

- [x] Phase 1: Project Foundation (Laravel 11, Filament 3, Livewire 3, Tailwind, configs)
- [x] Phase 2: Database & Authentication (17 Migrations, 27 Models, 6 Seeders, Breeze Auth & RBAC)
- [x] Phase 3: Public Website (Catalog, Filters, Details, Categories, Brands, Services, RFQ, FAQs, Contact)
- [x] Phase 4: E-Commerce (Cart, Checkout, Paystack, Flutterwave, Bank Transfer, Live Tracking, PDF Invoices)
- [x] Phase 5: Admin Dashboard (Filament 3 Resources for Products, Orders, RFQs, Users, Categories, Brands, Enquiries & Metrics)
- [x] Phase 6: Finalization (Full Test Suite with 35 assertions passing, PDF Proposal/Invoice downloads, documentation)

---

## Security

- Never commit `.env` files
- All payment verifications are server-side
- Webhook signatures are verified (HMAC)
- Role-based access control enforced throughout

---

## License

Proprietary. All rights reserved.
