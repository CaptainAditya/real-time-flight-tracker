CREATE TABLE `Airlines` (
	`ageFleet` DECIMAL,
	`callsign` varchar(255),
	`codeHub` varchar(255),
	`codeIataAirline` varchar(255),
	`codeIcaoAirline` varchar(255),
	`founding` INT(255),
	`nameAirline` varchar(255),
	`nameCountry` varchar(255),
	`sizeAirline` INT(255),
	PRIMARY KEY (`codeIcaoAirline`)
);

CREATE TABLE `Airports` (
	`codeIataAirport` varchar(255),
	`codeIcaoAirport` varchar(255) ,
	`latitudeAirport` DECIMAL(65),
	`longitudeAirport` DECIMAL(65),
	`nameAirport` varchar(255),
	`nameCountry` varchar(255),
	`time_zone` varchar(255),
	PRIMARY KEY (`codeIcaoAirport`)
);

CREATE TABLE `Airplane` (
	`airplaneIataType` VARCHAR(255) ,
	`engineCount` INT ,
	`enginesType` VARCHAR(255) ,
	`numberRegistration` VARCHAR(255) ,
	`planeAge` INT,
	`productionLine` VARCHAR(255) ,
	PRIMARY KEY (`numberRegistration`)
);

CREATE TABLE `departures` (
	`flightICAO` varchar(255) UNIQUE,
	`depIcaoCode` varchar(255),
	`depIataCode` varchar(255)
);

CREATE TABLE `arrivals` (
	`flightICAO` varchar(255) UNIQUE,
	`arrivalIcaoCode` varchar(255) ,
	`arrivalIataCode` varchar(255) 
);

CREATE TABLE `flight` (
	`aircraftRegNumber` varchar(255) UNIQUE,
	`airlineIcaoCode` varchar(255) UNIQUE,
	`flightIcaoNumber` varchar(255) UNIQUE,
	`status` varchar(255) ,
	PRIMARY KEY (`aircraftRegNumber`,`airlineIcaoCode`,`flightIcaoNumber`)
);

CREATE TABLE `Current_Status` (
	`flightICAO` varchar(255) UNIQUE,
	`altitude` DECIMAL ,
	`direction` DECIMAL ,
	`latitude` DECIMAL ,
	`longitude` DECIMAL ,
	`horizontalSpeed` DECIMAL ,
	`verticalSpeed` DECIMAL ,
	`isGround` DECIMAL ,
	PRIMARY KEY (`flightICAO`)
);

ALTER TABLE `departures` ADD CONSTRAINT `departures_fk0` FOREIGN KEY (`flightICAO`) REFERENCES `flight`(`flightIcaoNumber`);

ALTER TABLE `arrivals` ADD CONSTRAINT `arrivals_fk0` FOREIGN KEY (`flightICAO`) REFERENCES `flight`(`flightIcaoNumber`);

ALTER TABLE `flight` ADD CONSTRAINT `flight_fk0` FOREIGN KEY (`aircraftRegNumber`) REFERENCES `Airplane`(`numberRegistration`);

ALTER TABLE `flight` ADD CONSTRAINT `flight_fk1` FOREIGN KEY (`airlineIcaoCode`) REFERENCES `Airlines`(`codeIcaoAirline`);

ALTER TABLE `Current_Status` ADD CONSTRAINT `Current_Status_fk0` FOREIGN KEY (`flightICAO`) REFERENCES `flight`(`flightIcaoNumber`);








