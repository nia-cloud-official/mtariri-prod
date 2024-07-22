SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `users` (
  `phone_number` VARCHAR(15) NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`phone_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`phone_number`, `name`, `email`, `password_hash`) VALUES
('715212928', 'Milton Vafana', 'milton.vafana@example.com', 'hashed_password');

CREATE TABLE `policies` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `phone_number` VARCHAR(15),
  `policy_number` VARCHAR(50) NOT NULL,
  `start_date` DATE,
  `end_date` DATE,
  `details` TEXT,
  FOREIGN KEY (`phone_number`) REFERENCES `users`(`phone_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `policies` (`phone_number`, `policy_number`, `start_date`, `end_date`, `details`) VALUES
('715212928', 'POL12345', '2024-01-01', '2025-01-01', 'Details about the policy.');

CREATE TABLE `claims` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `phone_number` VARCHAR(15),
  `policy_id` INT,
  `claim_date` DATE,
  `status` VARCHAR(50),
  `details` TEXT,
  FOREIGN KEY (`phone_number`) REFERENCES `users`(`phone_number`),
  FOREIGN KEY (`policy_id`) REFERENCES `policies`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `claims` (`phone_number`, `policy_id`, `claim_date`, `status`, `details`) VALUES
('715212928', 1, '2024-06-01', 'Pending', 'Details about the claim.');

ALTER TABLE `policies`
  MODIFY `id` INT AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `claims`
  MODIFY `id` INT AUTO_INCREMENT, AUTO_INCREMENT=2;

COMMIT;
