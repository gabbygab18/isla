UPLOAD ORDER — Isla, August update
==================================

Two zips. Upload both; order does not matter, but do the source files
first so nothing renders half-updated.

1. isla-changed-files-only.zip  →  the Laravel app folder
   (the one OUTSIDE public_html — /home/<cpanel-user>/isla-react-laravel)

   Extract over the existing folder. Files touched:

     resources/js/components/site/AboutPhilippines.jsx   (NEW)
     resources/js/Pages/About.jsx                        (renders the new section)
     resources/js/Pages/Home.jsx                         (homepage title)
     resources/views/app.blade.php                       (favicon link tags)
     resources/views/admin/settings.blade.php            (4 new editable fields)

2. public_html-ready.zip  →  public_html

   Extract over public_html. Contains the new icons and the freshly
   compiled build assets.

   IMPORTANT: delete these two stale files from
   public_html/build/assets/ after extracting —

     app-D73atjdC.css
     app-ns_C6qr3.js

   They are the previous build. Nothing references them any more, but
   leaving them behind makes the next diff confusing.

3. In cPanel Terminal (or via a temporary route), clear the caches:

     php artisan view:clear
     php artisan config:clear

   Blade views changed, so view:clear is the one that matters.

4. Hard-refresh the site (Ctrl+Shift+R) and check:

     /about        → "About the Philippines" section is present
     browser tab   → butterfly icon, no clipped wings
     /admin        → Settings has "Homepage browser/search title" under
                     Brand, and three "About the Philippines" fields
                     under About page

No database changes. No composer install needed. Nothing to migrate.
