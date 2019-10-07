CREATE TABLE registration (
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
   registration_date DATETIME NOT NULL,
   registration_type INTEGER NOT NULL,
   fiscal_year_id INTEGER NOT NULL
);

INSERT INTO registration (person_id, lastname,  firstname, gender, birthdate, address, zipcode, city, email, phonenumber, image_rights, registration_date, registration_type, fiscal_year_id)
SELECT person_id,  lastname,  firstname, gender, birthdate, address, zipcode, city, email, phonenumber, image_rights, cotisation_member.date, 1, fiscal_year_id
FROM person, cotisation_member, cotisation
WHERE person.id = person_id AND cotisation_id = cotisation.id
GROUP BY fiscal_year_id, person_id
ORDER BY fiscal_year_id, lastname, firstname;


