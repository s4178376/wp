# BookVerse A3 — Process Evidence

Student: Seth Nightingale  
Student ID: s4178376

> Working template. Record events when they happen. Bracketed prompts are unfinished; they are not evidence. The draft AI entries describe this conversation, while personal review, acceptance, testing and commit details must be completed by the student.

AI tool chatgpt used to create README and START-HERE, as writing them up is annoying.

## 1. Development timeline

| Date | Activity | Result | Commit |
24th October - 26th October, creating the initial website and the associations (Mysql ect). Had to redo some parts due to Jacob5 being down as I now have to local develop before using MyDesktop.

## 2. Debugging records

No bugs found yet

### Bug [number] — [Short description]
- **Template created**
- **Date identified:** [Actual date]
- **Date fixed:** [Actual date or unresolved]
- **Affected files/environment:** [Local or Titan, file names]
- **Symptom:** [What you observed, including the exact error]
- **Reproduction steps:** [Steps that trigger the issue]
- **Root cause:** [Confirmed cause; mark hypotheses as unconfirmed]
- **Fix:** [Specific change and why it addresses the cause]
- **Verification:** [Test steps and actual before/after results]
- **Related commit:** [Actual hash and GitHub URL]
- **Status:** [Open / fixed and verified]

### Debugging index

| Record | Actual issue | Status | Commit |
| --- | --- | --- | --- |
| 1 | [Not recorded yet] | Pending | Pending |
| 2 | [Not recorded yet] | Pending | Pending |
| 3 | [Not recorded yet] | Pending | Pending |
| 4 | [Not recorded yet] | Pending | Pending |
| 5 | [Not recorded yet] | Pending | Pending |

## 3. AI usage records

### AI use 1 — A3 starter codebase

**Date:** 24 October 2026

**Tool:** ChatGPT

**Task:** Prepare a partly implemented A3 codebase using the supplied assessment brief, rubric and SQL.

**Prompt/input:** The assessment ZIP and marking rubric were supplied with a request for starting PHP/SQL files and a half-written codebase, initially without README or AI declarations.

**Output:** A separate `a3` package with shared PHP includes, database-backed browsing, search, seller pages, login/logout and session helpers. Registration and add/edit/delete forms and guarded handlers were scaffolded with TODOs rather than completed writes. A separate `local_setup.sql` uses `bookverse_a3` to isolate local A3 data from A2.

**Accepted:** [Describe the parts you actually integrated and reviewed. Delivery alone does not confirm acceptance.]

**Rejected or modified:** [Record your changes and reasons, or state none if accurate.]

**Validation reported by the assistant:** JavaScript syntax, static route/include references, cover decoding and ZIP integrity were checked. The original course SQL was preserved. The supplied sample password hash was checked against its documented password. PHP/MySQL execution and deployment were not tested by the assistant.

**My validation:** [Record your own commands, browser tests and outcomes. Pending until performed.]

**Related commit:** [Add actual commit link]

### AI use 2 — Starter project documentation

**Date:** 24 October 2026

**Tool:** ChatGPT

**Task:** Prepare base README and supporting files, with placement instructions.

**Prompt/input:** “can you make a base readme and other files I told you not to and tell me where to put them”

**Output:** Starter README, process-evidence template and setup guide matching the partial A3 implementation. Incomplete features and unverified tests remain marked as such.

**Accepted:** [Record which sections you used after review.]

**Rejected or modified:** [Record your edits and reasoning.]

**Validation:** [Compare these descriptions against your current code and actual test results.]

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

### What I can explain during the demonstration

[Identify code you can explain: request flow, prepared statements, hashing, sessions, owner checks, uploads and JavaScript. Record any topics you still need to practise.]
