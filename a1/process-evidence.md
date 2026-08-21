# Process Evidence Log

This file combines:
1. Debugging records
2. AI (e.g., Copilot/ChatGPT) usage logs

You must maintain this file throughout development.

---

## General Instructions
- Record entries as you work (not at the end)
- Be honest and specific
- Link to commits.Each debugging record must include at least one related GitHub commit 
(using commit hash and URL).
- Superficial or fabricated entries will not receive marks

---

# 🔧 Section 1: Debugging Records

## Bug 1

**Date Identified:**  
17/08/2026

**Date Fixed:**  
17/08/2026

**File:**  
`assets/js/scripts.js`, `index.html`, `books.html`, `gallery.html`, `add.html`

**Related Commit:**  
Pending — add the commit hash and GitHub URL after committing today's changes.

**Symptom:**  
When Dark mode was saved, a newly loaded page initially declared itself as Light mode and only changed to Dark after the page finished loading. This could display a brief light-coloured flash during refresh or navigation.

**Steps to Reproduce:**  
Select `Default Dark`, refresh the page or follow a navigation link, and inspect the initial page state before the `DOMContentLoaded` handler runs.

**Root Cause:**  
Every page used `data-bs-theme="light"` in its opening HTML element, while the saved theme was not read until the custom script at the end of the body executed after the document loaded.

**Fix:**  
I added `applySavedTheme()` at the beginning of the shared external JavaScript file and moved that single script reference into the head of every page. It now applies the saved theme before the body renders, while the remaining page functions still initialise on `DOMContentLoaded`.

**Verification:**  
I checked that all four pages load `assets/js/scripts.js` exactly once in the head, confirmed the file passes `node --check`, and confirmed that no inline JavaScript was introduced. A final manual browser refresh test will be repeated before submission.

---

## Bug 2

**Date Identified:**  
18/08/2026

**Date Fixed:**  
18/08/2026

**File:**  
`assets/css/style.css`

**Related Commit:**  
Pending — add the commit hash and GitHub URL after committing today's changes.

**Symptom:**  
The white text on the bright Available and Reserved badge backgrounds had insufficient colour contrast, making the status labels harder to read and weakening accessibility.

**Steps to Reproduce:**  
Open `index.html` or `books.html`, inspect an Available or Reserved badge, and calculate the contrast between its white text and configured background colour.

**Root Cause:**  
The badges directly used the bright `#10b981` accent green and `#d97706` secondary orange as backgrounds. These colours are useful accents but are too light for small white text.

**Fix:**  
I changed the Available badge to a darker green (`#047857`) and used the supplied secondary-dark colour (`#b45309`) for Reserved. Sold continues to use the supplied slate colour. All badges explicitly use white text.

**Verification:**  
I calculated contrast ratios of 5.48:1 for Available, 5.02:1 for Reserved and 7.58:1 for Sold against white. Each exceeds the WCAG 4.5:1 target for normal text.

---
## AI Task 3

**Date:**  
21/08/2026

**Task Description:**  
Apply the lecturer's dark-mode clarification to the complete repository and add concise explanatory comments.

**Tool Used:**  
ChatGPT (Codex Work mode)

**Prompt / Input:**  
I supplied the lecturer announcement explaining that light mode must use the teal/amber defaults and dark mode must be selected automatically with `@media (prefers-color-scheme: dark)` using navy, sky-blue, amber and teal colours. I got the code snippet to be used across all 4 main html documents

**AI Output Summary:**  
The AI removed the manual theme system, implemented automatic CSS colour-scheme handling, added the clarified gradients, retained the existing accessibility and validation features, added gallery Previous/Next controls, and inserted comments explaining the main structures and functions.

**What You Accepted:**  
I accepted the automatic CSS theme approach because it directly follows the lecturer's clarification and preserves the required single CSS and JavaScript files.

**What You Changed:**  
The earlier manual selector and `localStorage` approach were removed rather than combined with the new approach. This avoids conflicting theme states and keeps the implementation easier to explain.

**Validation Performed:**  
I checked JavaScript syntax, local asset paths, IDs, semantic landmarks, required form controls, `data-status` usage, absence of inline code, and the presence of the supplied dark-mode colours. The completed ZIP was also integrity-tested.

**Issues Identified:**  
The earlier manual theme implementation was technically functional but no longer compliant after the lecturer clarified that operating-system preference must control the theme

---

# 📌 Final Reflection (End of Assessment)

**What AI was most useful for:**  
AI was most useful for mapping the long brief to the required file structure, reviewing repeated code patterns, proposing focused accessibility improvements and identifying test cases for JavaScript behaviour.

**Where AI was incorrect or misleading:**  
The initial theme interpretation used a manual website selector. Although it worked technically, it did not match the later lecturer clarification requiring automatic operating-system selection. I corrected the approach when authoritative course information became available.

**What you learned about debugging:**  
I learned to describe a bug through its observable symptom, reproduction steps and root cause before changing code. I also learned to verify fixes with targeted checks such as syntax tests, path audits, contrast calculations and browser-mode emulation.

**How your approach changed over time:**  
I moved from building all visible features first to making smaller, testable changes across separate development days. Later changes focused on accessibility, evidence, documentation and compliance with clarified requirements rather than adding unnecessary features.
