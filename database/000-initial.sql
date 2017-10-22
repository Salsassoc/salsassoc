CREATE TABLE IF NOT EXISTS configdb (
   id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
   migration INTEGER NOT NULL
);

CREATE TABLE IF NOT EXISTS person (
   id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
   lastname VARCHAR(50) NOT NULL,
   firstname VARCHAR(50) NOT NULL,
   gender INTEGER NOT NULL,
   birthdate DATE NULL,
   email VARCHAR(150) NULL,
   phonenumber VARCHAR(150) NULL,
   creation_date DATETIME NOT NULL,
   password VARCHAR(50),
   is_member BOOLEAN NOT NULL,
   image_rights BOOLEAN NULL,
   comments TEXT NULL
);

INSERT INTO configdb (migration) VALUES (1);

CREATE TABLE IF NOT EXISTS cotisation (
   id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
   label VARCHAR(50) NOT NULL,
   amount FLOAT NOT NULL,
   start_date DATE NOT NULL,
   end_date DATE NOT NULL
);

CREATE TABLE IF NOT EXISTS cotisation_member (
   person_id INTEGER NOT NULL,
   cotisation_id INTEGER NOT NULL,
   date DATE NOT NULL,
   amount FLOAT NOT NULL,
   payment_method INTEGER NULL
);
