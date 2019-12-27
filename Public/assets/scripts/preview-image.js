"use strict";

const chooseFile = document.querySelector(".choose-file");

function previewImage() {
  const preview = document.querySelector("#output-image");
  const file = document.querySelector("input[type=file]").files[0];
  const reader = new FileReader();
  reader.addEventListener(
    "load",
    function() {
      preview.src = reader.result;
    },
    false
  );

  if (file) {
    reader.readAsDataURL(file);
  }
}

chooseFile.addEventListener("change", previewImage);
