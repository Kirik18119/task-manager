USE task_manager;

CREATE TABLE users(
    id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(20) NOT NULL
);

CREATE TABLE tasks(
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255),
    description TEXT,
    assigned_user INT,
    date_time_of_creation DATETIME,
    date_time_of_last_update DATETIME,
    status VARCHAR(10),
    FOREIGN KEY (assigned_user) REFERENCES users(id)
);