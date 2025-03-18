CREATE DATABASE IF NOT EXISTS vcs;

USE vcs;

DROP TABLE IF EXISTS `users`;


CREATE TABLE `users` {
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` var(30) NOT NULL,
    `password` var(40) NOT NULL,
    `fullname` var(40) NOT NULL,
    `phone_number` var(30) NOT NULL,
    PRIMARY KEY(`id`)
}