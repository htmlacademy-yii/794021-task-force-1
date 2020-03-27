CREATE DATABASE 794021_taskforce
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE 794021_taskforce;

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,

    title VARCHAR(60) NOT NULL,
    text VARCHAR(255),
    category_id INT NOT NULL,
    state_id INT NOT NULL DEFAULT 0,

    customer_id INT NOT NULL,
    contractor_id INT DEFAULT NULL,

    city_id INT DEFAULT NULL,
    address VARCHAR(255) DEFAULT NULL,
    latitude DECIMAL(10, 8) DEFAULT NULL,
    longitude DECIMAL(11, 8) DEFAULT NULL,
    address_comment VARCHAR(255) DEFAULT NULL,

    budget INT DEFAULT NULL,

    due_date DATETIME NOT NULL,
    datetime_created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    FULLTEXT (title, text, address, address_comment)
  )
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci
;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(255) NOT NULL,
    email VARCHAR(254) UNIQUE NOT NULL,

    password_hash VARCHAR(255) NOT NULL,
    avatar_file VARCHAR(255) DEFAULT NULL,
    description VARCHAR(255),

    city_id INT NOT NULL,
    birthday DATE DEFAULT NULL,

    phone VARCHAR(25),
    skype VARCHAR(100),
    telegram VARCHAR(100),

    notify_on_message BOOLEAN DEFAULT 1,
    notify_on_task_changes BOOLEAN DEFAULT 1,
    notify_on_review BOOLEAN DEFAULT 1,

    show_contacts_only_to_customer BOOLEAN DEFAULT 1,
    hide_profile BOOLEAN DEFAULT 1,

    is_logged_in BOOLEAN DEFAULT 0,
    website_last_action_datetime DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    datetime_created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FULLTEXT (fullname, description)
  )
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci
;

/*  Email length
    Despite domain part may be up to 255 and name part up to 64 symbols,
    there is a restriction of the e-mailbox: 256, including '<' and '>' symbols,
    which gives 256 - 2 = 254 character-long email fields.
    https://blog.moonmail.io/what-is-the-maximum-length-of-a-valid-email-address-f712c6c4bc93
 */

/*  People names' length
    Name might be consisted of first, second (patronimic), and last.
    Mastercard limits first and second up to 22.
    My consideration is to 22 + 22 + 22 = 66,
    multiplied to UTF's length of 4, plus 2 spaces between the parts.
    Totel: (66 * 4) + 2 * 1 = 266.
    I also know the following:
    https://www.kalzumeus.com/2010/06/17/falsehoods-programmers-believe-about-names/
 */

CREATE TABLE contractors_applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    task_id INT NOT NULL,
    applicant_id INT NULL,
    text VARCHAR(255),
    budget INT DEFAULT NULL, # TODO
    datetime_created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
  )
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci
;

CREATE TABLE reviews (
    task_id INT NOT NULL,
    contractor_id int NOT NULL,
    customer_id int NOT NULL,
    rating int DEFAULT NULL,
    text VARCHAR(200) NOT NULL UNIQUE,
    FULLTEXT(text),
    CONSTRAINT id PRIMARY KEY (task_id, contractor_id, customer_id)
  )
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci
;

CREATE TABLE task_chats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    task_id INT NOT NULL,
    sender_id int NOT NULL,
    text VARCHAR(200) NOT NULL UNIQUE,
    datetime_created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FULLTEXT(text)
  )
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci
;

CREATE TABLE task_states (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL UNIQUE
  )
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci
;

CREATE TABLE task_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(30) NOT NULL UNIQUE,
    icon VARCHAR(255)
  )
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci
;

CREATE TABLE favourite_contractors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    contractor_id INT NOT NULL,
    UNIQUE KEY (customer_id, contractor_id)
  )
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci
;

CREATE TABLE contractors_occupations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contractor_id INT NOT NULL,
    occupation_id INT NOT NULL,
    UNIQUE KEY(contractor_id, occupation_id)
  )
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci
;

CREATE TABLE occupations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(30) NOT NULL UNIQUE
  )
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci
;

CREATE TABLE task_files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    task_id INT NOT NULL,
    display_name VARCHAR(512) NOT NULL, # TODO
    saved_name VARCHAR(60) NOT NULL UNIQUE # TODO
  )
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci
;

CREATE TABLE cities (
    id INT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    latitude DECIMAL(10, 8) DEFAULT NULL,
    longitude DECIMAL(11, 8) DEFAULT NULL,
    country_id INT DEFAULT NULL
  )
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci
;

CREATE TABLE countries (
    id INT PRIMARY KEY,
    title VARCHAR(100) NOT NULL
  )
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci
;
