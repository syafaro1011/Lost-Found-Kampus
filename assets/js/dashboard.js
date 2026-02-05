// Auto-hide alert after 5 seconds
const alertMessage = document.getElementById("alertMessage");
if (alertMessage) {
  setTimeout(() => {
    const bsAlert = new bootstrap.Alert(alertMessage);
    bsAlert.close();
  }, 5000);
}

// Search input animation
const searchInput = document.querySelector('input[name="search"]');
if (searchInput) {
  searchInput.addEventListener("focus", function () {
    this.parentElement.style.transform = "scale(1.02)";
    this.parentElement.style.transition = "transform 0.2s ease";
  });

  searchInput.addEventListener("blur", function () {
    this.parentElement.style.transform = "scale(1)";
  });
}

// Card hover effect enhancement
document.querySelectorAll(".item-card").forEach((card) => {
  card.addEventListener("mouseenter", function () {
    this.style.transition = "all 0.3s ease";
  });
});

// Loading animation for buttons
document.querySelectorAll(".btn-detail, .btn-edit").forEach((btn) => {
  btn.addEventListener("click", function () {
    if (!this.classList.contains("btn-edit")) {
      const originalText = this.innerHTML;
      this.innerHTML = '<i class="bi bi-arrow-clockwise"></i> Loading...';
      this.disabled = true;
    }
  });
});

// Smooth scroll to top
window.addEventListener("scroll", function () {
  if (window.scrollY > 300) {
    if (!document.getElementById("scrollTopBtn")) {
      const btn = document.createElement("button");
      btn.id = "scrollTopBtn";
      btn.innerHTML = '<i class="bi bi-arrow-up"></i>';
      btn.className = "btn btn-success";
      btn.style.cssText =
        "position: fixed; bottom: 30px; right: 30px; z-index: 1000; border-radius: 50%; width: 50px; height: 50px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);";
      btn.onclick = () => window.scrollTo({ top: 0, behavior: "smooth" });
      document.body.appendChild(btn);
    }
  } else {
    const btn = document.getElementById("scrollTopBtn");
    if (btn) btn.remove();
  }
});
