# Coding handoff — 30 September 2026

This is an assistant-authored implementation note, not a student testing record.
The code is based on the last BookVerse dynamic milestone supplied in this chat.
It does not include any later changes made only on your Mac.

## Implemented requirements

| Area | Implementation |
| --- | --- |
| Shared structure | Five PHP pages with header, navigation, footer, unique titles and semantic landmarks |
| Homepage | Four static carousel slides and four newest database books |
| Catalogue | Prepared reads; status options from the database; JavaScript data-status filtering; details links |
| Gallery | Database covers, Bootstrap modal and wrapping previous/next controls |
| Details | Bound integer ID; full book details; invalid ID and missing record responses |
| Add Book | Multipart POST, required fields, server validation, prepared INSERT and redirect after success |
| Uploads | Extension, MIME, image dimensions and size checks; random filenames; failed-insert cleanup |
| Security | Escaped output, CSRF token, procedural prepared statements and private configuration |
| Appearance | Shared stylesheet, Bootstrap layouts, automatic Dark mode and visible keyboard focus |

The brief does not require edit/delete pages, checkout or an admin account.
The database schema and supplied seed SQL are unchanged.

## Fixes in this version

- Required condition/status selectors explicitly select their empty placeholder.
- Browser validation now rejects whitespace-only text and invalid ISBN shapes,
  matching the PHP checks. Correcting a field clears its custom error.
- Empty files are rejected in browser validation as well as on the server.
- Oversized POST requests receive one useful recovery message.
- A failed charset setup clears the connection so pages do not query through it.
- Dark-mode focus, dropdown arrows and invalid feedback remain readable.
- Screen readers receive an announcement after catalogue filtering.
- Gallery thumbnails load lazily; the modal starts with an existing fallback image.
- The supplied 12.png was truncated; it was restored from the intact earlier project asset.
- A read-only local diagnostic checks extensions, prepared queries and covers.

## Run in the VS Code terminal

Start the installed XAMPP services using the commands supplied by your lecturer:

```bash
sudo /Applications/XAMPP/xamppfiles/xampp start
sudo /Applications/XAMPP/xamppfiles/xampp status
cd /Applications/XAMPP/xamppfiles/htdocs/wp/a2
find . -type f \( -name '*.php' -o -name '*.inc' \) -exec /Applications/XAMPP/xamppfiles/bin/php -l {} \;
/Applications/XAMPP/xamppfiles/bin/php tools/check-local.php
```

If all syntax checks say `No syntax errors detected` and the local diagnostic
passes, open http://localhost/wp/a2/. These checks do not test Apache's upload
permissions or render the pages. No XAMPP reinstall is needed merely because
the graphical Manager does not open. Use the lecturer's attached guide for an
actual architecture error; the guide was not included in this chat.

## Browser acceptance checks

1. Confirm the homepage, catalogue and gallery show your existing books.
2. Open a title and check the author, ISBN, condition, price and cover.
3. Filter each status, restore Show All, and use the gallery modal controls.
4. On Add Book, confirm condition/status initially show placeholders. Try empty
   fields, spaces-only titles, malformed ISBNs and an unsupported cover.
5. Add a book using a small real image. Use an ISBN such as 9781020000012.
   Confirm success, the new details page, and the record on the other pages.
6. Refresh the details page and confirm no duplicate record is created.
7. With JavaScript disabled, try invalid data and a text file renamed to .jpg.
   Confirm PHP rejects both, preserves text, and requests the cover again.
8. Check details.php?id=0, id=abc, id[]=1 and an unused positive ID.
9. Check light/dark modes, narrow screens, keyboard controls and the console.
10. Validate rendered HTML and the shared CSS; fix actual reported errors.

## Deployment still requires your account

Keep your existing local private settings and all uploaded covers when merging.
Do not reimport bookverse.sql into the existing local database: its INSERTs
would add the sample books again.

For Titan, use the exact case-sensitive Jacob 5 username and database from
SDAMDS in includes/config.private.php. The host is
talsprddb02.int.its.rmit.edu.au. Never send the password in chat or commit it.
If importing the seed SQL into an empty Jacob database, select your assigned
database first and omit the local CREATE DATABASE and USE statements.

Deploy to ~/public_html/wp/a2/. Preserve live private settings when uploading;
never overwrite them with local root settings. The course specifies a2 directory
mode 755 and covers mode 777. Keep the university authentication file in
public_html. Verify all pages and a real upload on Titan after deployment.

## Verification boundaries

JavaScript syntax, simulated client interactions, static structure, local asset
references and ZIP integrity were checked here. PHP/MySQL is unavailable in this
workspace; installing it was blocked by the environment. PHP execution, browser
rendering, file uploads, W3C validation and Titan/Jacob connectivity are not claimed
as passed. Run the local checks above and report any failures.

README.md and process-evidence.md remain your original files. Complete them using
your own confirmed results and actual commits. This package is a code handoff,
not a declaration that the assessment is ready to submit.
