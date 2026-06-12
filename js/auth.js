let user = null;

/**
 * Checks if the user is authenticated via API
 */
async function checkAuth() {
  try {
    const res = await axios.get("api/auth/profile.php");

    if (res.data.success) {
      user = res.data.user;

      // Ensure elements exist before manipulation
      const loggedInArea = document.getElementById("auth-logged-in");
      const guestArea = document.getElementById("auth-guest");
      const usernameDisplay = document.getElementById("nav-username");

      // Set Initials
      const initial = user.name ? user.name.charAt(0).toUpperCase() : "U";
      document.getElementById("nav-avatar").textContent = initial;

      if (loggedInArea && guestArea) {
        loggedInArea.classList.remove("hidden");
        guestArea.classList.add("hidden");
      }

      if (usernameDisplay && user.name) {
        usernameDisplay.textContent = user.name.split(" ")[0];
      }
    } else {
      showGuest();
    }
  } catch (e) {
    showGuest();
  }
}

/**
 * Toggles UI to guest mode
 */
function showGuest() {
  const loggedInArea = document.getElementById("auth-logged-in");
  const guestArea = document.getElementById("auth-guest");

  if (loggedInArea && guestArea) {
    loggedInArea.classList.add("hidden");
    guestArea.classList.remove("hidden");
  }
}

/**
 * Modal control functions
 */
function showModal() {
  document.getElementById("logout-modal")?.classList.remove("hidden");
}

function closeModal() {
  document.getElementById("logout-modal")?.classList.add("hidden");
}

/**
 * Triggers the logout confirmation modal
 */
function handleLogout() {
  showModal();
}

/**
 * Finalizes logout action
 */
async function confirmLogout() {
  try {
    await axios.get("api/auth/logout.php");
    location.reload();
  } catch (error) {
    console.error("Logout failed:", error);
  }
}

// Called after navbar load
function initAuth() {
  checkAuth();
}
