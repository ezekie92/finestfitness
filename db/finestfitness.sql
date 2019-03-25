------------------------------
-- Archivo de base de datos --
------------------------------
DROP TABLE IF EXISTS tarifas CASCADE;

CREATE TABLE tarifas
(
    id               BIGSERIAL       PRIMARY KEY
    , tarifa           VARCHAR(30)     NOT NULL UNIQUE
    , precio           NUMERIC(5,2)    NOT NULL
    , hora_entrada_min TIME            NOT NULL
    , hora_entrada_max TIME            NOT NULL
);

DROP TABLE IF EXISTS personas CASCADE;

CREATE TABLE personas
(
    id              BIGSERIAL   PRIMARY KEY
  , nombre          VARCHAR(32) NOT NULL
  , email           VARCHAR(60) NOT NULL UNIQUE CONSTRAINT ck_personas_email_valido
                                CHECK (email ~ '^[a-zA-Z0-9.!#$%&''*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$')
  , contrasena      VARCHAR(60) NOT NULL
  , fecha_nac       DATE        NOT NULL
  , peso            SMALLINT    CONSTRAINT ck_personas_peso_positivo
                                CHECK (coalesce(peso, 0) >= 0)
  , altura          SMALLINT    CONSTRAINT ck_personas_altura_positiva
                                CHECK (coalesce(altura, 0) >= 0)
  , foto            VARCHAR(255)
  , telefono        NUMERIC(9)
  , tarifa          BIGINT      REFERENCES tarifas(id)
                                ON DELETE NO ACTION
                                ON UPDATE CASCADE
  , fecha_alta      DATE        NOT NULL DEFAULT CURRENT_DATE
  , tipo            VARCHAR(10) NOT NULL
  , monitor         BIGINT      REFERENCES personas (id)
                                ON DELETE NO ACTION
                                ON UPDATE CASCADE
  , horario_entrada TIME
  , horario_salida  TIME
  , especialidad    VARCHAR(10)
);

DROP TABLE IF EXISTS clases CASCADE;

CREATE TABLE clases
(
    id              BIGSERIAL   PRIMARY KEY
  , nombre          VARCHAR(32) NOT NULL
  , hora_inicio     TIME        NOT NULL
  , hora_fin        TIME        NOT NULL
  , monitor         BIGINT      NOT NULL
                                REFERENCES personas (id)
                                ON DELETE NO ACTION
                                ON UPDATE CASCADE
  , plazas          SMALLINT
);

DROP TABLE IF EXISTS entrenamientos CASCADE;

CREATE TABLE entrenamientos
(
    cliente_id      BIGINT  NOT NULL
                            REFERENCES personas (id)
                            ON DELETE NO ACTION
                            ON UPDATE CASCADE
  , entrenador_id   BIGINT  NOT NULL
                            REFERENCES personas (id)
                            ON DELETE NO ACTION
                            ON UPDATE CASCADE
  , hora_inicio     TIME
  , hora_fin        TIME
  , PRIMARY KEY(cliente_id, entrenador_id)
);

DROP TABLE IF EXISTS ejercicios CASCADE;

CREATE TABLE ejercicios
(
    id           BIGSERIAL   PRIMARY KEY
    , nombre       VARCHAR(60) NOT NULL
    , series       SMALLINT
    , repeticiones SMALLINT
    , descanso     SMALLINT
    , peso         SMALLINT
);

DROP TABLE IF EXISTS rutinas CASCADE;

CREATE TABLE rutinas
(
    id          BIGSERIAL   PRIMARY KEY
  , nombre      VARCHAR(25) NOT NULL
  , ejercicios  BIGINT      NOT NULL
                            REFERENCES ejercicios (id)
                            ON DELETE NO ACTION
                            ON UPDATE CASCADE
  , autor       BIGINT      NOT NULL
                            REFERENCES personas (id)
                            ON DELETE NO ACTION
                            ON UPDATE CASCADE
);

DROP TABLE IF EXISTS horarios CASCADE;

CREATE TABLE horarios
(
    id        BIGSERIAL   PRIMARY KEY
  , dia       VARCHAR(15) NOT NULL
  , apertura  TIME        NOT NULL
  , cierre    TIME        NOT NULL
);

---------------------
-- Datos de prueba --
---------------------

INSERT INTO tarifas (tarifa, precio, hora_entrada_min, hora_entrada_max)
VALUES ('Normal', 40, '7:00:00', '23:00:00');

INSERT INTO personas (nombre, email, contrasena, fecha_nac, fecha_alta, tipo)
VALUES('Admin', 'Admin@admin.com', crypt('admin', gen_salt('bf', 10)), '1970-1-1', '2019-1-1', 'admin')
    , ('Juan', 'Juan@juan.com', crypt('juan', gen_salt('bf', 10)), '1980-1-1', '2019-1-1', 'monitor')
    , ('Pedro', 'Pedro@pedro.com', crypt('pedro', gen_salt('bf', 10)), '1980-1-1', '2019-1-1', 'monitor')
    , ('Antonio', 'antonio@antonio.com', crypt('antonio', gen_salt('bf', 10)), '1991-1-1', '2019-1-1', 'cliente');

INSERT INTO personas (nombre, email, contrasena, fecha_nac, fecha_alta, tipo, monitor)
VALUES('Pepe', 'pepe@pepe.com', crypt('pepe', gen_salt('bf', 10)), '1990-1-1', '2019-1-1', 'cliente', 2)
    , ('Manolo', 'Manolo@manolo.com', crypt('manolo', gen_salt('bf', 10)), '1990-1-1', '2019-1-1', 'cliente', 3);


INSERT INTO clases (nombre, hora_inicio, hora_fin, monitor, plazas)
VALUES('Zumba', '12:00', '12:45', 2, 20);

INSERT INTO entrenamientos (cliente_id, entrenador_id, hora_inicio, hora_fin)
VALUES (4, 2, '10:00', '11:00');

INSERT INTO ejercicios (nombre)
VALUES('Press banca')
    , ('Press militar')
    , ('Dominadas')
    , ('Sentadillas')
    , ('Peso muerto');

INSERT INTO rutinas (nombre, ejercicios, autor)
VALUES('Básicos', 1, 1)
    , ('Básicos', 2, 1);


INSERT INTO horarios (dia, apertura, cierre)
VALUES('Lunes', '7:00', '23:00')
    , ('Martes', '7:00', '23:00')
    , ('Miércoles', '7:00', '23:00')
    , ('Jueves', '7:00', '23:00')
    , ('Viernes', '7:00', '23:00')
    , ('Sábado', '7:00', '12:00');
