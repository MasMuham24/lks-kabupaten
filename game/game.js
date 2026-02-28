const player = document.getElementById("player");
const scoreEl = document.getElementById("score");
const timerEl = document.getElementById("timer");
const wrapper = document.querySelector(".game-wrapper");

const gameOverPopup = document.getElementById("gameOverPopup");
const winPopup = document.getElementById("winPopup");

const restartBtn = document.getElementById("restartBtn");
const restartBtnWin = document.getElementById("restartBtnWin");

const backBtnLose = document.getElementById("backBtnLose");
const backBtnWin = document.getElementById("backBtnWin");

const catchSound = new Audio("audio/catch.mp3");
const loseLifeSound = new Audio("audio/lost.mp3");
const gameOverSound = new Audio("audio/lost.mp3");
const winSound = new Audio("sound/winner.mp3");
const bgm = new Audio("audio/bgm.mp3");

bgm.loop = true;
bgm.volume = 0.4;

window.addEventListener("click", () => {
  bgm.play();
}, { once: true });

let score = 0;
let lives = 3;
let timeLeft = 45;
let targetScore = 200;
let playerX = window.innerWidth / 2;
let keyboardSpeed = 25;
let gameRunning = true;

player.style.left = playerX + "px";

wrapper.addEventListener("mousemove", (e) => {
  if (!gameRunning) return;

  playerX = e.clientX - player.offsetWidth / 2;

  if (playerX < 0) playerX = 0;
  if (playerX > window.innerWidth - player.offsetWidth)
    playerX = window.innerWidth - player.offsetWidth;

  player.style.left = playerX + "px";
});

document.addEventListener("keydown", (e) => {
  if (!gameRunning) return;

  if (e.key === "ArrowLeft") playerX -= keyboardSpeed;
  if (e.key === "ArrowRight") playerX += keyboardSpeed;

  if (playerX < 0) playerX = 0;
  if (playerX > window.innerWidth - player.offsetWidth)
    playerX = window.innerWidth - player.offsetWidth;

  player.style.left = playerX + "px";
});

function spawnDurian() {
  if (!gameRunning) return;

  const durian = document.createElement("img");
  durian.src = "img/durian jatuh.png";
  durian.classList.add("durian");

  durian.style.left = Math.random() * (window.innerWidth - 70) + "px";
  durian.style.top = "0px";

  wrapper.appendChild(durian);

  let fall = 0;
  const speed = 4 + Math.random() * 3;

  const interval = setInterval(() => {
    if (!gameRunning) {
      clearInterval(interval);
      return;
    }

    fall += speed;
    durian.style.top = fall + "px";

    const dRect = durian.getBoundingClientRect();
    const pRect = player.getBoundingClientRect();

    if (
      dRect.bottom >= pRect.top &&
      dRect.left < pRect.right &&
      dRect.right > pRect.left
    ) {
      score += 5;
      scoreEl.textContent = score;

      catchSound.currentTime = 0;
      catchSound.play();

      if (score >= targetScore) {
        winGame();
      }

      durian.remove();
      clearInterval(interval);
    }

    if (fall > window.innerHeight) {
      durian.remove();
      clearInterval(interval);
      loseLife();
    }

  }, 20);
}

setInterval(spawnDurian, 1000);

function loseLife() {
  lives--;

  loseLifeSound.currentTime = 0;
  loseLifeSound.play();

  const heart = document.getElementById("life" + (lives + 1));
  if (heart) heart.style.display = "none";

  if (lives <= 0) endGame();
}

setInterval(() => {
  if (!gameRunning) return;

  timeLeft--;
  timerEl.textContent = timeLeft;

  if (timeLeft <= 0) endGame();

}, 1000);

function endGame() {
  gameRunning = false;
  bgm.pause();
  gameOverSound.play();
  gameOverPopup.style.display = "flex";
}

function winGame() {
  gameRunning = false;
  bgm.pause();
  winSound.play();
  winPopup.style.display = "flex";
}

restartBtn.addEventListener("click", () => {
  location.reload();
});

restartBtnWin.addEventListener("click", () => {
  location.reload();
});

if (backBtnLose) {
  backBtnLose.addEventListener("click", () => {
    window.location.href = "index.html";
  });
}

if (backBtnWin) {
  backBtnWin.addEventListener("click", () => {
    window.location.href = "index.html";
  });
}
