<?php
require_once 'config.php';

/**
 * Fetch all categories
 */
function get_categories($limit = null) {
    global $pdo;
    if (!$pdo) return [];
    
    $sql = "SELECT * FROM categories ORDER BY name ASC";
    if ($limit) $sql .= " LIMIT " . (int)$limit;
    
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

/**
 * Fetch latest posts with optional category filter
 */
function get_posts($limit = 10, $category_slug = null) {
    global $pdo;
    if (!$pdo) return [];
    
    $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug, a.name as author_name, a.image as author_image 
            FROM posts p 
            LEFT JOIN categories c ON p.category_id = c.id 
            LEFT JOIN authors a ON p.author_id = a.id 
            WHERE p.status = 'published'";
            
    if ($category_slug) {
        $sql .= " AND c.slug = :slug";
    }
    
    $sql .= " ORDER BY p.created_at DESC LIMIT :limit";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    if ($category_slug) {
        $stmt->bindValue(':slug', $category_slug, PDO::PARAM_STR);
    }
    
    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * Fetch latest posts (Legacy wrapper)
 */
function get_latest_posts($limit = 6) {
    return get_posts($limit);
}

/**
 * Fetch featured posts
 */
function get_featured_posts($limit = 3) {
    global $pdo;
    if (!$pdo) return [];
    
    $stmt = $pdo->prepare("
        SELECT p.*, c.name as category_name, c.slug as category_slug, a.name as author_name 
        FROM posts p 
        LEFT JOIN categories c ON p.category_id = c.id 
        LEFT JOIN authors a ON p.author_id = a.id 
        WHERE p.status = 'published' AND p.featured = 1 
        ORDER BY p.created_at DESC 
        LIMIT :limit
    ");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * Fetch a single post by slug
 */
function get_post_by_slug($slug) {
    global $pdo;
    if (!$pdo) return null;
    
    $stmt = $pdo->prepare("
        SELECT p.*, c.name as category_name, c.slug as category_slug, a.name as author_name, a.bio as author_bio, a.image as author_image 
        FROM posts p 
        LEFT JOIN categories c ON p.category_id = c.id 
        LEFT JOIN authors a ON p.author_id = a.id 
        WHERE p.slug = :slug AND p.status = 'published'
    ");
    $stmt->execute(['slug' => $slug]);
    return $stmt->fetch();
}

/**
 * Format date
 */
function format_date($date) {
    return date('M d, Y', strtotime($date));
}

/**
 * Sanitize output
 */
function e($text) {
    return htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8');
}


/**
 * Admin Functions
 */

function admin_login($username_or_email, $password) {
    global $pdo;
    if (!$pdo) return false;
    
    // Check both username and email
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ? OR email = ?");
    $stmt->execute([$username_or_email, $username_or_email]);
    $admin = $stmt->fetch();


    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        return true;
    }
    return false;
}

function is_admin_logged_in() {
    return isset($_SESSION['admin_id']);
}

function redirect_if_not_logged_in() {
    if (!is_admin_logged_in()) {
        header('Location: ' . BASE_URL . '/admin/login.php');
        exit;
    }
}

// Category Management
function create_category($name, $slug, $description = '') {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO categories (name, slug, description) VALUES (?, ?, ?)");
    return $stmt->execute([$name, $slug, $description]);
}

function update_category($id, $name, $slug, $description = '') {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE categories SET name = ?, slug = ?, description = ? WHERE id = ?");
    return $stmt->execute([$name, $slug, $description, $id]);
}

function delete_category($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    return $stmt->execute([$id]);
}

// Post Management
function create_post($data) {
    global $pdo;
    $sql = "INSERT INTO posts (category_id, author_id, title, slug, content, excerpt, featured_image, status, featured) 
            VALUES (:category_id, :author_id, :title, :slug, :content, :excerpt, :featured_image, :status, :featured)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($data);
}

function update_post($id, $data) {
    global $pdo;
    $data['id'] = $id;
    $sql = "UPDATE posts SET category_id = :category_id, author_id = :author_id, title = :title, slug = :slug, 
            content = :content, excerpt = :excerpt, featured_image = :featured_image, 
            status = :status, featured = :featured WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($data);
}

function delete_post($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
    return $stmt->execute([$id]);
}

/**
 * Search posts by title or excerpt
 */
function search_posts($query, $limit = 20) {
    global $pdo;
    if (!$pdo) return [];
    
    $stmt = $pdo->prepare("
        SELECT p.*, c.name as category_name, c.slug as category_slug 
        FROM posts p 
        LEFT JOIN categories c ON p.category_id = c.id 
        WHERE p.status = 'published' 
        AND (p.title LIKE :query OR p.excerpt LIKE :query OR p.content LIKE :query)
        ORDER BY p.created_at DESC 
        LIMIT :limit
    ");
    $stmt->bindValue(':query', '%' . $query . '%', PDO::PARAM_STR);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function get_all_posts_admin() {
    global $pdo;
    if (!$pdo) return [];
    
    $stmt = $pdo->query("SELECT p.*, c.name as category_name, a.name as author_name 
                         FROM posts p 
                         LEFT JOIN categories c ON p.category_id = c.id 
                         LEFT JOIN authors a ON p.author_id = a.id 
                         ORDER BY p.created_at DESC");
    return $stmt->fetchAll();
}

/**
 * Author Management
 */
function get_authors() {
    global $pdo;
    if (!$pdo) return [];
    $stmt = $pdo->query("SELECT * FROM authors ORDER BY name ASC");
    return $stmt->fetchAll();
}

function get_author_by_id($id) {
    global $pdo;
    if (!$pdo) return null;
    $stmt = $pdo->prepare("SELECT * FROM authors WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function create_author($data) {
    global $pdo;
    $sql = "INSERT INTO authors (name, bio, image) VALUES (:name, :bio, :image)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($data);
}

function update_author($id, $data) {
    global $pdo;
    $data['id'] = $id;
    $sql = "UPDATE authors SET name = :name, bio = :bio, image = :image WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($data);
}

function delete_author($id) {
    global $pdo;
    // Check if author has posts
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM posts WHERE author_id = ?");
    $stmt->execute([$id]);
    if ($stmt->fetchColumn() > 0) {
        return false; // Cannot delete author with posts
    }
    $stmt = $pdo->prepare("DELETE FROM authors WHERE id = ?");
    return $stmt->execute([$id]);
}

function get_post_by_id_admin($id) {
    global $pdo;
    if (!$pdo) return null;
    
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

/**
 * Handle Image Upload
 */
function upload_image($file) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $upload_dir = __DIR__ . '/uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid('img_', true) . '.' . $extension;
    $target_file = $upload_dir . $filename;

    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        return 'uploads/' . $filename;
    }
    
    return null;
}

/**
 * Event Management
 */
function get_all_events() {
    global $pdo;
    if (!$pdo) return [];
    $stmt = $pdo->query("SELECT * FROM events ORDER BY event_date ASC");
    return $stmt->fetchAll();
}

function get_event_by_id($id) {
    global $pdo;
    if (!$pdo) return null;
    $stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function create_event($data) {
    global $pdo;
    $sql = "INSERT INTO events (title, event_date, event_time, location, category, description, image, status) 
            VALUES (:title, :event_date, :event_time, :location, :category, :description, :image, :status)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($data);
}

function update_event($id, $data) {
    global $pdo;
    $data['id'] = $id;
    $sql = "UPDATE events SET title = :title, event_date = :event_date, event_time = :event_time, 
            location = :location, category = :category, description = :description, 
            image = :image, status = :status WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($data);
}

function delete_event($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
    return $stmt->execute([$id]);
}

/**
 * Reservations
 */
function create_reservation($data) {
    global $pdo;
    $sql = "INSERT INTO reservations (event_id, full_name, email, phone, seats) 
            VALUES (:event_id, :full_name, :email, :phone, :seats)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($data);
}

function get_event_reservations($event_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM reservations WHERE event_id = ? ORDER BY created_at DESC");
    $stmt->execute([$event_id]);
    return $stmt->fetchAll();
}

function get_all_reservations() {
    global $pdo;
    $stmt = $pdo->query("SELECT r.*, e.title as event_title 
                         FROM reservations r 
                         JOIN events e ON r.event_id = e.id 
                         ORDER BY r.created_at DESC");
    return $stmt->fetchAll();
}

/**
 * Contact Messages
 */
function save_contact_message($data) {
    global $pdo;
    if (!$pdo) return false;
    
    $sql = "INSERT INTO messages (name, email, subject, message) VALUES (:name, :email, :subject, :message)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        'name' => $data['first_name'] . ' ' . $data['last_name'],
        'email' => $data['email'],
        'subject' => $data['subject'],
        'message' => $data['message']
    ]);
}

function get_all_messages() {
    global $pdo;
    if (!$pdo) return [];
    $stmt = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC");
    return $stmt->fetchAll();
}

function delete_message($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
    return $stmt->execute([$id]);
}

function mark_message_read($id) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE messages SET status = 'read' WHERE id = ?");
    return $stmt->execute([$id]);
}

