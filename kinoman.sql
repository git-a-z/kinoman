/*kinoman*/

DROP DATABASE IF EXISTS kinoman;
CREATE DATABASE kinoman;
USE kinoman;

DROP TABLE IF EXISTS films;
CREATE TABLE films (
	id SERIAL PRIMARY KEY,
	title VARCHAR(255) NOT NULL,
	rus_title VARCHAR(255) NOT NULL,
	release_year YEAR NOT NULL,
	image_path VARCHAR(255) COMMENT 'мини-постер',
	INDEX films_title_year_idx(title, release_year)
) COMMENT 'Фильмы';

INSERT INTO films (title, rus_title, release_year, image_path) VALUES
	('One Flew Over the Cuckoo`s Nest', 'Пролетая над гнездом кукушки', 1975, 'OneFlewOverTheCuckoosNest.png'),
	('The Shining', 'Сияние', 1980, 'TheShining.png'),
	('Escape from New York', 'Побег из Нью-Йорка', 1981, 'EscapeFromNewYork.png'),
	('The Thing', 'Нечто', 1982, 'TheThing.png'),
	('Big Trouble in Little China', 'Большой переполох в маленьком Китае', 1986, 'BigTroubleInLittleChina.png'),
	('Se7en', 'Семь', 1995, 'Se7en.png'),
	('Fight Club', 'Бойцовский клуб', 1999, 'FightClub.png'),
	('Pulp Fiction', 'Криминальное чтиво', 1994, 'PulpFiction.png'),
	('The Hateful Eight', 'Омерзительная восьмерка', 2015, 'TheHatefulEight.png'),
	('Once Upon a Time... in Hollywood', 'Однажды в... Голливуде', 2019, 'OnceUponATimeInHollywood.png');

DROP TABLE IF EXISTS persons;
CREATE TABLE persons (
	id SERIAL PRIMARY KEY,
	firstname VARCHAR(50) NOT NULL,
	lastname VARCHAR(50) NOT NULL,
	birthday DATE NOT NULL,
	image_path VARCHAR(255) COMMENT 'мини-фото',
	INDEX persons_firstname_lastname_birthday_idx(firstname, lastname, birthday)
) COMMENT 'Люди';

INSERT INTO persons (firstname, lastname, birthday) VALUES
	('Джек', 'Николсон', '1937-04-22'),
	('Милош', 'Форман', '1932-02-18'),
	('Стэнли', 'Кубрик', '1928-07-26'),
	('Курт', 'Рассел', '1951-03-17'),
	('Джон', 'Карпентер', '1948-01-16'),
	('Дэвид', 'Финчер', '1962-08-28'),
	('Брэд', 'Питт', '1963-12-18'),
	('Квентин', 'Тарантино', '1963-03-27'),
	('Сэмюэл Л.', 'Джексон', '1948-12-21'),
	('Леонардо', 'ДиКаприо', '1974-11-11');

DROP TABLE IF EXISTS positions;
CREATE TABLE positions(
	id SMALLINT UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255),
	UNIQUE unique_name(name(50))
) COMMENT 'Должности';

INSERT INTO positions (name) VALUES
	('lead actor'),('lead actress'),('actor'),('actress'),('director'),
	('producer'),('director of photography'),('makeup artist'),('composer'),('writer');

DROP TABLE IF EXISTS film_persons;
CREATE TABLE film_persons (
	film_id BIGINT UNSIGNED NOT NULL,
	person_id BIGINT UNSIGNED NOT NULL,
	position_id SMALLINT UNSIGNED NOT NULL,
	PRIMARY KEY (film_id, person_id, position_id),
	FOREIGN KEY (film_id) REFERENCES films(id),
	FOREIGN KEY (person_id) REFERENCES persons(id),
	FOREIGN KEY (position_id) REFERENCES positions(id)
) COMMENT 'Фильм-люди';

INSERT INTO film_persons VALUES
	(1,1,1),(1,2,5),
	(2,1,1),(2,3,5),
	(3,4,1),(3,5,5),(3,5,10),(3,5,9),
	(4,4,1),(4,5,5),
	(5,4,1),(5,5,5),
	(6,7,1),(6,6,5),
	(7,7,1),(7,6,5),
	(8,8,5),(8,9,3),(8,8,10),
	(9,8,5),(9,9,1),(9,4,1),(9,8,10),
	(10,8,5),(10,7,3),(10,4,3),(10,10,1),(10,8,10),(10,8,6);

DROP TABLE IF EXISTS genres;
CREATE TABLE genres(
	id SMALLINT UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255),
	UNIQUE unique_name(name(50))
) COMMENT 'Жанры';

INSERT INTO genres (name) VALUES
	('Драма'),('Комедия'),('Боевик'),('Фэнтези'),('Криминал'),
	('Приключения'),('Мистика'),('Ужасы'),('Триллер'),('Фантастика'),('Вестерн');

DROP TABLE IF EXISTS film_genres;
CREATE TABLE film_genres (
	film_id BIGINT UNSIGNED NOT NULL,
	genre_id SMALLINT UNSIGNED NOT NULL,
	PRIMARY KEY (film_id, genre_id),
	FOREIGN KEY (film_id) REFERENCES films(id),
	FOREIGN KEY (genre_id) REFERENCES genres(id)
) COMMENT 'Фильм-жанры';

INSERT INTO film_genres VALUES
	(1,1),
	(2,1),(2,8),
	(3,3),(3,6),(3,10),
	(4,8),(4,7),(4,10),
	(5,3),(5,6),(5,2),(5,4),
	(6,5),(6,1),(6,7),(6,9),
	(7,1),
	(8,5),(8,1),
	(9,5),(9,1),(9,7),(9,9),(9,11),
	(10,2),(10,1);

DROP TABLE IF EXISTS media_types;
CREATE TABLE media_types(
	id SMALLINT UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255),
	UNIQUE unique_name(name(50))
) COMMENT 'Типы медиа';

INSERT INTO media_types (name) VALUES
	('text'),('photo');

DROP TABLE IF EXISTS media;
CREATE TABLE media(
	id SERIAL PRIMARY KEY,
	media_type_id SMALLINT UNSIGNED NOT NULL,
	film_id BIGINT UNSIGNED NULL,
	person_id BIGINT UNSIGNED NULL,
	briefly TEXT,
	description TEXT,
	filename VARCHAR(255),
	size INT,
	metadata JSON,
	created_at DATETIME DEFAULT NOW(),
	updated_at DATETIME DEFAULT NOW() ON UPDATE NOW(),
	FOREIGN KEY (media_type_id) REFERENCES media_types(id),
	FOREIGN KEY (film_id) REFERENCES films(id),
	FOREIGN KEY (person_id) REFERENCES persons(id)
) COMMENT 'Медиафайлы';

INSERT INTO media (media_type_id, film_id, person_id, briefly, description, filename) VALUES
	(1,1,NULL,'Персонаж Джека Николсона стал героем для всех стремящихся к свободе.','Драма о заключенных психиатрической клиники, взбунтовавшихся против системы. Пытаясь спрятаться от заключения в тюрьму, Рэндл Патрик Макмёрфи играет роль сумасшедшего и попадает в больницу для душевнобольных. Жестокие порядки, введённые медицинской сестрой Милдред Рэтчед, приводят его в ужас, как и то, что большинство больных подчиняются и принимают эти правила. Он начинает борьбу против таких условий жизни в лечебнице.',''),
	(1,2,NULL,'Триллер, который более 30 лет считается непревзойдённым образцом жанра.','Культовая экранизация романа Стивена Кинга, которую ненавидит автор, но обожает весь мир. Писатель Джек Торренс (Джек Николсон) с семьей проводит зиму в загадочном пустом отеле Оверлук. До весны здесь мертвый сезон, и у нового смотрителя достаточно времени для творчества. Джек полон надежд, он планирует проводить у пишущей машинки часы напролет. Но жена Венди (Шелли Дювалль) и сын Дэнни (Дэнни Ллойда) не разделяют радость главы семейства. Дэнни — особенный мальчик, который видит и слышит скрытое. Он гоняет по отелю на велосипеде, чувствуя приближение беды.',''),
	(1,3,NULL,'1997 год. Весь остров Манхэттен - одна большая тюрьма строгого режима. Много лет идет Третья мировая война.','1997 год. Весь остров Манхэттен - одна большая тюрьма строгого режима. Много лет идет Третья мировая война. Президент захвачен группой революционеров и посажен в тюрьму. Ветеран войны Плисскен должен вызволить президента из этой зоны беспредельной жестокости, а времени у него очень мало. Если он не спасет президента в срок, то погибнет сам. Ему введен смертельный препарат, а противоядие он получит по возвращении.',''),
	(1,4,NULL,'Культовый фильм от Джона Карпентера о том, что за ужас может таиться во льдах. Антарктида.','Культовый фильм от Джона Карпентера о том, что за ужас может таиться во льдах. Антарктида. Группа ученых находит замерзший во льдах космический корабль пришельцев. Рядом с таинственным звездным скитальцем, пролежавшим под снегом не менее ста тысяч лет, обнаружено тело пришельца. Аккуратно вырезанный кусок льда с телом транспортируют в лабораторию, расположенную на полярной станции. Часть ткани, взятая для анализа, подтверждает внеземное происхождение существа. Предчувствие ошеломляющего открытия захватывает ученых, и они не замечают, как пришелец, разбив глыбу, исчезает в неизвестном направлении. Причем в одной из клеток, где была заперта ездовая собака, осталась только лужа крови. ',''),
	(1,5,NULL,'Курт Рассел, Ким Кэтролл, Джеймс Хонг и Виктор Вонг в комедийном боевике Джона Карпентера.','Курт Рассел, Ким Кэтролл, Джеймс Хонг и Виктор Вонг в комедийном боевике Джона Карпентера. Джек Бертон неплохо устроился. Он занимается тем, что перевозит поросят на своем фургоне в Сан-Франциско. Работа не пыльная и отнимает не так много времени. А в свободное время Джек любит играть в карты и наведываться в местные бары. У Джека есть друг Ванг, и вот однажды прямо в аэропорту его невесту похищает китайская мафия. Девушка привлекла мафиози тем, что обладает необычным зеленым оттенком глаз. Джек намерен помочь другу вызволить любимую, а в этом ему будет помогать предприимчивая журналистка Грейси, с которой Джек познакомился в том же аэропорту. Грейси знает о том, где находится похищенная невеста, но будущие спасители не в курсе того, что в этом похищении замешаны еще и высшие силы. Друзей ждет не одна знатная переделка, ведь даже не беря в расчёт мистику, — с китайскими мафиози шутки плохи.',''),
	(1,6,NULL,'Триллер Дэвида Финчера с Брэдом Питтом, который ищет маньяка.','Культовый триллер о хладнокровном маньяке, возомнившем себя Богом, сделавший Девида Финчера главным режиссером девяностых. Что в коробке? Детективу Уильяму Сомерсету (Морган Фриман) оставалась всего неделя до выхода на пенсию, когда в городе произошло убийство невиданной жестокости. Опытный ветеран уголовного розыска чувствует — это лишь первое звено в цепочке чудовищных преступлений, за которыми стоит изощренный маньяк. Вместе с новым напарником Дэвидом Миллзом (Бред Питт) детективу нужно понять логику убийцы и предугадать его следующий шаг.',''),
	(1,7,NULL,'Культовая экранизация, превзошедшая книжный оригинал.','Потрясающая культовая картина, ставшая кульминацией американского кинематографа на стыке двух тысячелетий. История классического «белого воротничка», который страдает от своей никчёмности и бессонницы. Но всё меняется, когда в самолёте судьба сводит его с Тайлером, с которым они создают закрытый бойцовский клуб. Но постепенно это общество перерастает в нечто большее.',''),
	(1,8,NULL,'Фильм-обладатель премий «Оскар» и «Золотой пальмовой ветви» рассказывает о приключениях двух незаурядных бандитов-интеллектуалов.','Фильм-обладатель премий «Оскар» и «Золотой пальмовой ветви» рассказывает о приключениях двух незаурядных бандитов-интеллектуалов. Винсент Вега (Джон Траволта) и Джулс Винфилд (Сэмюэл Л.Джексон) — участники криминальной группировки, которой руководит Марселлас Уоллес (Винг Реймз). Преступники занимаются повседневными бандитскими делами, а в перерывах ведут философские беседы и рассказывают друг другу забавные случаи из жизни.',''),
	(1,9,NULL,'Возмутительная, необычная, экстремальная картина о Диком Западе.','Атмосферный зимний вестерн от создателя «Криминального чтива» Квентина Тарантино. Охотник за головами Джон Рут после гражданской войны в США вынужден сопровождать заключённую. К ним прибавляются ещё один охотник и новый шериф, но конвой во время пути застигает снежная буря. Им приходится переждать непогоду в лавке, где уже была весьма колоритная четвёрка.',''),
	(1,10,NULL,'Один из самых успешных фильмов Квентина Тарантино.','Ностальгическая картина, в которой главная роль досталась целой эпохе — эпохе шестидесятых. Актёр на закате карьеры Рик Далтон (Леонардо ДиКаприо) нервно пытается ухватиться за ускользающую славу. Единственная поддержка — его дублёр Клифф Бут (Брэд Питт), он же шофёр, ассистент и лучший друг Рика. Таким разным, на первый взгляд, им обоим важно не потеряться в этом слишком быстро меняющемся мире. Отсюда бесконечные съемки, скитания по Голливуду и воспоминания о былых днях. Сюжет вежливо уступит место остроумным отсылкам и бесконечным диалогам под музыку и пейзажи давно ушедших пленительных времён.',''),
	(2,1,NULL,NULL,NULL,'poster of "One Flew Over the Cuckoo`s Nest"'),
	(2,2,NULL,NULL,NULL,'poster of "The Shining"'),
	(2,3,NULL,NULL,NULL,'poster of "Escape from New York"'),
	(2,4,NULL,NULL,NULL,'poster of "The Thing"'),
	(2,5,NULL,NULL,NULL,'poster of "Big Trouble in Little China"'),
	(2,6,NULL,NULL,NULL,'poster of "Se7en"'),
	(2,7,NULL,NULL,NULL,'poster of "Fight Club"'),
	(2,8,NULL,NULL,NULL,'poster of "Pulp Fiction"'),
	(2,9,NULL,NULL,NULL,'poster of "The Hateful Eight"'),
	(2,10,NULL,NULL,NULL,'poster of "Once Upon a Time... in Hollywood"'),
	(2,NULL,1,NULL,NULL,'photo of Jack Nicholson'),
	(2,NULL,2,NULL,NULL,'photo of Milos Forman'),
	(2,NULL,3,NULL,NULL,'photo of Stanley Kubrick'),
	(2,NULL,4,NULL,NULL,'photo of Kurt Russell'),
	(2,NULL,5,NULL,NULL,'photo of John Carpenter'),
	(2,NULL,6,NULL,NULL,'photo of David Fincher'),
	(2,NULL,7,NULL,NULL,'photo of Brad Pitt'),
	(2,NULL,8,NULL,NULL,'photo of Quentin Tarantino'),
	(2,NULL,9,NULL,NULL,'photo of Samuel L. Jackson'),
	(2,NULL,10,NULL,NULL,'photo of Leonardo DiCaprio');

DROP TABLE IF EXISTS photos;
CREATE TABLE photos (
	id SERIAL PRIMARY KEY,
	name VARCHAR(255) DEFAULT NULL,
	media_id BIGINT UNSIGNED NOT NULL,
	FOREIGN KEY (media_id) REFERENCES media(id)
) COMMENT 'Фото';

INSERT INTO photos (name, media_id) VALUES
	('OneFlewOverTheCuckoosNest_poster.png',11),
	('TheShining_poster.png',12),
	('EscapeFromNewYork_poster.png',13),
	('TheThing_poster.png',14),
	('BigTroubleInLittleChina_poster.png',15),
	('Se7en_poster.png',16),
	('FightClub_poster.png',17),
	('PulpFiction_poster.png',18),
	('TheHatefulEight_poster.png',19),
	('OnceUponATimeInHollywood_poster.png',20),
	('photo of Jack Nicholson',21),
	('photo of Milos Forman',22),
	('photo of Stanley Kubrick',23),
	('photo of Kurt Russell',24),
	('photo of John Carpenter',25),
	('photo of David Fincher',26),
	('photo of Brad Pitt',27),
	('photo of Quentin Tarantino',28),
	('photo of Samuel L. Jackson',29),
	('photo of Leonardo DiCaprio',30);

DROP TABLE IF EXISTS profiles;
CREATE TABLE profiles (
	person_id BIGINT UNSIGNED NOT NULL UNIQUE,
	gender CHAR(1),    
	birthplace VARCHAR(100),
	photo_id BIGINT UNSIGNED NULL COMMENT 'Основное фото',
	bio_id BIGINT UNSIGNED NULL COMMENT 'Краткая биография',  
	FOREIGN KEY (person_id) REFERENCES persons(id) ON UPDATE CASCADE ON DELETE RESTRICT,
	FOREIGN KEY (photo_id) REFERENCES photos(id),
	FOREIGN KEY (bio_id) REFERENCES media(id)
) COMMENT 'Профили';

INSERT INTO profiles (person_id, gender, birthplace, photo_id) VALUES
	(1,'m','Neptune, New Jersey, USA',11),
	(2,'m','Cáslav, Czechoslovakia [now Czech Republic]',12),
	(3,'m','New York City, New York, USA',13),
	(4,'m','Springfield, Massachusetts, USA',14),
	(5,'m','Carthage, New York, USA',15),
	(6,'m','Denver, Colorado, USA',16),
	(7,'m','Shawnee, Oklahoma, USA',17),
	(8,'m','Knoxville, Tennessee, USA',18),
	(9,'m','Washington, District of Columbia, USA',19),
	(10,'m','Hollywood, Los Angeles, California, USA',20);

DROP TABLE IF EXISTS film_info;
CREATE TABLE film_info (
	film_id BIGINT UNSIGNED NOT NULL UNIQUE,
	length_in_minutes SMALLINT UNSIGNED NULL COMMENT 'Продолжительность в минутах',
	about_id BIGINT UNSIGNED NULL COMMENT 'Описание',
	poster_id BIGINT UNSIGNED NULL COMMENT 'Основной постер',
	FOREIGN KEY (film_id) REFERENCES films(id) ON UPDATE CASCADE ON DELETE RESTRICT,
	FOREIGN KEY (about_id) REFERENCES media(id),
	FOREIGN KEY (poster_id) REFERENCES photos(id)
) COMMENT 'Фильмы-инфо';

INSERT INTO film_info (film_id, length_in_minutes, about_id, poster_id) VALUES
	(1,133,1,1),
	(2,146,2,2),
	(3,99,3,3),
	(4,109,4,4),
	(5,99,5,5),
	(6,127,6,6),
	(7,139,7,7),
	(8,154,8,8),
	(9,168,9,9),
	(10,161,10,10);

/*Представления*/
CREATE OR REPLACE
VIEW kinoman.film_info_views AS
SELECT 
	fi.film_id AS id, f.title, f.rus_title, f.release_year, f.image_path, fi.length_in_minutes,
	group_concat(DISTINCT g.name ORDER BY g.name ASC SEPARATOR ', ') AS genres,
	group_concat(DISTINCT concat(pers.firstname, ' ', pers.lastname) ORDER BY pers.lastname ASC SEPARATOR ', ') AS actors,
	group_concat(DISTINCT concat(pers2.firstname, ' ', pers2.lastname) ORDER BY pers2.lastname ASC SEPARATOR ', ') AS directors,
	m.description	AS about,
	m.briefly	AS briefly,
	p.name 	AS poster 
FROM film_info fi 
LEFT JOIN films f 			ON fi.film_id = f.id
LEFT JOIN media m 			ON fi.about_id = m.id 
LEFT JOIN photos p 			ON fi.poster_id = p.id 
LEFT JOIN film_genres fg 	ON fi.film_id = fg.film_id
LEFT JOIN genres g 			ON fg.genre_id = g.id
LEFT JOIN film_persons fp 	ON fi.film_id = fp.film_id AND fp.position_id < 5
LEFT JOIN persons pers 		ON fp.person_id = pers.id
LEFT JOIN film_persons fp2 	ON fi.film_id = fp2.film_id AND fp2.position_id = 5
LEFT JOIN persons pers2 	ON fp2.person_id = pers2.id
GROUP BY fi.film_id;
/*SELECT * FROM film_info_views;*/

CREATE OR REPLACE
VIEW kinoman.person_info_views AS
SELECT
	p.person_id,
	concat(p1.firstname, ' ', p1.lastname) AS name,
	p.gender, p1.birthday, p.birthplace,
	group_concat(DISTINCT concat(f.title,' (',f.release_year,') as ', p3.name) ORDER BY f.release_year ASC SEPARATOR ', ') AS films, 
	p2.name AS photo,
	m.description 	AS bio
FROM profiles p 
LEFT JOIN persons p1 		ON p.person_id = p1.id 
LEFT JOIN photos p2 		ON p.photo_id = p2.id 
LEFT JOIN media m 			ON p.bio_id = m.id
LEFT JOIN film_persons fp	ON p.person_id = fp.person_id
LEFT JOIN films f			ON fp.film_id = f.id
LEFT JOIN positions p3		ON fp.position_id = p3.id
GROUP BY p.person_id;
/*SELECT * FROM person_info_views;*/

DROP TABLE IF EXISTS users;
CREATE TABLE users(
	id SERIAL PRIMARY KEY,
	name VARCHAR(255),
	email VARCHAR(255),
	`password` VARCHAR(255),
	email_verified_at TIMESTAMP NULL,
	remember_token VARCHAR(100),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
	UNIQUE unique_email(email(255))
) COMMENT 'Пользователи';

DROP TABLE IF EXISTS password_resets;
CREATE TABLE password_resets(
	email VARCHAR(255),
	token VARCHAR(255),
    created_at TIMESTAMP NULL
) COMMENT 'Сброс паролей';
CREATE INDEX idx_email ON password_resets (email); 

/**/

/*SELECT * FROM films;*/
/*SELECT * FROM persons;*/
/*SELECT * FROM positions;*/
/*SELECT * FROM genres;*/
/*SELECT * FROM media_types;*/
/*SELECT * FROM media;*/
/*SELECT * FROM photos;*/
/*SELECT * FROM profiles;*/
/*SELECT * FROM film_info;*/

/*SELECT * FROM film_persons fp 
JOIN films f ON fp.film_id = f.id 
JOIN persons p ON fp.person_id = p.id
JOIN positions p2 ON fp.position_id = p2.id;*/

/*SELECT * FROM film_genres fg
JOIN films f ON fg.film_id = f.id
JOIN genres g ON fg.genre_id = g.id;*/

/*SELECT * FROM photos p
JOIN media m ON p.media_id = m.id;*/

/*SELECT * FROM profiles p 
LEFT JOIN persons p1 		ON p.person_id = p1.id 
LEFT JOIN photos p2 		ON p.photo_id = p2.id 
LEFT JOIN media m 			ON p.bio_id = m.id;*/

/*SELECT * FROM film_info fi 
LEFT JOIN films f 			ON fi.film_id = f.id
LEFT JOIN media m 			ON fi.about_id = m.id 
LEFT JOIN photos p 			ON fi.poster_id = p.id;*/