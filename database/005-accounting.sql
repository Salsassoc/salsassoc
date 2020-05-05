CREATE TABLE IF NOT EXISTS accounting_account (
   id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
   label VARCHAR(100) NOT NULL,
   type INTEGER NOT NULL
);

CREATE TABLE IF NOT EXISTS accounting_operation_category (
   id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
   label VARCHAR(100) NOT NULL,
   account_number INTEGER NULL
);

CREATE TABLE IF NOT EXISTS accounting_operation (
   id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
   date_value DATE NULL,
   label VARCHAR(100) NOT NULL,
   category INTEGER NULL,
   op_method INTEGER NULL,
   op_method_number VARCHAR(50) NULL,
   amount_debit FLOAT NULL,
   amount_credit FLOAT NULL,
   date_effective DATE NULL,
   project_id INTEGER NULL,
   checked BOOLEAN NOT NULL,
   fiscalyear_id INTEGER NOT NULL,
   account_id INTEGER NULL,
   label_bank TEXT NOT NULL
);


ALTER TABLE accounting_operation_category ADD COLUMN account_name VARCHAR(100) NULL;
ALTER TABLE accounting_operation_category ADD COLUMN account_type INTEGER NOT NULL DEFAULT 0;
ALTER TABLE accounting_operation_category ADD COLUMN is_internal_move BOOLEAN NOT NULL DEFAULT FALSE;

