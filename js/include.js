/**
 * Loads a partial HTML file (navbar/footer) and handles 
 * the transition from skeleton to actual content.
 */
async function loadPartial(id, file) {
  try {
    const res = await fetch(file);
    if (!res.ok) throw new Error(`Could not load ${file}`);
    const html = await res.text();
    
    const container = document.getElementById(id);
    container.innerHTML = html;

    // Handle transition: remove skeleton and show actual content
    const skeleton = container.querySelector('#nav-skeleton');
    const actual = container.querySelector('#nav-actual');
    
    if (skeleton && actual) {
      skeleton.classList.add('hidden');
      actual.classList.remove('hidden');
    }
  } catch (err) {
    console.error("Partial load error:", err);
  }
}

document.addEventListener("DOMContentLoaded", async () => {
  // Load components in parallel
  await Promise.all([
    loadPartial("navbar", "/navbar.html"),
    loadPartial("footer", "/footer.html"),
  ]);

  highlightActiveLink();

  // Initialize authentication after the navbar is loaded
  if (typeof initAuth === "function") {
    initAuth();
  }
});

/**
 * Highlights the current active navigation link
 */
function highlightActiveLink() {
  const currentPage = window.location.pathname.split("/").pop() || "index.html";
  const navLinks = document.querySelectorAll(".nav-link");

  navLinks.forEach((link) => {
    if (link.getAttribute("href") === currentPage) {
      link.classList.add(
        "text-gray-900",
        "font-bold",
        "border-b-2",
        "border-amber-600",
        "pb-1",
      );
      link.classList.remove("text-gray-500");
    } else {
      link.classList.add("hover:text-gray-900");
    }
  });
}