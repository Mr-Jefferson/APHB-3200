/*
 * Initialize seminar_marks database, and respective relations.
 */

DROP DATABASE IF EXISTS seminar_marks;

CREATE DATABASE seminar_marks;
-- -----------------------------------------------------
-- Users Relation
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS seminar_marks.users (
    id_user INT NOT NULL PRIMARY KEY,
    username VARCHAR(45) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL DEFAULT '',
    cohort INT NOT NULL,
    semester TINYINT NOT NULL,
    session_hash VARCHAR(255) DEFAULT ''
);
-- -----------------------------------------------------
-- Markers Relation
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS seminar_marks.markers (
    id_marker INT NOT NULL PRIMARY KEY,
    marker_first_name VARCHAR(45) NOT NULL,
    marker_last_name VARCHAR(45) NOT NULL
);
-- -----------------------------------------------------
-- Students Relation
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS seminar_marks.students (
    id_student INT NOT NULL PRIMARY KEY,
    student_first_name VARCHAR(45) NOT NULL,
    student_last_name VARCHAR(45) NOT NULL,
    student_number INT NULL,
    cohort INT NOT NULL,
    semester TINYINT NOT NULL
);
-- -----------------------------------------------------
-- Marks Relation
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS seminar_marks.marks (
    id_mark INT NOT NULL PRIMARY KEY,
    mark_1 DOUBLE NOT NULL,
    mark_2 DOUBLE NOT NULL,
    mark_3 DOUBLE NOT NULL,
    seminar TINYINT NOT NULL,
    id_student INT NOT NULL,
    id_marker INT NOT NULL,

    FOREIGN KEY (id_student) REFERENCES students(id_student) ON DELETE CASCADE,
    FOREIGN KEY (id_marker) REFERENCES markers(id_marker) ON DELETE CASCADE
);
-- -----------------------------------------------------
-- Initial User
-- -----------------------------------------------------
INSERT INTO seminar_marks.users VALUES (1,'admin','$1$CKgg8CRW$YoqH9eNvg3QKm7thS/vyc.',2014,1,'');