let allBookings = [];

const statusColors = {
  confirmed: "bg-green-100 text-green-700",
  upcoming: "bg-blue-100 text-blue-700",
  completed: "bg-gray-100 text-gray-600",
  cancelled: "bg-red-100 text-red-600",
};

function formatDate(dateStr) {
  if (!dateStr) return "—";
  const d = new Date(dateStr + "T00:00:00");
  return d.toLocaleDateString("en-GB", {
    day: "2-digit",
    month: "short",
    year: "numeric",
  });
}

async function loadDashboard() {
  const loading = document.getElementById("loading");
  const errorBox = document.getElementById("error-box");

  loading.classList.remove("hidden");
  try {
    const profileRes = await axios.get("api/auth/profile.php");
    if (!profileRes.data.success) {
      window.location.href = "login.html";
      return;
    }

    const user = profileRes.data.user || {};
    document.getElementById("user-name").textContent = user.name || "Guest";
    document.getElementById("user-email").textContent = user.email || "";

    const bookingRes = await axios.get("api/booking/my_bookings.php");
    allBookings =
      bookingRes.data.success && Array.isArray(bookingRes.data.bookings)
        ? bookingRes.data.bookings
        : [];

    updateStats(allBookings);
    renderBookings(allBookings);
  } catch (err) {
    errorBox.textContent = "Failed to load dashboard data.";
    errorBox.classList.remove("hidden");
  } finally {
    loading.classList.add("hidden");
  }
}

function updateStats(bookings) {
  document.getElementById("stat-total").textContent = bookings.length;
  document.getElementById("stat-confirmed").textContent = bookings.filter(
    (b) => b.status === "confirmed",
  ).length;
  document.getElementById("stat-upcoming").textContent = bookings.filter(
    (b) => b.status === "upcoming",
  ).length;
  document.getElementById("stat-completed").textContent = bookings.filter(
    (b) => b.status === "completed",
  ).length;
}

function renderBookings(bookings) {
  const container = document.getElementById("bookings-container");
  const noBookings = document.getElementById("no-bookings");

  if (!bookings || bookings.length === 0) {
    container.innerHTML = "";
    noBookings.classList.remove("hidden");
    return;
  }
  noBookings.classList.add("hidden");

  container.innerHTML = bookings
    .map(
      (b) => `
    <div class="group bg-white rounded-lg border border-gray-100 p-6 flex flex-col md:flex-row gap-6 hover:shadow-lg hover:border-amber-200 transition-all duration-300">
      <img src="${b.room_image || "assets/images/rooms/default.jpg"}" 
           class="w-full md:w-32 h-28 object-cover rounded-lg shadow-sm flex-shrink-0" 
           onerror="this.src='assets/images/rooms/default.jpg'">
      
      <div class="flex-1">
        <div class="flex justify-between items-start">
          <div>
            <h3 class="text-lg font-serif font-bold text-gray-900">${b.room_name}</h3>
            <p class="text-xs text-gray-400 uppercase tracking-widest mt-1">${b.room_type || "Room"}</p>
          </div>
          <span class="text-[10px] uppercase tracking-widest px-3 py-1 rounded-full font-bold ${statusColors[b.status] || "bg-gray-100 text-gray-600"}">
            ${b.status}
          </span>
        </div>
        
        <div class="flex flex-wrap gap-8 mt-5 text-sm text-gray-600">
          <div><span class="text-[10px] text-gray-400 uppercase block">Check-in</span><span class="font-medium">${formatDate(b.check_in)}</span></div>
          <div><span class="text-[10px] text-gray-400 uppercase block">Check-out</span><span class="font-medium">${formatDate(b.check_out)}</span></div>
          <div><span class="text-[10px] text-gray-400 uppercase block">Total</span><span class="font-bold text-amber-600">৳${Number(b.total || 0).toLocaleString()}</span></div>
        </div>
      </div>

      <div class="flex md:flex-col gap-2 justify-center border-t md:border-t-0 md:border-l border-gray-100 pt-4 md:pt-0 md:pl-6">
        ${
          b.status !== "completed" && b.status !== "cancelled"
            ? `<button onclick="cancelBooking(${b.id})" 
                class="text-[10px] font-bold uppercase tracking-widest text-red-500 border border-red-200 px-4 py-2 rounded hover:bg-red-50 hover:border-red-300 transition">
                Cancel
              </button>`
            : ""
        }
        <a href="booking.html?room_id=${b.room_id}" 
           class="text-[10px] font-bold uppercase tracking-widest text-amber-600 border border-amber-200 px-4 py-2 rounded hover:bg-amber-50 hover:border-amber-300 transition text-center">
           Rebook
        </a>
      </div>
    </div>
    </div>
  `,
    )
    .join("");
}

function filterBookings(event, status) {
  document.querySelectorAll(".tab-btn").forEach((btn) => {
    btn.classList.remove("bg-amber-600", "text-white");
    btn.classList.add("border", "border-gray-300", "text-gray-600");
  });
  event.target.classList.add("bg-amber-600", "text-white");
  event.target.classList.remove("border", "border-gray-300", "text-gray-600");

  renderBookings(
    status === "all"
      ? allBookings
      : allBookings.filter((b) => b.status === status),
  );
}

async function cancelBooking(id) {
  if (!confirm("Are you sure?")) return;
  try {
    const res = await axios.post("api/booking/cancel.php", { id });
    if (res.data.success) {
      allBookings = allBookings.map((b) =>
        b.id === id ? { ...b, status: "cancelled" } : b,
      );
      updateStats(allBookings);
      renderBookings(allBookings);
    }
  } catch (err) {
    alert("Server error.");
  }
}

document.addEventListener("DOMContentLoaded", loadDashboard);
