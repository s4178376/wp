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
16/08/2026

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

# 🤖 Section 2: AI Usage Log

## AI Task 1

**Date:**  
14/08/2026

**Task Description:**  
Interpret the assessment brief and create the first functional BookVerse implementation from the supplied starter package.

**Tool Used:**  
ChatGPT (Codex Work mode)

**Prompt / Input:**  
I supplied the complete assessment brief, rubric, reference screenshots and starter `a1.zip`. I specified student ID `s4178376` and requested both Default Light and Default Dark modes.

**AI Output Summary:**  
The AI mapped the requirements to four pages and produced semantic HTML, a shared Bootstrap-based layout, an external stylesheet, and a consolidated JavaScript file. It also implemented the carousel, status filtering with `data-status`, gallery modal, add-book validation, image preview and theme selection.

**What You Accepted:**  
I accepted the required file structure, semantic layout, supplied colour palette, Bootstrap components and the separation of HTML, CSS and JavaScript.

**What You Changed:**  
To be completed after I personally review and adapt this first implementation. The related commit URL will also be added after this stage is committed.

**Validation Performed:**  
Initial automated checks were run for local asset references, HTML structure and JavaScript syntax. Browser testing, W3C validation and deployed-server testing still need to be recorded.

**Issues Identified:**  
The assessment rubric contained reused status wording (`Available/Pending/Adopted`). I rejected that wording and followed the detailed BookVerse requirement: `Available`, `Reserved` and `Sold`.

---

## AI Task 2

---

## AI Task 3

**Date:**  
18/08/2026

**Task Description:**  
Improve the Add Book form validation and accessibility during the third development-day review.

**Tool Used:**  
ChatGPT (Codex Work mode)

**Prompt / Input:**  
“we can smash through the next step now” together with the current BookVerse files and the rubric requirements for client-side validation, usability and valid code.

**AI Output Summary:**  
The AI reviewed the existing CSS, form markup and JavaScript. It identified low badge contrast and proposed accessible focus indicators, reduced-motion support, an `aria-live` image status, dynamic preview alternative text and focus movement to the first invalid field.

**What You Accepted:**  
I accepted changes that directly support the rubric: improved contrast, keyboard focus visibility, screen-reader feedback and clearer invalid-form navigation.

**What You Changed:**  
I kept the supplied teal and amber design and used darker matching shades only where needed for readable badge text. The screen-reader status was visually hidden so the required screenshot layout was not altered.

**Validation Performed:**  
I ran a JavaScript syntax check, searched for the new ARIA relationships and keyboard-focus code, confirmed that no inline code was introduced, and calculated the three badge contrast ratios.

**Issues Identified:**  
The original bright green and orange badge backgrounds did not provide sufficient contrast with small white text. The initial form also relied mainly on visual feedback, so assistive-technology announcements were added.

---

# 📌 Final Reflection (End of Assessment)

**What AI was most useful for:**  

**Where AI was incorrect or misleading:**  

**What you learned about debugging:**  

**How your approach changed over time:**  
