"use strict";

const chooseFile = document.querySelector(".choose-file");

function previewImage() {
  var preview = document.querySelector("#output-image");
  var file = document.querySelector("input[type=file]").files[0];
  var reader = new FileReader();
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
