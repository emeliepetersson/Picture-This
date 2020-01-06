"use strict";

const chooseFile = document.querySelector(".choose-file");

//When a file is choosen show it in the preview element
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

//when a file is choosen, add eventlistener to the element
if (chooseFile) {
  chooseFile.addEventListener("change", previewImage);
}
