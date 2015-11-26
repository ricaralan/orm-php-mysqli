CREATE DATABASE test_db;

USE test_db;

CREATE TABLE person(
per_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
per_name VARCHAR(30),
per_last_name VARCHAR(30)
);
