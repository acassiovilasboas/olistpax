-- CREATE DATABASE olist_test;
-- USE DATABASE olist_test
CREATE TABLE IF NOT EXISTS brazil_states (
    id INT(11) NOT NULL AUTO_INCREMENT,
    state_id INT(11),
    name VARCHAR(100),
    sigla VARCHAR(10),
    created_at TIMESTAMP DEFAULT current_timestamp,
    updated_at TIMESTAMP DEFAULT current_timestamp ON UPDATE current_timestamp,
    PRIMARY KEY (id)
    );

CREATE TABLE IF NOT EXISTS category (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    `created_at` timestamp DEFAULT current_timestamp,
    `updated_at` timestamp DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
    );

CREATE TABLE IF NOT EXISTS product (
    id INT(11) NOT NULL AUTO_INCREMENT,
    category_id INT(11) NOT NULL,
    name VARCHAR(255) NOT NULL,
    quantity INT(11) DEFAULT 0,
    price FLOAT(10,2) NOT NULL,
    `created_at` timestamp DEFAULT current_timestamp,
    `updated_at` timestamp DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE ON UPDATE CASCADE
    );

