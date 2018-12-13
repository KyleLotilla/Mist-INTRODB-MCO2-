INSERT INTO accounts (accountID, username, password, email, account_type)
VALUES (1, "GamerGirl", "23passWord", "GameGirl@example.com","Player");
INSERT INTO accounts (accountID, username, password, email, account_type)
VALUES (2, "GamerBoy", "PasswithCap5", "GameBoy@yahoo.com", "Player");
INSERT INTO accounts (accountID, username, password, email, account_type)
VALUES (3, "Test", "JustNumb3rs", "Test@example.com", "Developer");
INSERT INTO accounts (accountID, username, password, email, account_type)
VALUES (4, "Optimus Prime", "1mAdm1n", "SteveRob@hotmail.com", "Player");
INSERT INTO accounts (accountID, username, password, email, account_type)
VALUES (5, "4DM1N", "P4ssw0rd", "DevAd@gmail.com", "Developer");

INSERT INTO games (gameid, title, devID, price, date_published, description, image)
VALUES (1, "MineWorld", 3, 448.8, '2018-08-21', "Mining a world.", "GameImg/1mineworld.png");
INSERT INTO games (gameid, title, devID, price, date_published, description, image)
VALUES (2, "AttackMan", 3, 263.7, '2014-09-12', "Attacks Man with weapon.", "GameImg/2attackman.png");
INSERT INTO games (gameid, title, devID, price, date_published, description, image)
VALUES (3, "Game3", 3, 474.6, '2017-02-02', "Plays three games.", "GameImg/3game3.png");
INSERT INTO games (gameid, title, devID, price, date_published, description, image)
VALUES (4, "Norbert", 5, 0.0, '2017-10-08', "A Dog's world.", "GameImg/4norbert.png");
INSERT INTO games (gameid, title, devID, price, date_published, description, image)
VALUES (5, "Basoulo", 5, 389.9, '2017-10-09', "A cup on top of a head.", "GameImg/5basoulo.png");

INSERT INTO rating (accountID, gameID, liked)
VALUES (1, 1, 1);
INSERT INTO rating (accountID, gameID, liked)
VALUES (2, 2, 1);
INSERT INTO rating (accountID, gameID, liked)
VALUES (4, 2, 0);
INSERT INTO rating (accountID, gameID, liked)
VALUES (1, 2, 1);
INSERT INTO rating (accountID, gameID, liked)
VALUES (4, 3, 0);
 
INSERT INTO genres (gameID, genre)
VALUES (1, "Multiplayer");
INSERT INTO genres (gameID, genre)
VALUES (1, "RPG");
INSERT INTO genres (gameID, genre)
VALUES (2, "Shooter");
INSERT INTO genres (gameID, genre)
VALUES (2, "Singleplayer");
INSERT INTO genres (gameID, genre)
VALUES (2, "Strategy");
INSERT INTO genres (gameID, genre)
VALUES (3, "Strategy");
INSERT INTO genres (gameID, genre)
VALUES (3, "Puzzle");
INSERT INTO genres (gameID, genre)
VALUES (3, "Visual Novel");
INSERT INTO genres (gameID, genre)
VALUES (4, "MOBA");
INSERT INTO genres (gameID, genre)
VALUES (4, "Platformer");
INSERT INTO genres (gameID, genre)
VALUES (5, "Puzzle");
 
INSERT INTO valid_credit_card (credit_number, csv, expiration, payment_method)
VALUES ("4987-0424-9790-6165", 509, '2022-02-23', "Visa");
INSERT INTO valid_credit_card (credit_number, csv, expiration, payment_method)
VALUES ("4979-3641-6708-4481", 442, '2023-12-12', "Visa");
INSERT INTO valid_credit_card (credit_number, csv, expiration, payment_method)
VALUES ("5198-2299-5810-8892", 844, '2021-05-04', "Visa");
INSERT INTO valid_credit_card (credit_number, csv, expiration, payment_method)
VALUES ("4254-7590-4877-2293", 432, '2023-01-24', "Master Card");
INSERT INTO valid_credit_card (credit_number, csv, expiration, payment_method)
VALUES ("5106-3524-9709-4521", 104, '2022-05-15', "Master Card");
 
INSERT INTO transaction (transID, date_purchased, playerID, game_bought, amount_paid, payment_method, credit_number)
VALUES (1, '2018-08-12', 1, 1, 448.8, "Visa", "4987-0424-9790-6165");
INSERT INTO transaction (transID, date_purchased, playerID, game_bought, amount_paid, payment_method, credit_number)
VALUES (2, '2018-04-29', 2, 1, 448.8, "Visa", "4979-3641-6708-4481");
INSERT INTO transaction (transID, date_purchased, playerID, game_bought, amount_paid, payment_method, credit_number)
VALUES (3, '2018-05-13', 4, 5, 389.9, "Visa", "5198-2299-5810-8892");
INSERT INTO transaction (transID, date_purchased, playerID, game_bought, amount_paid, payment_method)
VALUES (4, '2018-08-22', 1, 4, 0.0, "Added to Library");
INSERT INTO transaction (transID, date_purchased, playerID, game_bought, amount_paid, payment_method, credit_number)
VALUES (5, '2018-01-11', 1, 5, 389.9, "Master Card", "5106-3524-9709-4521");
