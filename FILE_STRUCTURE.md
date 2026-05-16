## Updated File Structure

```bash
/var/www/html/
│
├── index.html                  # Home page
├── rooms.html                  # All rooms list
├── booking.html                # Booking form
├── login.html                  # Login page
├── register.html               # Register page
├── dashboard.html              # User dashboard
│
├── css/
│   └── style.css               # Custom CSS (Tailwind CDN will use)
│
├── js/
│   ├── main.js                 # Common JS (navbar, utils)
│   ├── rooms.js                # Rooms page logic
│   ├── booking.js              # Booking form logic
│   ├── auth.js                 # Login/Register logic
│   └── dashboard.js            # Dashboard logic
│
├── api/                        # PHP Backend
│   ├── config/
│   │   └── db.php              # MySQL connection
│   │
│   ├── auth/
│   │   ├── login.php           # Login API
│   │   └── register.php        # Register API
│   │
│   ├── rooms/
│   │   ├── get_rooms.php       # সব room fetch
│   │   └── get_room.php        # Single room fetch
│   │
│   └── booking/
│       ├── create.php          # Booking তৈরি
│       └── my_bookings.php     # User এর bookings
│
└── assets/
    └── images/
        └── rooms/              # Room এর photos
```

---

**প্রতিটা HTML file এ থাকবে:**
```html
<!-- Tailwind CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Axios CDN -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<!-- Page specific JS -->
<script src="js/auth.js"></script>
```

---

**Flow:**
```
HTML Page
  → Axios (js file এ)
    → PHP API (api/ folder)
      → MySQL Database
```

---

If Structure is confirmed, then we can start with:

**1. MySQL database + table তৈরি**
**2. PHP db connection**
**3. Frontend HTML pages**