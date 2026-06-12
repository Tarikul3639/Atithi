-- seed.rooms.sql
-- Run Command:
-- sudo -u postgres psql -d atithi -f database/seed.rooms.sql
-- sudo -u postgres psql -d atithi
-- SELECT * FROM rooms;

INSERT INTO rooms (type, name, price, capacity, description, image) VALUES
('single', 'Standard Single Room', 2500, 1, 'Cozy single room with modern amenities.', 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304'),
('double', 'Deluxe Double Room', 4500, 2, 'Spacious double room with city view.', 'https://images.unsplash.com/photo-1618773928121-c32242e63f39'),
('suite', 'Executive Suite', 8500, 2, 'Luxurious suite with separate living area.', 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b'),
('deluxe', 'Royal Deluxe Room', 6500, 3, 'Premium deluxe room with king-size bed.', 'https://images.unsplash.com/photo-1590490360182-c33d57733427'),
('single', 'Economy Single', 1800, 1, 'Budget-friendly room for solo travelers.', 'https://images.unsplash.com/photo-1595576508898-0ad5c879a061'),
('suite', 'Presidential Suite', 15000, 4, 'Ultimate luxury with butler service.', 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461'),
('double', 'Superior Double', 5000, 2, 'Comfortable double bed with work desk.', 'https://images.unsplash.com/photo-1590490360182-c33d57733427'),
('single', 'Business Single', 3000, 1, 'Equipped with high-speed internet.', 'https://images.unsplash.com/photo-1512918728675-ed5a9ecdebfd'),
('deluxe', 'Garden View Deluxe', 7000, 2, 'Beautiful views of the hotel garden.', 'https://images.unsplash.com/photo-1566665797739-1670de7a5311'),
('suite', 'Junior Suite', 9500, 3, 'Perfect for small families.', 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b'),
('double', 'Family Double', 5500, 3, 'Spacious room designed for families.', 'https://images.unsplash.com/photo-1611892440504-42a792e24021'),
('single', 'Studio Room', 2200, 1, 'Compact and efficient living space.', 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688'),
('suite', 'Penthouse Suite', 20000, 5, 'Top-floor luxury with private terrace.', 'https://images.unsplash.com/photo-1445019980597-93fa8acb246c'),
('deluxe', 'Ocean View Deluxe', 7500, 2, 'Wake up to the sound of the sea.', 'https://images.unsplash.com/photo-1506744038136-46273834b3fb'),
('double', 'Twin Room', 4000, 2, 'Two comfortable twin beds.', 'https://images.unsplash.com/photo-1540518614846-7eded433c458'),
('single', 'Cozy Nook', 1500, 1, 'Small but very comfortable room.', 'https://images.unsplash.com/photo-1590490360182-c33d57733427'),
('suite', 'Honeymoon Suite', 12000, 2, 'Romantic decor with a jacuzzi.', 'https://images.unsplash.com/photo-1590490360182-c33d57733427'),
('deluxe', 'Corner Deluxe', 6800, 2, 'Large windows with panoramic views.', 'https://images.unsplash.com/photo-1590490360182-c33d57733427'),
('double', 'Standard Double', 3500, 2, 'Value-for-money double room.', 'https://images.unsplash.com/photo-1590490360182-c33d57733427'),
('suite', 'Gold Suite', 11000, 2, 'Elegantly furnished with gold accents.', 'https://images.unsplash.com/photo-1590490360182-c33d57733427');