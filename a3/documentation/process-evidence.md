# BookVerse A3 — Process Evidence

Student: Seth Nightingale  
Student ID: s4178376

> Working template. Record events when they happen. Bracketed prompts are unfinished; they are not evidence. The draft AI entries describe this conversation, while personal review, acceptance, testing and commit details must be completed by the student.

AI tool chatgpt used to create README and START-HERE, as writing them up is annoying.

## 1. Development timeline

| Date | Activity | Result | Commit |
24th October - 26th October, creating the initial website and the associations (Mysql ect). Had to redo some parts due to Jacob5 being down as I now have to local develop before using MyDesktop.
26th - 28th October was spent failing to get Jacob5 working through Mydesktop and figuring out how to get Register, login ect. working
1st November: Added edit.php and process_edit php, bug fixing (incomplete)
1st November: process-evidence updates. details.php has been completed and the form submission working properly. Process-delete added, including
the ability to delete books from the library
added comments to the main repository

## 2. Debugging records

### Bug — Login rejected some valid registered usernames

**Date identified:** 26 October 2026

**Affected file:** `process_login.php`

**Symptom:**  
registration accepts usernames up to 50 characters, but login rejected usernames exceeding 50 bytes.

**Reproduction steps:**
1. Register with a username consisting of `é` repeated 30 times. This is because its an ASKII character
2. Use a valid email and matching password.
3. Log out.
4. Attempt to log in using the same credentials.

**Expected behaviour:**  
The registered user can log in.

**Root cause:**  
PHP's `strlen()` counts bytes. The original login check limited usernames
to 50 bytes, while the database supports 50 UTF-8 characters.

**Fix:**  
Changed the login input limit from 50 to 200 bytes, accommodating
up to 50 UTF-8 characters at four bytes per character. 

**Verification:**  
50 characters of `é` caused the bug to occur
**Related commit:**  

**Status:**  
Code corrected; runtime verification pending.

### Bug — price-validation mismatch between the browser form and PHP.

**Date identified:** 1St November 2026

**Affected file:** book_validation / process_add.php

**Symptom:**  
The price field uses type="number" and step="0.01". A value such as 19.990 represents a valid price of $19.99, but the PHP validation rejects it because it contains three digits after the decimal point.

**Reproduction steps:**
1. Open Add Book and complete the fields with valid details.
2. Enter 19.990 as the price.
3. Select a valid cover and submit.
4. Check whether the browser permits submission but PHP returns:Enter a price from $0.01 to $999,999.99 with at most two decimal places.
5. Change the price to 19.99 and submit again.

**Expected behaviour:**  
This was not part of the expected behaviour and should have been stopped with a client side check

**Root cause:**  
book_validation.inc

**Fix:**  
Browser number validation checks the numeric value and step; includes/book_validation.inc checks the exact text using a regular expression that permits only one or two decimal digits. (?) 

**Verification:**  
Mismatch allowed to pass through without fail check

**Related commit:**  
[Add the actual commit link.]

**Status:**  
Code corrected; runtime verification pending.

### Debugging index

| Record | Actual issue | Status | Commit |
| --- | --- | --- | --- |
| 1 | Username / Character limit fail bug
| 2 | price-validation mismatch between the browser form and PHP. (fixed)
| 3 | Rejects passwords over 72 byte limit (left due to 72 byte being a large limit)
| 4 | Books unable to be added with a cover page (fixed)
| 5 | [Not recorded yet] | Pending | Pending |

## 3. AI usage records

### AI use 1 — A3 starter codebase

**Date:** 24 October 2026

**Tool:** ChatGPT

**Task:** Prepare a partly implemented A3 codebase using the supplied assessment brief, rubric and SQL.

**Prompt/input:** The assessment ZIP and marking rubric were supplied with a request for starting PHP/SQL files

**Output:** A separate `a3` package with shared PHP includes, database-backed browsing, search, seller pages, login/logout and session helpers. Registration and add/edit/delete forms and guarded handlers were scaffolded with TODOs rather than completed writes. A separate `local_setup.sql` uses `bookverse_a3` to isolate local A3 data from A2.

**Accepted:** It laid out the basic files for me

**Rejected or modified:** I modified the request after to change the file structure a little

**Validation reported by the assistant:** JavaScript syntax, static route/include references, cover decoding and ZIP integrity were checked. The original course SQL was preserved. The supplied sample password hash was checked against its documented password. PHP/MySQL execution and deployment were not tested by the assistant.

**My validation:** works on local machine, Jacob5 innaccessible unless on Mydesktop makes it hard to validate outside of it.

**Related commit:** [Add actual commit link]

### AI use 2 — Starter project documentation

**Date:** 24 October 2026

**Tool:** ChatGPT

**Task:** Prepare base README and supporting files, with placement instructions.

**Prompt/input:** “can you make a base readme and other files that are boring to create"

**Output:** Starter README, process-evidence template and setup guide matching the partial A3 implementation. Incomplete features and unverified tests remain marked as such.

**Accepted:** Added in the after text myself

**Rejected or modified:** Modified afterwards to make easier

**Validation:** Only text files, nothing to validate

**Related commit:** [Add actual commit link]

### AI use 3 — 

**Date:** 1st November, 2026

**Tool:** Chatgpt in GPT-6 Astra

**Task/input:** Validate the files and look for bugs

**Output:** Critical bug found - price-validation mismatch between the browser form and PHP.

**Accepted:** I have accepted this as a bug and checked it manually

**Rejected or modified:** Started work on a bug fix

**Assistant validation:**  

**My validation:** 

**Related commit:** [Add the real link after committing.]

### AI use 4 — Book upload issue diagnoses

**Date:** 1 November 2026

**Tool:** ChatGPT-6 Astra

**Task:** Diagnose and repair this error in phpmyadmin / XAMPP running on VSCode: ethnightingale@Mac a3 % ls -ld /Applications/XAMPP/xamppfiles/htdocs/wp/a3/assets/images/covers
drwxr-xr-x@ 16 sethnightingale  staff  512 Nov  1 21:06 /Applications/XAMPP/xamppfiles/htdocs/wp/a3/assets/images/covers
sethnightingale@Mac a3 % sudo tail -n 40 /Applications/XAMPP/xamppfiles/logs/error_log
Password:
[Fri Oct 02 07:33:38.561722 2026] [mpm_prefork:notice] [pid 30622] AH00169: caught SIGTERM, shutting down
[Fri Oct 02 07:44:30.701296 2026] [ssl:warn] [pid 31495] AH01906: www.example.com:443:0 server certificate is a CA certificate (BasicConstraints: CA == TRUE !?)
[Fri Oct 02 07:44:30.701660 2026] [ssl:warn] [pid 31495] AH01909: www.example.com:443:0 server certificate does NOT include an ID which matches the server name
[Fri Oct 02 07:44:30.936486 2026] [ssl:warn] [pid 31496] AH01906: www.example.com:443:0 server certificate is a CA certificate (BasicConstraints: CA == TRUE !?)
[Fri Oct 02 07:44:30.936514 2026] [ssl:warn] [pid 31496] AH01909: www.example.com:443:0 server certificate does NOT include an ID which matches the server name
[Fri Oct 02 07:44:30.936688 2026] [lbmethod_heartbeat:notice] [pid 31496] AH02282: No slotmem from mod_heartmonitor
[Fri Oct 02 07:44:30.977427 2026] [mpm_prefork:notice] [pid 31496] AH00163: Apache/2.4.56 (Unix) OpenSSL/1.1.1t PHP/8.2.4 mod_perl/2.0.12 Perl/v5.34.1 configured -- resuming normal operations
[Fri Oct 02 07:44:30.977485 2026] [core:notice] [pid 31496] AH00094: Command line: '/Applications/XAMPP/xamppfiles/bin/httpd -E /Applications/XAMPP/xamppfiles/logs/error_log -D SSL -D PHP'
[Fri Oct 02 07:46:59.797036 2026] [mpm_prefork:notice] [pid 31496] AH00169: caught SIGTERM, shutting down
[Fri Oct 02 07:48:28.770461 2026] [ssl:warn] [pid 32490] AH01906: www.example.com:443:0 server certificate is a CA certificate (BasicConstraints: CA == TRUE !?)
[Fri Oct 02 07:48:28.770855 2026] [ssl:warn] [pid 32490] AH01909: www.example.com:443:0 server certificate does NOT include an ID which matches the server name
[Fri Oct 02 07:48:29.002903 2026] [ssl:warn] [pid 32491] AH01906: www.example.com:443:0 server certificate is a CA certificate (BasicConstraints: CA == TRUE !?)
[Fri Oct 02 07:48:29.003025 2026] [ssl:warn] [pid 32491] AH01909: www.example.com:443:0 server certificate does NOT include an ID which matches the server name
[Fri Oct 02 07:48:29.003448 2026] [lbmethod_heartbeat:notice] [pid 32491] AH02282: No slotmem from mod_heartmonitor
[Fri Oct 02 07:48:29.043654 2026] [mpm_prefork:notice] [pid 32491] AH00163: Apache/2.4.56 (Unix) OpenSSL/1.1.1t PHP/8.2.4 mod_perl/2.0.12 Perl/v5.34.1 configured -- resuming normal operations
[Fri Oct 02 07:48:29.043699 2026] [core:notice] [pid 32491] AH00094: Command line: '/Applications/XAMPP/xamppfiles/bin/httpd -E /Applications/XAMPP/xamppfiles/logs/error_log -D SSL -D PHP'
[Fri Oct 02 07:51:15.894770 2026] [mpm_prefork:notice] [pid 32491] AH00169: caught SIGTERM, shutting down
[Fri Oct 09 15:36:21.531392 2026] [ssl:warn] [pid 40996] AH01906: www.example.com:443:0 server certificate is a CA certificate (BasicConstraints: CA == TRUE !?)
[Fri Oct 09 15:36:21.531693 2026] [ssl:warn] [pid 40996] AH01909: www.example.com:443:0 server certificate does NOT include an ID which matches the server name
[Fri Oct 09 15:36:21.770902 2026] [ssl:warn] [pid 41000] AH01906: www.example.com:443:0 server certificate is a CA certificate (BasicConstraints: CA == TRUE !?)
[Fri Oct 09 15:36:21.770935 2026] [ssl:warn] [pid 41000] AH01909: www.example.com:443:0 server certificate does NOT include an ID which matches the server name
[Fri Oct 09 15:36:21.771123 2026] [lbmethod_heartbeat:notice] [pid 41000] AH02282: No slotmem from mod_heartmonitor
[Fri Oct 09 15:36:21.806085 2026] [mpm_prefork:notice] [pid 41000] AH00163: Apache/2.4.56 (Unix) OpenSSL/1.1.1t PHP/8.2.4 mod_perl/2.0.12 Perl/v5.34.1 configured -- resuming normal operations
[Fri Oct 09 15:36:21.806138 2026] [core:notice] [pid 41000] AH00094: Command line: '/Applications/XAMPP/xamppfiles/bin/httpd -E /Applications/XAMPP/xamppfiles/logs/error_log -D SSL -D PHP'
[Fri Oct 23 16:34:07.300849 2026] [mpm_prefork:notice] [pid 41000] AH00169: caught SIGTERM, shutting down
[Fri Oct 23 18:37:18.574191 2026] [ssl:warn] [pid 57432] AH01906: www.example.com:443:0 server certificate is a CA certificate (BasicConstraints: CA == TRUE !?)
[Fri Oct 23 18:37:18.574492 2026] [ssl:warn] [pid 57432] AH01909: www.example.com:443:0 server certificate does NOT include an ID which matches the server name
[Fri Oct 23 18:37:18.815176 2026] [ssl:warn] [pid 57433] AH01906: www.example.com:443:0 server certificate is a CA certificate (BasicConstraints: CA == TRUE !?)
[Fri Oct 23 18:37:18.815205 2026] [ssl:warn] [pid 57433] AH01909: www.example.com:443:0 server certificate does NOT include an ID which matches the server name
[Fri Oct 23 18:37:18.815369 2026] [lbmethod_heartbeat:notice] [pid 57433] AH02282: No slotmem from mod_heartmonitor
[Fri Oct 23 18:37:18.852215 2026] [mpm_prefork:notice] [pid 57433] AH00163: Apache/2.4.56 (Unix) OpenSSL/1.1.1t PHP/8.2.4 mod_perl/2.0.12 Perl/v5.34.1 configured -- resuming normal operations
[Fri Oct 23 18:37:18.852259 2026] [core:notice] [pid 57433] AH00094: Command line: '/Applications/XAMPP/xamppfiles/bin/httpd -E /Applications/XAMPP/xamppfiles/logs/error_log -D SSL -D PHP'
[Fri Oct 23 18:39:34.639509 2026] [mpm_prefork:notice] [pid 57433] AH00169: caught SIGTERM, shutting down
[Sun Nov 01 22:45:38.208193 2026] [ssl:warn] [pid 74521] AH01906: www.example.com:443:0 server certificate is a CA certificate (BasicConstraints: CA == TRUE !?)
[Sun Nov 01 22:45:38.208522 2026] [ssl:warn] [pid 74521] AH01909: www.example.com:443:0 server certificate does NOT include an ID which matches the server name
[Sun Nov 01 22:45:38.442640 2026] [ssl:warn] [pid 74522] AH01906: www.example.com:443:0 server certificate is a CA certificate (BasicConstraints: CA == TRUE !?)
[Sun Nov 01 22:45:38.442668 2026] [ssl:warn] [pid 74522] AH01909: www.example.com:443:0 server certificate does NOT include an ID which matches the server name
[Sun Nov 01 22:45:38.442856 2026] [lbmethod_heartbeat:notice] [pid 74522] AH02282: No slotmem from mod_heartmonitor
[Sun Nov 01 22:45:38.485251 2026] [mpm_prefork:notice] [pid 74522] AH00163: Apache/2.4.56 (Unix) OpenSSL/1.1.1t PHP/8.2.4 mod_perl/2.0.12 Perl/v5.34.1 configured -- resuming normal operations
[Sun Nov 01 22:45:38.485304 2026] [core:notice] [pid 74522] AH00094: Command line: '/Applications/XAMPP/xamppfiles/bin/httpd -E /Applications/XAMPP/xamppfiles/logs/error_log -D SSL -D PHP'
sethnightingale@Mac a3 %

**Prompt/input:** Added above

**Output:** our covers folder is 755, so only your Mac user can write to it. That’s likely blocking Apache from saving uploads. The log you pasted doesn’t show the upload failure itself.

For your local assignment setup, run this in VS Code:
chmod 777 /Applications/XAMPP/xamppfiles/htdocs/wp/a3/assets/images/covers

**Accepted:** This fixed it

**Rejected or modified:** I accepted the fix

**Validation reported by the assistant:** The issue is fixed

**My validation:** works on local machine

**Related commit:** [Add actual commit link]

### Template for the next meaningful AI interaction

**AI use [number] — [Task title]**

- **Date:** [Actual date]
- **Tool/model if known:** [Actual tool]
- **Task:** [What you needed help with]
- **Prompt/input:** [Exact prompt or faithful summary; identify supplied files/errors]
- **Output summary:** [What was suggested/generated]
- **Accepted:** [What you integrated and why]
- **Rejected or modified:** [What you changed or rejected and why]
- **Validation:** [Actual checks, results and remaining uncertainty]
- **Related commit:** [Real link]

Add entries progressively until there are at least five meaningful interactions. Do not count this blank template as an entry.

## 4. Testing evidence

Use the test list in README.md to plan checks. Record completed runs here with enough detail to repeat them.

| Date | Environment | Test/input | Expected | Actual | Evidence/commit |
| --- | --- | --- | --- | --- | --- |
| [Date] | [Local/Titan; browser/version] | [Specific test] | [Expected behaviour] | [Observed outcome] | [Link/path] |

Server settings, account passwords and session tokens must not appear in screenshots or copied logs. Redact secrets before adding evidence.

## 5. Final reflection — complete after development

### What AI helped with

[Explain concrete benefits using examples from your recorded interactions.]

### What required correction or personal judgement

[Explain a suggestion you checked, changed or rejected, and the evidence behind your decision.]

### What I learned about debugging and security

[Use actual examples involving queries, sessions, ownership, validation or deployment.]

### How my approach changed

[Describe what changed in your implementation/testing approach over time.]