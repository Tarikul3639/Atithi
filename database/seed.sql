INSERT INTO users (name,email,password)
VALUES
(
    'Tarikul',
    'tarikul@email.com',
    '$2y$12$.ucanVPWqJuL/li.Y5lMGuU/cwDuRYkjrM4yLnoVohJuu7rrJ18zu' -- password: 1234
);

INSERT INTO rooms
(type,name,price,capacity,description,image)
VALUES
(
'single',
'Standard Single Room',
2500,
1,
'Cozy single room',
'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=600'
),
(
'double',
'Deluxe Double Room',
4500,
2,
'Spacious double room',
'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=600'
),
(
'suite',
'Executive Suite',
8500,
2,
'Luxury suite',
'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=600'
);