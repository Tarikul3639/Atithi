-- seed.users.sql
-- Run Command:
-- sudo -u postgres psql -d atithi -f database/seed.users.sql
-- sudo -u postgres psql -d atithi
-- SELECT * FROM users;

TRUNCATE TABLE users RESTART IDENTITY CASCADE;
INSERT INTO users (name, email, phone, password) VALUES
-- Original Password: admin
('Admin User', 'admin@gmail.com', '01700000000', '$2a$12$Tig6Rz9hiTWHf2bL4QOfteiiHeni/0OmNERlVVRZo13urPez.EUZO'),
-- Original Password: password123
('Tarikul Islam', 'tarikul@email.com', '01711223344', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm'),
-- Original Password: userpass1
('Rahim Ahmed', 'rahim@email.com', '01811223344', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
-- Original Password: userpass2
('Karim Uddin', 'karim@email.com', '01911223344', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
-- Original Password: userpass3
('Fatima Begum', 'fatima@email.com', '01611223344', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');