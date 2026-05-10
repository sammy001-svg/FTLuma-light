-- Sample Seed Data for Modern Green Blog System

-- Insert Categories (using IGNORE to avoid duplicate errors)
INSERT IGNORE INTO categories (name, slug, description) VALUES
('Technology', 'technology', 'The latest in software, hardware, and digital innovation.'),
('Design', 'design', 'Exploring aesthetics, user experience, and visual communication.'),
('Lifestyle', 'lifestyle', 'Insights for a balanced and inspired modern life.'),
('Business', 'business', 'Strategies and news from the global market.');


-- Insert Posts
INSERT IGNORE INTO posts (category_id, title, slug, content, excerpt, featured_image, status, featured) VALUES
(1, 'The Rise of Sustainable AI', 'rise-of-sustainable-ai', '<p>Artificial Intelligence is transforming our world, but its energy consumption is a growing concern. In this article, we explore how researchers are building more efficient algorithms that require less power without sacrificing performance.</p><p>From hardware optimizations to better training data management, the path to green AI is becoming clearer.</p>', 'How researchers are building more efficient AI algorithms for a greener future.', 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&q=80&w=800', 'published', 1),
(2, 'Mastering Glassmorphism in 2026', 'mastering-glassmorphism-2026', '<p>Glassmorphism continues to be a dominant trend in modern UI design. Its ability to create depth and hierarchy through translucent layers is unmatched.</p><p>Learn the best practices for background blur, border treatments, and accessibility when using this elegant style.</p>', 'A deep dive into the evolution and implementation of glassmorphism in modern interfaces.', 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?auto=format&fit=crop&q=80&w=800', 'published', 1),
(3, 'The Art of Slow Living in a Fast World', 'art-of-slow-living', '<p>In an age of instant gratification, the practice of slow living offers a path to meaningful connection and mental clarity.</p><p>We examine simple shifts in daily habits that can lead to a more intentional and fulfilling lifestyle.</p>', 'Finding balance and intentionality in our hyper-connected modern environment.', 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&q=80&w=800', 'published', 0),
(4, 'The Future of Remote Work Culture', 'future-of-remote-work', '<p>Remote work is no longer a temporary solution; it is the new standard. Organizations are now focusing on how to build a strong culture across distributed teams.</p>', 'Strategies for maintaining connection and productivity in the age of distributed teams.', 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&q=80&w=800', 'published', 0);


-- Insert Default Admin (Email: info@ftluma-light.com, Password: Ftluma@123@1)
DELETE FROM admins WHERE username = 'admin' OR email = 'info@ftluma-light.com';
INSERT INTO admins (username, password, email, full_name) VALUES
('admin', '$2y$10$wtwdMBImY7Eb1OevWCHUbOWFHea.QSi.7OtLWcRDnODYekgvpxOSq', 'info@ftluma-light.com', 'System Administrator');


