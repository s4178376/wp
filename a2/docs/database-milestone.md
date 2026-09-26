# Database implementation milestone

Prepared 26 September 2026 for Seth Nightingale.
This is an implementation/validation note, not a student reflection or fabricated
assessment evidence. The official README and process-evidence files are preserved.

## Changed

- db_connect.inc chooses local or live settings, uses procedural MySQLi and utf8mb4.
  Private PHP configuration supports the supplied university setup.
- functions.inc centralises HTML escaping, safe cover paths, badge classes and
  procedural prepared SELECT execution.
- index.php retrieves the latest four books with deterministic timestamp/ID order.
- books.php retrieves the catalogue and DISTINCT status values. JavaScript still
  filters the rendered data-status rows, without a new database request.
- details.php validates and binds a positive integer ID, handles 400/404/503 cases
  and shows the complete record.
- gallery.php builds cover buttons from the database and reuses the shared modal.
- add.php includes a session token and redisplays text after server errors.
- process_add.php validates fields, file extension, MIME, actual image dimensions,
  upload error and size. It generates a random filename, inserts with bound data,
  cleans up the new file on insertion failure and redirects after success.
- scripts.js permits valid POST requests instead of always blocking submission.
- Include and upload directory .htaccess files restrict direct access/execution.

## Actual verification and remaining checks

JavaScript syntax and a simulated DOM check cover filtering, gallery wrapping,
invalid-form prevention and valid-form submission.
Static checks cover local include/asset references, schema preservation,
documentation preservation and parameter/type counts.
ZIP integrity is checked before delivery.

PHP execution, SQL execution, live database access, actual upload requests,
browser rendering, W3C validation and screenshot matching remain untested.
The PHP runtime is absent from the assistant workspace. No test passes are
claimed for those areas.

## Design limits

- ISBN validation checks format rather than checksum, consistent with synthetic
  ISBN values in the supplied dataset.
- Maximum image size is 5 MiB and maximum dimension is 10000 pixels per side.
- A filesystem move and MySQL insert are not one atomic transaction; handled
  insert failures remove the new file, but a server crash could leave an orphan.
- A missing cover uses the supplied favicon instead of a broken URL.
- Local defaults assume unchanged XAMPP root credentials; live defaults are empty.
- Screenshot layout refinement and the student-written documentation remain.
- The supplied SQL file is retained unchanged; do not rerun seed INSERTs.

## Understanding the flow

A GET page loads the shared connection, executes its prepared SELECT, escapes
each returned value and builds HTML before Apache sends it to the browser.
The catalogue filter and image modal then operate in the browser.

An Add Book POST first checks the session token and validates everything again.
After upload storage and a successful INSERT, a 303 redirect sends the browser
to details.php?id=... . Refreshing that GET does not repeat the INSERT.

Review these changes yourself, record your actual tests and modifications in
process-evidence.md, and link a real commit. No commit/date history is fabricated.
