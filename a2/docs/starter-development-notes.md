# BookVerse Part 2 starter development notes

These are assistant-generated reference notes from the earlier scaffold.
The official student README is ../README.md; complete that file yourself
as development progresses. The official evidence log is ../process-evidence.md.
The earlier AI draft is retained here as draft-ai-scaffold-record.md.
The supplied Part 2 favicon now replaces the earlier Part 1 favicon.

Author: Seth Nightingale (s4178376)

## Current stage

This is a structure-first learning scaffold, not a completed assessment.
Place the a2 folder inside your existing wp repository beside a1.
Do not replace a1 or initialise a new Git repository inside a2.

## Implemented starting structure

Five PHP pages share header.inc, nav.inc and footer.inc.
The homepage contains four static carousel images. The shared stylesheet
and original cover assets were reused from the available Part 1 copy.
Navigation highlights the current page. One custom JavaScript file provides
starter filter/modal logic plus local image preview and browser validation.

## Technologies and coding choices

PHP renders shared includes, titles and navigation; HTML and Bootstrap 5
provide page structure. External CSS provides the BookVerse theme.
External JavaScript handles browser interactions. __DIR__ anchors include paths.
htmlspecialchars() escapes the shared output.
No database library is used yet. Future database work must use procedural
MySQLi prepared statements, with escaped output.

## Remaining implementation

- Automatic local/Coreteaching connection selection in db_connect.inc.
- Latest four database records on the homepage.
- Catalogue rows and status options generated from database data.
- Selected book retrieval, invalid-ID handling and database gallery.
- Full server-side field and image validation, unique upload filenames,
  prepared INSERT, failure handling and successful redirect.
- Final screenshot/layout compliance and complete validation.
- Deployment to Titan and Jacob 5.

The simplified form currently checks required fields and numeric bounds.
It does not verify ISBN checksums. File extensions alone do not verify image contents.
process_add.php deliberately returns HTTP 501 and performs no saving.

## Database setup deferred

database/bookverse.sql is the unmodified supplied SQL.
Do not import it yet unless ready to configure a database.
For localhost it creates and selects bookverse. For Jacob 5, omit the
CREATE DATABASE and USE bookverse statements and select s4178376.
Repeated imports can duplicate sample records; the seed INSERT is not idempotent.
Do not change supplied table or column names.

## Editing and testing

XAMPP setup is deferred. Editing files does not require a running server.
Rendering PHP includes and testing uploads/database behaviour requires a
PHP-capable environment later; VS Code Live Server does not execute PHP.
JavaScript syntax and source checks are recorded in process-evidence.md.
No browser, PHP runtime, database, W3C or live deployment pass is claimed.

## Deployment plan

Planned website directory: ~/public_html/wp/a2/
Planned URL: https://titan.csit.rmit.edu.au/~s4178376/wp/a2/
Live database: s4178376 on Jacob 5 (actual hostname/settings still to confirm).
Course authentication .htaccess belongs in public_html, not a2.
No authentication configuration is generated in this starter.
Do not publish .inc files containing secrets without protecting them from direct access.
Review RMIT deployment instructions before changing permissions or authentication.

## Git process

Keep working in the existing wp repository. a2/.gitignore ignores the covers
directory without changing your repository-root ignore rules.
Git ignoring files does not remove files already tracked.
Include cover files manually in the final ZIP and deployment.
The brief requires at least five meaningful commits across five calendar days;
the rubric also says no one day should contain more than 50 percent of commits.
Use real development sessions and actual dates; no backdating.
No commit or push has been performed by this scaffold.

## AI use and student documentation

ChatGPT generated this starter; review and adapt it before committing.
The associated draft AI record is in process-evidence.md.
This is not the completed student-written README required for submission.
Replace the starter descriptions with your own explanation of the finished
implementation, actual tests, Git process, confirmed deployment and limitations.
