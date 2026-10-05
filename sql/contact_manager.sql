-- 1. Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS contact_manager_2026_am;
USE contact_manager_2026_am;

-- 2. Drop the old table if it exists to give you a clean slate
DROP TABLE IF EXISTS contacts;
DROP TABLE IF EXISTS types;

-- 3. Create the table exactly as the PHP code expects
CREATE TABLE contacts (
  contactID INT NOT NULL AUTO_INCREMENT,
  firstName VARCHAR(50) NOT NULL,
  lastName VARCHAR(50) NOT NULL,
  emailAddress VARCHAR(100) NOT NULL,
  phone VARCHAR(20) DEFAULT NULL,
  status VARCHAR(20) NOT NULL DEFAULT 'Active',
  imageName VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (contactID),
  UNIQUE KEY (emailAddress)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Insert some starting data so your index.php isn't empty
INSERT INTO contacts (firstName, lastName, emailAddress, phone, status, imageName) VALUES
('Bugs', 'Bunny', 'bbunny@ltunes.com', '555-555-1111', 'Active', NULL),
('Daffy', 'Duck', 'dduck@ltunes.com', '555-555-1112', 'Inactive', NULL),
('Tweety', 'Bird', 'tbird@ltunes.com', '555-555-1113', 'Active', NULL);