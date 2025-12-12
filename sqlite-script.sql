CREATE TABLE IF NOT EXISTS users
(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    first_name VARCHAR(40) NOT NULL,
    last_name VARCHAR(40) NOT NULL,
    email VARCHAR(40) NOT NULL,
    password VARCHAR(256) NOT NULL,
    is_admin BOOLEAN,
    category TINYINT(10) NOT NULL
    );

CREATE TABLE IF NOT EXISTS tasks
(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR (50) NOT NULL,
    description TEXT,
    status TINYINT(10) DEFAULT 1,
    estimated_hours INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    deleted_at DATETIME DEFAULT NULL,
    user_id int DEFAULT NULL,
    assigner_id int,
    FOREIGN KEY (assigner_id) REFERENCES users(id)
    );

CREATE TABLE IF NOT EXISTS task_progress
(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    task_id INT,
    updater_id INT,
    name VARCHAR(40) NOT NULL,
    spent_hours INT,
    FOREIGN KEY (task_id) REFERENCES tasks (id),
    FOREIGN KEY (updater_id) REFERENCES users(id)
    );

CREATE TABLE IF NOT EXISTS task_files
(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    task_id INT,
    file_path TEXT NOT NULL,
    FOREIGN KEY (task_id) REFERENCES tasks (id)
    );

CREATE TABLE IF NOT EXISTS task_status_history
(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    task_id INT,
    updater_id INT,
    old_status TINYINT(10) NOT NULL,
    new_status TINYINT(10) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (task_id) REFERENCES tasks (id),
    FOREIGN KEY (updater_id) REFERENCES users (id)
    );

CREATE TABLE IF NOT EXISTS task_assignment_history
(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    task_id INT,
    assigner_id INT,
    old_user_id INT,
    new_user_id INT,
    FOREIGN KEY (task_id) REFERENCES tasks (id),
    FOREIGN KEY (assigner_id) REFERENCES users(id)
    );

CREATE TABLE IF NOT EXISTS comments
(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    task_id INT,
    commentator_id INT,
    text TEXT NOT NULL,
    FOREIGN KEY (task_id) REFERENCES tasks (id),
    FOREIGN KEY (commentator_id) REFERENCES users (id)
);