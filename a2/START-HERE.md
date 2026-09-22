# Add this restructured starter to wp

## Database connection update

includes/db_connect.inc now contains the commented procedural MySQLi
connection code from the next-step explanation. Settings are not configured,
and the pages still do not include this file. No PHP runtime or database
testing has been performed. The official README and evidence are unchanged.
This update supersedes the inactive-connection description in the older
reference notes in docs/.

If you changed files locally since downloading the starter, copy only
includes/db_connect.inc into your existing a2 folder to preserve your work.
Otherwise this ZIP contains the full a2 folder to place inside wp.

Required PHP server environment variables, to configure later:
- Local: BOOKVERSE_LOCAL_DB_HOST, BOOKVERSE_LOCAL_DB_USER,
  BOOKVERSE_LOCAL_DB_PASSWORD.
- Live: BOOKVERSE_LIVE_DB_HOST, BOOKVERSE_LIVE_DB_USER,
  BOOKVERSE_LIVE_DB_PASSWORD.

Database names: bookverse locally and s4178376 live.
Do not put passwords in Git. This code does not automatically load .env files.
Confirm RMIT's supported configuration method before deployment.

This package merges the official a2 starter with the earlier PHP scaffold.
The supplied README.md, process-evidence.md and favicon.svg are unchanged.
The official asset directories and their placeholder files are retained.
The official ZIP did not contain covers, CSS, JavaScript or PHP pages.
The 12 covers and shared stylesheet come from the available Part 1 copy;
the PHP pages and JavaScript come from the earlier Part 2 scaffold.
database/bookverse.sql is the unchanged SQL from the assessment package.

## Documentation to work on

- README.md: official student-completed template. Its TODOs are intentional
  at this starting stage, but must all be completed before final submission.
- process-evidence.md: official blank evidence template, not completed records.
  It contains two example slots of each type; add slots as needed to meet
  the requirement of at least four real bugs and four meaningful AI records.
  Include actual commit hashes and URLs in both debugging and AI records.
- docs/starter-development-notes.md: the previous starter's technical notes.
- docs/draft-ai-scaffold-record.md: reference material for reviewing the first
  AI interaction, not a substitute for your official evidence log.

No tests, commits, student reflections or acceptance decisions have been
filled into the official templates on your behalf.

## Installation

1. Extract the ZIP. Move its a2 folder into your existing wp folder, beside a1.
2. If wp/a2 already exists, compare/merge the files rather than overwriting work.
3. Open wp in VS Code. Keep the existing repository and its history.
4. Review includes/header.inc, nav.inc and footer.inc, then index.php.
5. Review the remaining placeholders and the JavaScript starter.
6. Use the draft AI notes to complete the official process-evidence.md entry
   with your actual review, development date, changes, tests and commit link.
7. Inspect git status before staging. Commit only the intended a2 changes.

Suggested first commit: Create Part 2 PHP scaffold and shared includes

The covers folder is included in this ZIP but ignored by a2/.gitignore as
required by the brief. Git will not include these covers in a future fresh clone.
Keep a separate copy for deployment and Canvas packaging.

This is not the final COSC2446_a2_s4178376.zip submission.
This package contains only a2: a1 and your repository history are untouched.
No XAMPP installation, database connection, deployment, commit or push is done.
Next milestone: implement the database connection and read-only book queries.
