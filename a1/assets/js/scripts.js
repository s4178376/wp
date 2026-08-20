"use strict";

applySavedTheme();

document.addEventListener("DOMContentLoaded", () => {
  initialiseTheme();
  initialiseBookFilter();
  initialiseGalleryModal();
  initialiseBookForm();
});

// Applies the saved theme before the page body finishes loading.
function applySavedTheme() {
  const savedTheme =
    localStorage.getItem("bookverse-theme") || "light";

  document.documentElement.setAttribute(
    "data-bs-theme",
    savedTheme
  );
}

// Controls the Default Light and Default Dark selector.
function initialiseTheme() {
  const selector = document.querySelector("#theme-select");

  if (!selector) return;

  selector.value =
    document.documentElement.getAttribute("data-bs-theme");

  selector.addEventListener("change", () => {
    document.documentElement.setAttribute(
      "data-bs-theme",
      selector.value
    );

    localStorage.setItem(
      "bookverse-theme",
      selector.value
    );
  });
}

// Filters the book table using each row's data-status value.
function initialiseBookFilter() {
  const filter = document.querySelector("#status-filter");

  if (!filter) return;

  const rows = document.querySelectorAll(
    "#book-table-body tr[data-status]"
  );

  filter.addEventListener("change", () => {
    const selectedStatus = filter.value;

    rows.forEach((row) => {
      row.hidden =
        selectedStatus !== "all" &&
        row.dataset.status !== selectedStatus;
    });
  });
}

// Opens gallery images and controls Previous/Next navigation.
function initialiseGalleryModal() {
  const modalElement =
    document.querySelector("#gallery-modal");

  if (!modalElement) return;

  const modalImage =
    modalElement.querySelector("#modal-image");

  const modalTitle =
    modalElement.querySelector("#gallery-modal-label");

  const previousButton =
    modalElement.querySelector("#previous-cover");

  const nextButton =
    modalElement.querySelector("#next-cover");

  const galleryButtons = [
    ...document.querySelectorAll(".gallery-item")
  ];

  let currentIndex = 0;

  // Updates the modal using the currently selected cover.
  function updateModal() {
    const selectedCover = galleryButtons[currentIndex];

    modalImage.src = selectedCover.dataset.image;
    modalImage.alt = selectedCover.dataset.title;
    modalTitle.textContent = selectedCover.dataset.title;
  }

  // Opens the cover that the user selected.
  galleryButtons.forEach((button, index) => {
    button.addEventListener("click", () => {
      currentIndex = index;
      updateModal();
    });
  });

  // Moves backwards and wraps cover 1 to cover 12.
  previousButton.addEventListener("click", () => {
    currentIndex =
      (currentIndex - 1 + galleryButtons.length) %
      galleryButtons.length;

    updateModal();
  });

  // Moves forward and wraps cover 12 to cover 1.
  nextButton.addEventListener("click", () => {
    currentIndex =
      (currentIndex + 1) %
      galleryButtons.length;

    updateModal();
  });
}

// Validates the Add Book form and previews valid cover images.
function initialiseBookForm() {
  const form = document.querySelector("#add-book-form");
  const imageInput = document.querySelector("#image-path");
  const preview = document.querySelector("#image-preview");
  const feedback = document.querySelector("#image-feedback");
  const imageStatus = document.querySelector("#image-status");

  if (
    !form ||
    !imageInput ||
    !preview ||
    !feedback ||
    !imageStatus
  ) {
    return;
  }

  const allowedExtensions = [
    "jpg",
    "jpeg",
    "png",
    "gif",
    "webp"
  ];

  imageInput.addEventListener("change", () => {
    const file = imageInput.files[0];

    preview.classList.remove("is-visible");
    preview.removeAttribute("src");
    preview.alt = "Preview of selected book cover";

    imageInput.setCustomValidity("");
    imageInput.classList.remove("is-invalid");

    if (!file) {
      imageStatus.textContent =
        "No cover image selected.";

      return;
    }

    const extension =
      file.name.split(".").pop().toLowerCase();

    if (!allowedExtensions.includes(extension)) {
      imageInput.setCustomValidity(
        "Choose a JPG, JPEG, PNG, GIF or WEBP image."
      );

      feedback.textContent =
        "Only JPG, JPEG, PNG, GIF and WEBP files are accepted.";

      imageInput.classList.add("is-invalid");

      imageStatus.textContent =
        `${file.name} was rejected because its file type is not allowed.`;

      return;
    }

    const reader = new FileReader();

    reader.addEventListener("load", () => {
      preview.src = reader.result;
      preview.alt = `Preview of ${file.name}`;
      preview.classList.add("is-visible");

      imageStatus.textContent =
        `${file.name} is valid and its preview is displayed.`;
    });

    reader.readAsDataURL(file);
  });

  form.addEventListener("submit", (event) => {
    event.preventDefault();
    form.classList.add("was-validated");

    if (form.checkValidity()) {
      window.alert(
        "Book details validated successfully. No data is submitted in Stage 1."
      );
    } else {
      const firstInvalidField =
        form.querySelector(":invalid");

      if (firstInvalidField) {
        firstInvalidField.focus();
      }
    }
  });
}