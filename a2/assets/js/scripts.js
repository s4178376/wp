"use strict";

// defer in header.inc ensures the HTML is parsed before these run.
initialiseBookFilter();
initialiseGalleryModal();
initialiseBookForm();

function initialiseBookFilter() {
  const filter = document.querySelector("#status-filter");
  if (!filter) return; // Other pages do not have this component.
  filter.addEventListener("change", () => {
    document.querySelectorAll("#book-table-body tr[data-status]").forEach((row) => {
      // Use the same casing for each option and its row's data-status.
      row.hidden = filter.value !== "all" && row.dataset.status !== filter.value;
    });
  });
}

function initialiseGalleryModal() {
  const modal = document.querySelector("#gallery-modal");
  const covers = [...document.querySelectorAll(".gallery-item")];
  if (!modal || covers.length === 0) return; // Empty starter gallery is intentional.
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
  const input = form.querySelector("#image-path");
  const preview = form.querySelector("#image-preview");
  const status = form.querySelector("#image-status");
  let selectionVersion = 0;

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
    // Starter only: always prevent submission, even if browser checks pass.
    // Later permit valid submissions to the completed PHP processing endpoint.
    event.preventDefault();
    form.classList.add("was-validated");
    const message = form.querySelector("#form-status");
    if (!form.checkValidity()) {
      message.textContent = "Please correct the highlighted fields.";
      form.querySelector(":invalid")?.focus();
      return;
    }
    message.textContent = "Browser checks passed. Starter only: no record or image was saved.";
  });
}

