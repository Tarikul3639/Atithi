const params = new URLSearchParams(window.location.search);
const roomId = params.get("room_id") || 17;

async function loadRoom() {
  try {
    const res = await axios.get(`api/rooms/get_room.php?id=${roomId}`);
    
    if (res.data.success) {
      const room = res.data.room;
      
      // Basic Data
      document.getElementById("room-image").src = room.image;
      document.getElementById("room-name").textContent = room.name;
      document.getElementById("room-type").textContent = room.type;
      
      // Capacity and Status Mapping
      document.getElementById("room-capacity").textContent = `${room.capacity} Guests`;
      const statusEl = document.getElementById("room-status");
      statusEl.textContent = room.status;
      
      // Visual style for status
      if (room.status === 'available') {
        statusEl.classList.add('bg-green-50', 'text-green-600');
      } else {
        statusEl.classList.add('bg-red-50', 'text-red-600');
      }
      
      // Price
      const price = Number(room.price);
      document.getElementById("price-per-night").textContent = `৳${price.toLocaleString()}`;
      window.roomPrice = price;
    }
  } catch (err) {
    console.error("Error loading room:", err);
  }
}

function calculateTotal() {
  const checkInVal = document.getElementById("check-in").value;
  const checkOutVal = document.getElementById("check-out").value;
  
  if (checkInVal && checkOutVal) {
    const checkIn = new Date(checkInVal);
    const checkOut = new Date(checkOutVal);
    
    if (checkOut > checkIn) {
      const nights = Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24));
      const total = nights * (window.roomPrice || 0);
      document.getElementById("total-nights").textContent = `${nights} night(s)`;
      document.getElementById("total-amount").textContent = `৳${total.toLocaleString()}`;
    }
  }
}

document.getElementById("check-in").addEventListener("change", calculateTotal);
document.getElementById("check-out").addEventListener("change", calculateTotal);

async function handleBooking() {
  const btn = document.getElementById("book-btn");
  const errorMsg = document.getElementById("error-msg");
  
  const data = {
    room_id: roomId,
    name: document.getElementById("guest-name").value.trim(),
    email: document.getElementById("guest-email").value.trim(),
    phone: document.getElementById("guest-phone").value.trim(),
    check_in: document.getElementById("check-in").value,
    check_out: document.getElementById("check-out").value
  };

  if (!data.name || !data.phone || !data.email || !data.check_in || !data.check_out) {
    errorMsg.textContent = "Please fill in all fields.";
    errorMsg.classList.remove("hidden");
    return;
  }

  btn.disabled = true;
  btn.textContent = "Processing...";

  try {
    const res = await axios.post("api/booking/create.php", data);
    if (res.data.success) {
      document.getElementById("success-msg").textContent = "Booking confirmed!";
      document.getElementById("success-msg").classList.remove("hidden");
      setTimeout(() => { window.location.href = "dashboard.html"; }, 2000);
    } else {
      errorMsg.textContent = res.data.message;
      errorMsg.classList.remove("hidden");
    }
  } catch {
    errorMsg.textContent = "Server error.";
    errorMsg.classList.remove("hidden");
  } finally {
    btn.disabled = false;
    btn.textContent = "Confirm Reservation";
  }
}

loadRoom();