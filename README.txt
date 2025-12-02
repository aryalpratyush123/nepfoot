NepFoot - Simple PHP/MySQL e-commerce (College project)
Files: Basic structure using plain PHP (no frameworks). Designed for XAMPP.
Place this folder inside your htdocs (e.g. C:\xampp\htdocs\nepfoot_project) and open http://localhost/nepfoot_project

1) Import database:
 - Open phpMyAdmin -> Import -> choose sql/nepfoot.sql OR run the SQL script via MySQL.
 - Database name: nepfoot (script creates it)

2) Update DB connection (if needed) in includes/db.php:
 - Default host: localhost, user: root, password: (empty), db: nepfoot

3) Sample accounts:
 - admin@nepfoot.test / admin123
 - seller@nepfoot.test / seller123
 - customer@nepfoot.test / customer123

4) Features:
 - Registration & Login (roles: admin, seller, customer)
 - Product CRUD (admin manages all, seller manages their own)
 - Basic validation (server-side + HTML5)
 - Simple CSS for layout

This is minimal, educational code for college project. Do not use in production.
