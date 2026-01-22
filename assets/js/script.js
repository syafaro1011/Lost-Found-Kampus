// Password Toggle
document
  .getElementById("togglePassword")
  .addEventListener("click", function () {
    const passwordInput = document.getElementById("password");
    const toggleIcon = document.getElementById("toggleIcon");

    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      toggleIcon.classList.remove("fa-eye");
      toggleIcon.classList.add("fa-eye-slash");
    } else {
      passwordInput.type = "password";
      toggleIcon.classList.remove("fa-eye-slash");
      toggleIcon.classList.add("fa-eye");
    }
  });

// Form Animation
document.getElementById("loginForm").addEventListener("submit", function (e) {
  const button = this.querySelector('button[type="submit"]');
  button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
  button.disabled = true;
});

// Input Focus Animation
document.querySelectorAll(".form-control").forEach((input) => {
  input.addEventListener("focus", function () {
    this.parentElement.style.transform = "scale(1.01)";
    this.parentElement.style.transition = "transform 0.2s ease";
  });

  input.addEventListener("blur", function () {
    this.parentElement.style.transform = "scale(1)";
  });
});

// Random float animation for floating icons
document.querySelectorAll(".icon-element").forEach((icon) => {
  const randomDelay = Math.random() * 2;
  const randomDuration = 3 + Math.random() * 2;
  icon.style.animationDelay = randomDelay + "s";
  icon.style.animationDuration = randomDuration + "s";
});

// Auto-hide alert after 5 seconds
const alert = document.querySelector(".alert");
if (alert) {
  setTimeout(() => {
    alert.style.animation = "slideDown 0.3s ease reverse";
    setTimeout(() => alert.remove(), 300);
  }, 5000);
}
