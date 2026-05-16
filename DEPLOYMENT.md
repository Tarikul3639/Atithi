# 🚀 Atithi — Deployment Guide

Step-by-step guide to zip, deploy, and run the Atithi project on Apache (Kali Linux).

---

## 📦 Step 1 — Project Zip করো

Project folder এর ভেতরে থেকে run করো:

```bash
sudo rm -rf /var/www/html/* && zip -r Atithi.zip . && sudo mv Atithi.zip /var/www/html/
```

---

## 🌐 Step 2 — Apache চলছে কিনা Check করো

```bash
sudo service apache2 status
```

### ❌ Inactive (বন্ধ) থাকলে:

```bash
sudo service apache2 start
```

### ✅ Already Active থাকলে:

পরের step এ যাও।

---

## 📂 Step 3 — Apache Folder এ যাও

```bash
cd /var/www/html
```

---

## 📁 Step 4 — Zip Extract করো

```bash
sudo unzip Atithi.zip
```

---

## 🗄️ Step 5 — MySQL Setup করো

### MySQL চালু করো:

```bash
sudo service mysql start
```

### Database তৈরি করো:

```bash
sudo mysql -u root -p
```

```sql
CREATE DATABASE atithi_db;
USE atithi_db;
SOURCE /var/www/html/database/schema.sql;
EXIT;
```

---

## ⚙️ Step 6 — DB Connection Configure করো

```bash
sudo nano /var/www/html/api/config/db.php
```

এই values গুলো তোমার MySQL অনুযায়ী set করো:

```php
<?php
$host     = "localhost";
$user     = "root";
$password = "your_password";
$database = "atithi_db";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
  die(json_encode(["success" => false, "message" => "Connection failed"]));
}
?>
```

---

## 🌍 Step 7 — Browser এ Open করো

```
http://localhost
```

---

## 🔁 Quick Reference

| Command | কাজ |
|---------|-----|
| `sudo service apache2 status` | Apache চলছে কিনা দেখো |
| `sudo service apache2 start` | Apache চালু করো |
| `sudo service apache2 stop` | Apache বন্ধ করো |
| `sudo service apache2 restart` | Apache restart করো |
| `sudo service mysql start` | MySQL চালু করো |
| `sudo service mysql status` | MySQL চলছে কিনা দেখো |

---

## ⚠️ Note

> এই project শুধুমাত্র **local lab environment** এ run করার জন্য। Cybersecurity practice এর বাইরে ব্যবহার করবে না।