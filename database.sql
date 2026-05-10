-- Unified Database Schema and Data for FTLuma-Light

-- 1. Create Tables
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS authors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    bio TEXT,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    author_id INT,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    content TEXT NOT NULL,
    excerpt TEXT,
    featured_image VARCHAR(255),
    status ENUM('draft', 'published') DEFAULT 'draft',
    featured BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    FOREIGN KEY (author_id) REFERENCES authors(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    full_name VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    event_date DATE NOT NULL,
    event_time TIME NOT NULL,
    location VARCHAR(255),
    category VARCHAR(100),
    description TEXT,
    image VARCHAR(255),
    status ENUM('upcoming', 'completed', 'cancelled') DEFAULT 'upcoming',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    seats INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255),
    message TEXT NOT NULL,
    status ENUM('unread', 'read') DEFAULT 'unread',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- 2. Seed Data
-- Insert Categories (using IGNORE to avoid duplicate errors)
INSERT IGNORE INTO categories (name, slug, description) VALUES
('Technology', 'technology', 'The latest in software, hardware, and digital innovation.'),
('Design', 'design', 'Exploring aesthetics, user experience, and visual communication.'),
('Lifestyle', 'lifestyle', 'Insights for a balanced and inspired modern life.'),
('Business', 'business', 'Strategies and news from the global market.');


-- Insert Authors
INSERT INTO authors (name, bio, image) VALUES 
('Luma Admin', 'Founder and Lead Editor of FTLuma-Light. Passionate about sustainable technology and modern design.', 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&q=80&w=200'),
('Sarah Green', 'Environmental researcher and tech enthusiast focusing on green energy innovations.', 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&q=80&w=200');

-- Insert Posts
INSERT IGNORE INTO posts (category_id, author_id, title, slug, content, excerpt, featured_image, status, featured) VALUES
(1, 1, 'The Rise of Sustainable AI', 'rise-of-sustainable-ai', '<p>Artificial Intelligence is transforming our world, but its energy consumption is a growing concern. In this article, we explore how researchers are building more efficient algorithms that require less power without sacrificing performance.</p>', 'How researchers are building more efficient AI algorithms for a greener future.', 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&q=80&w=800', 'published', 1),
(2, 1, 'Mastering Glassmorphism in 2026', 'mastering-glassmorphism-2026', '<p>Glassmorphism continues to be a dominant trend in modern UI design. Its ability to create depth and hierarchy through translucent layers is unmatched.</p>', 'A deep dive into the evolution and implementation of glassmorphism in modern interfaces.', 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?auto=format&fit=crop&q=80&w=800', 'published', 1),
(3, 2, 'The Art of Slow Living in a Fast World', 'art-of-slow-living', '<p>In an age of instant gratification, the practice of slow living offers a path to meaningful connection and mental clarity.</p>', 'Finding balance and intentionality in our hyper-connected modern environment.', 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&q=80&w=800', 'published', 0);


-- Insert Default Admin (Email: info@ftluma-light.com, Password: Ftluma@123@1)
DELETE FROM admins WHERE username = 'admin' OR email = 'info@ftluma-light.com';
INSERT INTO admins (username, password, email, full_name) VALUES
('admin', '$2y$10$wtwdMBImY7Eb1OevWCHUbOWFHea.QSi.7OtLWcRDnODYekgvpxOSq', 'info@ftluma-light.com', 'System Administrator');




