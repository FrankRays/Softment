/* Drop tables */
DROP TABLE IF EXISTS 'user';
DROP TABLE IF EXISTS 'customer';
DROP TABLE IF EXISTS 'project';
DROP TABLE IF EXISTS 'resource';
DROP TABLE IF EXISTS 'task';
DROP TABLE IF EXISTS 'team';
DROP TABLE IF EXISTS 'team_member';


/* Create tables */
CREATE TABLE `user` (
	`id`	INTEGER,
	`nickname`	VARCHAR(20) UNIQUE,
	`password`	VARCHAR(32),
	`name`	VARCHAR(64),
	`type` INTEGER, /* 1 Director - 2 Jefe - 3 Equipo */
	PRIMARY KEY(`id`)
);

CREATE TABLE `customer` (
	`id`	INTEGER,
	`name`	INTEGER NOT NULL UNIQUE,
	`email`	INTEGER,
	`telephone`	INTEGER,
	PRIMARY KEY(`id`)
);

CREATE TABLE `project` (
	`id`	INTEGER,
	`customer_id`	INTEGER,
	`manager_id` INTEGER,
	`name`	VARCHAR(20) NOT NULL UNIQUE,
	`description`	TEXT,
	`creation_date`	INTEGER,
	`state`	VARCHAR(16) NOT NULL,
	`finish_date` INTEGER,
	PRIMARY KEY(`id`),
	FOREIGN KEY(`customer_id`) REFERENCES `customer`(`id`),
	FOREIGN KEY(`manager_id`) REFERENCES `user`(`id`) 
);

CREATE TABLE `resource` (
	`id`	INTEGER,
	`project_id`	INTEGER,
	`type`	VARCHAR(16),
	`name`	VARCHAR(32),
	`email` VARCHAR(64),
	`state`	VARCHAR(16),
	PRIMARY KEY(`id`),
	FOREIGN KEY(`project_id`) REFERENCES `project`(`id`)
);

CREATE TABLE `task` (
	`id`	INTEGER,
	`project_id` INTEGER,
	`name`	VARCHAR(32) NOT NULL,
	`description`	VARCHAR(64),
	`start_date`	INTEGER NOT NULL,
	`state`	VARCHAR(16) NOT NULL,
	`finish_date`	INTEGER NOT NULL,
	PRIMARY KEY(`id`),
	FOREIGN KEY(`project_id`) REFERENCES `project`(`id`)
);

CREATE TABLE `team`(
	`id` INTEGER,
	`project_id` INTEGER,
	`name` INTEGER NOT NULL,
	`state` VARCHAR(16) NOT NULL,
	PRIMARY KEY(`id`),
	FOREIGN KEY(`project_id`) REFERENCES `project`(`id`)
);

CREATE TABLE `team_member`(
	`id` INTEGER,
	`resource_id` INTEGER,
	`team_id` INTEGER,
	PRIMARY KEY(`id`),
	FOREIGN KEY(`resource_id`) REFERENCES resource(`id`),
	FOREIGN KEY(`team_id`) REFERENCES team(`id`)
);

/* Poblate table */
INSERT INTO user(nickname, password, name, type)
	VALUES ("Director", "1234", "Juan Hernández Cabrera", 1);
INSERT INTO user(nickname, password, name, type)
	VALUES ("Jefe", "1234", "Manolo Ramírez", 2);
INSERT INTO user(nickname, password, name, type)
	VALUES ("Equipo", "1234", "Analistas", 3);

INSERT INTO customer(name, email)
	VALUES ("Ingeniería de Requisitos", "ir@is.com");
INSERT INTO customer(name, email)
	VALUES ("Ascensores Cristaleros S.A", "ascensoinseguro@cristalero.com");
INSERT INTO customer(name, email)
	VALUES ("Seguridad Privatizada", "lovemostodo@sinprivacidad.com");

INSERT INTO project(customer_id, name, description, state)
	VALUES (1, "SoftMent", "Gestor de proyectos", "Sin asignar");
INSERT INTO project(customer_id, manager_id, name, description, state)
	VALUES (2, 2, "Elever", "Controlador de ascensores", "En proceso");
INSERT INTO project(customer_id, manager_id, name, description, state)
	VALUES (2, 2, "Descenser", "Controlador de descensores", "En proceso");
INSERT INTO project(customer_id, name, description, state)
	VALUES (3, "Stalk Cam", "Controlador de camaras de seguridad", "Finalizado");
	
INSERT INTO resource(type, name, state)
	VALUES ("EVE 24/7", "Héctor Déniz Álvarez", "Sin asignar");
INSERT INTO resource(type, name, state)
	VALUES ("Superviviente", "Carlos Esteban León", "Sin asignar");
INSERT INTO resource(type, name, state, project_id)
	VALUES ("Programador", "Zabai Armas Herrera", "Asignado", 2);

INSERT INTO task(project_id, name, description, start_date, state, finish_date)
	VALUES (2, "Analizar software similares", "Familiarizarse con software establecido en el mercado", 1490030081, "Sin empezar", 1489529681);
INSERT INTO task(project_id, name, description, start_date, state, finish_date)
	VALUES (2, "Modelado de negocio", "Diagramas de modelado de negocio", 1489511681, "En proceso", 1489529681);
INSERT INTO task(project_id, name, description, start_date, state, finish_date)
	VALUES (2, "Análisis de mercado", "Informe de mercado", 1488752081, "Finalizada", 1489097681);

INSERT INTO team(name, state)
	VALUES ("Analistas de GS1", "Sin asignar");
INSERT INTO team(project_id, name, state)
	VALUES (2, "Estudiantes de IR", "Asignado");
INSERT INTO team(project_id, name, state)
	VALUES (2, "Estudiantes de ADE", "Asignado");

INSERT INTO team_member(resource_id, team_id)
	VALUES (1, 1); /* Hector a GS1 */
INSERT INTO team_member(resource_id, team_id)
	VALUES (2, 2); /* Carlos a IR */
INSERT INTO team_member(resource_id, team_id)
	VALUES (3, 3); /* Zabai a ADE */
INSERT INTO team_member(resource_id, team_id)
	VALUES (2, 3);