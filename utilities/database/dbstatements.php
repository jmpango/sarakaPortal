<?php

$dsn = 'mysql:host='.DB_HOST;
self::$db = new PDO($dsn, DB_USER, DB_PASS);
self::$db->query("CREATE DATABASE ".DB_NAME);
self::$db->query("USE ".DB_NAME);

/** CREATE TABLES */
self::$db->query("CREATE TABLE IF NOT EXISTS users(id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, password VARCHAR(255) NOT NULL, secret_answer VARCHAR(255), secret_question VARCHAR(255), record_status INT(5), username VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255), date_last_updated DATE, gender CHAR(1))");
self::$db->query("CREATE TABLE IF NOT EXISTS roles(id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, description VARCHAR(255) NOT NULL, role_name VARCHAR(255), date_last_updated DATE, record_status INT(5))");
self::$db->query("CREATE TABLE IF NOT EXISTS permissions(id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, description VARCHAR(255) NOT NULL, permission_name VARCHAR(255), date_last_updated DATE, record_status INT(5))");
self::$db->query("CREATE TABLE IF NOT EXISTS role_permission(role_id INT UNSIGNED NOT NULL, perm_id INT UNSIGNED NOT NULL, UNIQUE KEY role_perm_id(role_id, perm_id))");
self::$db->query("CREATE TABLE IF NOT EXISTS role_user(user_id INT UNSIGNED NOT NULL, role_id INT UNSIGNED NOT NULL, UNIQUE KEY role_user_id(user_id, role_id))");
self::$db->query("CREATE TABLE IF NOT EXISTS dashboard(id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, dname VARCHAR(255) NOT NULL, tagline VARCHAR(255) , date_last_updated DATE, record_status INT(5))");
self::$db->query("CREATE TABLE IF NOT EXISTS dashboardcategory(id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, cname VARCHAR(255) NOT NULL, date_last_updated DATE, record_status INT(5), dashboard_id INT NOT NULL, FOREIGN KEY(dashboard_id) REFERENCES dashboard(id))");
self::$db->query("CREATE TABLE IF NOT EXISTS buddy(id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, date_last_updated DATE, record_status INT(5), name VARCHAR(255) NOT NULL, tagline VARCHAR(255), address VARCHAR(255), telphone VARCHAR(255) NOT NULL, email VARCHAR(255), fax VARCHAR(255), url VARCHAR(255), dashboard_category_id INT NOT NULL, seed VARCHAR(255), FOREIGN KEY(dashboard_category_id) REFERENCES dashboardcategory(id))");
self::$db->query("CREATE TABLE IF NOT EXISTS buddy_ratings(id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, date_last_updated DATE, record_status INT(5), prv_rate INT, current_rate INT,  buddy_id INT NOT NULL, FOREIGN KEY(buddy_id) REFERENCES buddy(id))");
self::$db->query("CREATE TABLE IF NOT EXISTS buddy_locations(id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, date_last_updated DATE, record_status INT(5), location_name VARCHAR(255),  buddy_id INT NOT NULL, FOREIGN KEY(buddy_id) REFERENCES buddy(id))");
self::$db->query("CREATE TABLE IF NOT EXISTS buddy_search_tags(id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, date_last_updated DATE, record_status INT(5), search_value VARCHAR(255),  buddy_id INT NOT NULL, FOREIGN KEY(buddy_id) REFERENCES buddy(id))");
self::$db->query("CREATE TABLE IF NOT EXISTS buddy_comments(id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, date_last_updated DATE, record_status INT(5), comment VARCHAR(1000), author_name VARCHAR(255), date_submitted DATE, buddy_id INT NOT NULL, FOREIGN KEY(buddy_id) REFERENCES buddy(id))");
self::$db->query("CREATE TABLE IF NOT EXISTS buddy_usage(id INT PRIMARY KEY AUTO_INCREMENT, page_hits INT, call_hits INT, url_hits INT, email_hits INT, submitted_date DATE , buddy_id INT, FOREIGN KEY(buddy_id) REFERENCES buddy(id))");
self::$db->query("CREATE TABLE IF NOT EXISTS seeding(id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255), description VARCHAR(255))");

/** INSERT DATA */
self::$db->query("INSERT INTO permissions(id, description, permission_name, date_last_updated, record_status) VALUES (000001, 'DEFAULT ADMIN PERMISSION', 'PERM_ADMINISTRATOR', '2013-04-02', 1)");
self::$db->query("INSERT INTO roles(id, description, role_name, date_last_updated, record_status) VALUES (000001, 'DEFAULT ADMIN ROLE', 'ROLE_ADMINISTRATOR', '2013-04-02', 1)");
self::$db->query("INSERT INTO users(id, password, secret_answer, secret_question, username, first_name, last_name, date_last_updated, gender, record_status) VALUES ('000001','65b07af0391855176483c0949c23e487742d965f589f31ee05a1045d6a110812','Who created you?', 'UGBuddy', 'administrator', 'UGBuddy', 'Administrator', '2013-04-02', 'M', 1)");
self::$db->query("INSERT INTO role_permission(role_id, perm_id) VALUES (000001, 000001)");
self::$db->query("INSERT INTO role_user(user_id, role_id) VALUES (000001, 000001)");
?>