let allRooms = [];

/* ---------- LOAD ROOMS ---------- */
async function loadRooms() {
  const loading = document.getElementById("loading");
  const container = document.getElementById("rooms-container");
  const noRooms = document.getElementById("no-rooms");

  if (!loading || !container || !noRooms) return;

  loading.classList.remove("hidden");
  container.innerHTML = ""; // Clear existing
  noRooms.classList.add("hidden");

  try {
    const res = await axios.get("api/rooms/get_rooms.php");

    if (res.data?.success && Array.isArray(res.data.rooms)) {
      allRooms = res.data.rooms;
      renderRooms(allRooms);
    } else {
      showEmpty("No rooms found.");
    }
  } catch (err) {
    console.error("Fetch Error:", err);
    showEmpty("Failed to load rooms.");
  } finally {
    loading.classList.add("hidden");
  }
}

/* ---------- RENDER (CORPORATE VIBE) ---------- */
function renderRooms(rooms) {
  const container = document.getElementById("rooms-container");
  const noRooms = document.getElementById("no-rooms");

  if (!rooms || rooms.length === 0) {
    showEmpty("No rooms found.");
    return;
  }

  noRooms.classList.add("hidden");
  container.innerHTML = rooms
    .map(
      (room) => `
    <div class="group bg-white border border-gray-200 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full">
      <div class="relative overflow-hidden h-60">
        <img src="${room.image || "assets/images/rooms/default.jpg"}" 
             alt="${room.name}"
             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
        <div class="absolute top-4 right-4 bg-gray-900/80 backdrop-blur-sm text-white text-[10px] tracking-[0.2em] px-3 py-1 uppercase font-semibold">
          ${room.type}
        </div>
      </div>

      <div class="p-6 flex-1 flex flex-col">
        <div class="flex justify-between items-start mb-2">
          <h3 class="text-lg font-serif font-bold text-gray-900">${room.name}</h3>
        </div>
        
        <p class="text-gray-500 text-sm leading-relaxed mb-4 flex-1">
          ${room.description || "Experience the perfect blend of comfort and elegance in our premium suite."}
        </p>

        <div class="grid grid-cols-2 gap-4 mb-6 py-4 border-y border-gray-100">
          <div>
            <span class="block text-[10px] uppercase tracking-widest text-gray-400">Capacity</span>
            <span class="text-sm font-semibold text-gray-700">${room.capacity} Guests</span>
          </div>
          <div>
            <span class="block text-[10px] uppercase tracking-widest text-gray-400">Nightly Rate</span>
            <span class="text-sm font-semibold text-amber-700">৳${parseFloat(room.price).toLocaleString()}</span>
          </div>
        </div>

        ${
          room.status === "available"
            ? `<a href="booking.html?room_id=${room.id}" 
                class="w-full py-3 text-sm font-bold uppercase tracking-widest bg-gray-900 hover:bg-amber-500 text-white transition-colors duration-300 text-center">
                Book Reservation
             </a>`
            : `<button disabled 
                class="w-full border border-gray-200 text-gray-400 py-3 text-sm font-bold uppercase tracking-widest cursor-not-allowed">
                Fully Occupied
             </button>`
        }
      </div>
    </div>
  `,
    )
    .join("");
}

/* ---------- FILTER ---------- */
function filterRooms(event, type) {
  // Update UI active state
  document.querySelectorAll(".filter-btn").forEach((btn) => {
    btn.classList.remove("bg-amber-600", "text-white");
    btn.classList.add("border-gray-300", "text-gray-600");
  });
  event.target.classList.add("bg-amber-600", "text-white");
  event.target.classList.remove("border-gray-300", "text-gray-600");

  // Filter logic
  if (type === "all") {
    renderRooms(allRooms);
  } else {
    renderRooms(allRooms.filter((r) => r.type === type));
  }
}

/* ---------- EMPTY STATE ---------- */
function showEmpty(msg) {
  const container = document.getElementById("rooms-container");
  const noRooms = document.getElementById("no-rooms");
  container.innerHTML = "";
  noRooms.textContent = msg;
  noRooms.classList.remove("hidden");
}

// Ensure DOM is ready before loading
document.addEventListener("DOMContentLoaded", loadRooms);
