-- Blog Management System Database Schema

CREATE DATABASE IF NOT EXISTS blog_sphere_db;
USE blog_sphere_db;

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Categories Table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Posts Table
CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    category_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    image VARCHAR(255),
    status ENUM('published', 'draft') DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

-- Initial Data
INSERT IGNORE INTO users (username, email, password, role) VALUES 
('admin', 'admin@blogsphere.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'), -- Password: password
('raj', 'raj@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user');

INSERT IGNORE INTO categories (name) VALUES 
('Technology'), ('Lifestyle'), ('Travel'), ('Education'), ('Food'), ('Health');

-- Sample Posts
INSERT IGNORE INTO posts (user_id, category_id, title, content, image, status) VALUES 
(1, 1, 'The Future of AI in 2026', 'Artificial Intelligence is evolving at an unprecedented pace. From generative models to autonomous systems, the landscape of technology is shifting...', 'https://images.unsplash.com/photo-1677442136019-21780ecad995?w=800&auto=format&fit=crop', 'published'),
(2, 3, 'Top 5 Hidden Gems in Europe', 'Traveling back to Europe always feels like a dream. This year, we explored the hidden villages of Portugal and the pristine lakes of Montenegro...', 'https://images.unsplash.com/photo-1467269204594-9661b134dd2b?w=800&auto=format&fit=crop', 'published'),
(1, 4, 'Mastering Web Programming', 'Web development is more than just writing code. It is about creating experiences. In this post, we dive deep into PHP, MySQL, and modern CSS...', 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=800&auto=format&fit=crop', 'published'),
(1, 1, 'Understanding MySQL Performance', 'When building large scale applications, database performance becomes critical. Learn how indexing and query optimization can speed up your app...', 'https://images.unsplash.com/photo-1544383835-bda2bc66a55d?w=800&auto=format&fit=crop', 'published'),
(2, 2, 'The Art of Slow Living', 'In a world that never stops moving, finding peace in the small things is a superpower. Here are some tips on how to embrace a slower lifestyle...', 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?w=800&auto=format&fit=crop', 'published');
