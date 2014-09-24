DROP DATABASE IF EXISTS seminar_marks;
CREATE DATABASE seminar_marks;
USE seminar_marks;
-- -----------------------------------------------------
-- Users Relation
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
    id_user INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(45) NOT NULL UNIQUE,
    password VARCHAR(45) NOT NULL
);
-- -----------------------------------------------------
-- Markers Relation
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS markers (
    id_marker INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    marker_first_name VARCHAR(45) NOT NULL,
    marker_last_name VARCHAR(45) NOT NULL
);
-- -----------------------------------------------------
-- Students Relation
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS students (
    id_student INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    student_first_name VARCHAR(45) NOT NULL,
    student_last_name VARCHAR(45) NOT NULL,
    student_number VARCHAR(45) NULL
);
-- -----------------------------------------------------
-- Marks Relation
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS marks (
    id_mark INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    mark_1 INT NOT NULL,
    mark_2 INT NOT NULL,
    mark_3 INT NOT NULL,
    cohort INT NOT NULL,
    semester TINYINT NOT NULL,
    seminar TINYINT NOT NULL,
    id_student INT NOT NULL,
    id_marker INT NOT NULL,
    id_user INT NOT NULL,

    FOREIGN KEY (id_student) REFERENCES students(id_student) ON DELETE CASCADE,
    FOREIGN KEY (id_marker) REFERENCES markers(id_marker) ON DELETE CASCADE,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE
);