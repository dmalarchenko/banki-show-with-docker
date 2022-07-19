CREATE TABLE images (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `name` varchar(100) NOT NULL,
    `uploaded_at` timestamp DEFAULT CURRENT_TIMESTAMP
)