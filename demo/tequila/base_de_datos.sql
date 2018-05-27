CREATE TABLE estatus(
	id int auto_increment NOT NULL,
	nombre varchar(50) NOT NULL,
	CONSTRAINT PRIMARY KEY (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE permisos(
	id int auto_increment NOT NULL,
	nombre varchar(50) NOT NULL,
	CONSTRAINT PRIMARY KEY (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE perfiles(
	id int auto_increment NOT NULL,
	nombre varchar(50) NOT NULL,
	CONSTRAINT PRIMARY KEY (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE estados(
	id int auto_increment NOT NULL,
	nombre varchar(50) NOT NULL,
	CONSTRAINT PRIMARY KEY (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE municipios(
	id int auto_increment NOT NULL,
	idEstado int NOT NULL,
	nombre varchar(50) NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idEstado) REFERENCES estados(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE colonias(
	id int auto_increment NOT NULL,
	nombre varchar(150) NOT NULL,
	idEstado int NOT NULL,
	idMunicipio int NOT NULL,
	contacto varchar(250) NOT NULL,
	razonSocial varchar(250) NOT NULL,
	rfc varchar(20) NOT NULL,
	regimenFiscal Varchar(75) NOT NULL,
	idEstadoFiscal int NOT NULL,
	idMunicipioFiscal int NOT NULL,
	cpFiscal int NOT NULL,
	coloniaFiscal varchar(100) NOT NULL,
	calleFiscal varchar(100) NOT NULL,
	numeroInterior varchar(10) NOT NULL,
	numeroExterior varchar(10) NOT NULL,
	pathCer varchar(100) NOT NULL,
	pathKey varchar(100) NOT NULL,
	fechaRegistro datetime NOT NULL,
	fechaActualizo datetime NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idEstado) REFERENCES estados(id),
	CONSTRAINT FOREIGN KEY (idMunicipio) REFERENCES municipios(id),
	CONSTRAINT FOREIGN KEY (idEstadoFiscal) REFERENCES estados(id),
	CONSTRAINT FOREIGN KEY (idMunicipioFiscal) REFERENCES municipios(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE usuarios(
	id bigint auto_increment NOT NULL,
	nombre varchar(100) NOT NULL,
	correo varchar(125) NOT NULL,
	idPerfil int NOT NULL,
	idColonia int NOT NULL,
	password varchar(50) NOT NULL,
	intento int NOT NULL,
	hash varchar(40) NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idPerfil) REFERENCES perfiles(id),
	CONSTRAINT FOREIGN KEY (idColonia) REFERENCES colonias(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE perfiles_permisos(
	idPerfil int NOT NULL,
	idPermiso int NOT NULL,
	CONSTRAINT PRIMARY KEY (idPerfil, idPermiso),
	CONSTRAINT FOREIGN KEY (idPerfil) REFERENCES perfiles(id),
	CONSTRAINT FOREIGN KEY (idPermiso) REFERENCES permisos(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE tipos(
	id int auto_increment NOT NULL,
	nombre varchar(50) NOT NULL,
	color varchar(10) NOT NULL,
	idColonia int NOT NULL,
	idUsuarioRegistro bigint NOT NULL,
	fechaRegistro datetime NOT NULL,
	idUsuarioActualizo bigint NOT NULL,
	fechaActualizo datetime NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idColonia) REFERENCES colonias(id),
	CONSTRAINT FOREIGN KEY (idUsuarioRegistro) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idUsuarioActualizo) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE residentes(
	id bigint auto_increment NOT NULL,
	nombre varchar(100) NOT NULL,
	acumulado decimal(10,2) NOT NULL,
	telefono varchar(30) NOT NULL,
	correo varchar(125) NOT NULL,
	idColonia int NOT NULL,
	idUsuario bigint NOT NULL,
	datosFiscales boolean NOt NULL,
	razonSocial varchar(250) NOT NULL,
	rfc varchar(20) NOT NULL,
	idEstadoFiscal int NOT NULL,
	idMunicipioFiscal int NOT NULL,
	cpFiscal int NOT NULL,
	coloniaFiscal varchar(100) NOT NULL,
	calleFiscal varchar(100) NOT NULL,
	numeroInterior varchar(10) NOT NULL,
	numeroExterior varchar(10) NOT NULL,
	idUsuarioRegistro bigint NOT NULL,
	fechaRegistro datetime NOT NULL,
	idUsuarioActualizo bigint NOT NULL,
	fechaActualizo datetime NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idColonia) REFERENCES colonias(id),
	CONSTRAINT FOREIGN KEY (idUsuario) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idEstadoFiscal) REFERENCES estados(id),
	CONSTRAINT FOREIGN KEY (idMunicipioFiscal) REFERENCES municipios(id),
	CONSTRAINT FOREIGN KEY (idUsuarioRegistro) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idUsuarioActualizo) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE unidades(
	id int auto_increment NOT NULL,
	nombre varchar(50) NOT NULL,
	idColonia int NOT NULL,
	idUsuarioRegistro bigint NOT NULL,
	fechaRegistro datetime NOT NULL,
	idUsuarioActualizo bigint NOT NULL,
	fechaActualizo datetime NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idColonia) REFERENCES colonias(id),
	CONSTRAINT FOREIGN KEY (idUsuarioRegistro) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idUsuarioActualizo) REFERENCES usuarios(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE casas(
	id bigint auto_increment NOT NULL,
	nombre varchar(50) NOT NULL,
	direccion varchar(200) NOT NULL,
	idUnidad int NOT NULL,
	cantidad decimal(10,2) NOT NULL,
	idResidente bigint NOT NULL,
	idColonia int NOT NULL,
	idUsuarioRegistro bigint NOT NULL,
	fechaRegistro datetime NOT NULL,
	idUsuarioActualizo bigint NOT NULL,
	fechaActualizo datetime NOT NULL,
	idEstatus int(11) NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idUnidad) REFERENCES unidades(id),
	CONSTRAINT FOREIGN KEY (idResidente) REFERENCES residentes(id),
	CONSTRAINT FOREIGN KEY (idColonia) REFERENCES colonias(id),
	CONSTRAINT FOREIGN KEY (idUsuarioRegistro) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idUsuarioActualizo) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE cambios_casas(
	id bigint auto_increment NOT NULL,
	idCasa bigint NOT NULL,
	nombreCasa varchar(50) NOT NULL,
	idUnidad int NOT NULL,
	nombreUnidad varchar(50) NOT NULL,
	cantidad decimal(10,2) NOT NULL,
	idResidente bigint NOT NULL,
	nombreResidente varchar(100) NOT NULL,
	idColonia int NOT NULL,
	idUsuarioRegistro bigint NOT NULL,
	fechaRegistro datetime NOT NULL,
	idEstatus int(11) NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idCasa) REFERENCES casas(id),
	CONSTRAINT FOREIGN KEY (idUnidad) REFERENCES unidades(id),
	CONSTRAINT FOREIGN KEY (idResidente) REFERENCES residentes(id),
	CONSTRAINT FOREIGN KEY (idColonia) REFERENCES colonias(id),
	CONSTRAINT FOREIGN KEY (idUsuarioRegistro) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE estacionamientos(
	id bigint auto_increment NOT NULL,
	espacio varchar(50) NOT NULL,
	idResidente bigint NOT NULL,
	idColonia int NOT NULL,
	idUsuarioRegistro bigint NOT NULL,
	fechaRegistro datetime NOT NULL,
	idUsuarioActualizo bigint NOT NULL,
	fechaActualizo datetime NOT NULL,
	idEstatus int(11) NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idResidente) REFERENCES residentes(id),
	CONSTRAINT FOREIGN KEY (idColonia) REFERENCES colonias(id),
	CONSTRAINT FOREIGN KEY (idUsuarioRegistro) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idUsuarioActualizo) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE almacenes(
	id bigint auto_increment NOT NULL,
	almacen varchar(50) NOT NULL,
	descripcion varchar(100) NOT NULL,
	idResidente bigint NOT NULL,
	idColonia int NOT NULL,
	idUsuarioRegistro bigint NOT NULL,
	fechaRegistro datetime NOT NULL,
	idUsuarioActualizo bigint NOT NULL,
	fechaActualizo datetime NOT NULL,
	idEstatus int(11) NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idResidente) REFERENCES residentes(id),
	CONSTRAINT FOREIGN KEY (idColonia) REFERENCES colonias(id),
	CONSTRAINT FOREIGN KEY (idUsuarioRegistro) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idUsuarioActualizo) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE zonas(
	id int auto_increment NOT NULL,
	nombre varchar(100) NOT NULL,
	descripcion varchar (200) NOT NULL,
	costo decimal(10, 2) NOT NULL,
	solicitarPersonas boolean NOT NULL,
	verificarReservaciones boolean NOT NULL,
	idColonia int NOT NULL,
	idUsuarioRegistro bigint NOT NULL,
	fechaRegistro datetime NOT NULL,
	idUsuarioActualizo bigint NOT NULL,
	fechaActualizo datetime NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idColonia) REFERENCES colonias(id),
	CONSTRAINT FOREIGN KEY (idUsuarioRegistro) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idUsuarioActualizo) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE horarios(
	id int auto_increment NOT NULL,
	nombre varchar(100) NOT NULL,
	descripcion varchar (200) NOT NULL,
	idColonia int NOT NULL,
	idUsuarioRegistro bigint NOT NULL,
	fechaRegistro datetime NOT NULL,
	idUsuarioActualizo bigint NOT NULL,
	fechaActualizo datetime NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idColonia) REFERENCES colonias(id),
	CONSTRAINT FOREIGN KEY (idUsuarioRegistro) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idUsuarioActualizo) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE reservaciones(
	id bigint auto_increment NOT NULL,
	idResidente bigint NOT NULL,
	nombreResidente varchar (100) NOT NULL,
	idZona int NOT NULL,
	nombreZona varchar (100) NOT NULL,
	costoZona decimal(10, 2) NOT NULL,
	idHorario int NOT NULL,
	nombreHorario varchar(100) NOT NULL,
	fecha datetime NOT NULL,
	personas int NOT NULL,
	idColonia int NOT NULL,
	idUsuarioRegistro bigint NOT NULL,
	fechaRegistro datetime NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idResidente) REFERENCES residentes(id),
	CONSTRAINT FOREIGN KEY (idZona) REFERENCES zonas(id),
	CONSTRAINT FOREIGN KEY (idHorario) REFERENCES horarios(id),
	CONSTRAINT FOREIGN KEY (idColonia) REFERENCES colonias(id),
	CONSTRAINT FOREIGN KEY (idUsuarioRegistro) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE bancos(
	id int auto_increment NOT NULL,
	nombre varchar(50) NOT NULL,
	idColonia int NOT NULL,
	idUsuarioRegistro bigint NOT NULL,
	fechaRegistro datetime NOT NULL,
	idUsuarioActualizo bigint NOT NULL,
	fechaActualizo datetime NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idColonia) REFERENCES colonias(id),
	CONSTRAINT FOREIGN KEY (idUsuarioRegistro) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idUsuarioActualizo) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE reglamentos(
	id int auto_increment NOT NULL,
	nombre text(50) NOT NULL,
	idColonia int NOT NULL,
	idUsuarioRegistro bigint NOT NULL,
	fechaRegistro datetime NOT NULL,
	idUsuarioActualizo bigint NOT NULL,
	fechaActualizo datetime NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idColonia) REFERENCES colonias(id),
	CONSTRAINT FOREIGN KEY (idUsuarioRegistro) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idUsuarioActualizo) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE adjuntos_minutas(
	id bigint auto_increment NOT NULL,
	idMinuta bigint NOT NULL,
	paths varchar(100) NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idMinuta) REFERENCES minutas(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE cuentas(
	id int auto_increment NOT NULL,
	nombre varchar(50) NOT NULL,
	idColonia int NOT NULL,
	descripcion varchar(200) NOT NULL,
	idBanco int NOT NULL,
	nombreBanco varchar(50) NOT NULL,
	numero int NOT NULL,
	idUsuarioRegistro bigint NOT NULL,
	fechaRegistro datetime NOT NULL,
	idUsuarioActualizo bigint NOT NULL,
	fechaActualizo datetime NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idColonia) REFERENCES colonias(id),
	CONSTRAINT FOREIGN KEY (idBanco) REFERENCES bancos(id),
	CONSTRAINT FOREIGN KEY (idUsuarioRegistro) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idUsuarioActualizo) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE recargos(
	id bigint auto_increment NOT NULL,
	nombreRecargo varchar(100) NOT NULL,
	sobreTotal boolean NOT NULL,
	cantidad decimal(10, 2) NOT NULL,
	idTipo int NOT NULL,
	idColonia int NOT NULL,
	idUsuarioRegistro bigint NOT NULL,
	fechaRegistro datetime NOT NULL,
	idUsuarioActualizo bigint NOT NULL,
	fechaActualizo datetime NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idTipo) REFERENCES tipos_recargos(id),
	CONSTRAINT FOREIGN KEY (idColonia) REFERENCES colonias(id),
	CONSTRAINT FOREIGN KEY (idUsuarioRegistro) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idUsuarioActualizo) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE aportaciones(
	id bigint auto_increment NOT NULL,
	cuota decimal(10, 2) NOT NULL,
	nombre varchar(100) NOT NULL,
	idUnidad int NOT NULL,
	nombreUnidad varchar(50) NOT NULL,
	idRecargo bigint NOT NULL,
	idTipoRecargo int NOT NULL,
	recargoCantidad decimal(10, 2) NOT NULL,
	recargoSobreTotal boolean NOT NULL,
	fechaInicio datetime NOT NULL,
	fechaVence datetime NOT NULL,
	idColonia int NOT NULL,
	idUsuarioRegistro bigint NOT NULL,
	fechaRegistro datetime NOT NULL,
	idUsuarioActualizo bigint NOT NULL,
	fechaActualizo datetime NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idRecargo) REFERENCES recargos(id),
	CONSTRAINT FOREIGN KEY (idTipoRecargo) REFERENCES tipos_recargos(id),
	CONSTRAINT FOREIGN KEY (idUnidad) REFERENCES unidades(id),
	CONSTRAINT FOREIGN KEY (idColonia) REFERENCES colonias(id),
	CONSTRAINT FOREIGN KEY (idUsuarioRegistro) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idUsuarioActualizo) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE adeudos(
	id bigint auto_increment NOT NULL,
	concepto varchar(150) NOT NULL,
	cantidad decimal(10,2) not null,
	fechaInicio datetime NOT NULL,
	fechaVence datetime NOT NULL,
	idResidente bigint NOT NULL,
	idColonia int NOT NULL,
	idUsuarioRegistro bigint NOT NULL,
	fechaRegistro datetime NOT NULL,
	idUsuarioActualizo bigint NOT NULL,
	fechaActualizo datetime NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idResidente) REFERENCES residentes(id),
	CONSTRAINT FOREIGN KEY (idColonia) REFERENCES colonias(id),
	CONSTRAINT FOREIGN KEY (idUsuarioRegistro) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idUsuarioActualizo) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE adeudos_aportaciones(
	id bigint auto_increment NOT NULL,
	idCasa bigint NOT NULL,
	idAportacion bigint NOT NULL,
	idAdeudo bigint NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idCasa) REFERENCES casas(id),
	CONSTRAINT FOREIGN KEY (idAportacion) REFERENCES aportaciones(id),
	CONSTRAINT FOREIGN KEY (idAdeudo) REFERENCES adeudos(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE adeudos_reservaciones(
	id bigint auto_increment NOT NULL,
	idReservacion bigint NOT NULL,
	idAdeudo bigint NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idReservacion) REFERENCES reservaciones(id),
	CONSTRAINT FOREIGN KEY (idAdeudo) REFERENCES adeudos(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE tipos_recargos(	
	id int auto_increment NOT NULL,
	nombre varchar(50) NOT NULL,
	CONSTRAINT PRIMARY KEY (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE adeudos_recargos(
	id bigint auto_increment NOT NULL,
	idRecargo bigint NOT NULL,
	idAportacion bigint NOT NULL,
	fecha int NOT NULL,
	idAdeudo bigint NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idRecargo) REFERENCES recargos(id),
	CONSTRAINT FOREIGN KEY (idAportacion) REFERENCES aportaciones(id),
	CONSTRAINT FOREIGN KEY (idAdeudo) REFERENCES adeudos(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE adeudos_extras(
	id bigint auto_increment NOT NULL,
	idExtra bigint NOT NULL,
	idAdeudo bigint NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idExtra) REFERENCES adeudos(id),
	CONSTRAINT FOREIGN KEY (idAdeudo) REFERENCES adeudos(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE ingresos(
	id bigint auto_increment NOT NULL,
	idResidente bigint NOT NULL,
	nombreResidente varchar(100) NOT NULL,
	idCuenta int NOT NULL,
	nombreCuenta varchar(50) NOT NULL,
	referencia varchar(100) NOT NULL,
	idColonia int NOT NULL,
	idUsuarioRegistro bigint NOT NULL,
	fechaRegistro datetime NOT NULL,
	idUsuarioActualizo bigint NOT NULL,
	fechaActualizo datetime NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idResidente) REFERENCES residentes(id),
	CONSTRAINT FOREIGN KEY (idCuenta) REFERENCES cuentas(id),
	CONSTRAINT FOREIGN KEY (idColonia) REFERENCES colonias(id),
	CONSTRAINT FOREIGN KEY (idUsuarioRegistro) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idUsuarioActualizo) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE pagos(
	id bigint auto_increment NOT NULL,
	idIngreso bigint NOT NULL,
	idAdeudo bigint NOT NULL,
	nombreAportacion varchar(100) NOT NULL,
	cantidad decimal(10,2) NOT NULL,
	idColonia int NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idIngreso) REFERENCES ingresos(id),
	CONSTRAINT FOREIGN KEY (idAdeudo) REFERENCES adeudos(id),
	CONSTRAINT FOREIGN KEY (idColonia) REFERENCES colonias(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE facturas(
	id bigint auto_increment NOT NULL,
	folio varchar(100) NOT NULL,
	pathPDF varchar(150) NOT NULL,
	pathXML varchar(150) NOT NULL,
	idColonia int NOT NULL,
	idUsuarioRegistro bigint NOT NULL,
	fechaRegistro datetime NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idColonia) REFERENCES colonias(id),
	CONSTRAINT FOREIGN KEY (idUsuarioRegistro) REFERENCES usuarios(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE anuncios(
	id bigint auto_increment NOT NULL,
	idTipo int NOT NULL,
	titulo varchar(100) NOT NULL,
	comentarios varchar(250) NOT NULL,
	idColonia int NOT NULL,
	idUsuarioRegistro bigint NOT NULL,
	fechaRegistro datetime NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idColonia) REFERENCES colonias(id),
	CONSTRAINT FOREIGN KEY (idTipo) REFERENCES tipos(id),
	CONSTRAINT FOREIGN KEY (idUsuarioRegistro) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE adjuntos(
	id bigint auto_increment NOT NULL,
	idAnuncio bigint NOT NULL,
	paths varchar(100) NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idAnuncio) REFERENCES anuncios(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE comentarios(
	id bigint auto_increment NOT NULL,
	idAnuncio bigint NOT NULL,
	comentarios varchar(250) NOT NULL,
	idUsuarioRegistro bigint NOT NULL,
	fechaRegistro datetime NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idUsuarioRegistro) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE adjuntos_comentarios(
	id bigint auto_increment NOT NULL,
	idComentario bigint NOT NULL,
	paths varchar(100) NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idComentario) REFERENCES comentarios(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE usuarios_anuncios(
	idUsuario bigint NOT NULL,
	idAnuncio bigint NOT NULL,
	CONSTRAINT PRIMARY KEY (idUsuario, idAnuncio),
	CONSTRAINT FOREIGN KEY (idUsuario) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idAnuncio) REFERENCES anuncios(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE minutas(
	id bigint auto_increment NOT NULL,
	titulo varchar(100) NOT NULL,
	contenido varchar(250) NOT NULL,
	idColonia int NOT NULL,
	idUsuarioRegistro bigint NOT NULL,
	fechaRegistro datetime NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idColonia) REFERENCES colonias(id),
	CONSTRAINT FOREIGN KEY (idUsuarioRegistro) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE adjuntos_minutas(
	id bigint auto_increment NOT NULL,
	idMinuta bigint NOT NULL,
	paths varchar(100) NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idMinuta) REFERENCES minutas(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE proyectos(
	id bigint auto_increment NOT NULL,
	nombre varchar(100) NOT NULL,
	descripcion varchar(250) NOT NULL,
	idAnuncio bigint NOT NULL,
	idColonia int NOT NULL,
	idUsuarioRegistro bigint NOT NULL,
	fechaRegistro datetime NOT NULL,
	idUsuarioActualizo bigint NOT NULL,
	fechaActualizo datetime NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idAnuncio) REFERENCES anuncios(id),
	CONSTRAINT FOREIGN KEY (idColonia) REFERENCES colonias(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE proveedores(
	id bigint auto_increment NOT NULL,
	nombre varchar(100) NOT NULL,
	especialidad varchar(100) NOT NULL,
	comentarios varchar(250) NOT NULL,
	rfc varchar(30) NOT NULL,
	telefono varchar(30) NOT NULL,
	direccion varchar(200) NOT NULL,
	correo varchar(125) NOT NULL,
	idColonia int NOT NULL,
	idUsuarioRegistro bigint NOT NULL,
	fechaRegistro datetime NOT NULL,
	idUsuarioActualizo bigint NOT NULL,
	fechaActualizo datetime NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idColonia) REFERENCES colonias(id),
	CONSTRAINT FOREIGN KEY (idUsuarioRegistro) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idUsuarioActualizo) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE cotizaciones(
	id bigint auto_increment NOT NULL,
	nombre varchar(100) NOT NULL,
	idProyecto bigint NOT NULL,
	descripcion varchar(250) NOT NULL,
	costo decimal(10,2) NOT NULL,
	idColonia int NOT NULL,
	idUsuarioRegistro bigint NOT NULL,
	fechaRegistro datetime NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idColonia) REFERENCES colonias(id),
	CONSTRAINT FOREIGN KEY (idUsuarioRegistro) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE adjuntos_cotizaciones(
	id bigint auto_increment NOT NULL,
	idCotizacion bigint NOT NULL,
	paths varchar(100) NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idCotizacion) REFERENCES cotizaciones(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE adjuntos_casas(
	id bigint auto_increment NOT NULL,
	idCambioCasas bigint NOT NULL,
	paths varchar(100) NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idCambioCasas) REFERENCES cambios_casas(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE gastos_programados(
	id bigint auto_increment NOT NULL,
	cantidad decimal(10, 2) NOT NULL,
	concepto varchar(100) NOT NULL,
	idProyecto bigint NOT NULL,
	nombreProyecto varchar(100) NOT NULL,
	idProveedor bigint NOT NULL,
	nombreProveedor varchar(100) NOT NULL,
	idColonia int NOT NULL,
	fechaVence datetime NOT NULL,
	idUsuarioRegistro bigint NOT NULL,
	fechaRegistro datetime NOT NULL,
	idUsuarioActualizo bigint NOT NULL,
	fechaActualizo datetime NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idProyecto) REFERENCES proyectos(id),
	CONSTRAINT FOREIGN KEY (idProveedor) REFERENCES proveedores(id),
	CONSTRAINT FOREIGN KEY (idColonia) REFERENCES colonias(id),
	CONSTRAINT FOREIGN KEY (idUsuarioRegistro) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idUsuarioActualizo) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE egresos(
	id bigint auto_increment NOT NULL,
	idGastoProgramado bigint NOT NULL,
	conceptoGasto varchar(100) NOT NULL,
	idCuenta int NOT NULL,
	nombreCuenta int NOT NULL,
	cantidad decimal(10, 2) NOT NULL,
	referencia varchar(100) NOT NULL,
	idColonia int NOT NULL,
	idUsuarioRegistro bigint NOT NULL,
	fechaRegistro datetime NOT NULL,
	idUsuarioActualizo bigint NOT NULL,
	fechaActualizo datetime NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idGastoProgramado) REFERENCES gastos_programados(id),
	CONSTRAINT FOREIGN KEY (idCuenta) REFERENCES cuentas(id),
	CONSTRAINT FOREIGN KEY (idColonia) REFERENCES colonias(id),
	CONSTRAINT FOREIGN KEY (idUsuarioRegistro) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idUsuarioActualizo) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE adjuntos_egresos(
	id bigint auto_increment NOT NULL,
	idEgreso bigint NOT NULL,
	paths varchar(100) NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idEgreso) REFERENCES egresos(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE elementos(
	id int auto_increment NOT NULL,
	nombre varchar(100) NOT NULL,
	imagen varchar(100) NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE bitacoras(
	id bigint auto_increment NOT NULL,
	idAnuncio bigint NOT NULL,
	idElemento int NOT NULL,
	nombreElemento varchar(100) NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idAnuncio) REFERENCES anuncios(id),
	CONSTRAINT FOREIGN KEY (idElemento) REFERENCES elementos(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE puestos(
	id int auto_increment NOT NULL,
	nombre varchar(100) NOT NULL,
	descripcion varchar (200) NOT NULL,
	idColonia int NOT NULL,
	idUsuarioRegistro bigint NOT NULL,
	fechaRegistro datetime NOT NULL,
	idUsuarioActualizo bigint NOT NULL,
	fechaActualizo datetime NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idColonia) REFERENCES colonias(id),
	CONSTRAINT FOREIGN KEY (idUsuarioRegistro) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idUsuarioActualizo) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


CREATE TABLE reglamentos(
	id int auto_increment NOT NULL,
	nombre varchar(50) NOT NULL,
	descripcion text(60000) NOT NULL,
	idColonia int NOT NULL,
	idUsuarioRegistro bigint NOT NULL,
	fechaRegistro datetime NOT NULL,
	idUsuarioActualizo bigint NOT NULL,
	fechaActualizo datetime NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idColonia) REFERENCES colonias(id),
	CONSTRAINT FOREIGN KEY (idUsuarioRegistro) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idUsuarioActualizo) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE adjuntos_reglamentos(
	id bigint auto_increment NOT NULL,
	idReglamento int NOT NULL,
	paths varchar(100) NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idReglamento) REFERENCES reglamentos(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE asambleas(
	id int auto_increment NOT NULL,
	titulo varchar(100) NOT NULL,
	contenido text NOT NULL,
	presupuesto decimal(12, 2) NOT NULL,
	fecha datetime NOT NULL,
	idColonia int NOT NULL,
	idUsuarioRegistro bigint NOT NULL,
	fechaRegistro datetime NOT NULL,
	idUsuarioActualizo bigint NOT NULL,
	fechaActualizo datetime NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idColonia) REFERENCES colonias(id),
	CONSTRAINT FOREIGN KEY (idUsuarioRegistro) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idUsuarioActualizo) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE adjuntos_asambleas(
	id bigint auto_increment NOT NULL,
	idAsamblea int NOT NULL,
	paths varchar(100) NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idAsamblea) REFERENCES asambleas(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE configuraciones(
	id int auto_increment NOT NULL,
	idColonia int NOT NULL,
	costoReservacion boolean NOT NULL,
	recargos boolean NOT NULL,
	validacionReservacion boolean NOT NULL,
	personasReservacion boolean NOT NULL,
	idUsuarioRegistro bigint NOT NULL,
	fechaRegistro datetime NOT NULL,
	idUsuarioActualizo bigint NOT NULL,
	fechaActualizo datetime NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idColonia) REFERENCES colonias(id),
	CONSTRAINT FOREIGN KEY (idUsuarioRegistro) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idUsuarioActualizo) REFERENCES usuarios(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE miembros(
	id bigint auto_increment NOT NULL,
	idUsuario bigint NOT NULL,
	idPuesto int NOT NULL,
	nombrePuesto varchar(100) NOT NULL,
	idAsamblea int not null,
	idColonia int NOT NULL,
	idUsuarioRegistro bigint NOT NULL,
	fechaRegistro datetime NOT NULL,
	idUsuarioActualizo bigint NOT NULL,
	fechaActualizo datetime NOT NULL,
	idEstatus int NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idUsuario) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idPuesto) REFERENCES puestos(id),
	CONSTRAINT FOREIGN KEY (idColonia) REFERENCES colonias(id),
	CONSTRAINT FOREIGN KEY (idUsuarioRegistro) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idUsuarioActualizo) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idEstatus) REFERENCES estatus(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE correos(
	id bigint auto_increment NOT NULL,
	receptores text NOT NULL,
	titulo varchar(150) NOT NULL,
	contenido text NOT NULL,
	idColonia int NOT NULL,
	idUsuarioRegistro bigint NOT NULL,
	fechaRegistro datetime NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idColonia) REFERENCES colonias(id),
	CONSTRAINT FOREIGN KEY (idUsuarioRegistro) REFERENCES usuarios(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE adjuntos_correos(
	id bigint auto_increment NOT NULL,
	idCorreo bigint NOT NULL,
	paths varchar(100) NOT NULL,
	CONSTRAINT PRIMARY KEY (id),
	CONSTRAINT FOREIGN KEY (idCorreo) REFERENCES correos(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE usuarios_colonias(
	idUsuario bigint NOT NULL,
	idColonia int NOT NULL,
	CONSTRAINT PRIMARY KEY (idUsuario, idColonia),
	CONSTRAINT FOREIGN KEY (idUsuario) REFERENCES usuarios(id),
	CONSTRAINT FOREIGN KEY (idColonia) REFERENCES colonias(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO estados (id, nombre) VALUES
(1, 'Aguascalientes'),
(2, 'Baja California'),
(3, 'Baja California Sur'),
(4, 'Campeche'),
(5, 'Chiapas'),
(6, 'Chihuahua'),
(7, 'Coahuila'),
(8, 'Colima'),
(9, 'Distrito Federal'),
(10, 'Durango'),
(11, 'Estado de México'),
(12, 'Guanajuato'),
(13, 'Guerrero'),
(14, 'Hidalgo'),
(15, 'Jalisco'),
(16, 'Michoacán'),
(17, 'Morelos'),
(18, 'Nayarit'),
(19, 'Nuevo León'),
(20, 'Oaxaca'),
(21, 'Puebla'),
(22, 'Querétaro'),
(23, 'Quintana Roo'),
(24, 'San Luis Potosí'),
(25, 'Sinaloa'),
(26, 'Sonora'),
(27, 'Tabasco'),
(28, 'Tamaulipas'),
(29, 'Tlaxcala'),
(30, 'Veracruz'),
(31, 'Yucatán'),
(32, 'Zacatecas');

INSERT INTO estatus (id, nombre) VALUES
(1, 'Habilitado'),
(2, 'Deshabilitado'),
(3, 'Borrado'),
(4, 'Aceptado'),
(5, 'Rechazado'),
(6, 'En Proceso'),
(7, 'Terminado'),
(8, 'Cancelado'),
(9, 'Resuelta');

INSERT INTO perfiles (id, nombre) VALUES
(1, 'Innsert'),
(2, 'Austero'),
(3, 'Básico'),
(4, 'Adminsitración');

INSERT INTO permisos (id, nombre) VALUES
(1, 'Innsert'),
(2, 'Administración'),
(3, 'Usuarios'),
(4, 'Tipos de Anuncio'),
(5, 'Residentes'),
(6, 'Perfiles de Usuario'),
(7, 'Bancos'),
(8, 'Cuentas de Banco'),
(9, 'Horarios'),
(10, 'Zonas'),
(11, 'Aportaciones'),
(12, 'Pagos'),
(13, 'Iniciativas'),
(14, 'Proyectos'),
(15, 'Proveedores'),
(16, 'Cuentas por Pagar'),
(17, 'Egresos'),
(18, 'Minutas'),
(19, 'Cotizaciones'),
(20, 'Estados'),
(21, 'Casas'),
(22, 'Quejas'),
(23, 'Puestos'),
(24, 'Miembros'),
(25, 'Asambleas'),
(26, 'Unidades');

INSERT INTO perfiles_permisos (idPerfil, idPermiso) VALUES
(1, 1),
(3, 18),
(3, 19),
(4, 2),
(4, 3),
(4, 4),
(4, 5),
(4, 6),
(4, 7),
(4, 8),
(4, 9),
(4, 10),
(4, 11),
(4, 12),
(4, 13),
(4, 14),
(4, 15),
(4, 16),
(4, 17),
(4, 18),
(4, 19),
(4, 20),
(4, 21),
(4, 22),
(4, 23),
(4, 24),
(4, 25),
(4, 26);

INSERT INTO tipos_recargos (id, nombre) VALUES
(1, 'Porcentaje'),
(1, 'Cantidad Fija');

INSERT INTO recargos (id, nombreRecargo, sobreTotal, cantidad, idTipo, idColonia, idUsuarioRegistro, fechaRegistro, idUsuarioActualizo, fechaActualizo, idEstatus) VALUES
(1, 'Sin Recargos', 0, 0, 0, 1, 1, 1, '2015-07-11 12:00:00', 1, '2015-07-11 12:00:00', 1);

/**
* Insertar después de municipios
*/
INSERT INTO colonias (id, nombre, idEstado, idMunicipio, contacto, fechaRegistro, fechaActualizo, idEstatus) VALUES
(1, 'Innsert', 1, 1, 'contacto@innsert.com', '2015-07-11 12:00:00', '2015-07-11 12:00:00', 1);

INSERT INTO configuraciones (id, idColonia, costoReservacion, recargos, validacionReservacion, personasReservacion, idUsuarioRegistro, fechaRegistro, idUsuarioActualizo, fechaActualizo) VALUES
(1, 1, 0, 0, 0, 0, 1, '2015-07-11 12:00:00', 1, '2015-07-11 12:00:00');

INSERT INTO usuarios (id, nombre, correo, idPerfil, idColonia, password, intento, hash, idEstatus) VALUES
(1, 'Administrador Innsert', 'contacto@innsert.com', 1, 1, 'a153b4f408a01ae4bd6ad0436da3a41a9fee49b2', 1371272400, 'TEQUILA51ccadc8800149.335', 1);

INSERT INTO residentes(id, nombre, acumulado, telefono, correo, idColonia, idUsuario, idUsuarioRegistro, fechaRegistro, idUsuarioActualizo, fechaActualizo, idEstatus) VALUES
(1, 'Administrador Innsert', 0, '1234569789', 'contacto@innsert.com', 1, 1, 1, '2015-07-11 12:00:00', 1, '2015-07-11 12:00:00', 1 );

INSERT INTO tipos (id, nombre, color, idColonia, idUsuarioRegistro, fechaRegistro, idUsuarioActualizo, fechaActualizo, idEstatus) VALUES
(1, 'Anuncio', '#0066CC', 1, 1, '2015-07-11 12:00:00', 1, '2015-07-11 12:00:00', 1),
(2, 'Venta', '#3BBF21', 1, 1, '2015-07-11 12:00:00', 1, '2015-07-11 12:00:00', 1),
(3, 'Queja Pública', '#CC1912', 1, 1, '2015-07-11 12:00:00', 1, '2015-07-11 12:00:00', 1),
(4, 'Sugerencia', '#FFB521', 1, 1, '2015-07-11 12:00:00', 1, '2015-07-11 12:00:00', 1),
(5, 'Iniciativa de Proyecto', '#D814FF', 1, 1, '2015-07-11 12:00:00', 1, '2015-07-11 12:00:00', 1),
(6, 'Proyecto', '#D814FF', 1, 1, '2015-07-11 12:00:00', 1, '2015-07-11 12:00:00', 1),
(7, 'Queja Privada', '#CC1912', 1, 1, '2015-07-11 12:00:00', 1, '2015-07-11 12:00:00', 1);