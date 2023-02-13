# Database stuff

One should run this scripts in mysql workbench or terminal to create all necessary tables

# Create products table

CREATE TABLE IF NOT EXISTS products(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    sku varchar(100) UNIQUE NOT NULL,
    name varchar(100) NOT NULL,
    price decimal(15,2) NOT NULL,
    unit varchar(50),
    product_type varchar(50) NOT NULL
);

# Create table for books dimension

CREATE TABLE IF NOT EXISTS books_dimension(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    weight decimal(15,2) NOT NULL,
    product_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE
);

# Create Table for dvd dimenisons

CREATE TABLE IF NOT EXISTS dvd_dimension(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    size decimal(15,2) NOT NULL,
    product_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE
);

# Create table for furniture dimension

CREATE TABLE IF NOT EXISTS furniture_dimension(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    length decimal(15,2) NOT NULL,
    width decimal(15,2) NOT NULL,
    height decimal(15,2) NOT NULL,
    product_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE
);