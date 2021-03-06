CREATE DATABASE taskforce
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE  utf8_general_ci;
USE taskforce;

CREATE TABLE cities (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  city VARCHAR(64) NOT NULL,
  latitude INT NOT NULL,
  longitude INT NOT NULL
);

CREATE TABLE categories (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(128) NOT NULL UNIQUE,
  icon VARCHAR(128) NOT NULL UNIQUE
);

CREATE TABLE users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(64) NOT NULL,
  password VARCHAR(64) NOT NULL,
  avatar_path VARCHAR(128),
  birthday DATETIME,
  about TEXT,
  phone VARCHAR(64),
  email VARCHAR(64) NOT NULL UNIQUE,
  skype VARCHAR(64),
  another_contact VARCHAR(64),
  registration_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  last_visit DATETIME,
  rank INT DEFAULT '0',
  address VARCHAR(128),
  city_id INT UNSIGNED NOT NULL,
  role ENUM('customer', 'executor'),
  FOREIGN KEY (city_id) REFERENCES cities (id)
);

CREATE TABLE photos_work (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  image_path VARCHAR(255) NOT NULL,
  user_id INT UNSIGNED NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
);

CREATE TABLE tasks (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(128) NOT NULL,
  description TEXT NOT NULL,
  budget INT,
  creation_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  expire DATETIME,
  status ENUM('new', 'cancelled', 'in_work', 'completed', 'failed'),
  category_id INT UNSIGNED NOT NULL,
  address VARCHAR(128),
  city_id INT UNSIGNED,
  creator_id INT UNSIGNED,
  executor_id INT UNSIGNED,
  latitude INT NOT NULL,
  longitude INT NOT NULL,
  FOREIGN KEY (category_id) REFERENCES categories (id),
  FOREIGN KEY (city_id) REFERENCES cities (id),
  FOREIGN KEY (creator_id) REFERENCES users (id) ON DELETE SET NULL,
  FOREIGN KEY (executor_id) REFERENCES users (id) ON DELETE SET NULL
);

CREATE TABLE attachments (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  url_file VARCHAR(128) NOT NULL,
  user_id INT UNSIGNED,
  task_id INT UNSIGNED NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE SET NULL,
  FOREIGN KEY (task_id) REFERENCES tasks (id) ON DELETE CASCADE
);

CREATE TABLE replies (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  description TEXT NOT NULL,
  creation_time DATETIME DEFAULT CURRENT_TIMESTAMP,
  rate INT,
  user_id INT UNSIGNED NOT NULL,
  task_id INT UNSIGNED NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
  FOREIGN KEY (task_id) REFERENCES tasks (id) ON DELETE CASCADE
);

CREATE TABLE user_categories (
  user_id INT UNSIGNED NOT NULL,
  category_id INT UNSIGNED NOT NULL,
  PRIMARY KEY (user_id, category_id),
  FOREIGN KEY (user_id) REFERENCES users (id),
  FOREIGN KEY (category_id) REFERENCES categories (id)
);

CREATE TABLE reviews (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  review_text TEXT,
  evaluation INT DEFAULT '0',
  task_id INT UNSIGNED,
  user_id INT UNSIGNED,
  FOREIGN KEY (task_id) REFERENCES tasks (id) ON DELETE SET NULL,
  FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE SET NULL
);

CREATE TABLE messages (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  message_text TEXT,
  creation_time DATETIME DEFAULT CURRENT_TIMESTAMP,
  user_id INT UNSIGNED,
  task_id INT UNSIGNED,
  FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE SET NULL,
  FOREIGN KEY (task_id) REFERENCES tasks (id) ON DELETE CASCADE
);



