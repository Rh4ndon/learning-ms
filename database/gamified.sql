
-- Users table (for students and teachers, though teachers will have admin flag)
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    password VARCHAR(255) NOT NULL,  -- store hashed passwords
    email VARCHAR(100) NOT NULL UNIQUE,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    is_admin BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Quizzes table
CREATE TABLE quizzes (
    quiz_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    subject VARCHAR(50) NOT NULL,
    description TEXT,
    time_limit INT,  -- in minutes, NULL for no time limit
    is_published BOOLEAN DEFAULT FALSE,
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(user_id)
);

-- Questions table (stores all question types)
CREATE TABLE questions (
    question_id INT AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT NOT NULL,
    question_type ENUM('multiple_choice', 'true_false', 'short_text') NOT NULL,
    question_text TEXT NOT NULL,
    points INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (quiz_id) REFERENCES quizzes(quiz_id)
);

-- Options for multiple choice and true/false questions
CREATE TABLE question_options (
    option_id INT AUTO_INCREMENT PRIMARY KEY,
    question_id INT NOT NULL,
    option_text TEXT NOT NULL,
    is_correct BOOLEAN DEFAULT FALSE,
    display_order INT NOT NULL,  -- can be randomized when displaying
    FOREIGN KEY (question_id) REFERENCES questions(question_id)
);


-- Student answers
CREATE TABLE student_answers (
    answer_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    quiz_id INT NOT NULL,
    question_id INT NOT NULL,
    answer_text TEXT,  -- for short text answers
    option_id INT,  -- for selected option (multiple choice/true false)
    points_earned DECIMAL(10,2) DEFAULT 0,
    is_graded BOOLEAN DEFAULT FALSE,  -- for short answers needing teacher grading
    graded_by INT,  -- teacher who graded the answer
    graded_at TIMESTAMP NULL,
    taken_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    feedback TEXT,
    FOREIGN KEY (student_id) REFERENCES users(user_id),
    FOREIGN KEY (quiz_id) REFERENCES quizzes(quiz_id),
    FOREIGN KEY (question_id) REFERENCES questions(question_id),
    FOREIGN KEY (option_id) REFERENCES question_options(option_id),
    FOREIGN KEY (graded_by) REFERENCES users(user_id)
);

-- Student progress/achievements (for gamification)
CREATE TABLE student_progress (
    progress_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    total_points DECIMAL(10,2) DEFAULT 0,
    quizzes_completed INT DEFAULT 0,
    last_activity TIMESTAMP NULL,
    badges_earned TEXT,  -- could store JSON or comma-separated badges
    FOREIGN KEY (student_id) REFERENCES users(user_id),
    UNIQUE KEY (student_id)
);

CREATE TABLE sections (
    section_id INT AUTO_INCREMENT PRIMARY KEY,
    section_name VARCHAR(100) NOT NULL UNIQUE
);