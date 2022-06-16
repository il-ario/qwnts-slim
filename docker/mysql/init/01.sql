-- Users
CREATE TABLE users (
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    givenName VARCHAR(255) NOT NULL,
    familyName VARCHAR(255) DEFAULT NULL,
    email VARCHAR(255) NOT NULL,
    birthDate TIMESTAMP DEFAULT NULL,
    password VARCHAR(255) NOT NULL,
    createdAt TIMESTAMP DEFAULT NOW(),
    updatedAt TIMESTAMP DEFAULT NOW(),
    UNIQUE KEY (email)
);

-- Dummy users
INSERT INTO users (givenName, familyName, email, birthDate, password, createdAt, updatedAt)
VALUES
	('Mario', 'Mario', 'mario@bros.com', '1981-01-01', SHA1('Password1.'), NOW() - INTERVAL 1 DAY, NOW() - INTERVAL 1 DAY),
	('Mario', 'Luigi', 'luigimario@bros.com', NULL, SHA1('Password1.'), NOW(), NOW());

-- Posts
CREATE TABLE posts (
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    body VARCHAR(255) NOT NULL,
    status ENUM('offline', 'online') NOT NULL,
    createdAt TIMESTAMP DEFAULT NOW(),
    updatedAt TIMESTAMP DEFAULT NOW()
);

-- Dummy posts
INSERT INTO posts (title, body, status, createdAt, updatedAt)
VALUES
	('Lorem ipsum', "Lorem ipsum dolor sit amet, consectetur adipiscing elit.", 'offline', NOW() - INTERVAL 1 DAY, NOW() - INTERVAL 1 DAY),
	('Dolor sit amet', "Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.", 'online', NOW(), NOW());
