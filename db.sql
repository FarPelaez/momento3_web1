CREATE DATABASE `realstatedb`;

CREATE TABLE `user` (
    `name` VARCHAR(40) NOT NULL,
    `lastname` VARCHAR(40) NOT NULL,
    `email` VARCHAR(30) NOT NULL,
    `type_id` VARCHAR(10) NOT NULL,
    `identification` VARCHAR(20) NOT NULL,
    `password` VARCHAR(16) NOT NULL
);

CREATE TABLE `property` (
    `title` VARCHAR(30) NOT NULL,
    `type` VARCHAR(30) NOT NULL,
    `address` VARCHAR(30) NOT NULL,
    `rooms` INT(3) NOT NULL,
    `price` INT(10) NOT NULL,
    `area` INT(4) NOT NULL
);