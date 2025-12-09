CREATE DATABASE task_manager;

USE task_manager;

CREATE TABLE `users` (

  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE tasks (

  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `due_date` date NOT NULL,
  `priority` enum('low','medium','high') NOT NULL DEFAULT 'medium',
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),

  PRIMARY KEY (`id`),

  KEY `user_id` (`user_id`),

  CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO users (name, email, password) VALUES

('madni', 'mad@example.com', '123'),
('madni', 'mad@example.com', '456');


INSERT INTO tasks (user_id, title, description, due_date, priority, completed) VALUES

(1, 'Finish report', 'Complete the annual financial report', '2025-04-30', 'high', 0),
(1, 'Team meeting', 'Weekly sync with the team', '2025-04-25', 'medium', 0),
(2, 'Design mockup', 'Create UI mockups for the new feature', '2025-04-27', 'low', 0);


INSERT INTO users (name, email, password) 

VALUES ('mad', 'mad@gmail.com', '123');

INSERT INTO tasks (user_id, title, description, due_date, priority, completed) 

VALUES (3, 'Prepare presentation', 'Create slides for client meeting', '2025-05-05', 'high', 0);


CREATE VIEW pending_tasks AS
SELECT * FROM tasks 
WHERE completed = 0 
AND due_date >= CURDATE();

CREATE VIEW completed_tasks AS
SELECT * FROM tasks 
WHERE completed = 1;

CREATE VIEW overdue_tasks AS
SELECT * FROM tasks 
WHERE completed = 0 
AND due_date < CURDATE();


select title from tasks;


