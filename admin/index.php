<?php
require_once '../functions.php';
redirect_if_not_logged_in();

$posts = get_all_posts_admin();
$categories = get_categories();
$events = get_all_events();
$reservations = get_all_reservations();
$authors = get_authors();

$page_title = 'Admin Dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> | FTLuma-Light Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        :root {
            --sidebar-width: 280px;
        }
        body {
            display: flex;
            background: #f8fafc;
        }
        .admin-sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--primary-900);
            color: white;
            position: fixed;
            padding: 2rem;
        }
        .admin-main {
            margin-left: var(--sidebar-width);
            flex: 1;
            padding: 3rem;
        }
        .sidebar-nav {
            margin-top: 3rem;
            list-style: none;
        }
        .sidebar-nav li {
            margin-bottom: 1rem;
        }
        .sidebar-nav a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            display: block;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }
        .sidebar-nav a:hover, .sidebar-nav a.active {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        .stat-card {
            background: white;
            padding: 2rem;
            border-radius: 1.5rem;
            border: 1px solid var(--border);
            text-align: center;
        }
        .admin-table {
            width: 100%;
            background: white;
            border-radius: 1.5rem;
            border: 1px solid var(--border);
            border-collapse: collapse;
            overflow: hidden;
            margin-top: 2rem;
        }
        .admin-table th, .admin-table td {
            padding: 1.25rem 1.5rem;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }
        .admin-table th {
            background: #f1f5f9;
            font-weight: 700;
        }
        .status-pill {
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }
        .status-published { background: #dcfce7; color: #15803d; }
        .status-draft { background: #fef9c3; color: #a16207; }
    </style>
</head>
<body>
    <aside class="admin-sidebar">
        <div class="logo">
            <div class="logo-icon">FT</div>
            <span>Admin</span>
        </div>
        <ul class="sidebar-nav">
            <li><a href="index.php" class="active">Dashboard</a></li>
            <li><a href="posts.php">Manage Posts</a></li>
            <li><a href="categories.php">Categories</a></li>
            <li><a href="authors.php">Authors</a></li>
            <li><a href="events.php">Upcoming Events</a></li>
            <li><a href="messages.php">Messages</a></li>
            <li><a href="reservations.php">Reservations</a></li>

            <li><a href="../index.php" target="_blank">View Site ↗</a></li>
            <li style="margin-top: 5rem;"><a href="logout.php" style="color: #f87171;">Logout</a></li>
        </ul>
    </aside>

    <main class="admin-main">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem;">
            <h1>Dashboard Overview</h1>
            <p>Welcome back, <strong><?php echo e($_SESSION['admin_username']); ?></strong></p>
        </div>

        <div class="grid" style="grid-template-columns: repeat(4, 1fr); gap: 2rem;">
            <div class="stat-card">
                <h4 style="color: var(--text-muted); margin-bottom: 0.5rem;">Total Posts</h4>
                <div style="font-size: 2.5rem; font-weight: 800; color: var(--primary-700);"><?php echo count($posts); ?></div>
            </div>
            <div class="stat-card">
                <h4 style="color: var(--text-muted); margin-bottom: 0.5rem;">Events</h4>
                <div style="font-size: 2.5rem; font-weight: 800; color: var(--amber-600);"><?php echo count($events); ?></div>
            </div>
            <div class="stat-card">
                <h4 style="color: var(--text-muted); margin-bottom: 0.5rem;">Reservations</h4>
                <div style="font-size: 2.5rem; font-weight: 800; color: var(--primary-600);"><?php echo count($reservations); ?></div>
            </div>
            <div class="stat-card">
                <h4 style="color: var(--text-muted); margin-bottom: 0.5rem;">Authors</h4>
                <div style="font-size: 2.5rem; font-weight: 800; color: var(--primary-700);"><?php echo count($authors); ?></div>
            </div>
        </div>

        <h2 style="margin-top: 4rem;">Recent Posts</h2>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (array_slice($posts, 0, 5) as $post): ?>
                <tr>
                    <td style="font-weight: 600;"><?php echo e($post['title']); ?></td>
                    <td><?php echo e($post['category_name']); ?></td>
                    <td><?php echo format_date($post['created_at']); ?></td>
                    <td>
                        <span class="status-pill status-<?php echo $post['status']; ?>">
                            <?php echo $post['status']; ?>
                        </span>
                    </td>
                    <td>
                        <a href="post_edit.php?id=<?php echo $post['id']; ?>" style="color: var(--primary-700); font-weight: 700;">Edit</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
