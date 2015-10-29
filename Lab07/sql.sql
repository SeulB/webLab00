DROP TABLE IF EXISTS `student`;
CREATE TABLE student (
	student_id INTEGER NOT NULL PRIMARY KEY,
	name VARCHAR(10) NOT NULL,
	year SMALLINT NOT NULL DEFAULT "1",                                       
	dept_no INTEGER NOT NULL,
	major VARCHAR(20)
);

DROP TABLE IF EXISTS `department`;
CREATE TABLE department (                                                
	dept_no INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,                 
	dept_name VARCHAR(20) NOT NULL UNIQUE,                               
	office VARCHAR(20) NOT NULL,                                         
	office_tel VARCHAR(13)
);

ALTER TABLE student
MODIFY COLUMN major VARCHAR(40);

ALTER TABLE student
ADD COLUMN gender;

ALTER TABLE department
MODIFY COLUMN dept_name VARCHAR(40);

ALTER TABLE department
MODIFY COLUMN office VARCHAR(30);

ALTER TABLE student
DROP COLUMN gender;

-- student table item
INSERT INTO student
VALUES (20070002, 'James Bond', 3, 4, 'Business Administration'), 
(20060001, 'Queenie', 4, 4, 'Business Administration'),
(20030001, 'Reonardo', 4, 2, 'Electronic Engineering'), 
(20040003, 'Julia', 3, 2, 'Electronic Engineering'),
(20060002, 'Roosevelt', 3, 1, 'Computer Science'),
(20100002, 'Fearne', 3, 4, 'Business Administration'),
(20110001, 'Chloe', 2, 1, 'Computer Science'), 
(20080003, 'Amy', 4, 3, 'Law'),
(20040002, 'Selina', 4, 5, 'English Literature'), 
(20070001, 'Ellen', 4, 4, 'Business Administration'),
(20100001, 'Kathy', 3, 4, 'Business Administration'), 
(20110002, 'Lucy', 2, 2, 'Electronic Engineering'),
(20030002, 'Michelle', 5, 1, 'Computer Science'), 
(20070003, 'April', 4, 3, 'Law'),
(20070005, 'Alicia', 2, 5, 'English Literature'), 
(20100003, 'Yullia', 3, 1, 'Computer Science'),
(20070007, 'Ashlee', 2, 4, 'Business Administration');
-- 확인
SELECT * FROM student;

-- department table item
INSERT INTO department (dept_name, office, office_tel)
VALUES ('Computer Science', 'Engineering building', '02-3290-0123'),
('Electronic Engineering', 'Engineering building', '02-3290-2345'),
('Law', 'Law building', '02-3290-7896'),
('Business Administration', 'Administration building', '02-3290-1112'),
('English Literature', 'Literature building', '02-3290-4412');

SELECT * FROM department;

-- Ex 3
UPDATE department 
SET dept_name = 'Electronic and Electrical Engineering' 
WHERE dept_name = 'Electronic Engineering';
UPDATE student
SET major = 'Electronic and Electrical Engineering' 
WHERE major = 'Electronic Engineering';

SELECT * FROM department;
SELECT * FROM student;


INSERT INTO department (dept_name, office, office_tel)
VALUES ('Education', 'Education building', '02-3290-2347');

SELECT * FROM department;


UPDATE student
SET major = 'Education', dept_no = (SELECT dept_no FROM department WHERE dept_name = 'Education')
WHERE name = 'Chloe';

SELECT * FROM student;


DELETE FROM student WHERE name = 'Michelle';
DELETE FROM student WHERE name = 'Fearne';

SELECT * FROM student;


-- Ex 4
SELECT * FROM student WHERE major = "Computer Science";
SELECT student_id, year, major FROM student;
SELECT * FROM student WHERE year = 3;
SELECT * FROM student WHERE year = 1 OR year = 2;
SELECT * FROM student s JOIN department d ON s.dept_no = d.dept_no 
WHERE s.major = 'Business Administration';


-- Ex 5
SELECT name FROM student WHERE student_id LIKE '2007%';
SELECT name, student_id FROM student ORDER BY student_id;
SELECT major FROM student GROUP BY major HAVING avg(year) > 3;
SELECT name 
FROM student 
WHERE major = 'Business Administration' AND student_id LIKE '2007%' 
LIMIT 2;


-- Ex 6
SELECT r.role
FROM movies m JOIN roles r ON m.id = r.movie_id
WHERE m.name = 'Pi';

SELECT a.first_name, a.last_name, r.role
FROM roles r JOIN movies m ON m.id = r.movie_id
JOIN actors a ON a.id = r.actor_id
WHERE m.name = 'Pi';

---
SELECT a.first_name, a.last_name 
FROM roles r JOIN movies m1 ON m1.id = r.movie_id
JOIN movies m2 ON m2.id = r.movie_id
JOIN actors a ON a.id = r.actor_id
GROUP BY a.id
WHERE m1.name = 'Kill Bill: Vol. 1' AND m2.name = 'Kill Bill: Vol. 2';

SELECT a.first_name, a.last_name
FROM roles r JOIN movies m ON m.id = r.movie_id
JOIN actors a ON a.id = r.actor_id 
GROUP BY a.id
ORDER BY COUNT(m.id) DESC
LIMIT 7;

SELECT mg.genre
FROM movies m JOIN movies_genres mg ON m.id = mg.movie_id
GROUP BY genre
ORDER BY COUNT(m.id) DESC
LIMIT 3;

SELECT d.first_name, d.last_name
FROM directors d JOIN movies_directors md ON d.id = md.director_id
JOIN movies_genres mg ON md.movie_id = mg.movie_id
GROUP BY mg.genre
HAVING mg.genre = 'Thriller'
ORDER BY COUNT(d.id) DESC
LIMIT 1;


-- Ex 7
SELECT grade 
FROM courses c JOIN grades g ON c.id = g.course_id
WHERE c.name = 'Computer Science 143';

SELECT s.name, g.grade 
FROM grades g JOIN students s ON g.student_id = s.id
JOIN courses c ON c.id = g.course_id
WHERE c.name = 'Computer Science 143' 
AND ((g.grade = 'B-') OR (g.grade = 'B-') OR (g.grade = 'B') OR (g.grade = 'B+') 
OR (g.grade = 'A-') OR (g.grade = 'A') OR (g.grade = 'A+'));

SELECT s.name, c.name, g.grade
FROM grades g JOIN students s ON g.student_id = s.id
JOIN courses c ON c.id = g.course_id
WHERE (g.grade = 'B-') OR (g.grade = 'B-') OR (g.grade = 'B') OR (g.grade = 'B+') 
OR (g.grade = 'A-') OR (g.grade = 'A') OR (g.grade = 'A+');

