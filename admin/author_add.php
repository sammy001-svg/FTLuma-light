<?php
require_once '../functions.php';
redirect_if_not_logged_in();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name' => $_POST['name'],
        'bio' => $_POST['bio'],
        'image' => upload_image($_FILES['image'])
    ];

    if (create_author($data)) {
        header('Location: authors.php?msg=Author added successfully');
        exit;
    }
}

$page_title = 'Add Author';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> | Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        :root { --sidebar-width: 280px; }
        body { display: flex; background: #f8fafc; }
        .admin-sidebar { width: var(--sidebar-width); height: 100vh; background: var(--primary-900); color: white; position: fixed; padding: 2rem; }
        .admin-main { margin-left: var(--sidebar-width); flex: 1; padding: 3rem; }
        .sidebar-nav { margin-top: 3rem; list-style: none; }
        .sidebar-nav li { margin-bottom: 1rem; }
        .sidebar-nav a { color: rgba(255,255,255,0.7); text-decoration: none; display: block; padding: 0.75rem 1rem; border-radius: 0.75rem; transition: all 0.3s ease; }
        .sidebar-nav a:hover, .sidebar-nav a.active { background: rgba(255,255,255,0.1); color: white; }
        .form-card { background: white; padding: 3rem; border-radius: 1.5rem; border: 1px solid var(--border); max-width: 800px; }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 700; color: var(--primary-900); }
        .form-control { width: 100%; padding: 0.75rem 1rem; border-radius: 0.75rem; border: 1px solid var(--border); font-family: inherit; }
        .btn { padding: 0.75rem 1.5rem; border-radius: 0.75rem; font-weight: 700; text-decoration: none; display: inline-block; cursor: pointer; border: none; }
        .btn-primary { background: var(--primary-600); color: white; }
    </style>
</head>
<body>
    <aside class="admin-sidebar">
        <div class="logo">
            <div class="logo-icon">FT</div>
            <span>Admin</span>
        </div>
        <ul class="sidebar-nav">
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="posts.php">Manage Posts</a></li>
            <li><a href="categories.php">Categories</a></li>
            <li><a href="authors.php" class="active">Authors</a></li>
            <li><a href="events.php">Upcoming Events</a></li>
            <li><a href="reservations.php">Reservations</a></li>
            <li><a href="subscribers.php">Subscribers</a></li>
            <li><a href="../index.php" target="_blank">View Site ↗</a></li>
            <li style="margin-top: 5rem;"><a href="logout.php" style="color: #f87171;">Logout</a></li>
        </ul>
    </aside>

    <main class="admin-main">
        <h1 style="margin-bottom: 2rem;">Add New Author</h1>

        <div class="form-card">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Biography</label>
                    <textarea name="bio" class="form-control" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <label>Profile Image</label>
                    <input type="file" name="image" class="form-control">
                </div>
                <div style="margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary">Create Author</button>
                    <a href="authors.php" style="margin-left: 1rem; color: var(--text-muted); font-weight: 600;">Cancel</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
