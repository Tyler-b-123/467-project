DROP TABLE quantity;
DROP TABLE admin;
DROP TABLE warehouse;

CREATE TABLE quantity (

number		int NOT NULL,
qty		int NOT NULL,

PRIMARY KEY (number) );

CREATE TABLE admin (

name		CHAR(20) NOT NULL,
weight		float(10,2) NOT NULL,
shipDate	CHAR(20) NOT NULL,
status		CHAR(20) NOT NULL,
price		float(10,2) NOT NULL,

PRIMARY KEY (name) );

CREATE TABLE warehouse (
name		CHAR(30) NOT NULL,
email		CHAR(40) NOT NULL,
number 		int NOT NULL,
qty		int NOT NULL,
address    	CHAR(100) NOT NULL,

PRIMARY KEY (number) );
