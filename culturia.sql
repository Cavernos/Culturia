CREATE DATABASE IF NOT EXISTS culturia_test;
USE culturia_test;

DROP TABLE IF EXISTS artwork_category;
DROP TABLE IF EXISTS category;
DROP TABLE IF EXISTS reviews;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS artwork;
DROP TABLE IF EXISTS artists;
DROP TABLE IF EXISTS clients;




CREATE TABLE IF NOT EXISTS clients (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    name INT,
    avatar VARCHAR(128),
    email VARCHAR(128),
    password_hash VARCHAR(128),
    inscription_date DATE,
    modification_date DATE
);

CREATE TABLE IF NOT EXISTS artists (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    name INT,
    avatar VARCHAR(128),
    email VARCHAR(128),
    password_hash VARCHAR(128),
    inscription_date DATE,
    modification_date DATE
);

CREATE TABLE IF NOT EXISTS artwork (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    name VARCHAR(128),
    description VARCHAR(256),
    creation_date DATE,
    modification_date DATE,
    price INT,
    image VARCHAR(128),
    artist_id INT,
    FOREIGN KEY (artist_id) REFERENCES artists (id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS category (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    name VARCHAR(128),
    description VARCHAR(256)
);

CREATE TABLE IF NOT EXISTS artwork_category (
    artwork_id INT,
    category_id INT,
    FOREIGN KEY (artwork_id) REFERENCES  artwork (id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE,
    PRIMARY KEY (artwork_id, category_id)
);

CREATE TABLE IF NOT EXISTS orders (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    order_date DATE,
    client_address VARCHAR(128),
    previsionnal_delivery DATE,
    artwork_id INT,
    client_id INT,
    FOREIGN KEY (artwork_id) REFERENCES artwork (id) ON DELETE CASCADE,
    FOREIGN KEY (client_id) REFERENCES clients (id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS reviews (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    rate INTEGER,
    review_date DATE,
    comment VARCHAR(256),
    order_id INT,
    client_id INT,
    FOREIGN KEY (order_id) REFERENCES orders (id) ON DELETE CASCADE,
    FOREIGN KEY (client_id) REFERENCES clients (id) ON DELETE CASCADE
);
INSERT INTO artists (name,avatar,email, password_hash, inscription_date, modification_date) VALUES ("Alessandro", "", "alessandro.ian@isep.fr", "fksjgjz", "2025-06-21", "2025-06-21");
INSERT INTO artwork (name,description,creation_date, modification_date, price, image, artist_id) VALUES ("Oeuvre 1", "Lorem ipsum", "2025-06-21", "2025-06-21", "650€", "/assets/img/oeuvre_1.png", 1)