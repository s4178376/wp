# Integrate the database milestone

This package upgrades the supplied starter, not your submitted a1.
The homepage, catalogue, gallery and details now read the books table.
The Add Book form now submits to PHP, validates data and uploads, inserts
a record, and redirects to its details page.

## 1 Preserve your existing work

Back up your current a2 outside htdocs. Merge this a2 folder into
/Applications/XAMPP/xamppfiles/htdocs/wp/a2.
Keep any existing private configuration and additional cover files.
README.md and process-evidence.md are unchanged from the ZIP you supplied.
Do not overwrite newer local edits to those files.
The official templates still require your own completion before submission.

## 2 Local configuration

Start Apache and MySQL in XAMPP. The code automatically uses:
host 127.0.0.1, port 3306, user root, empty password, database bookverse.
These are development defaults, not live credentials.
Your already imported books table can be reused. Do NOT reimport the SQL.
Environment variables BOOKVERSE_LOCAL_DB_HOST/USER/PASSWORD/DATABASE/PORT,
if configured previously, override these defaults.

If your local password or port differs, copy includes/config.example.php
to includes/config.private.php and edit its local section privately.
Do not commit config.private.php. You do not need a root-level .htaccess
containing credentials for this version.

## 3 Permissions

If you encounter the previous asset permissions problem again, set folders
inside a2 to 755 and ordinary source/assets to 644. Do not change wp/.git.
The covers directory also needs to be writable by PHP for uploads.
The course specifies 777 for this particular directory:
chmod 777 /Applications/XAMPP/xamppfiles/htdocs/wp/a2/assets/images/covers

Do not use 777 on the whole project. Keep includes/.htaccess and
assets/images/covers/.htaccess from this package. They protect include files
from direct requests and prevent execution of uploaded scripts respectively.
These are not substitutes for the required university authentication file.

## 4 Test in the browser

Open http://localhost/wp/a2/
- Homepage: four latest books, sorted by created_at DESC then book_id DESC.
  With the unchanged seed data, IDs 12, 11, 10 and 9 normally appear.
- Browse Books: 12 sample records; each title opens the correct details page.
- Filters: Available, Reserved, Sold and Show All.
- Details: check ?id=1; then ?id=0, ?id=abc and an unknown positive ID.
- Gallery: all covers, modal close, previous and next including wrapping.
- Add Book: submit valid fields and a small JPG/PNG/GIF/WEBP image.
  Use a 10- or 13-character ISBN such as 9781020000012.
- Confirm success on the details page and appearance in all four read pages.
- Refresh details: the record must not be inserted a second time.
- Try blank fields, unsupported files, an image over 5 MiB and a non-image
  renamed to .jpg. Browser and server validation should prevent insertion.
- On a server rejection, confirm text remains and reselect the file.
- Stop MySQL temporarily and confirm a readable error rather than a broken page.
- Check mobile/tablet/desktop, keyboard use, light and dark modes.
- Validate rendered HTML and CSS. Raw PHP is not HTML validator input.

The UI file limit is 5 MiB. PHP upload_max_filesize must allow that size and
post_max_size must be larger to include all fields (for example 8M).
A lower PHP limit will reject a file even if the browser permits it.
Check the active XAMPP php.ini before changing limits, then restart Apache.

## 5 PHP checks on your Mac

From the a2 directory run:
find . -type f \( -name '*.php' -o -name '*.inc' \) -exec /Applications/XAMPP/xamppfiles/bin/php -l {} \;

Server extensions needed: mysqli (with mysqlnd), fileinfo and sessions.
The connection uses TCP to avoid the earlier local socket mismatch.

## 6 Titan later

Copy config.example.php to config.private.php on Titan and fill the live
section using SDAMDS. The host is talsprddb02.int.its.rmit.edu.au.
The exact database name includes a suffix; it is NOT assumed to be s4178376.
Upload config.private.php privately, never through Git. Exclude it from ZIPs
you share and preserve it when updating code.
Set the covers upload permission per the course instructions.
Keep the RMIT authentication .htaccess in public_html.
Verify the include files return 403 when requested directly in a browser.
Do not use the earlier broad upload command without excluding config.private.php.

## Scope and evidence

This is a functional implementation milestone awaiting PHP/MySQL browser tests
on your machine. No runtime, database, W3C or deployed pass is claimed.
The environment here does not have PHP/MySQL and package installation was unavailable.
See docs/database-milestone.md for the changes and actual checks.
Older docs/starter-development-notes.md and draft AI notes describe earlier
stages and are historical, not the current feature status.
No Git commit, push, deployment or database import was performed.
