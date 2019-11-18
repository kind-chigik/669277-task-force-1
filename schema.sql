CREATE DATABASE taskforce
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE  utf8_general_ci;
USE taskforce;

CREATE TABLE city (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(64) NOT NULL,
  coordinates INT NOT NULL
);

CREATE TABLE category (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(128) NOT NULL UNIQUE
);

CREATE TABLE role (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(64) NOT NULL UNIQUE,
  creation_time DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE status_user (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(64) NOT NULL UNIQUE
);

CREATE TABLE status_task (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(64) NOT NULL UNIQUE
);

CREATE TABLE portfolio (
  id INT AUTO_INCREMENT PRIMARY KEY,
  image VARCHAR(255) NOT NULL
);

CREATE TABLE user (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(64) NOT NULL,
  password VARCHAR(64) NOT NULL,
  avatar VARCHAR(128),
  birthday DATETIME,
  description TEXT NOT NULL,
  phone VARCHAR(64),
  email VARCHAR(64) NOT NULL UNIQUE,
  skype VARCHAR(64),
  another_contact VARCHAR(64),
  registration_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  last_visit DATETIME,
  rank INT DEFAULT '0',
  city_id INT NOT NULL,
  role_id INT NOT NULL,
  status_id INT NOT NULL,
  photo_work_id INT,
  FOREIGN KEY (city_id) REFERENCES city (id),
  FOREIGN KEY (role_id) REFERENCES role (id),
  FOREIGN KEY (status_id) REFERENCES status_user (id),
  FOREIGN KEY (photo_work_id) REFERENCES portfolio (id)
);

CREATE TABLE attachment (
  id INT AUTO_INCREMENT PRIMARY KEY,
  url_file VARCHAR(128) NOT NULL,
  user_id INT NOT NULL,
  FOREIGN KEY (user_id) REFERENCES user (id)
);

CREATE TABLE reply (
  id INT AUTO_INCREMENT PRIMARY KEY,
  reply_text TEXT NOT NULL,
  creation_time DATETIME DEFAULT CURRENT_TIMESTAMP,
  user_id INT NOT NULL,
  FOREIGN KEY (user_id) REFERENCES user (id)
);

CREATE TABLE task (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(128) NOT NULL,
  discription TEXT NOT NULL,
  price INT NOT NULL,
  creation_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  category_id INT NOT NULL,
  city_id INT NOT NULL,
  creator_id INT NOT NULL,
  executor_id INT NOT NULL,
  status_id INT NOT NULL,
  attachment_id INT NOT NULL,
  reply_id INT NOT NULL,
  FOREIGN KEY (category_id) REFERENCES category (id),
  FOREIGN KEY (city_id) REFERENCES city (id),
  FOREIGN KEY (creator_id) REFERENCES user (id),
  FOREIGN KEY (executor_id) REFERENCES user (id),
  FOREIGN KEY (status_id) REFERENCES status_task (id),
  FOREIGN KEY (attachment_id) REFERENCES attachment (id),
  FOREIGN KEY (reply_id) REFERENCES reply (id)
);

CREATE TABLE specialization (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(128) NOT NULL UNIQUE,
  category_id INT NOT NULL,
  user_id INT,
  FOREIGN KEY (category_id) REFERENCES category (id),
  FOREIGN KEY (user_id) REFERENCES user (id)
);

CREATE TABLE review (
  id INT AUTO_INCREMENT PRIMARY KEY,
  review_text TEXT,
  evaluation INT NOT NULL,
  task_id INT,
  user_id INT NOT NULL,
  FOREIGN KEY (task_id) REFERENCES task (id),
  FOREIGN KEY (user_id) REFERENCES user (id)
);

CREATE TABLE message (
  id INT AUTO_INCREMENT PRIMARY KEY,
  message_text TEXT,
  creation_time DATETIME DEFAULT CURRENT_TIMESTAMP,
  user_id INT NOT NULL,
  task_id INT,
  FOREIGN KEY (user_id) REFERENCES user (id),
  FOREIGN KEY (task_id) REFERENCES task (id)
);



