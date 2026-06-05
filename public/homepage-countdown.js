function getNextSgranarDate() {
    const now = new Date();
    let year = now.getFullYear();

    const target = new Date(year, 5, 7, 9, 30, 0);

    if (now > target) {
      year++;
    }

    return new Date(year, 5, 7, 9, 30, 0);
  }

  const targetDate = getNextSgranarDate();

  function updateCountdown() {
    const now = new Date();
    const diff = targetDate - now;

    if (diff <= 0) {
      document.getElementById("countdown").innerHTML = "Sgranar per Colli è iniziato!";
      return;
    }

    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
    const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
    const minutes = Math.floor((diff / (1000 * 60)) % 60);
    const seconds = Math.floor((diff / 1000) % 60);

    document.getElementById("days").textContent = String(days).padStart(2, "0");
    document.getElementById("hours").textContent = String(hours).padStart(2, "0");
    document.getElementById("minutes").textContent = String(minutes).padStart(2, "0");
    document.getElementById("seconds").textContent = String(seconds).padStart(2, "0");
  }

  updateCountdown();
  setInterval(updateCountdown, 1000);
