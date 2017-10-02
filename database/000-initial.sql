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
