// Smooth scroll on page load
window.addEventListener("load", function () {
  document.querySelector(".detail-card").style.opacity = "0";
  setTimeout(() => {
    document.querySelector(".detail-card").style.transition =
      "opacity 0.5s ease";
    document.querySelector(".detail-card").style.opacity = "1";
  }, 100);
});

// Share Function
function shareItem() {
  const title = "<?= $item['judul_laporan'] ?? 'Barang Lost & Found'; ?>";
  const text =
    "<?= ($item['status'] ?? 'lost') == 'lost' ? 'Ada yang kehilangan' : 'Ada yang menemukan'; ?> <?= $item['judul_laporan'] ?? 'barang'; ?> di <?= $item['lokasi'] ?? 'kampus'; ?>";
  const url = window.location.href;

  if (navigator.share) {
    navigator
      .share({
        title: title,
        text: text,
        url: url,
      })
      .then(() => {
        showNotification("Berhasil dibagikan!", "success");
      })
      .catch(() => {
        fallbackShare(url);
      });
  } else {
    fallbackShare(url);
  }
}

// Fallback share (copy to clipboard)
function fallbackShare(url) {
  navigator.clipboard
    .writeText(url)
    .then(() => {
      showNotification("Link berhasil disalin ke clipboard!", "success");
    })
    .catch(() => {
      showNotification("Gagal menyalin link", "error");
    });
}

// Show notification
function showNotification(message, type) {
  const notification = document.createElement("div");
  notification.className = `alert alert-${type === "success" ? "success" : "danger"} position-fixed top-0 start-50 translate-middle-x mt-3`;
  notification.style.zIndex = "9999";
  notification.innerHTML = `
            <i class="bi bi-${type === "success" ? "check-circle" : "x-circle"}"></i>
            ${message}
        `;
  document.body.appendChild(notification);

  setTimeout(() => {
    notification.style.transition = "opacity 0.3s";
    notification.style.opacity = "0";
    setTimeout(() => notification.remove(), 300);
  }, 3000);
}

// Image zoom effect on modal
document
  .getElementById("imageModal")
  .addEventListener("shown.bs.modal", function () {
    const modalImage = this.querySelector(".modal-image");
    modalImage.style.transform = "scale(0.9)";
    setTimeout(() => {
      modalImage.style.transition = "transform 0.3s ease";
      modalImage.style.transform = "scale(1)";
    }, 100);
  });

// Back button with animation
document.querySelector(".back-btn").addEventListener("click", function (e) {
  e.preventDefault();
  document.body.style.transition = "opacity 0.3s ease";
  document.body.style.opacity = "0";
  setTimeout(() => {
    window.location.href = this.href;
  }, 300);
});

// Status badge animation
const statusBadge = document.getElementById("statusBadge");
setInterval(() => {
  statusBadge.style.transform = "scale(1.1)";
  setTimeout(() => {
    statusBadge.style.transform = "scale(1)";
  }, 200);
}, 3000);

// Image error handling
document.getElementById("mainImage").addEventListener("error", function () {
  this.src =
    "https://via.placeholder.com/300?text=Image+Error";
});

// Lazy loading effect
const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      entry.target.style.animation = "slideIn 0.5s ease";
    }
  });
});

document.querySelectorAll(".info-section").forEach((section) => {
  observer.observe(section);
});
