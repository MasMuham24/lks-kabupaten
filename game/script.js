const popup = document.getElementById("popup");

function openPopup() {
  popup.style.display = "flex";
  popup.style.opacity = "0";

  setTimeout(() => {
    popup.style.transition = "opacity 0.3s ease";
    popup.style.opacity = "1";
  }, 10);
}

function closePopup() {
  popup.style.opacity = "0";

  setTimeout(() => {
    popup.style.display = "none";
  }, 300);
}

popup.addEventListener("click", function (e) {
  if (e.target === popup) {
    closePopup();
  }
});

function mulaiGame() {

  document.body.style.transition = "opacity 0.5s ease";
  document.body.style.opacity = "0";

  setTimeout(() => {
    window.location.href = "game.html"; 
  }, 500);
}

const character = document.querySelector(".character");

let floatUp = true;

setInterval(() => {
  if (floatUp) {
    character.style.transform = "translateY(-10px)";
  } else {
    character.style.transform = "translateY(0px)";
  }

  character.style.transition = "transform 1s ease-in-out";
  floatUp = !floatUp;

}, 1000);
