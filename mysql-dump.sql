CREATE TABLE users
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(10) NOT NULL,
    last_name VARCHAR(10) NOT NULL,
    is_admin BOOLEAN,
    category VARCHAR(20) NOT NULL
);

CREATE TABLE tasks
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR (50) NOT NULL,
    description TEXT,
    status VARCHAR(20) DEFAULT 'to-do',
    estimated_hours INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    deleted_at DATETIME DEFAULT NULL
);

CREATE TABLE task_progress
(
    id INT AUTO_INCREMENT,
    task_id INT,
    FOREIGN KEY (task_id) REFERENCES tasks (id),
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users (id),
    name VARCHAR(40) NOT NULL,
    spent_hours INT

);

CREATE TABLE task_files
(
    id INT AUTO_INCREMENT,
    task_id INT,
    FOREIGN KEY (task_id) REFERENCES tasks (id),
    file_path VARCHAR(100) NOT NULL
);

CREATE TABLE task_status_history
(
    id INT AUTO_INCREMENT,
    task_id INT,
    FOREIGN KEY (task_id) REFERENCES tasks (id),
    old_status VARCHAR(20) NOT NULL ,
    new_status VARCHAR(20) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE task_assigment_history
(
    id INT AUTO_INCREMENT,
    task_id INT,
    FOREIGN KEY (task_id) REFERENCES tasks (id),
    old_user_id INT,
    FOREIGN KEY (old_user_id) REFERENCES users (id),
    new_user_id INT,
    FOREIGN KEY (new_user_id) REFERENCES users (id)
);
CREATE TABLE comments
(
    id INT AUTO_INCREMENT,
    task_id INT ,
    FOREIGN KEY (task_id) REFERENCES tasks (id),
    text TEXT NOT NULL
)