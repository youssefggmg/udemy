CREATE TYPE users_type as ENUM('Student', 'Teacher', 'Administrator') ;
CREATE TYPE status_type as ENUM('Active', 'Inactive') ;

CREATE TABLE "User" (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    user_type users_type NOT NULL,
    account_status status_type NOT NULL DEFAULT 'Active'
);
CREATE TABLE Category (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    catImage text not null
);
CREATE TABLE Tag (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);
CREATE TYPE Cour_content as ENUM('Video', 'Text');
CREATE TYPE Cour_Status as ENUM('accepted', 'pending','rejected');

CREATE TABLE Course (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    content_type Cour_content NOT NULL,
    status Cour_Status NOT NULL DEFAULT 'pending',
    vedio_url VARCHAR(255) ,
    content TEXT ,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    teacher_ID int ,
    CONSTRAINT fk_teacher FOREIGN KEY (teacher_ID) REFERENCES "User"(id)
);
CREATE TABLE Course_Category (
	id SERIAL PRIMARY KEY,
    course_id INT,
    category_id INT,
    CONSTRAINT fk_course FOREIGN KEY (course_id) REFERENCES Course(id) ON DELETE CASCADE,
    CONSTRAINT fk_category FOREIGN KEY (category_id) REFERENCES Category(id) ON DELETE CASCADE
);
CREATE TABLE Course_Tag (
	id SERIAL PRIMARY KEY,
    course_id INT,
    tag_id INT,
    CONSTRAINT fk_course_tag FOREIGN KEY (course_id) REFERENCES Course(id) ON DELETE CASCADE,
    CONSTRAINT fk_tag FOREIGN KEY (tag_id) REFERENCES Tag(id) ON DELETE CASCADE
);
CREATE TYPE enrollment_status AS ENUM('Active', 'Completed', 'Canceled');
CREATE TABLE Enrollment (
    id SERIAL PRIMARY KEY,
    student_id INT,
    course_id INT,
    enrollment_date DATE NOT NULL,
    status enrollment_status NOT NULL,
    CONSTRAINT fk_student FOREIGN KEY (student_id) REFERENCES "User"(id) ON DELETE CASCADE,
    CONSTRAINT fk_course_enrollment FOREIGN KEY (course_id) REFERENCES Course(id) ON DELETE CASCADE
);