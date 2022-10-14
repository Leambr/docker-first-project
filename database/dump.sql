CREATE TABLE users 
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL, 
    is_admin BOOLEAN
); 

CREATE TABLE posts
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    content TEXT NOT NULL,
    published_at DATETIME,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
)