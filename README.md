# Isla — Managed Virtual Staffing (React + Laravel)

The Isla marketing site rebuilt as a **React (Inertia.js) + Laravel** application.
Laravel keeps the routing, Eloquent models, admin dashboard, and enquiry handling;
every public page is now a React component with ScrollXUI-style animated UI.

- **Backend:** Laravel 10 + Inertia (server adapter)
- **Frontend:** React 18 + @inertiajs/react + Vite + Tailwind CSS + Framer Motion
- **Fonts:** Satoshi (display/headings, via Fontshare) + Geist / Geist Mono (body/UI/captions, via Google Fonts)
- **Palette:** unchanged — the four Isla brand swatches (cream `#fdf7ef`, white, rose `#db9496`, sage `#8f9d77`) plus the supporting ink neutral `#2b2723`

---

## Setup

```bash
composer install          # installs inertiajs/inertia-laravel (added to composer.json)
cp .env.example .env      # if starting fresh
php artisan key:generate
php artisan migrate --seed

npm install
npm run dev               # or: npm run build for production
php artisan serve
```

The admin dashboard (`/admin`) is untouched and still Blade-based —
all its CRUD screens and the Settings page keep working, and the settings
still drive the public copy (shared to React through Inertia middleware).

## Architecture

| Piece | Where |
|---|---|
| Inertia root view (fonts + `@vite` + `@inertia`) | `resources/views/app.blade.php` |
| Shared props (settings, nav items, flash) | `app/Http/Middleware/HandleInertiaRequests.php` |
| Public controllers → `Inertia::render(...)` | `app/Http/Controllers/IslaController.php` |
| React entry | `resources/js/app.jsx` |
| Pages (one per route) | `resources/js/Pages/**` |
| Site layout (nav, marquee, footer, dock) | `resources/js/Layouts/SiteLayout.jsx` |
| ScrollXUI components | `resources/js/components/scrollxui/**` |
| Shared site pieces (TrustBar, CtaBand, forms…) | `resources/js/components/site/**` |
| Brand tokens / type hierarchy | `tailwind.config.js` + `resources/css/app.css` |

The old public Blade views under `resources/views/isla/` are no longer used
by any route and can be deleted once you're happy with the React version.

## ScrollXUI component mapping

All 21 requested components are implemented locally under
`resources/js/components/scrollxui/`, styled with the Isla palette:

| Component | Used for |
|---|---|
| `reveal-text` → `RevealText` | Every major heading (word-by-word scroll reveal) |
| `stagger-button` → `StaggerButton` | Nav CTA + secondary buttons (letter roll on hover) |
| `orb-button` → `OrbButton` | "Book a Discovery Call" hero + CTA band |
| `spotlightcard` → `SpotlightCard` | Service cards, benefits, role grid, "what happens next" |
| `statscount` → `StatsCount` | About "At a glance" stats (count-up on scroll) |
| `bento-grid` → `BentoGrid` | Who We Work With (home + index) |
| `card` → `Card` | Related-item cards |
| `lean-card` → `LeanCard` | Pricing plans (3D lean on hover) |
| `expandable-cards` → `ExpandableCards` | FAQs everywhere |
| `expandable-dock` → `ExpandableDock` | Floating quick-actions dock (book / estimate / enquire) |
| `kinetic-testimonials` → `KineticTestimonials` | Brand-promise marquee under the nav |
| `layer-stack` → `LayerStack` | Home hero visual (stacked brand panels + badge) |
| `parallaxcards` → `ParallaxCards` | How It Works step stack |
| `animated-tabs` → `AnimatedTabs` | Cost Estimator: Single Role / Build Your Team |
| `select` → `Select` | Estimator controls + form sector picker |
| `search-cell` → `SearchCell` | FAQ search |
| `scroll-areapro` → `ScrollAreaPro` | Book-a-call time-slot list |
| `slider` → `Slider` | Related services / sectors rails |
| `showcase` → `Showcase` | Services index rows + About story |
| `dropdown-menu` → `DropdownMenu` | "More" group in the desktop nav |
| `loader` → `Loader` | Form submit spinner |

**Swapping in the official registry versions:** the project ships with a
`components.json` and the `@` alias, so the `npx shadcn@latest add @scrollxui/...`
commands will drop the official components into `resources/js/components/ui/`.
You can then point any import at the registry version instead of the local one.
(The local versions were written here because the registry can't be reached
from the build environment — behaviour and naming match.)

## Fonts

- **Satoshi** loads from the Fontshare CDN (`app.blade.php`). To self-host,
  download the family from fontshare.com, drop the woff2 files into
  `public/fonts/`, and replace the `<link>` with `@font-face` rules.
- **Geist / Geist Mono** load from Google Fonts.
- Note: the request said "Geister" — this build assumes **Geist** (the Vercel
  typeface, now on Google Fonts). If a different face was meant, it's a
  one-line swap in `tailwind.config.js` + `app.blade.php`.

## Notable behaviours kept from the Blade build

- Admin-editable settings drive all headings/copy (same keys, same defaults).
- Cost Estimator math is identical (base rates per service, experience ×
  setup multipliers, flat management fee, 38 hrs/week basis, AUD/USD/NZD/GBP).
- Book-a-call scheduler: weekday-only calendar, the same time slots, and the
  chosen slot is prepended to the enquiry message on submit.
- Enquiry form posts to the same `/contact` endpoint → `ContactMessage`,
  with server-side validation errors and the success flash rendered inline.
# isla
