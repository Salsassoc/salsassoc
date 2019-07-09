CREATE TABLE IF NOT EXISTS accounting_account (
   id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
   label VARCHAR(100) NOT NULL,
   type INTEGER NOT NULL,
   initial_amount FLOAT NOT NULL,
);

CREATE TABLE IF NOT EXISTS accounting_operation_category (
   id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
   label VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS accounting_operation (
   id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
   label VARCHAR(100) NOT NULL,
   category INTEGER NULL,
   date_value DATE NOT NULL,
   amount FLOAT NOT NULL,
   payment_method INTEGER NULL,
   payment_number VARCHAR(50) NULL,
   fiscalyear_id INTEGER NOT NULL,
   account_id INTEGER NULL,
   checked BOOLEAN NOT NULL,
   date_effective DATE NULL
);




