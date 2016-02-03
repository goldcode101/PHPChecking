-- Generates the base schema for the Checking application

CREATE TABLE IF NOT EXISTS transactions
(
    id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255),
    amount FLOAT(10, 2),
    balance FLOAT(15, 2)
);
