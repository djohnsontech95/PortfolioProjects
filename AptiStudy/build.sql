DROP TABLE IF EXISTS ticket CASCADE;
DROP TABLE IF EXISTS ticket_category CASCADE;
DROP TABLE IF EXISTS meeting CASCADE;
DROP TABLE IF EXISTS room CASCADE;
DROP TABLE IF EXISTS building CASCADE;
DROP TABLE IF EXISTS calendar CASCADE;
DROP TABLE IF EXISTS quiz_answers CASCADE;
DROP TABLE IF EXISTS quiz_questions CASCADE;
DROP TABLE IF EXISTS comp_quiz CASCADE;
DROP TABLE IF EXISTS multiselect_goals CASCADE;
DROP TABLE IF EXISTS group_goals CASCADE;
DROP TABLE IF EXISTS group_members CASCADE;
DROP TABLE IF EXISTS enrolled_courses CASCADE;
DROP TABLE IF EXISTS course CASCADE;
DROP TABLE IF EXISTS student_majors CASCADE;
DROP TABLE IF EXISTS majors CASCADE;
DROP TABLE IF EXISTS announcements CASCADE;
DROP TABLE IF EXISTS group_image CASCADE;
DROP TABLE IF EXISTS study_group CASCADE;
DROP TABLE IF EXISTS profile_image CASCADE;
DROP TABLE IF EXISTS user_authentication CASCADE;
DROP TABLE IF EXISTS student CASCADE;


CREATE TABLE student (
    id INT auto_increment NOT NULL,
    fname VARCHAR(20) NOT NULL,
    lname VARCHAR(20) NOT NULL,
    username VARCHAR(10) NOT NULL,
    college_standing VARCHAR(10) NOT NULL,
    user_bio VARCHAR(256),
    PRIMARY KEY (id)
) ENGINE = innodb;

CREATE TABLE user_authentication (
    authenticate_id VARCHAR(30) NOT NULL,
    student_id INT NOT NULL,
    FOREIGN KEY (student_id) REFERENCES student(id),
    PRIMARY KEY (authenticate_id)
) ENGINE = innodb;

CREATE TABLE profile_image (
    id INT auto_increment NOT NULL,
    student_id INT NOT NULL,
    file_name VARCHAR(256) COLLATE utf8_unicode_ci NOT NULL,
    FOREIGN KEY (student_id) REFERENCES student(id),
    PRIMARY KEY (id)
) ENGINE = innodb DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE majors (
    id INT auto_increment NOT NULL,
    major_name VARCHAR (50) NOT NULL,
    PRIMARY KEY (id)
) ENGINE = innodb;

CREATE TABLE student_majors (
    student_id INT NOT NULL,
    major_id INT NOT NULL,
    FOREIGN KEY (student_id) REFERENCES student(id),
    FOREIGN KEY (major_id) REFERENCES majors(id)
) ENGINE = innodb;


CREATE TABLE course (
    id INT auto_increment NOT NULL,
    course_title VARCHAR(30) NOT NULL,
    subject VARCHAR(30) NOT NULL,
    PRIMARY KEY (id)
) ENGINE = innodb;

CREATE TABLE enrolled_courses (
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    FOREIGN KEY (student_id) REFERENCES student(id),
    FOREIGN KEY (course_id) REFERENCES course(id)
) ENGINE = innodb;


CREATE TABLE building (
    id INT auto_increment NOT NULL,
    name tinytext NOT NULL,
    street VARCHAR(30) NOT NULL,
    city VARCHAR(15) NOT NULL,
    state CHAR(2) NOT NULL,
    area_code CHAR(5) NOT NULL,
    PRIMARY KEY (id)
) ENGINE = innodb;

CREATE TABLE room (
    id INT auto_increment NOT NULL,
    building_id INT NOT NULL,
    room_num VARCHAR(8) NOT NULL,
    FOREIGN KEY (building_id) REFERENCES building(id),
    PRIMARY KEY (id)
) ENGINE = innodb;


CREATE TABLE comp_quiz (
    id INT auto_increment NOT NULL,
    student_id INT NOT NULL,
    FOREIGN KEY (student_id) REFERENCES student(id),
    PRIMARY KEY (id)
) ENGINE = innodb;

CREATE TABLE quiz_questions (
    id INT auto_increment NOT NULL,
    question tinytext NOT NULL,
    PRIMARY KEY (id)
) ENGINE = innodb;

CREATE TABLE quiz_answers (
    student_id INT NOT NULL,
    question_num INT NOT NULL,
    answer_num INT NOT NULL,
    answer tinytext NOT NULL,
    FOREIGN KEY (question_num) REFERENCES quiz_questions(id),
    FOREIGN KEY (student_id) REFERENCES student(id)
) ENGINE = innodb;


CREATE TABLE study_group (
    id INT auto_increment NOT NULL,
    host_id INT,
    group_name VARCHAR(50) NOT NULL,
    description VARCHAR(256) NOT NULL,
    max_members INT NOT NULL,
    FOREIGN KEY (host_id) REFERENCES student(id),
    PRIMARY KEY (id)
) ENGINE = innodb;

CREATE TABLE group_image (
    id INT auto_increment NOT NULL,
    group_id INT NOT NULL,
    file_name VARCHAR(256) COLLATE utf8_unicode_ci NOT NULL,
    FOREIGN KEY (group_id) REFERENCES study_group(id),
    PRIMARY KEY (id)
) ENGINE = innodb DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE group_goals (
    id INT auto_increment NOT NULL,
    goal tinytext NOT NULL,
    PRIMARY KEY (id)
) ENGINE = innodb;

CREATE TABLE multiselect_goals (
    group_id INT NOT NULL,
    goal_id INT NOT NULL,
    FOREIGN KEY (group_id) REFERENCES study_group(id),
    FOREIGN KEY (goal_id) REFERENCES group_goals(id)
) ENGINE = innodb;

CREATE TABLE calendar (
    id INT auto_increment NOT NULL,
    group_id INT NOT NULL,
    FOREIGN KEY (group_id) REFERENCES study_group(id),
    PRIMARY KEY (id)
) ENGINE = innodb;

CREATE TABLE group_members (
    id INT auto_increment NOT NULL,
    group_id INT NOT NULL,
    member_id INT NOT NULL,
    FOREIGN KEY (group_id) REFERENCES study_group(id),
    FOREIGN KEY (member_id) REFERENCES student(id),
    PRIMARY KEY (id)
) ENGINE = innodb;

CREATE TABLE meeting (
    id INT auto_increment NOT NULL,
    group_id INT NOT NULL,
    location INT NOT NULL,
    meeting_name VARCHAR(150) NOT NULL,
    _time time NOT NULL,
    _date date NOT NULL,
    FOREIGN KEY (group_id) REFERENCES study_group(id),
    FOREIGN KEY (location) REFERENCES room(id),
    PRIMARY KEY (id)
) ENGINE = innodb;

CREATE TABLE announcements (
    id INT auto_increment NOT NULL,
    group_id INT NOT NULL,
    first_update VARCHAR(55),
    second_update VARCHAR(55),
    third_update VARCHAR(55),
    FOREIGN KEY (group_id) REFERENCES study_group(id),
    PRIMARY KEY (id)
) ENGINE = innodb;


CREATE TABLE ticket_category (
    id INT NOT NULL,
    category VARCHAR(30) NOT NULL,
    PRIMARY KEY (id)
) ENGINE = innodb;

CREATE TABLE ticket (
    id INT auto_increment NOT NULL,
    student_id INT NOT NULL,
    date_filed DATE NOT NULL,
    time_filed TIME NOT NULL,
    type INT NOT NULL,
    severity VARCHAR(20) NOT NULL,
    description VARCHAR(256) NOT NULL,
    ticket_status VARCHAR(10) NOT NULL,
    FOREIGN KEY (type) REFERENCES ticket_category(id),
    FOREIGN KEY (student_id) REFERENCES student(id),
    PRIMARY KEY (id)
) ENGINE = innodb;


INSERT INTO student (id, fname, lname, username, college_standing) VALUES
(1, 'Joel', 'Hammersin', 'jhammer', 'Sophomore'),
(2, 'Sophie', 'Hatter', 'shatter', 'Senior'),
(3, 'David', 'Oblenski', 'doblenski', 'Senior'),
(4, 'Rudeus', 'Greymann', 'rudemann', 'Junior'),
(5, 'Cally', 'Shuumerman', 'cshuumer', 'Junior');

INSERT INTO majors VALUES
(1, "Accounting"),
(2, "African American & African Diaspora Studies"),
(3, "American Studies"),
(4, "Animal Behavior"),
(5, "Anthropology"),
(6, "Art History"),
(7, "Biochemistry"),
(8, "Biology"),
(9, "Biotechnology"),
(10, "Chemistry"),
(11, "Cinematic Arts"),
(12, "Classical Civilization"),
(13, "Cognitive Science"),
(14, "Community Health"),
(15, "Composition"),
(16, "Computer Science"),
(17, "Criminal Justice"),
(18, "Data Science"),
(19, "Dietetics"),
(20, "Earth and Atmospheric Sciences"),
(21, "Earth Science"),
(22, "East Asian Studies"),
(23, "Economics"),
(24, "English"),
(25, "Entrepreneurship and Corporate Innovation"),
(26, "Environmental Health"),
(27, "Environmental Management"),
(28, "Environmental Science"),
(29, "Epidemiology"),
(30, "Finance"),
(31, "Fitness and Health"),
(32, "French"),
(33, "Game Design"),
(34, "Gender Studies"),
(35, "Geography"),
(36, "Germanic Studies"),
(37, "Healthcare Management and Policy"),
(38, "History"),
(39, "Human Biology"),
(40, "Human Resource Management"),
(41, "Informatics"),
(42, "Information Systems"),
(43, "International Studies"),
(44, "Journalism"),
(45, "Law and Public Policy"),
(46, "Liberal Studies"),
(47, "Linguistics"),
(48, "Management"),
(49, "Marketing"),
(50, "Mathematics"),
(51, "Media"),
(52, "Microbiology"),
(53, "Neuroscience"),
(54, "Nursing"),
(55, "Operations Management"),
(56, "Optometry"),
(57, "Parks, Recreation, and the Outdoors"),
(58, "Philosophy"),
(59, "Physics"),
(60, "Political Science"),
(61, "Psychology"),
(62, "Public Policy Analysis"),
(63, "Real Estate"),
(64, "Religious Studies"),
(65, "Safety"),
(66, "Sociology"),
(67, "Statistics"),
(68, "Supply Chain Management"),
(69, "Theatre and Drama"),
(70, "Visual Arts Education"),
(71, "Youth Development");

INSERT INTO course VALUES
(1, 'INFO-I 495', 'Informatics'),
(2, 'INFO-I 360', 'Informatics'),
(3, 'CSCI-C 291', 'Computer Science'),
(4, 'INFO-Y 395', 'Informatics'),
(5, 'INFO-I 210', 'Informatics'),
(6, 'INFO-I 211', 'Informatics'),
(7, 'CSCI-A 110', 'Computer Science'),
(8, 'INFO-I 300', 'Informatics'),
(9, 'INFO-I 400', 'Informatics'),
(10, 'INFO-I 370', 'Informatics'),
(11, 'CSCI-C 200', 'Computer Science'),
(12, 'INFO-Y 365', 'Informatics');

INSERT INTO enrolled_courses VALUES
(1, 2),
(2, 4),
(3, 1),
(4, 3),
(5, 4),
(1, 3),
(2, 2),
(3, 3),
(4, 2),
(5, 2);


INSERT INTO study_group VALUES
(1, 2, 'Hatters', 'A group to better learn about Merchandising!', 8),
(2, 5, 'Infoers', 'Let''s learn how to design websites together!', 8),
(3, 4,  'Computers', 'Let''s code code together!', 8);

INSERT INTO group_members VALUES
(1, 1, 2),
(2, 2, 5),
(3, 2, 2),
(4, 2, 4),
(5, 3, 4),
(6, 3, 1),
(7, 3, 3);

INSERT INTO group_goals VALUES
(1, 'Make friends!'),
(2, 'Learn more about merchandising!'),
(3, 'Help each other study'),
(4, 'Learn more about website design!'),
(5, 'Learn about coding with each other!'),
(6, 'Help each other out!');

INSERT INTO multiselect_goals VALUES 
(1, 1),
(1, 2),
(2, 3),
(3, 2),
(3, 6);


INSERT INTO building VALUES
(1, 'Hodge Hall', '1309 E 10th St', 'Bloomington', 'IN', '47405'),
(2, 'Luddy Hall', '700 N. Woodlawn Ave', 'Bloomington', 'IN', '47408'),
(3, 'Herman B Wells Library', '1320 E 10th St', 'Bloomington', 'IN', '47405'),
(4, 'Global and International Studies Building', '355 Eagleson Ave', 'Bloomington', 'IN', '47405'),
(5, 'Indiana Memorial Union', '900 E 7th St', 'Bloomington', 'IN', '47405');

INSERT INTO room VALUES
(1, 1, 2023),
(2, 1, 3054),
(3, 2, 1006),
(4, 2, 2000),
(5, 3, 1300),
(6, 3, 2100),
(7, 4, 2131),
(8, 4, 1100),
(9, 5, 3156),
(10, 5, 0013);


INSERT INTO calendar VALUES
(1, 1),
(2, 2),
(3, 3);

INSERT INTO meeting VALUES
(1, 2, 2, 'Assignment 1 help sesh', '12:00:00', '2023-01-23'),
(2, 3, 3, 'Week 3 Catch-up', '14:00:00', '2023-01-25');


INSERT INTO ticket_category VALUES
(1, 'Classroom Availability'),
(2, 'Classroom Booking'),
(3, 'Compatibility Questionnaire'),
(4, 'Group Creation'),
(5, 'Group Events'),
(6, 'Meeting Scheduling'),
(7, 'User Profile'),
(8, 'Study Groups (General)'),
(9, 'Other');

INSERT INTO ticket VALUES
(1, 3, '18-06-12', '10:34:09', 3, "Low Severity", 'Don''t know how to book a room.', 'Active'),
(2, 1, '18-06-12', '10:34:09', 1, "Medium Severity", 'I can''t seem to see the group calendar events on my calendar.', 'Active'),
(3, 2, '18-06-12', '10:34:09', 3, "Medium Severity", 'I can''t seem to add a meeting location from scheduling a meeting.', 'Active'),
(4, 5, '18-06-12', '10:34:09', 5, "High Severity", 'I can''t add anyone to my study group, how do I do that?', 'Active');


INSERT INTO comp_quiz VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5);

INSERT INTO quiz_questions VALUES
(1, 'What time do you generally prefer to study during the day?'),
(2, 'Where is your favorite place to study on campus?'),
(3, 'What do you seek most when working in study groups or groups in general?'),
(4, 'Do you prefer to study with others within the same major?'),
(5, 'How much time do you spend studying per week?');

INSERT INTO quiz_answers VALUES
(1, 1, 1, 'After 6:00PM'),
(1, 1, 2, 'Indiana Memorial Union'),
(1, 1, 3, 'Making friends'),
(1, 1, 4, 'Yes'),
(1, 1, 5, '2-3 hours per week');