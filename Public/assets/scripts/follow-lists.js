"use strict";

const followersButton = document.querySelector(".followers-button");
const followingButton = document.querySelector(".following-button");
const followersList = document.querySelector(".followers-list");
const followingList = document.querySelector(".following-list");
const backButtons = document.querySelectorAll(".back");

backButtons.forEach(backButton => {
  backButton.addEventListener("click", hideFollowList);
});

followersButton.addEventListener("click", showFollowers);
followingButton.addEventListener("click", showFollowings);

function showFollowers() {
  followersList.classList.add("show");
  background.classList.add("show");
}

function showFollowings() {
  followingList.classList.add("show");
  background.classList.add("show");
}

function hideFollowList(event) {
  const list = event.currentTarget.parentNode;
  background.classList.remove("show");
  list.classList.remove("show");
}
