CREATE DATABASE smart_wallet;
USE smart_wallet;

CREATE TABLE incomes(
	id int auto_increment primary key,
    amount DOUBLE NOT NULL,
    date_income DATE NOT NULL DEFAULT (CURDATE()),
    destination enum("freelance", "salary", "buisness", "transfert") NOT NULL,
    description TEXT NOT NULL
);

CREATE TABLE expenses(
	id int auto_increment primary key,
    amount DOUBLE NOT NULL,
    date_expense DATE NOT NULL DEFAULT (CURDATE()),
    destination enum('shoping','food','bills','transport','trips')NOT NULL,
    description TEXT NOT NULL
);

create table cards(
	ID int primary key AUTO_increment,
	bank enum('CIH Bank','BMCE','Bank Populaire','Credit Maroc'),
	card_number VARCHAR(16) unique NOT NULL,
	user_id int NOT NULL,
	foreign key(user_id) references users(id) ON DELETE cascade
)
