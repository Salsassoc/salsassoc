CREATE TABLE membership (
   id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
   person_id INTEGER NOT NULL,
   lastname VARCHAR(50) NOT NULL,
   firstname VARCHAR(50) NOT NULL,
   gender INTEGER NOT NULL,
   birthdate DATE NULL,
   address VARCHAR(100) NULL,
   zipcode INTEGER NULL,
   city VARCHAR(50) NULL,
   email VARCHAR(150) NULL,
   phonenumber VARCHAR(150) NULL,
   image_rights BOOLEAN NULL,
   membership_date DATETIME NOT NULL,
   membership_type INTEGER NOT NULL,
   fiscal_year_id INTEGER NOT NULL
);

INSERT INTO membership (person_id, lastname,  firstname, gender, birthdate, address, zipcode, city, email, phonenumber, image_rights, membership_date, membership_type, fiscal_year_id)
SELECT person_id,  lastname,  firstname, gender, birthdate, address, zipcode, city, email, phonenumber, image_rights, cotisation_member.date, 1, fiscal_year_id
FROM person, cotisation_member, cotisation
WHERE person.id = person_id AND cotisation_id = cotisation.id
GROUP BY fiscal_year_id, person_id
ORDER BY fiscal_year_id, lastname, firstname;

CREATE TABLE membership_cotisation (
   membership_id INTEGER NOT NULL,
   cotisation_id INTEGER NOT NULL,
   date DATE NOT NULL,
   amount FLOAT NOT NULL,
   payment_method INTEGER NULL
);

INSERT INTO membership_cotisation (membership_id, cotisation_id, date, amount, payment_method)
SELECT membership.id, cotisation_id, date, amount, payment_method
FROM membership, cotisation_member
WHERE membership.person_id = cotisation_member.person_id
AND membership_date = cotisation_member.date;

DROP TABLE cotisation_member;
