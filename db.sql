CREATE TYPE role_info AS ENUM ('USER', 'MOD', 'ADMIN');

CREATE TABLE roles (
  role_id SERIAL UNIQUE NOT NULL PRIMARY KEY,
  role_name role_info NOT NULL DEFAULT 'USER'  
);

INSERT INTO roles(role_name) VALUES
('USER'),
('MOD'),
('ADMIN');

CREATE TYPE location_info AS (
    city VARCHAR,
    country VARCHAR
);

CREATE TABLE users (
  user_id SERIAL UNIQUE NOT NULL PRIMARY KEY,
  username VARCHAR(30) UNIQUE NOT NULL,
  passhash VARCHAR NOT NULL,
  email VARCHAR NOT NULL,
  date_of_birth DATE NOT NULL,
  location location_info NOT NULL,
  is_deactivated BOOLEAN DEFAULT false NOT NULL,
  city VARCHAR (50),
  country VARCHAR(50),
  role_id INT NOT NULL DEFAULT 1 REFERENCES roles (role_id) MATCH SIMPLE ON DELETE RESTRICT ON UPDATE CASCADE NOT DEFERRABLE
);

INSERT INTO users(username, passhash, email, date_of_birth, location, role_id) 
	VALUES('admin', 'd74ff0ee8da3b9806b18c877dbf29bbde50b5bd8e4dad7a3a725000feb82e8f1', 'admin@askme.com', '1991-06-20', ROW('Zagreb', 'Croatia'), 3);

CREATE TABLE categories (
  category_id SERIAL UNIQUE NOT NULL PRIMARY KEY,
  category_name VARCHAR(30),
  is_deactivated BOOLEAN DEFAULT false NOT NULL
);

CREATE TABLE questions (
  question_id SERIAL UNIQUE NOT NULL PRIMARY KEY,
  question_text TEXT NOT NULL,
  question_body TEXT,
  published_at timestamp DEFAULT current_timestamp,
  user_id INT NOT NULL REFERENCES users(user_id) MATCH SIMPLE ON DELETE RESTRICT ON UPDATE CASCADE NOT DEFERRABLE,
  is_displayed BOOLEAN DEFAULT true NOT NULL
);

CREATE TABLE answers (
  answer_id SERIAL UNIQUE NOT NULL PRIMARY KEY,
  answer_text TEXT,
  published_at timestamp DEFAULT current_timestamp,
  question_id INT NOT NULL REFERENCES questions (question_id) MATCH SIMPLE ON DELETE RESTRICT ON UPDATE CASCADE NOT DEFERRABLE,
  user_id INT NOT NULL REFERENCES users(user_id) MATCH SIMPLE ON DELETE RESTRICT ON UPDATE CASCADE NOT DEFERRABLE,
  is_displayed BOOLEAN DEFAULT true NOT NULL
);

/*
	user_id -> ON DELETE CASCADE -> ako obrišemo usera, brišemo i sve njegove voteove
	answer_id -> ON DELETE CASCADE -> ako obišemo answer, brišemo i njegove voteove
*/
CREATE TABLE votes(
  vote_id SERIAL UNIQUE NOT NULL PRIMARY KEY,
  score INT DEFAULT 0,
  voted_at timestamp DEFAULT now(),
  answer_id INT NOT NULL REFERENCES answers (answer_id) MATCH SIMPLE ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE,
  user_id INT NOT NULL REFERENCES users (user_id) MATCH SIMPLE ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE
);

CREATE TABLE question_categories(
  question_category_id SERIAL UNIQUE NOT NULL PRIMARY KEY,
  question_id INT NOT NULL REFERENCES questions(question_id) MATCH SIMPLE ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE,
  category_id INT NOT NULL REFERENCES categories (category_id) MATCH SIMPLE ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE
);

/* Funkcija i trigger za punjenje složenog atributa location */
CREATE FUNCTION setLocationFunction()
RETURNS trigger AS '
BEGIN
  IF NEW.location IS NULL  THEN
    NEW.location := ROW(NEW.city, NEW.country);
  END IF;
  RETURN NEW;
END' LANGUAGE 'plpgsql';

CREATE TRIGGER location_trigger
BEFORE INSERT ON users
FOR EACH ROW
EXECUTE PROCEDURE setLocationFunction();

/* Funkcija i trigger za punjenje složenog atributa location nakon updatea */
CREATE FUNCTION updateLocationFunction()
RETURNS trigger AS '
BEGIN
  IF NEW.city != OLD.city OR NEW.country != OLD.country THEN
    NEW.location := ROW(NEW.city, NEW.country);
  END IF;
  RETURN NEW;
END' LANGUAGE 'plpgsql';

CREATE TRIGGER update_location_trigger
BEFORE UPDATE ON users
FOR EACH ROW
EXECUTE PROCEDURE updateLocationFunction();


