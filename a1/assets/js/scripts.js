"use strict";

document.addEventListener("DOMContentLoaded", () => {
  initialiseTheme();
  initialiseBookFilter();
  initialiseGalleryModal();
  initialiseBookForm();
});

function initialiseTheme() {
  const selector = document.querySelector("#theme-select");
  const savedTheme = localStorage.getItem("bookverse-theme") || "light";
  document.documentElement.setAttribute("data-bs-theme", savedTheme);

  if (!selector) return;
  selector.value = savedTheme;
  selector.addEventListener("change", () => {
    document.documentElement.setAttribute("data-bs-theme", selector.value);
    localStorage.setItem("bookverse-theme", selector.value);
  });
}

function initialiseBookFilter() {
  const filter = document.querySelector("#status-filter");
  if (!filter) return;

  const rows = document.querySelectorAll("#book-table-body tr[data-status]");
  filter.addEventListener("change", () => {
    const selectedStatus = filter.value;
    rows.forEach((row) => {
      row.hidden = selectedStatus !== "all" && row.dataset.status !== selectedStatus;
    });
  });
}

function initialiseGalleryModal() {
  const modalElement = document.querySelector("#gallery-modal");
  if (!modalElement) return;

  const modalImage = modalElement.querySelector("#modal-image");
  const modalTitle = modalElement.querySelector("#gallery-modal-label");
  const galleryButtons = document.querySelectorAll(".gallery-item");

  galleryButtons.forEach((button) => {
    button.addEventListener("click", () => {
      modalImage.src = button.dataset.image;
      modalImage.alt = button.dataset.title;
      modalTitle.textContent = button.dataset.title;
    });
  });
}

function initialiseBookForm() {
  const form = document.querySelector("#add-book-form");
  const imageInput = document.querySelector("#image-path");
  const preview = document.querySelector("#image-preview");
  const feedback = document.querySelector("#image-feedback");
  if (!form || !imageInput || !preview || !feedback) return;

  const allowedExtensions = ["jpg", "jpeg", "png", "gif", "webp"];

  imageInput.addEventListener("change", () => {
    const file = imageInput.files[0];
    preview.classList.remove("is-visible");
    preview.removeAttribute("src");
    imageInput.setCustomValidity("");

    if (!file) return;
    const extension = file.name.split(".").pop().toLowerCase();

    if (!allowedExtensions.includes(extension)) {
      imageInput.setCustomValidity("Choose a JPG, JPEG, PNG, GIF or WEBP image.");
      feedback.textContent = "Only JPG, JPEG, PNG, GIF and WEBP files are accepted.";
      imageInput.classList.add("is-invalid");
      return;
    }

    imageInput.classList.remove("is-invalid");
    const reader = new FileReader();
    reader.addEventListener("load", () => {
      preview.src = reader.result;
      preview.classList.add("is-visible");
    });
    reader.readAsDataURL(file);
  });

  form.addEventListener("submit", (event) => {
    event.preventDefault();
    form.classList.add("was-validated");
    if (form.checkValidity()) {
      window.alert("Book details validated successfully. No data is submitted in Stage 1.");
    }
  });
}
