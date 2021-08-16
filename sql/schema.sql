CREATE DATABASE 794021_taskforce
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE 794021_taskforce;

CREATE TABLE city (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    latitude DECIMAL(10, 8) DEFAULT NULL,
    longitude DECIMAL(11, 8) DEFAULT NULL
);

CREATE TABLE task_state (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE task_category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(30) NOT NULL UNIQUE,
    icon VARCHAR(255)
);

CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(255) NOT NULL,
    email VARCHAR(254) UNIQUE NOT NULL,

    password_hash VARCHAR(255) NOT NULL,
    avatar_file VARCHAR(255) DEFAULT NULL,
    description VARCHAR(255),

    city_id INT NOT NULL,
      FOREIGN KEY (city_id) REFERENCES city(id),

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
);

/*  Email length limit
    Despite the fact 'Domain name after @' may be up to 255 symbols and
    'Name before @ may be up to 64 symbols', there is an additional restriction:
    e-mailbox lengthname <= 256, including '<' and '>' symbols,
    which gives 256 - 2 = 254 character-long email fields.
    https://blog.moonmail.io/what-is-the-maximum-length-of-a-valid-email-address-f712c6c4bc93
 */

/*  Person name length limit
    Name might be combined from first, second (patronimic), and last.
    The Mastercard limits first and second up to 22.
    This project consideration is: 22 + 22 + 22 = 66,
    multiplied to UTF's length of 4 bytes,
    plus 2 spaces between the parts.
    Total are: (66 * 4) + 2 * 1 = 266.

    Morover, see the following:
      https://www.kalzumeus.com/2010/06/17/falsehoods-programmers-believe-about-names/
 */
CREATE TABLE task (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    text VARCHAR(2000),

    category_id INT NOT NULL,
      FOREIGN KEY (category_id) REFERENCES task_category(id),
    state_id INT NOT NULL,
      FOREIGN KEY (state_id) REFERENCES task_state(id),
    customer_id INT NOT NULL,
      FOREIGN KEY (customer_id) REFERENCES user (id),
    contractor_id INT DEFAULT NULL,
      FOREIGN KEY (contractor_id) REFERENCES user (id),

    city_id INT DEFAULT NULL,
      FOREIGN KEY (city_id) REFERENCES city (id),
    address VARCHAR(255) DEFAULT NULL,
    latitude DECIMAL(10, 8) DEFAULT NULL,
    longitude DECIMAL(11, 8) DEFAULT NULL,
    address_comment VARCHAR(255) DEFAULT NULL,

    budget INT DEFAULT NULL,

    due_date DATETIME NOT NULL,
    datetime_created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    FULLTEXT (title, text, address, address_comment)
);

CREATE TABLE contractor_application (
    id INT AUTO_INCREMENT PRIMARY KEY,
    task_id INT NOT NULL,
      FOREIGN KEY (task_id) REFERENCES task(id),
    applicant_id INT NOT NULL,
      FOREIGN KEY (applicant_id) REFERENCES user(id),
    budget INT NOT NULL,
    text VARCHAR(2000),
    datetime_created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE review (
    id INT AUTO_INCREMENT PRIMARY KEY,
    task_id INT NOT NULL,
      FOREIGN KEY (task_id) REFERENCES task(id),
    contractor_id int NOT NULL,
      FOREIGN KEY (contractor_id) REFERENCES user(id),
    customer_id int NOT NULL,
      FOREIGN KEY (customer_id) REFERENCES user(id),
    rating int DEFAULT NULL,
    text VARCHAR(200) NOT NULL UNIQUE,

    FULLTEXT(text),
    UNIQUE KEY (task_id, contractor_id, customer_id)
);

CREATE TABLE message (
    id INT AUTO_INCREMENT PRIMARY KEY,
    task_id INT NOT NULL,
      FOREIGN KEY (task_id) REFERENCES task(id),
    sender_id int NOT NULL,
      FOREIGN KEY (sender_id) REFERENCES user(id),
    text VARCHAR(200) NOT NULL,
    datetime_created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    FULLTEXT(text)
);

CREATE TABLE favorite_contractor (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
      FOREIGN KEY (customer_id) REFERENCES user(id),
    contractor_id INT NOT NULL,
      FOREIGN KEY (contractor_id) REFERENCES user(id),
    UNIQUE KEY (customer_id, contractor_id)
);

CREATE TABLE contractor_occupation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contractor_id INT NOT NULL,
      FOREIGN KEY (contractor_id) REFERENCES user(id),
    occupation_id INT NOT NULL,
      FOREIGN KEY (occupation_id) REFERENCES task_category(id),

    UNIQUE KEY(contractor_id, occupation_id)
);

CREATE TABLE task_file (
    id INT AUTO_INCREMENT PRIMARY KEY,
    task_id INT NOT NULL,
      FOREIGN KEY (task_id) REFERENCES task(id),
    display_name VARCHAR(512) NOT NULL,
    saved_name VARCHAR(255) NOT NULL
);
