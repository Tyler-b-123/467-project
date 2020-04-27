DROP TABLE shipping;

CREATE TABLE shipping (

placment	int NOT NULL AUTO_INCREMENT,
first		int NOT NULL,
second 		int NOT NULL,
price		float(10,2) NOT NULL,
PRIMARY KEY(placment) );

INSERT INTO shipping (first, second, price) VALUES (0,24,3.99);
INSERT INTO shipping (first, second, price) VALUES (25,49,6.99);
INSERT INTO shipping (first, second, price) VALUES (50,74,9.99);
INSERT INTO shipping (first, second, price) VALUES (75,500,12.99);

