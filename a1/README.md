# COSC2446 Web Programming – Assessment 1  
# BookVerse Online Bookstore Platform

## Student Details

| Item | Details |
|---|---|
| Student name | Seth Nightingale |
| Student ID | s4178376 |
| GitHub repository URL | TODO |
| Deployed website URL | TODO |

---

## 1. Purpose of This README

This README documents the Assessment 1 project and should be completed by the student.

It is used to:

- summarise the project;
- explain the structure and technical choices;
- document testing and deployment;
- support marking of documentation and submission quality;
- help AI tools such as GitHub Copilot follow the assessment requirements.

TODO: After completing the project, update every TODO section in this file.

---

## 2. Copilot and AI Coding Instructions

This section must be completed by the student after reading the Assessment 1 brief.

Write clear instructions that would help GitHub Copilot or another AI tool produce code that follows the Assessment 1 requirements.

Your instructions should help the AI understand what it is allowed to generate, what it must not generate, and which assessment constraints must be followed.

TODO: Include instructions about:

- allowed technologies;
- technologies, frameworks, or tools that must not be used;
- required files and folders;
- CSS and JavaScript file requirements;
- whether inline CSS or inline JavaScript is allowed;
- Bootstrap layout requirements;
- form requirements;
- image validation requirements;
- gallery modal requirements;
- book status filtering requirements;
- accessibility and usability expectations;
- AI usage and process-evidence requirements.

### My Copilot / AI instructions

TODO: Write your Copilot/AI instructions here in clear bullet points.
---

## 3. Project Overview

Briefly describe the purpose of the BookVerse website.

TODO: In 3–5 sentences, explain:

- what BookVerse is;
- who the website is for;
- what users can view or interact with;
- which technologies were used;
- whether this is a static or dynamic website.

---

## 4. Website Structure

Complete the table below by describing the purpose of each page.

| File | Purpose |
|---|---|
| `index.html` | TODO |
| `books.html` | TODO |
| `gallery.html` | TODO |
| `add.html` | TODO |

---

## 5. Project Folder Structure

Show the final structure of your `a1` folder.

TODO: Update this structure if your final project contains additional required files or folders.

```text
a1/
├── assets/
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── scripts.js
│   └── images/
│       └── covers/
├── index.html
├── books.html
├── gallery.html
├── add.html
├── README.md
└── process-evidence.md
```

## 6. Technologies Used

Complete the table below. Explain how each technology was used in your project.

| Technology | How it was used in this project |
|---|---|
| HTML5 | TODO |
| CSS3 | TODO |
| Bootstrap 5 | TODO |
| JavaScript | TODO |
| Google Fonts | TODO |
| Material Icons | TODO |
| GitHub | TODO |
| Coreteaching server | TODO |
| AI tools | TODO |

## 7. Design and Layout

Based on the assessment document, describe the design and layout choices.

TODO: Explain:

how the required colour palette should be used;
how to use the required fonts;
how to use Material Icons;
how Bootstrap should be used for layout and responsiveness.

## 8. Required Features

Complete the table below by explaining where and how each required feature should be implemented.

Feature	Page	Explanation
Carousel	index.html	TODO
Responsive book layout	index.html	TODO
Book table	books.html	TODO
Status filter	books.html	TODO
Gallery grid	gallery.html	TODO
Bootstrap image modal	gallery.html	TODO
Add Book form	add.html	TODO
Image validation	add.html	TODO
Image preview	add.html	TODO

## 9. JavaScript Functionality

Describe the JavaScript features that should be implemented in your website.

JavaScript feature	Page	How it works
Image extension validation	add.html	TODO
Image preview	add.html	TODO
Gallery modal	gallery.html	TODO
Book status filter	books.html	TODO

## 10. Form Validation

Every field in `add.html` is mandatory and each control is connected to a visible
`label` using matching `for` and `id` values. Appropriate types and constraints
are used, including number inputs for publication year and price, minimum and
maximum values, a price step of `0.01`, and an ISBN pattern. The agreement uses
a required checkbox.

The shared JavaScript reads the selected cover filename, extracts its extension
and compares it with the allowed `jpg`, `jpeg`, `png`, `gif` and `webp` list. An
invalid extension sets a custom validation message and does not create a
preview. A valid file is read with `FileReader` and displayed locally without
uploading it. Image selection results are announced through an `aria-live`
status, and an invalid submission moves keyboard focus to the first invalid
field. A valid submission only displays a Stage 1 confirmation because this is
a static website.

## 11. Accessibility and Usability

All pages use unique titles and semantic `header`, `nav`, `main` and `footer`
elements. Images have meaningful alternative text, form controls have labels,
the current navigation link uses `aria-current`, decorative icons are hidden
from assistive technology, and the gallery modal has an accessible name and
close control. Keyboard users receive strong visible focus indicators.

The interface uses consistent navigation, responsive Bootstrap grids and a
scrollable table container for smaller screens. Status badge colours achieve at
least a 4.5:1 contrast ratio with their white text. The stylesheet also respects
the user's reduced-motion preference. Form errors use Bootstrap feedback,
invalid submission focus, and a screen-reader announcement for cover-image
validation and preview results.

## 12. Testing and Validation

Complete this section after testing your website.

HTML Validation
File	Result	Notes
index.html	TODO: Pass / Issues found	TODO
books.html	TODO: Pass / Issues found	TODO
gallery.html	TODO: Pass / Issues found	TODO
add.html	TODO: Pass / Issues found	TODO

CSS Validation
File	Result	Notes
assets/css/style.css	TODO: Pass / Issues found	TODO

Functionality Testing
Feature tested	Result	Notes
Navigation links	TODO	TODO
Carousel	TODO	TODO
Gallery modal	TODO	TODO
Book status filter	TODO	TODO
Add Book form validation	TODO	TODO
Image preview	TODO	TODO
Deployed site links/assets	TODO	TODO

## 13. Deployment

Provide details of your deployed website.

Item	Details
Deployed website URL	TODO
Coreteaching server	TODO
Deployment folder	TODO
.htaccess location	TODO

TODO: In 2–4 sentences, explain how you checked that the deployed website works correctly.

## 14. Git and Development Process

Briefly describe how you used Git during the project.

TODO: Explain:

how often you committed changes;
what types of changes your commits show;
how your Git history shows progressive development;
how your commits relate to your process-evidence records.

## 15. AI Use Declaration

AI tools are required for this assessment.

Confirm the following:
- [ ] I used AI tools meaningfully during this assessment.
- [ ] I recorded meaningful AI use in `process-evidence.md`.
- [ ] I reviewed, tested, and adapted AI-assisted output.
- [ ] I can explain all AI-assisted code submitted.

TODO: Write 2–5 sentences.

Detailed AI usage records must be included in process-evidence.md.

## 16. Process Evidence

Confirm that your process evidence file has been completed.

Requirement	Completed?
process-evidence.md file included	TODO: Yes / No
At least 2 debugging records included	TODO: Yes / No
At least 2 meaningful AI usage records included	TODO: Yes / No
Relevant commit links included	TODO: Yes / No

## 17. Known Issues or Limitations

List any known issues or limitations in your submitted project.

Issue or limitation	Explanation
TODO	TODO
TODO	TODO

If there are no known issues, write:

> No known issues at the time of submission.
