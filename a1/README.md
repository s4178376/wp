# COSC2446 Web Programming – Assessment 1
# BookVerse Online Bookstore Platform

## Student Details

| Item | Details |
|---|---|
| Student name | Seth Nightingale |
| Student ID | s4178376 |
| GitHub repository URL | <https://github.com/s4178376/wp> |
| Deployed website URL | https://titan.csit.rmit.edu.au/~s4178376/a1/books.html |

## 1. Project Overview

BookVerse is a responsive static bookstore website that lets visitors browse a catalogue, filter books by availability, view cover artwork and validate a new book listing. It is designed for readers who want a simple visual catalogue and for users preparing book information for a future dynamic version. The site uses HTML5, CSS3, Bootstrap 5 and vanilla JavaScript. Assessment 1 does not store or submit form data because it is the static first stage of the platform.

## 2. Copilot and AI Coding Instructions

The following instructions were used to evaluate AI-assisted suggestions:

- Use only HTML5, CSS3, Bootstrap 5 and vanilla JavaScript.
- Do not add React, Vue, jQuery, server-side code, databases or build tools.
- Keep `index.html`, `books.html`, `gallery.html` and `add.html`.
- Use only `assets/css/style.css` and `assets/js/scripts.js` for custom code.
- Do not use inline CSS, inline JavaScript or inline event handlers.
- Use semantic `header`, `nav`, `main` and `footer` elements on every page.
- Use Bootstrap rows, columns and responsive utilities for page layout.
- Keep navigation, branding, themes and the footer consistent across pages.
- Make every Add Book field required and connect every control to a label.
- Accept only `jpg`, `jpeg`, `png`, `gif` and `webp` covers and show a local preview with `FileReader`.
- Use a Bootstrap modal for gallery previews.
- Filter rows with vanilla JavaScript and the required `data-status` attribute using `Available`, `Reserved` and `Sold`.
- Preserve keyboard access, alternative text, readable contrast, visible focus and clear validation feedback.
- Review, test and adapt AI output, then document meaningful use and commits honestly in `process-evidence.md`.

## 3. Website Structure

| File | Purpose |
|---|---|
| `index.html` | Home page with four-slide carousel and featured-book cards. |
| `books.html` | Responsive catalogue table with a status filter. |
| `gallery.html` | Twelve-cover responsive gallery with a full-size modal. |
| `add.html` | Required Add Book form with validation and image preview. |

## 4. Project Folder Structure

```text
a1/
├── assets/
│   ├── css/style.css
│   ├── js/scripts.js
│   └── images/
│       ├── favicon.svg
│       └── covers/ (1.png to 12.png)
├── index.html
├── books.html
├── gallery.html
├── add.html
├── README.md
└── process-evidence.md
```

## 5. Technologies Used

| Technology | Use in BookVerse |
|---|---|
| HTML5 | Semantic structure, accessible content, tables and forms. |
| CSS3 | Shared palette, light/dark themes, responsive refinements and focus states. |
| Bootstrap 5 | Navbar, carousel, grid, cards, table wrapper, forms and modal. |
| JavaScript | Status filtering, gallery navigation and form validation. |
| Google Fonts | Righteous headings and Elms Sans body text. |
| Material Icons | Visual labels in the brand, navigation and headings. |
| GitHub | Private repository and progressive development history. |
| Coreteaching | Required production host; details will be added after deployment. |
| ChatGPT | Requirement analysis, code review, debugging and documentation support. |

## 6. Design and Layout

The light design uses the supplied teal and amber brand palette. Automatic dark mode is implemented with `@media (prefers-color-scheme: dark)` as clarified by the lecturer. It changes the page to a deep navy gradient, the navigation and footer to navy blue, the accent strips to amber/sky-blue/teal, and the text to near-white. The browser or operating system selects the mode; no manual switch is required. Righteous is used for headings and the brand; Elms Sans is used for body copy, controls and navigation.

Bootstrap containers, rows and responsive columns control the layout. Featured cards change from one to two to four columns, the gallery changes from two to six columns, the navbar collapses on smaller screens and the book table uses a responsive scrolling wrapper.

## 7. Required Features

| Feature | Page | Implementation |
|---|---|---|
| Carousel | `index.html` | Four supplied images with captions and controls. |
| Responsive books | `index.html` | Eight cards in a responsive grid. |
| Book table | `books.html` | Twelve books with catalogue details and status. |
| Status filter | `books.html` | Shows/hides rows by comparing the dropdown with `data-status`. |
| Gallery grid | `gallery.html` | Twelve supplied covers in responsive columns. |
| Image modal | `gallery.html` | Bootstrap modal updated from cover data attributes with Previous/Next navigation. |
| Add Book form | `add.html` | Eleven required and labelled controls. |
| Image validation | `add.html` | Extension allow-list and custom validity message. |
| Image preview | `add.html` | `FileReader` displays the image without uploading it. |

## 8. JavaScript Functionality

All custom behaviour is consolidated in `assets/js/scripts.js`, while light/dark presentation is handled entirely by CSS. Page-specific initialisers safely return when their target elements are absent. The book filter reads `data-status`; gallery listeners copy data attributes into the modal and cycle through the 12 covers; and the form validates extensions, creates an accessible preview and focuses the first invalid control. No inline JavaScript is used.

## 9. Form Validation

Every field is mandatory and each control is connected to a visible label. Number controls apply ranges and steps, the ISBN field uses a pattern and the agreement is a required checkbox. JavaScript compares the cover extension with `jpg`, `jpeg`, `png`, `gif` and `webp`. An invalid file receives a custom message and no preview; a valid file is shown with `FileReader`. An `aria-live` status announces the result. Valid submission only displays a Stage 1 confirmation because no data is sent.

## 10. Accessibility and Usability

Pages have unique titles, semantic landmarks, meaningful image alternative text, labelled controls, `aria-current` navigation and an accessible modal. Decorative icons are hidden from assistive technology. Keyboard users receive visible focus indicators, reduced-motion preferences are respected and badge combinations exceed 4.5:1 contrast with white text. Navigation and layout remain consistent at different widths.

## 11. Testing and Validation

| Automated/local check | Result | Notes |
|---|---|---|
| JavaScript syntax | Pass | `scripts.js` passes `node --check`. |
| Local asset references | Pass | No missing relative paths. |
| Duplicate element IDs | Pass | No duplicate IDs detected within a page. |
| Required form controls | Pass | All 11 required controls detected. |
| Form labels | Pass | Every form control has an associated label. |
| ARIA references | Pass | All `aria-describedby` IDs resolve. |
| Inline code check | Pass | No inline styles or event handlers found. |
| Badge contrast | Pass | Available 5.48:1, Reserved 5.02:1, Sold 7.58:1. |
| W3C HTML validation | Pending | Validate all four final files before submission. |
| W3C CSS validation | Pending | Validate final `style.css` before submission. |
| Manual browser testing | Pending | Record themes, screen sizes and components. |

## 12. Deployment

| Item | Details |
|---|---|
| Deployed website URL | Pending |
| Coreteaching server | Titan (`titan.csit.rmit.edu.au`) |
| Deployment folder | `public_html/a1` |
| `.htaccess` location | `public_html` — not inside `a1` |

After deployment, each page will be opened from the live URL and checked for navigation, images, fonts, CSS, JavaScript, carousel, modal, filtering and validation. The final URL and results will then replace the pending entries.

## 13. Git and Development Process

The project is stored in the private `wp` repository under the required `a1` directory. Development is divided into stages covering the base site, theme correction, debugging, accessibility, validation and deployment. Commit messages describe these changes rather than using generic messages. Debugging and AI records are maintained progressively and must link to matching commits before submission.

## 14. AI Use Declaration

- [x] I used AI tools meaningfully during this assessment.
- [x] I recorded meaningful AI use in `process-evidence.md`.
- [x] I reviewed, tested and adapted AI-assisted output.
- [x] I can explain all AI-assisted code submitted.

ChatGPT was used to interpret requirements, propose approaches, identify testable issues and improve documentation. Suggestions were checked against the brief, selectively accepted and adapted. The process log records prompts, modifications, rejected assumptions and verification.

## 15. Process Evidence

| Requirement | Status |
|---|---|
| `process-evidence.md` included | Yes |
| At least two debugging records | Yes |
| At least two meaningful AI records | Yes |
| Relevant commit links | Pending insertion from private GitHub history |

## 16. Known Limitations

- Assessment 1 is static, so the form validates input but does not save or transmit it.
- Bootstrap, Google Fonts and Material Icons are loaded from CDNs and require internet access.
- Final W3C, browser and Coreteaching deployment results remain to be recorded.
