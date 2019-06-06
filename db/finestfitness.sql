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

DROP TABLE IF EXISTS especialidades CASCADE;

CREATE TABLE especialidades
(
    id            BIGSERIAL PRIMARY KEY
  , especialidad  VARCHAR(25)
);

DROP TABLE IF EXISTS administradores CASCADE;

CREATE TABLE administradores
(
    id              BIGSERIAL   PRIMARY KEY
  , nombre          VARCHAR(32) NOT NULL
  , email           VARCHAR(60) NOT NULL UNIQUE CONSTRAINT ck_administradores_email_valido
                                CHECK (email ~ '^[a-zA-Z0-9.!#$%&''*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$')
  , contrasena      VARCHAR(60) NOT NULL
  , token           VARCHAR(255)
  , confirmado      BOOLEAN     DEFAULT 'f'
);

DROP TABLE IF EXISTS monitores CASCADE;

CREATE TABLE monitores
(
    id              BIGSERIAL   PRIMARY KEY
  , nombre          VARCHAR(32) NOT NULL
  , email           VARCHAR(60) NOT NULL UNIQUE CONSTRAINT ck_monitores_email_valido
                                CHECK (email ~ '^[a-zA-Z0-9.!#$%&''*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$')
  , contrasena      VARCHAR(60) NOT NULL
  , fecha_nac       TIMESTAMP   NOT NULL
  , foto            VARCHAR(255)
  , telefono        NUMERIC(9)
  , horario_entrada TIME
  , horario_salida  TIME
  , especialidad    BIGINT      NOT NULL REFERENCES especialidades (id)
                                ON DELETE NO ACTION
                                ON UPDATE CASCADE
  , token           VARCHAR(255)
  , confirmado      BOOLEAN     DEFAULT 'f'
);

DROP TABLE IF EXISTS clientes CASCADE;

CREATE TABLE clientes
(
    id              BIGSERIAL   PRIMARY KEY
  , nombre          VARCHAR(32) NOT NULL
  , email           VARCHAR(60) NOT NULL UNIQUE CONSTRAINT ck_clientes_email_valido
                                CHECK (email ~ '^[a-zA-Z0-9.!#$%&''*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$')
  , contrasena      VARCHAR(60) NOT NULL
  , fecha_nac       TIMESTAMP   NOT NULL
  , peso            SMALLINT    CONSTRAINT ck_clientes_peso_positivo
                                CHECK (coalesce(peso, 0) >= 0)
  , altura          SMALLINT    CONSTRAINT ck_clientes_altura_positiva
                                CHECK (coalesce(altura, 0) >= 0)
  , foto            VARCHAR(255)
  , telefono        NUMERIC(9)
  , tarifa          BIGINT      NOT NULL REFERENCES tarifas (id)
                                ON DELETE NO ACTION
                                ON UPDATE CASCADE
  , fecha_alta      TIMESTAMP   NOT NULL DEFAULT CURRENT_TIMESTAMP
  , monitor         BIGINT      REFERENCES monitores (id)
                                ON DELETE NO ACTION
                                ON UPDATE CASCADE
  , token           VARCHAR(255)
  , confirmado      BOOLEAN     DEFAULT 'f'
);

DROP TABLE IF EXISTS dias CASCADE;

CREATE TABLE dias
(
    id  BIGSERIAL PRIMARY KEY
  , dia VARCHAR(15)
);


DROP TABLE IF EXISTS clases CASCADE;

CREATE TABLE clases
(
    id              BIGSERIAL   PRIMARY KEY
  , nombre          VARCHAR(32) NOT NULL
  , hora_inicio     TIME        NOT NULL
  , hora_fin        TIME        NOT NULL
  , dia             BIGINT      NOT NULL
                                REFERENCES dias (id)
                                ON DELETE NO ACTION
                                ON UPDATE CASCADE
  , monitor         BIGINT      NOT NULL
                                REFERENCES monitores (id)
                                ON DELETE NO ACTION
                                ON UPDATE CASCADE
  , plazas          SMALLINT
);

DROP TABLE IF EXISTS entrenamientos CASCADE;

CREATE TABLE entrenamientos
(
    cliente_id      BIGINT  NOT NULL
                            REFERENCES clientes (id)
                            ON DELETE NO ACTION
                            ON UPDATE CASCADE
  , monitor_id      BIGINT  NOT NULL
                            REFERENCES monitores (id)
                            ON DELETE NO ACTION
                            ON UPDATE CASCADE
  , hora_inicio     TIME
  , hora_fin        TIME
  , dia             BIGINT  NOT NULL
                            REFERENCES dias (id)
                            ON DELETE NO ACTION
                            ON UPDATE CASCADE
  , estado          BOOLEAN
  , PRIMARY KEY(cliente_id, monitor_id, dia)
);


DROP TABLE IF EXISTS rutinas CASCADE;

CREATE TABLE rutinas
(
    id          BIGSERIAL   PRIMARY KEY
  , nombre      VARCHAR(25) NOT NULL
  , cliente_id  BIGINT      NOT NULL
                            REFERENCES clientes (id)
                            ON DELETE NO ACTION
                            ON UPDATE CASCADE
);

DROP TABLE IF EXISTS ejercicios CASCADE;

CREATE TABLE ejercicios
(
    id           BIGSERIAL   PRIMARY KEY
    , nombre       VARCHAR(60) NOT NULL
    , dia_id       BIGINT      NOT NULL
    REFERENCES dias (id)
    ON DELETE NO ACTION
    ON UPDATE CASCADE
    , rutina_id    BIGINT      NOT NULL
    REFERENCES rutinas (id)
    ON DELETE NO ACTION
    ON UPDATE CASCADE
    , series       VARCHAR(5)
    , repeticiones VARCHAR(15)
    , descanso     SMALLINT
    , peso         SMALLINT
    );

DROP TABLE IF EXISTS horarios CASCADE;

CREATE TABLE horarios
(
    id        BIGSERIAL   PRIMARY KEY
  , dia       BIGINT      NOT NULL
                          REFERENCES dias (id)
                          ON DELETE NO ACTION
                          ON UPDATE CASCADE
  , apertura  TIME        NOT NULL
  , cierre    TIME        NOT NULL
);

DROP TABLE IF EXISTS clientes_clases CASCADE;

CREATE TABLE clientes_clases
(
    cliente_id      BIGINT  NOT NULL
                            REFERENCES clientes (id)
                            ON DELETE NO ACTION
                            ON UPDATE CASCADE
  , clase_id        BIGINT  NOT NULL
                            REFERENCES clases (id)
                            ON DELETE NO ACTION
                            ON UPDATE CASCADE
  , PRIMARY KEY(cliente_id, clase_id)
);

DROP TABLE IF EXISTS pagos CASCADE;

CREATE TABLE pagos
(
    id          BIGSERIAL       PRIMARY KEY
  , fecha       TIMESTAMP       NOT NULL
  , cliente_id  BIGINT          NOT NULL
                                REFERENCES clientes (id)
                                ON DELETE NO ACTION
                                ON UPDATE CASCADE
  , concepto    VARCHAR(255)    NOT NULL
  , cantidad    NUMERIC(10,2)   NOT NULL
);

---------------------
-- Datos de prueba --
---------------------

INSERT INTO tarifas (tarifa, precio, hora_entrada_min, hora_entrada_max)
VALUES('Normal', 40, '7:00:00', '23:00:00')
    , ('Joven', 28, '7:00:00', '23:00:00');

INSERT INTO especialidades (especialidad)
VALUES('Spinning')
    , ('Boxeo')
    , ('Musculación')
    , ('Yoga');

INSERT INTO administradores (nombre, email, contrasena, confirmado)
VALUES('Z', 'z@z.com', crypt('z', gen_salt('bf', 10)), true)
    , ('Ezequiel', 'Ezequiel@ezequiel.com', crypt('ezequiel', gen_salt('bf', 10)), false);

INSERT INTO monitores (nombre, email, contrasena, fecha_nac, telefono, horario_entrada, horario_salida, especialidad, confirmado)
VALUES('Blas', 'blas@blas.com', crypt('blas', gen_salt('bf', 10)), '1978-1-1', 666999888, '7:00:00', '15:00:00', 1, true)
    , ('Benito', 'benito@benito.com', crypt('benito', gen_salt('bf', 10)), '1985-1-1', 666777888, '15:00:00', '23:00:00', 3, false);

INSERT INTO clientes (nombre, email, contrasena, fecha_nac, peso, altura, telefono, tarifa, fecha_alta, monitor, confirmado)
VALUES('Alberto', 'alberto@alberto.com', crypt('alberto', gen_salt('bf', 10)), '1970-1-1', 70, 175, 666555444, 1, '2019-1-1', 2, true)
    , ('Alfredo', 'alfredo@alfredo.com', crypt('alfredo', gen_salt('bf', 10)), '1980-1-1', 65, 172, 666555444, 1, '2019-1-1', 1, false)
    , ('Antonio', 'antonio@antonio.com', crypt('antonio', gen_salt('bf', 10)), '1991-1-1', 65, 170, 666555444, 2, '2019-1-1', 2, false);

INSERT INTO dias (dia)
VALUES('Lunes')
    , ('Martes')
    , ('Miércoles')
    , ('Jueves')
    , ('Viernes')
    , ('Sábado')
    , ('Domingo');

INSERT INTO clases (nombre, hora_inicio, hora_fin, dia, monitor, plazas)
VALUES('Zumba', '12:00', '12:45', 2, 1, 20)
    , ('Spinning', '12:00', '12:45', 1, 2, 10);

INSERT INTO entrenamientos (cliente_id, monitor_id, hora_inicio, hora_fin, dia, estado)
VALUES (3, 2, '16:30', '17:45', 1, true);

INSERT INTO rutinas (nombre, cliente_id)
VALUES('Básicos', 1);

INSERT INTO ejercicios (nombre, dia_id, rutina_id, series, repeticiones, descanso)
VALUES('Press banca', 2, 1, 5, 5, 180)
    , ('Press militar', 2, 1, 5, 5, 180)
    , ('Dominadas', 2, 1, 5, 'Fallo', 120)
    , ('Sentadillas', 1, 1, 5, 5, 180)
    , ('Peso muerto', 1, 1, 5, 5, 180);

INSERT INTO horarios (dia, apertura, cierre)
VALUES(1, '7:00', '23:00')
    , (2, '7:00', '23:00')
    , (3, '7:00', '23:00')
    , (4, '7:00', '23:00')
    , (5, '7:00', '23:00')
    , (6, '7:00', '12:00');

INSERT INTO clientes_clases(cliente_id, clase_id)
VALUES(2,1);
