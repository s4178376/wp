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
| 3 | Rejects passwords over 72 byte limit (fixed)
| 4 | [Not recorded yet] | Pending | Pending |
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