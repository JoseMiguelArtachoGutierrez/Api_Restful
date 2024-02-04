CREATE DATABASE IF NOT EXISTS cursosapi;
USE cursosapi;
show tables from cursosapi;
DROP TABLE IF EXISTS ponentes;
CREATE TABLE `ponentes` (
                            `id` int NOT NULL AUTO_INCREMENT,
                            `nombre` varchar(40) DEFAULT NULL,
                            `apellidos` varchar(40) DEFAULT NULL,
                            `imagen` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                            `tags` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                            `redes` text,
                            CONSTRAINT pk_ponentes PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS usuarios;
CREATE TABLE IF NOT EXISTS `usuarios` (
    `id` int NOT NULL AUTO_INCREMENT,
    `nombre` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
    `apellidos` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
    `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `rol` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
    `confirmado` boolean DEFAULT FALSE,
    `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `token_exp` timestamp NULL DEFAULT NULL,

    CONSTRAINT pk_usuarios PRIMARY KEY(id),
    CONSTRAINT uq_email UNIQUE(email)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SELECT * FROM usuarios;
select * from ponentes;