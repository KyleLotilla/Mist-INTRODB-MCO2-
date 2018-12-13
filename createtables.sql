CREATE DATABASE mistdb;
USE mistdb;

CREATE TABLE accounts (
	accountID int(8) AUTO_INCREMENT,
	username varchar(32) NOT NULL UNIQUE,
	password varchar(32) NOT NULL,
	email varchar(255) NOT NULL,
	account_type ENUM('Player', 'Developer') NOT NULL,
	PRIMARY KEY (accountID)
	);
	
CREATE TABLE games (
	gameID int(8) AUTO_INCREMENT,
	title varchar(32) NOT NULL UNIQUE,
	devID int(8) NOT NULL,
	price decimal(10,2) NOT NULL,
	date_published date NOT NULL,
	description varchar(255),
	image varchar(255) NOT NULL,
	PRIMARY KEY (gameID),
	FOREIGN KEY (devID) REFERENCES accounts(accountID)
	);

CREATE TABLE rating (
	accountID int(8),
	gameID int(8),
	liked bool NOT NULL,
	PRIMARY KEY (accountID, gameID),
	FOREIGN KEY (accountID) REFERENCES accounts(accountID),
	FOREIGN KEY (gameID) REFERENCES games(gameID)
	);
	
CREATE TABLE genres (
	gameID int(8),
	genre varchar(32) NOT NULL,
	PRIMARY KEY(gameID, genre),
	FOREIGN KEY (gameID) REFERENCES games(gameID)
	);
    
CREATE TABLE valid_credit_card (
	credit_number char(19) NOT NULL,
	csv int(3) NOT NULL,
	expiration date NOT NULL,
	payment_method varchar(32) NOT NULL,
	PRIMARY KEY (credit_number)
	);

CREATE TABLE transaction (
	transID int(8) AUTO_INCREMENT,
	date_purchased date NOT NULL,
	playerID int(8) NOT NULL,
	game_bought int(8) NOT NULL,
	amount_paid decimal(10, 2) NOT NULL,
	payment_method varchar(32) NOT NULL,
	credit_number char(19),
	PRIMARY KEY (transID),
	FOREIGN KEY (playerID) REFERENCES accounts(accountID),
	FOREIGN KEY (game_bought) REFERENCES games(gameID),
	FOREIGN KEY (credit_number) REFERENCES valid_credit_card(credit_number)
	);