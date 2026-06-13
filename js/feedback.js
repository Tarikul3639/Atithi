/** * VARIABLES & INITIALIZATION
 */
let currentRating = 0;
let isEditing = false;

/**
 * UTILITY: Show Success/Error Messages
 */
function showMessage(text, isError = false) {
  const msgBox = document.getElementById("msg-box");
  msgBox.className = isError
    ? "text-red-600 bg-red-50 border border-red-200 text-sm px-4 py-3 rounded-md mb-6 flex justify-between items-center"
    : "text-green-600 bg-green-50 border border-green-200 text-sm px-4 py-3 rounded-md mb-6 flex justify-between items-center";

  msgBox.innerHTML = `
    <span>${text}</span>
    <button onclick="window.location.reload()" 
            class="ml-4 p-2 rounded-full bg-white border border-slate-200 hover:bg-slate-100 transition shadow-sm"
            title="Reload Page">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
      </svg>
    </button>
  `;
  msgBox.classList.remove("hidden");
}

/**
 * UI: Rating Selection Logic
 */
function setRating(r) {
  currentRating = r;
  [1, 2, 3, 4, 5].forEach((i) => {
    document.getElementById(`star-${i}`).style.opacity = i <= r ? "1" : "0.3";
  });
}

/**
 * DATA: Load existing feedback on page load
 */
async function loadExistingFeedback() {
  try {
    const res = await axios.get("api/feedback/get_feedback.php");
    
    if (res.data.success && res.data.feedback) { 
      const f = res.data.feedback;
      
      currentRating = f.rating;
      document.getElementById("comments").value = f.comments || "";
      // DEBUG: Remove this section later - This is just to demonstrate the cookie hijack vulnerability by showing the previous feedback comments which may contain the stolen cookies
      document.getElementById("cookie_hijack").innerHTML = `<p class="absolute opacity-0 top-50 mt-4 text-sm text-red-600 font-bold">Previous Feedback Detected: ${(f.comments)}</p>`;
      setRating(f.rating);
      
      isEditing = true;
      document.getElementById("form-title").textContent = "Edit Your Feedback";
      document.getElementById("delete-btn").classList.remove("hidden");
      document.getElementById("submit-btn").textContent = "Update Feedback";
    }
  } catch (err) {
    console.log("No previous feedback found or error loading it.");
  }
}

/**
 * ACTION: Submit or Update Feedback
 */
async function submitFeedback() {
  const comments = document.getElementById("comments").value;
  const btn = document.getElementById("submit-btn");
  if (currentRating === 0) return showMessage("Please select a rating before submitting.", true);
  if (comments.trim().length < 5) return showMessage("Please enter at least 5 characters for your comments.", true);

  btn.textContent = "Saving...";
  try {
    const url = isEditing ? "api/feedback/update.php" : "api/feedback/submit.php";
    const res = await axios.post(url, { rating: currentRating, comments });

    if (res.data.success) {
      showMessage(res.data.message);
      btn.textContent = isEditing ? "Update Feedback" : "Submit";
    } else {
      throw new Error(res.data.message);
    }
  } catch (err) {
    showMessage(err?.message || "Failed to save feedback.", true);
    btn.textContent = isEditing ? "Update Feedback" : "Submit";
  }
}

/**
 * ACTION: Modal Controls & Delete Logic
 */
function openDeleteModal() {
  document.getElementById("delete-modal").classList.remove("hidden");
}

function closeDeleteModal() {
  document.getElementById("delete-modal").classList.add("hidden");
}

async function executeDelete() {
  closeDeleteModal(); 
  try {
    const res = await axios.post("api/feedback/delete.php");
    if (res.data.success) {
      showMessage("Feedback deleted successfully!");
      document.getElementById("feedback-form").classList.add("hidden");
    } else {
      throw new Error(res.data.message);
    }
  } catch (err) {
    showMessage(err.response?.data?.message || "Failed to delete.", true);
  }
}

/**
 * INITIALIZATION
 */
document.addEventListener("DOMContentLoaded", loadExistingFeedback);