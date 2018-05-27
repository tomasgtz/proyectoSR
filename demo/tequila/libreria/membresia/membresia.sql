CREATE TABLE usuarios(
	id int AUTO_INCREMENT NOT NULL,
	nombre varchar(25) NOT NULL,
	password varchar(40) NOT NULL,
	intento int NOT NULL,
	hash varchar(25) NOT NULL,
	administrador boolean NOT NULL,
	estatus boolean NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE permisos(
	id int AUTO_INCREMENT NOT NULL,
	nombre varchar(25) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE usuarios_permisos(
	usuario int NOT NULL,
	permiso int NOT NULL,
	PRIMARY KEY (usuario, permiso)
	FOREIGN KEY (usuario) REFERENCES usuarios (id),
	FOREIGN KEY (permiso) REFERENCES permisos (id)
);