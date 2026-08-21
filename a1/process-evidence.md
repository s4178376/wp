# BookVerse Process Evidence Log

**Student:** Seth Nightingale  
**Student ID:** s4178376  
**Repository:** https://github.com/s4178376/wp  
**Project:** BookVerse – Online Bookstore Platform  

This file records debugging work, use of AI tools and the iterative development process followed during Assessment 1.

---

## Section 1: Debugging Records

### Bug 1 – Saved theme displayed too late

**Date identified:** 17/08/2026  
**Date fixed:** 17/08/2026  

**Files involved:**

- `index.html`
- `books.html`
- `gallery.html`
- `add.html`
- `assets/js/scripts.js`

**Related commit:**  
[8c062e361883a0b805cc5b0ef813fbf07a71356a 
https://github.com/s4178376/wp/commit/8c062e361883a0b805cc5b0ef813fbf07a71356a]

**Symptom:**  
When the earlier manual Dark theme was selected, a newly loaded page initially appeared in Light mode before changing to Dark mode. This caused a brief flash of the light design when refreshing or navigating between pages.

**Steps to reproduce:**

1. Select the earlier Default Dark option.
2. Refresh the page or follow a navigation link.
3. Observe the initial page appearance before JavaScript finishes loading.

**Root cause:**  
Every page initially declared itself as Light mode. The saved theme preference was not read until the `DOMContentLoaded` event, after the page had already started rendering.

**Fix:**  
At this stage of development, the saved theme was applied earlier from the shared external JavaScript file. The script was referenced from the document head, while page-specific functionality continued to initialise after `DOMContentLoaded`.

**Verification:**  
I checked that the four pages loaded the shared JavaScript file once and that no inline JavaScript was introduced. The JavaScript file also passed a Node syntax check.

**Later development:**  
This manual theme system was eventually removed after the lecturer clarified that Light and Dark modes must be selected automatically using `prefers-color-scheme`. This record remains because it documents a genuine earlier debugging step.

---

### Bug 2 – Status badges had insufficient contrast

**Date identified:** 17/08/2026  
**Date fixed:** 18/08/2026  

**File involved:**  
`assets/css/style.css`

**Related commit:**  
[70a74f86bf374b0e2cdffcaa941852376229819a
https://github.com/s4178376/wp/commit/70a74f86bf374b0e2cdffcaa941852376229819a]

**Symptom:**  
The white text used on the Available and Reserved status badges was difficult to read against the original bright green and orange backgrounds.

**Steps to reproduce:**

1. Open `index.html` or `books.html`.
2. Locate the Available and Reserved badges.
3. Compare the small white text against their original background colours.
4. Test the colour combinations using a contrast checker.

**Root cause:**  
The badges used bright accent colours directly as their backgrounds. These colours were suitable for decorative elements but did not provide sufficient contrast for small white text.

**Fix:**  
I changed the Available badge background to darker green `#047857` and the Reserved badge to darker amber `#b45309`. The Sold badge retained its darker slate colour. White text remained consistent across all status badges.

**Verification:**  
The calculated contrast ratios against white were:

- Available: 5.48:1
- Reserved: 5.02:1
- Sold: 7.58:1

These exceed the WCAG target of 4.5:1 for normal text.

---

### Bug 3 – Dark mode did not match the clarified requirement

**Date identified:** 21/08/2026  
**Date fixed:** 21/08/2026  

**Files involved:**

- `index.html`
- `books.html`
- `gallery.html`
- `add.html`
- `assets/css/style.css`
- `assets/js/scripts.js`

**Related commit:**  
[814f76ec417495f02f4958a5fd674fdea24ca6df
https://github.com/s4178376/wp/commit/814f76ec417495f02f4958a5fd674fdea24ca6df]

**Symptom:**  
The earlier version required the visitor to select Default Light or Default Dark manually. Its Dark mode also retained a teal navigation bar rather than matching the navy-blue Dark mode shown in the assessment screenshots.

**Steps to reproduce:**

1. Set macOS, Windows or browser emulation to Dark mode.
2. Open any BookVerse page.
3. Observe that the earlier site did not automatically follow the system setting.
4. Compare the navigation and footer colours with the supplied Dark mode screenshots.

**Root cause:**  
The original requirement was initially interpreted as asking for a manual theme selector. The lecturer later clarified that the operating system or browser must select the mode automatically using `@media (prefers-color-scheme: dark)`.

**Fix:**  
I removed:

- The manual theme selector
- The `data-bs-theme` attributes
- Theme-related `localStorage`
- Theme-switching JavaScript

The light teal and amber palette is now the default CSS design. A `prefers-color-scheme: dark` media query applies the lecturer-supplied Dark mode colours:

- Page background: `#0f172a` to `#020617`
- Navigation and footer: `#0c4a6e` and `#082f49`
- Highlights: `#38bdf8`, `#f59e0b` and `#14b8a6`
- Main Dark mode text: `#f1f5f9`

**Verification:**  
I searched the repository and confirmed that the theme selector, `data-bs-theme`, saved theme code and theme-related `localStorage` were removed. I also confirmed that the supplied Dark mode colours and `prefers-color-scheme: dark` query were present in the stylesheet.

Dark mode can be tested using:

- macOS: System Settings → Appearance → Dark
- Windows: Settings → Personalisation → Colours → Dark
- Chrome DevTools: Rendering → Emulate CSS media feature `prefers-color-scheme: dark`

---

### Bug 4 – Gallery modal failed HTML validation

**Date identified:** 21/08/2026  
**Date fixed:** 21/08/2026  

**File involved:**  
`gallery.html`

**Related commit:**  
[71ccc91d5df40bedc1479b7545ae5e0a2c6fed38
https://github.com/s4178376/wp/commit/71ccc91d5df40bedc1479b7545ae5e0a2c6fed38]

**Symptom:**  
The Nu HTML Checker reported that `aria-labelledby` could not be used on the outer modal `<div>` because the element did not have an appropriate ARIA role. A later edited version also reported a stray closing `</div>` tag.

**Validator messages:**

- `The aria-labelledby attribute must not be specified on any div element unless the element has a role value...`
- `Stray end tag div.`

**Steps to reproduce:**

1. Open the Nu HTML Checker at https://validator.w3.org/nu/
2. Validate `gallery.html`.
3. Review the errors reported around the Bootstrap modal.

**Root cause:**  
Bootstrap JavaScript manages modal behaviour, but the validator only evaluates the submitted HTML. The outer modal element used `aria-labelledby` without explicitly declaring `role="dialog"`. While correcting it, the compact one-line modal markup made the nested closing elements difficult to track.

**Fix:**  
I added `role="dialog"` to the outer modal element and reformatted the complete modal using clearly nested elements:

1. Outer modal
2. Modal dialog
3. Modal content
4. Header, body and footer

I also retained the IDs required by `scripts.js`:

- `gallery-modal`
- `gallery-modal-label`
- `modal-image`
- `previous-cover`
- `next-cover`

The Google Fonts URL was also updated to use `&amp;` between query parameters.

**Verification:**  
I checked that every opening modal `<div>` has a corresponding closing tag and that `aria-labelledby` points to the existing `gallery-modal-label` heading.

**Final validator result:**  
[REPLACE WITH “PASSED WITH NO ERRORS” AFTER REVALIDATING]

---

### Bug 5 – Add Book page failed HTML validation

**Date identified:** 21/08/2026  
**Date fixed:** 21/08/2026  

**File involved:**  
`add.html`

**Related commit:**  
[8063952b15d3ed0625c04e615fb2fb38e93dcd51
https://github.com/s4178376/wp/commit/8063952b15d3ed0625c04e615fb2fb38e93dcd51]

**Symptoms:**  
The Nu HTML Checker reported three issues:

1. The preview `<img>` did not have a `src` or `srcset`.
2. The required Availability Status selector started with a non-empty value.
3. The form panel used a `<section>` without its own heading.

**Steps to reproduce:**

1. Validate `add.html` using the Nu HTML Checker.
2. Review the errors associated with the preview image and status selector.
3. Review the warning associated with the form panel section.

**Root causes:**

- The preview image was intended to receive its source from JavaScript after the user selected a file, but static HTML validation still requires an initial `src` or `srcset`.
- A required single-choice `<select>` must begin with an empty placeholder option if the user is expected to make a selection.
- The form panel used a semantic `<section>` even though it did not contain its own heading.

**Fix:**  

- Added a valid initial image path to the preview `<img>`.
- Kept the preview hidden through CSS until JavaScript adds the `is-visible` class.
- Added an empty disabled placeholder to Availability Status:

  ```html
  <option value="" selected disabled>Select a status</option>

  # Section 2: AI Usage Log

## AI Task 1 – Initial website structure

**Date:**  
14/08/2026

**Tool used:**  
ChatGPT in Codex Work mode

**Task description:**  
Interpret the assessment brief and help create the initial BookVerse website structure from the supplied starter package.

**Prompt/input:**  
I supplied the assessment instructions, marking rubric, reference screenshots and starter ZIP file. I also provided my student ID and explained that the website required Light and Dark designs.

**AI output summary:**  
AI mapped the requirements to the four required pages:

- `index.html`
- `books.html`
- `gallery.html`
- `add.html`

It proposed semantic page structures, reusable navigation and footer components, Bootstrap layouts, one shared stylesheet and one consolidated JavaScript file. It also helped implement the carousel, catalogue filter, gallery modal and Add Book form.

**What I accepted:**  
I accepted the overall file structure, semantic layout, Bootstrap grid, responsive navigation, external CSS and consolidated JavaScript approach.

**What I changed or rejected:**  
The rubric included reused wording referring to Available, Pending and Adopted. I rejected those values because the BookVerse-specific instructions and screenshots required Available, Reserved and Sold.

I also kept the implementation within the Stage 1 static-site requirements and did not add a database or server-side submission.

**Validation performed:**  
I checked navigation links, local asset paths, semantic elements and JavaScript syntax. W3C validation and detailed browser testing were completed during later development stages.

**Related commit:**  
[7f4f127b7e7b06f6270cba00bec6b295729ce4c6
https://github.com/s4178376/wp/commit/7f4f127b7e7b06f6270cba00bec6b295729ce4c6]

---

## AI Task 2 – Theme behaviour review


---

## AI Task 2 – Form validation and accessibility

**Date:**  
18/08/2026

**Tool used:**  
ChatGPT in Codex Work mode

**Task description:**  
Review the Add Book form and improve its validation, keyboard support and accessibility.

**Prompt/input:**  
I asked AI to complete another small development step using the existing files and the assessment criteria for validation and usability.

**AI output summary:**  
AI reviewed the form markup, JavaScript and stylesheet. It suggested:

- Bootstrap invalid-feedback messages
- File-extension validation
- Local cover-image preview
- An `aria-live` image status
- Dynamic preview alternative text
- Moving focus to the first invalid field
- Visible keyboard focus indicators
- Reduced-motion support
- Improved status badge contrast

**What I accepted:**  
I accepted the improvements that directly supported the validation, accessibility and usability criteria.

**What I changed or rejected:**  
I kept the screen-reader status visually hidden so it could provide accessibility feedback without changing the required visual layout. I retained the supplied teal and amber palette and used darker related shades only where needed for readable badge text.

**Validation performed:**  
I ran a JavaScript syntax check, checked the relationships between labels and controls, reviewed the ARIA attributes and calculated the badge contrast ratios.

**Related commit:**  
[70a74f86bf374b0e2cdffcaa941852376229819a
https://github.com/s4178376/wp/commit/70a74f86bf374b0e2cdffcaa941852376229819a]

---

## AI Task 3 – Project documentation

**Date:**  
20/08/2026

**Tool used:**  
ChatGPT in Codex Work mode

**Task description:**  
Turn the starter README into BookVerse-specific documentation and prepare the project for validation and deployment.

**Prompt/input:**  
I supplied the private repository address, `https://github.com/s4178376/wp`, and asked what work should be completed next.

**AI output summary:**  
AI helped organise README sections covering:

- Project overview
- File structure
- Technologies used
- Page features
- JavaScript functionality
- Responsive design
- Accessibility
- Validation and testing
- Deployment
- AI usage
- Project limitations

**What I accepted:**  
I accepted descriptions that corresponded directly to the submitted HTML, CSS and JavaScript files.

**What I changed or rejected:**  
I did not include invented commit hashes, deployment results or W3C validation results. Information that had not yet been confirmed remained marked as pending.

**Validation performed:**  
I compared the README descriptions with the implementation and searched for unanswered starter-template placeholders.

**Related commit:**  
[814f76ec417495f02f4958a5fd674fdea24ca6df
https://github.com/s4178376/wp/commit/814f76ec417495f02f4958a5fd674fdea24ca6df]

---

## AI Task 4 – Automatic Dark Mode and Final HTML Validation

**Date:**  
21/08/2026

**Tool Used:**  
ChatGPT in Codex Work mode

**Task Description:**  
Apply the lecturer’s clarified Dark mode requirements and correct the final HTML validation errors without breaking the existing Bootstrap components or JavaScript functionality.

**Prompt / Input:**  
I supplied the lecturer’s announcement explaining that Light mode must use the teal and amber default design and Dark mode must be selected automatically using `@media (prefers-color-scheme: dark)`. I also supplied the exact errors reported by the Nu HTML Checker for `gallery.html` and `add.html`.

**AI Output Summary:**  
AI helped remove the earlier manual theme system and replace it with automatic CSS colour-scheme handling. Light mode remained the default, while a `prefers-color-scheme: dark` media query applied the lecturer-supplied navy, sky-blue, amber, teal and near-white colours.

AI also explained and corrected the HTML validation problems involving:

- The gallery modal’s missing `role="dialog"`
- Incorrect or unclear modal element nesting
- A preview image without a `src`
- An invalid first option in a required `select`
- A `section` element without its own heading
- Unescaped ampersands in the Google Fonts URL

**What You Accepted:**  
I accepted the automatic CSS theme approach because it directly followed the lecturer’s clarification. I also accepted the HTML corrections because they were based on the actual validator results and preserved the required Bootstrap and JavaScript functionality.

**What You Changed:**  
I removed the earlier manual theme selector, `data-bs-theme`, theme-related `localStorage` and theme-switching JavaScript rather than combining them with the automatic approach.

I checked that the corrected HTML retained the IDs expected by `assets/js/scripts.js`, including:

- `gallery-modal`
- `gallery-modal-label`
- `modal-image`
- `previous-cover`
- `next-cover`
- `add-book-form`
- `image-path`
- `image-preview`
- `image-feedback`
- `image-status`

I also kept the project within the Stage 1 static-site requirements and did not add server-side form submission.

**Validation Performed:**  
I checked:

- The presence of `@media (prefers-color-scheme: dark)`
- The lecturer-supplied Dark mode colours
- The removal of the manual theme system
- Correct modal element nesting
- The presence of `role="dialog"`
- Required form placeholder options
- Valid image source attributes
- Matching JavaScript element IDs
- The absence of inline styles and inline JavaScript
- JavaScript syntax
- Nu HTML Checker results

**Final Validation Results:**

- `index.html`: [ADD FINAL RESULT]
- `books.html`: [ADD FINAL RESULT]
- `gallery.html`: [ADD FINAL RESULT]
- `add.html`: [ADD FINAL RESULT]

**Issues Identified:**  
The earlier manual theme implementation was functional but no longer complied with the lecturer’s clarified requirements. The HTML also appeared functional in the browser despite containing standards-validation problems, demonstrating why generated code must still be manually reviewed and validated.

**Related Commit:**  
[1ae4eeda97d3627f84303e932a35b29ec97c2041
https://github.com/s4178376/wp/commit/1ae4eeda97d3627f84303e932a35b29ec97c2041]

---

# Final Reflection

## What AI Was Most Useful For

AI was most useful for breaking the long assessment brief into specific technical requirements and organising those requirements into four HTML pages, one shared stylesheet and one consolidated JavaScript file. It also helped review repeated structures, explain validator messages and identify focused accessibility and usability improvements.

AI helped me understand why particular changes were needed rather than only providing replacement code. Examples included explaining how `data-status` supports catalogue filtering, how `FileReader` creates a local image preview and why an element using `aria-labelledby` requires an appropriate role.

## Where AI Was Incorrect or Required Correction

The original theme interpretation used a manual Light and Dark selector. Although this feature worked technically, it did not match the lecturer’s later clarification that the operating system or browser must select the theme automatically.

After receiving the clarification, I evaluated the existing implementation and removed the selector, `data-bs-theme`, saved theme preference and related JavaScript. I replaced them with a CSS `prefers-color-scheme` media query.

The AI-generated HTML also required further validation. The Nu HTML Checker identified problems involving the gallery modal’s ARIA role, modal nesting, a missing preview-image source, a required selector and a section without a heading. This showed that AI-generated code should not be assumed to be correct without testing.

## What I Learned About Debugging

I learned to describe a problem using its observable symptom, reproduction steps and root cause before changing the code. This made it easier to choose a targeted fix and verify whether the fix addressed the actual problem.

The validator’s line and column references helped locate structural HTML errors. I also learned that a page can appear to work in a browser while still containing invalid or inaccessible markup. Effective testing therefore needs to include HTML validation, JavaScript syntax checks, browser behaviour, keyboard navigation, responsive layouts and colour contrast.

## How I Evaluated AI Output

I evaluated AI suggestions by comparing them with:

- The written assessment instructions
- The lecturer’s Dark mode clarification
- The supplied reference screenshots
- The existing CSS classes and JavaScript selectors
- Nu HTML Checker results
- Browser behaviour
- Accessibility and colour-contrast requirements

I accepted suggestions that directly supported the assessment requirements. I changed or rejected suggestions that no longer matched the final instructions, introduced unnecessary complexity or could not be verified.

I also checked that revised HTML retained the IDs used by the shared JavaScript. This was important because changing an ID in the HTML without updating its JavaScript selector would break the related functionality.

## How My Development Approach Changed

I began by implementing the main visible features, including the navigation, carousel, catalogue, gallery and form. I then moved toward smaller and more testable updates across separate development days.

Later development concentrated on accessibility, validation, documentation, automatic Dark mode and deployment instead of adding unnecessary features. This incremental approach created a clearer Git history and made it easier to connect individual changes with debugging records and AI usage entries.

## What I Learned About HTML, CSS, Bootstrap and JavaScript

I learned that semantic HTML elements provide meaning in addition to visual structure. The website uses `header`, `nav`, `main` and `footer` landmarks so browsers and assistive technologies can understand the purpose of each area.

I used Bootstrap’s grid system and responsive breakpoints to change the number of gallery and book-card columns at different viewport widths. Bootstrap also provides the responsive navigation, carousel, modal, form controls and utility classes.

The custom stylesheet applies the BookVerse brand design while keeping styling separate from the HTML. Light mode is the default, and Dark mode overrides the necessary colours using `@media (prefers-color-scheme: dark)`.

The shared JavaScript file initialises only the functionality present on the current page. It filters book rows using `data-status`, updates the gallery modal, provides circular Previous and Next navigation, validates uploaded file extensions and creates a local image preview using `FileReader`.

## What I Can Explain During the Demonstration

I can explain:

- How semantic HTML structures each page
- Why each page has a unique title
- How the shared navigation links the four pages
- How Bootstrap breakpoints create responsive layouts
- How the Bootstrap carousel works
- How the gallery buttons open the Bootstrap modal
- Why the modal uses `role="dialog"` and `aria-labelledby`
- How the catalogue uses `data-status` attributes for filtering
- How JavaScript changes the gallery image and modal title
- How the Previous and Next gallery controls wrap around the collection
- How the Add Book form uses required fields and invalid feedback
- How `checkValidity()` tests the form
- How `FileReader` displays a local cover preview
- Why the project uses one shared CSS file and one JavaScript file
- How `prefers-color-scheme` automatically selects Dark mode
- Why inline styling and inline JavaScript were avoided
- How HTML validation helped identify issues that were not visually obvious