# BookVerse — Assessment 3

> Starter documentation, not a completed submission. Update this file as the implementation progresses and replace all bracketed prompts before submission. Review the explanations in your own words.

## Student and project details

| Item | Details |
| --- | --- |
| Student | Seth Nightingale |
| Student ID | s4178376 |
| Course | COSC2446 Web Programming A |
| Repository | https://github.com/s4178376/wp |
| Project directory | `wp/a3/` |
| Local URL | http://localhost/wp/a3/ |
| Intended live URL | https://titan.csit.rmit.edu.au/~s4178376/wp/a3/ — Deployment down due to PHP outage

## Overview

BookVerse is a PHP and MySQL book-listing website. Assessment 3 extends the earlier website with user accounts, seller profiles, keyword search and ownership-based book management.

The current package is a partially implemented starter. Reading, login/logout and registration code is present. Book-changing handlers are deliberately unfinished; their forms display explanatory feedback rather than writing data.

## Current implementation

| Feature | Starter status |
| --- | --- |
| Homepage with latest database covers and four latest books | Implemented; runtime verification pending |
| Catalogue and JavaScript status filter | Implemented; runtime verification pending |
| Gallery and Bootstrap image modal | Implemented; runtime verification pending |
| Details and public seller pages | Implemented; runtime verification pending |
| Search across title, author and description | Implemented; runtime verification pending |
| Login, logout, sessions and flash feedback | Implemented; runtime verification pending |
| Login and ownership guards | Implemented; two-account testing pending |
| Registration | Server validation, duplicate handling, bcrypt insertion and automatic login implemented; local runtime verification pending |
| Add Book | Form and protected handler scaffold; no upload or insertion yet |
| Edit Book | Owner check and prefilled form; no update or cover replacement yet |
| Delete Book | Owner-only button, modal and protected handler; no deletion yet |
| Reference screenshot matching | Final visual review pending |

## File structure

| Path | Purpose |
| --- | --- |
| `index.php`, `books.php`, `gallery.php`, `details.php` | Public book browsing |
| `search.php`, `seller.php` | Keyword results and books belonging to a seller |
| `login.php`, `register.php`, `logout.php` | Account interface and logout |
| `add.php`, `edit.php` | Protected book forms |
| `process_login.php` | Login processing |
| `process_register.php` | Registration validation, prepared account insertion and automatic login |
| `process_add.php`, `process_edit.php`, `process_delete.php` | Unfinished book write handlers |
| `includes/bootstrap.inc` | Shared initialisation and ownership guard |
| `includes/session.inc` | Session, CSRF, authentication and flash helpers |
| `includes/db_connect.inc` | Automatic local/live database configuration |
| `includes/config.example.php` | Configuration template |
| `includes/config.private.php` | Private overrides; created locally and excluded from Git |
| `includes/functions.inc` | Escaping, cover paths and prepared SELECT helper |
| `includes/header.inc`, `nav.inc`, `footer.inc` | Shared page layout |
| `includes/book_cards.inc`, `book_form.inc` | Shared cards and add/edit form |
| `assets/css/style.css`, `assets/js/scripts.js` | Shared styling and browser interactions |
| `assets/images/covers/` | Book covers; include in deployment and submission ZIP |
| `database/bookverse.sql` | Original supplied SQL, including destructive DROP statements |
| `database/local_setup.sql` | Isolated local A3 setup, imported once |
| `START-HERE.md` | Development setup steps |
| `process-evidence.md` | Progressive debugging and AI-use records |

## Technologies

- PHP with procedural MySQLi and prepared statements.
- MySQL-compatible database; local XAMPP and live Jacob 5.
- HTML, CSS, JavaScript and Bootstrap 5.
- Google Fonts: Righteous and Elms Sans; Material Icons.
- Git/GitHub for version history.

Actual tested PHP/database/browser versions: [Record versions after testing.]

## Database and configuration

The supplied schema contains `users` and `books`. `books.user_id` references `users.user_id`; one user can own multiple books. The foreign key uses `ON DELETE SET NULL`.

The starter's local database is `bookverse_a3`, isolated from A2. It retains the supplied table and column names. `local_setup.sql` creates that local database and seeds the supplied users and books. Import it once into a fresh setup.

Do not run the original `bookverse.sql` against an existing A2/live database: it drops `books` and `users`. Live migration and the exact A3 database allocation must be confirmed before import. The earlier A2 allocation must not be treated as disposable.

Database credentials are configured through `includes/config.private.php` or environment variables. Do not put real passwords in this README, evidence records or Git.

## Coding choices

- Shared includes reduce repeated layout and initialisation code.
- Prepared statements separate query structure from bound values.
- `htmlspecialchars()` escapes values where they enter HTML.
- Server-side ownership checks protect edit/delete routes; hiding buttons alone is insufficient.
- A named A3 session separates its authentication from the earlier project.
- Login uses `password_verify()` and regenerates the session ID on success.
- Registration uses `password_hash()` with `PASSWORD_BCRYPT`, fitting the supplied `CHAR(60)` column. Passwords require at least eight characters and at most 72 bytes to avoid bcrypt truncation. Duplicate username/email checks use prepared queries and the database UNIQUE constraints. Only non-password form values are retained after errors.
- POST actions check CSRF tokens and redirect with session feedback.
- Search binds the keyword and escapes LIKE wildcards for literal matching.
- The catalogue filter uses `data-status`; the supplied SQL statuses are Available, Reserved and Sold.
- Responsive layout uses Bootstrap; automatic Dark mode uses CSS media queries.

My own decisions, changes and reasons: [Explain what you kept or changed after reviewing the code.]

## Testing

The starter-generation checks covered JavaScript syntax, static route/include references, cover-image decoding and package integrity. These are assistant-side checks, not evidence that PHP, MySQL, uploads or live deployment passed.

| Test | Expected result | Actual result/date |
| --- | --- | --- |
| PHP syntax | All PHP and INC files parse | Pending |
| Local schema | Users/books load with correct relationships | Pending |
| Homepage | Latest four records and carousel covers | Pending |
| Catalogue | Status filtering and correct details links | Pending |
| Gallery | Correct image/title, close, previous/next | Pending |
| Search | Matching title/author/description and useful no-results response | Pending |
| Details/seller IDs | Valid IDs load; malformed/missing records handled | Pending |
| Login/logout | Correct credentials accepted; session cleared on logout | Pending |
| Flash feedback | Message displays once | Pending |
| Anonymous routes | Add/edit/delete require login | Pending |
| Two-account ownership | Non-owner cannot edit/delete another user's book | Pending |
| Registration | Hashed account inserted and automatically logged in; duplicate/invalid inputs rejected | Implemented; runtime test pending |
| Add/upload | Record and image saved with session owner ID | Not implemented |
| Edit | Fields update; optional cover replacement cleans old file | Not implemented |
| Delete | Confirmation, owned record and image removed | Not implemented |
| HTML/CSS validators | Rendered HTML and stylesheet checked | Pending |
| Responsive/accessibility | Mobile/tablet/desktop, keyboard and both colour modes | Pending |
| Titan/Jacob 5 | All features work on deployed site | Pending |

Record exact failures and fixes in `process-evidence.md`. Update status only after running each test.

## Deployment

Intended destination: `~/public_html/wp/a3/` on Titan, using the assigned Jacob 5 database.

Deployment date: [Pending]

Confirmed live URL: [Pending]

Actual database allocation and import approach: [Confirm without recording the password.]

The course specifies directory mode 755 for A3 and mode 777 for the cover-upload directory. The university authentication file belongs in `public_html`. Verify upload protection and image loading on the live server.

## Git process

Actual branch/workflow: [Describe your workflow.]

Relevant commits: [Add real commit links as development proceeds.]

The written brief asks for at least five meaningful commits across five calendar days. Keep authentic history; do not backdate or invent commits. Cover images are ignored by the starter's Git rules and need to be included separately in deployment and the submission ZIP.

## AI-use declaration — draft for review

ChatGPT assisted with the initial A3 structure, PHP foundations and starter documentation. The generated code includes public database pages, authentication helpers and unfinished write handlers. The interactions are recorded in `process-evidence.md`.

My review, adaptations and validation: [Describe what you personally examined, changed, tested and can explain.]

Other AI tools used: [List actual tools, or state none.]

## Known limitations and remaining work

- Book insertion/uploads, updates and deletion are not implemented yet. Registration is implemented but needs local runtime testing.
- The supplied sample accounts are development fixtures, not production credentials.
- PHP/MySQL execution, browser behaviour and A3 deployment have not been verified here.
- Final screenshot matching, validation and authentication/authorization testing remain.
- This README and the evidence records need your own completed results and reflection.

Final limitations after implementation: [Replace with actual remaining limitations.]
