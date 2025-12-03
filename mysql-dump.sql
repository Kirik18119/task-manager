CREATE TABLE users
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(40) NOT NULL,
    last_name VARCHAR(40) NOT NULL,
    is_admin BOOLEAN,
    category TINYINT(10) NOT NULL
);

CREATE TABLE tasks
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR (50) NOT NULL,
    description TEXT,
    status TINYINT(10) DEFAULT 1,
    estimated_hours INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at DATETIME DEFAULT NULL
);

CREATE TABLE task_progress
(
    id INT AUTO_INCREMENT,
    task_id INT,
    user_id INT,
    name VARCHAR(40) NOT NULL,
    spent_hours INT,
    FOREIGN KEY (task_id) REFERENCES tasks (id),
    FOREIGN KEY (user_id) REFERENCES users (id)
);

CREATE TABLE task_files
(
    id INT AUTO_INCREMENT,
    task_id INT,
    file_path TEXT NOT NULL,
    FOREIGN KEY (task_id) REFERENCES tasks (id)
);

CREATE TABLE task_status_history
(
    id INT AUTO_INCREMENT,
    task_id INT,
    old_status TINYINT(10) NOT NULL ,
    new_status TINYINT(10) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (task_id) REFERENCES tasks (id)
);
CREATE TABLE task_assigment_history
(
    id INT AUTO_INCREMENT,
    task_id INT,
    old_user_id INT,
    new_user_id INT,
    FOREIGN KEY (task_id) REFERENCES tasks (id),
    FOREIGN KEY (old_user_id) REFERENCES users (id),
    FOREIGN KEY (new_user_id) REFERENCES users (id)
);
CREATE TABLE comments
(
    id INT AUTO_INCREMENT,
    task_id INT,
    text TEXT NOT NULL,
    FOREIGN KEY (task_id) REFERENCES tasks (id)
);