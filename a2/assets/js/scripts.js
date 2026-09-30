"use strict";

// defer in header.inc ensures the HTML is parsed before these run.
initialiseBookFilter();
initialiseGalleryModal();
initialiseBookForm();

function initialiseBookFilter() {
  const filter = document.querySelector("#status-filter");
  if (!filter) return; // Other pages do not have this component.
  filter.addEventListener("change", () => {
    let visibleCount = 0;
    document.querySelectorAll("#book-table-body tr[data-status]").forEach((row) => {
      // Use the same casing for each option and its row's data-status.
      row.hidden = filter.value !== "all" && row.dataset.status !== filter.value;
      if (!row.hidden) visibleCount += 1;
    });
    const status = document.querySelector("#filter-status");
    if (status) status.textContent = `${visibleCount} books shown.`;
  });
}

function initialiseGalleryModal() {
  const modal = document.querySelector("#gallery-modal");
  const covers = [...document.querySelectorAll(".gallery-item")];
  if (!modal || covers.length === 0) return; // An empty database has no covers.
  const image = modal.querySelector("#modal-image");
  const title = modal.querySelector("#gallery-modal-label");
  let currentIndex = 0;
  function updateModal() {
    image.src = covers[currentIndex].dataset.image;
    image.alt = covers[currentIndex].dataset.title;
    title.textContent = covers[currentIndex].dataset.title;
  }
  covers.forEach((button, index) => {
    button.addEventListener("click", () => {
      currentIndex = index;
      updateModal();
    });
  });
  modal.querySelector("#previous-cover").addEventListener("click", () => {
    currentIndex = (currentIndex - 1 + covers.length) % covers.length;
    updateModal();
  });
  modal.querySelector("#next-cover").addEventListener("click", () => {
    currentIndex = (currentIndex + 1) % covers.length;
    updateModal();
  });
}

function initialiseBookForm() {
  const form = document.querySelector("#add-book-form");
  if (!form) return;
  document.querySelector("#server-errors")?.focus();
  const input = form.querySelector("#image-path");
  const preview = form.querySelector("#image-preview");
  const status = form.querySelector("#image-status");
  let selectionVersion = 0;

  // Match PHP's trimming and ISBN-shape checks before sending the request.
  // Custom validity must be cleared as the user corrects a field.
  const textFields = [...form.querySelectorAll('input[type="text"], textarea')];
  function validateText(field) {
    const text = field.value.trim();
    field.setCustomValidity(field.required && !text ? "Enter a value, not just spaces." : "");
    if (field.id === "isbn" && text &&
        !/^(?:[0-9]{9}[0-9Xx]|[0-9]{13})$/.test(text.replace(/[ -]/g, ""))) {
      field.setCustomValidity("Enter a 10- or 13-character ISBN.");
    }
  }
  textFields.forEach((field) => field.addEventListener("input", () => validateText(field)));

  input.addEventListener("change", () => {
    // Ignore an older asynchronous read if another file is selected.
    const version = ++selectionVersion;
    const file = input.files[0];
    preview.classList.remove("is-visible");
    preview.src = "assets/images/favicon.svg";
    input.setCustomValidity("");
    input.classList.remove("is-invalid");
    if (!file) {
      status.textContent = "No cover selected.";
      return;
    }
    const extension = file.name.split(".").pop().toLowerCase();
    // Extension validation is usability feedback, NOT a server security check.
    if (!["jpg", "jpeg", "png", "gif", "webp"].includes(extension)) {
      input.setCustomValidity("Choose a JPG, JPEG, PNG, GIF or WEBP image.");
      input.classList.add("is-invalid");
      status.textContent = "Unsupported file extension.";
      return;
    }
    if (file.size === 0 || file.size > 5 * 1024 * 1024) {
      input.setCustomValidity("Choose a non-empty image no larger than 5 MiB.");
      input.classList.add("is-invalid");
      status.textContent = "Image is empty or exceeds 5 MiB.";
      return;
    }
    const reader = new FileReader();
    reader.addEventListener("load", () => {
      if (version !== selectionVersion) return;
      preview.src = reader.result;
      preview.alt = "Preview of " + file.name;
      preview.classList.add("is-visible");
      status.textContent = "Preview prepared. Nothing has been uploaded.";
    });
    reader.addEventListener("error", () => {
      if (version !== selectionVersion) return;
      input.setCustomValidity("The file could not be read. Choose another image.");
      input.classList.add("is-invalid");
      status.textContent = "The selected file could not be read.";
    });
    reader.readAsDataURL(file);
  });

  form.addEventListener("submit", (event) => {
    // Permit valid forms to POST. PHP independently validates everything.
    textFields.forEach(validateText);
    form.classList.add("was-validated");
    const message = form.querySelector("#form-status");
    if (!form.checkValidity()) {
      event.preventDefault();
      message.textContent = "Please correct the highlighted fields.";
      form.querySelector(":invalid")?.focus();
      return;
    }
    message.textContent = "Submitting book…";
  });
}
