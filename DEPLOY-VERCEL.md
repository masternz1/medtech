# Deploying to Vercel

Vercel runs PHP through the community runtime `vercel-php` (already configured in `vercel.json`).
Vercel is "serverless", which means three things for this project:

1. **There is no database on Vercel.** Use a hosted one (Supabase Postgres).
2. **Files do not persist.** Product photos must live in external storage (Supabase Storage).
3. **Nothing can run `php artisan` on Vercel.** Run migrations from your own computer.

The built website assets are already in `public/build`, because the PHP runtime does not run npm.
Run `npm run build` again and commit `public/build` whenever you change styles.

## 1. Supabase

1. Create a project at supabase.com.
2. Database: Project Settings > Database > Connection string > **Session pooler**. Note host, user, password.
3. Storage: create a **public** bucket (for example `media`). Then Storage > S3 Connection > create an access key.

## 2. Create the tables (from your own computer)

Put the Supabase database details in your local `.env` (DB_CONNECTION=pgsql ... DB_SSLMODE=require).
Enable `extension=pdo_pgsql` and `extension=pgsql` in `php.ini`, then:

    php artisan config:clear
    php artisan migrate --force
    php artisan db:seed --force

The seeder creates DEMO accounts (admin@medequippro.com / password). Log in to /admin straight away,
change that password and delete the demo accounts and demo products.

## 3. Push to GitHub

    git add .
    git commit -m "Redesign and Vercel setup"
    git push

`.env` is not committed (it is in `.gitignore`). Keep it that way.

## 4. Vercel

1. vercel.com > Add New > Project > import the GitHub repository.
2. Framework Preset: **Other**. Leave Build and Output settings empty (vercel.json sets them).
3. Add every variable from `.env.vercel.example` under Environment Variables.
4. Deploy. Then set `APP_URL` to your real address and redeploy.

## Good to know

- **Vercel's free Hobby plan is for non-commercial use.** A business shop needs the Pro plan.
- Product photo uploads in /admin go straight from the browser to Supabase Storage. If an upload fails,
  run the site on your own computer with the production `.env` and upload from there. The photos and
  database are shared, so they appear on the live site.
- Payment webhooks (Paystack, Flutterwave) must point to your live address.
- Emails use `MAIL_MAILER=log` until you add a real mail service, so customers will not receive emails.
