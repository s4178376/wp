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
(e.g., 15/03/2026)

**Date Fixed:**  
(e.g., 15/03/2026)

**File:**  
(e.g., about.html)

**Related Commit:**  
(e.g., abc1234)

**Symptom:**  
What went wrong?

**Steps to Reproduce:**  
How can the issue be triggered?

**Root Cause:**  
Why did the issue occur?

**Fix:**  
What did you change?

**Verification:**  
How did you confirm the fix?

---

## Bug 2

**Date Identified:**  

**Date Fixed:**  

**File:**  

**Related Commit:**  

**Symptom:**  

**Steps to Reproduce:**  

**Root Cause:**  

**Fix:**  

**Verification:**  

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

**Date:**  

**Task Description:**  

**Tool Used:**  

**Prompt / Input:**  

**AI Output Summary:**  

**What You Accepted:**  

**What You Changed:**  

**Validation Performed:**  

**Issues Identified:**  

---

# 📌 Final Reflection (End of Assessment)

**What AI was most useful for:**  

**Where AI was incorrect or misleading:**  

**What you learned about debugging:**  

**How your approach changed over time:**  
