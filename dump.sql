USE task_manager;

CREATE TABLE users(
    id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(20) NOT NULL
);

CREATE TABLE tasks(
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255),
    description TEXT,
    assigned_user INT,
    created_at DATETIME,
    updated_at DATETIME,
    status ENUM('NEW','IN PROGRESS','REVIEW','DONE'),
    FOREIGN KEY (assigned_user) REFERENCES users(id)
);