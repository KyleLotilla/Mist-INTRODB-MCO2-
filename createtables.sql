CREATE DATABASE mistdb;
USE mistdb;

CREATE TABLE accounts (
	accountID int(8) AUTO_INCREMENT,
	username varchar(32) NOT NULL UNIQUE,
	password varchar(32) NOT NULL,
	email_address varchar(255) NOT NULL UNIQUE,
	account_type ENUM('Player', 'Developer') NOT NULL,
	description varchar(255),
	PRIMARY KEY (accountID)
	);
	
CREATE TABLE games (
	gameID int(8) AUTO_INCREMENT,
	title varchar(32) NOT NULL UNIQUE,
	devID int(8) NOT NULL,
	price decimal(10,2),
	date_published date NOT NULL,
	likes int(10) DEFAULT 0,
	dislikes int(10) DEFAULT 0,
	description varchar(255),
	PRIMARY KEY (gameID),
	FOREIGN KEY (devID) REFERENCES accounts(accountID)
	);

CREATE TABLE genres (
	gameID int(8),
	multiplayer bool NOT NULL,
	single_player bool NOT NULL,
	moba bool NOT NULL,
	shooter bool NOT NULL,
	rpg bool NOT NULL,
	visual_novel bool NOT NULL,
	platformer bool NOT NULL,
	strategy bool NOT NULL,
	puzzle bool NOT NULL,
	PRIMARY KEY(gameID),
	FOREIGN KEY (gameID) REFERENCES games(gameID)
	);

CREATE TABLE transaction (
	transID int(8) AUTO_INCREMENT,
	date_purchased date NOT NULL,
	playerID int(8) NOT NULL,
	game_bought int(8) NOT NULL,
	amount_paid decimal(10, 2) NOT NULL,
	credit_number char(19) NOT NULL,
	csv int(3) NOT NULL,
	expiration date NOT NULL,
	PRIMARY KEY (transID),
	FOREIGN KEY (playerID) REFERENCES accounts(accountID),
	FOREIGN KEY (game_bought) REFERENCES games(gameID)
	);