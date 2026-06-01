<?php
require_once '../functions.php';
redirect_if_not_logged_in();

if (!isset($_GET['id'])) {
    header('Location: events.php');
    exit;
}

$event = get_event_by_id($_GET['id']);
if (!$event) {
    die("Event not found.");
}

$reservations = get_event_reservations($_GET['id']);
$page_title = 'Reservations for ' . $event['title'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Reservations | Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        :root { --sidebar-width: 280px; }
        body { display: flex; background: #f8fafc; }
        .admin-sidebar { width: var(--sidebar-width); height: 100vh; background: var(--primary-900); color: white; position: fixed; padding: 2rem; }
        .admin-main { margin-left: var(--sidebar-width); flex: 1; padding: 3rem; }
        .sidebar-nav { margin-top: 3rem; list-style: none; }
        .sidebar-nav li { margin-bottom: 1rem; }
        .sidebar-nav a { color: rgba(255,255,255,0.7); text-decoration: none; display: block; padding: 0.75rem 1rem; border-radius: 0.75rem; }
        .sidebar-nav a:hover, .sidebar-nav a.active { background: rgba(255,255,255,0.1); color: white; }
        .admin-table { width: 100%; background: white; border-radius: 1.5rem; border: 1px solid var(--border); border-collapse: collapse; overflow: hidden; margin-top: 2rem; }
        .admin-table th, .admin-table td { padding: 1.25rem 1.5rem; text-align: left; border-bottom: 1px solid var(--border); }
        .admin-table th { background: #f1f5f9; }
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
            <li><a href="events.php" class="active">Upcoming Events</a></li>
            <li><a href="reservations.php">Reservations</a></li>
            <li><a href="../index.php" target="_blank">View Site ↗</a></li>
            <li style="margin-top: 5rem;"><a href="logout.php" style="color: #f87171;">Logout</a></li>
        </ul>
    </aside>

    <main class="admin-main">
        <div style="margin-bottom: 3rem;">
            <a href="events.php" style="text-decoration: none; color: var(--text-muted); margin-bottom: 1rem; display: inline-block;">← Back to Events</a>
            <h1>Reservations</h1>
            <p style="color: var(--text-muted);">Showing all people who reserved a spot for: <strong><?php echo e($event['title']); ?></strong></p>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Attendee Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Seats</th>
                    <th>Date Joined</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $res): ?>
                <tr>
                    <td style="font-weight: 600;"><?php echo e($res['full_name']); ?></td>
                    <td><?php echo e($res['email']); ?></td>
                    <td><?php echo e($res['phone']); ?></td>
                    <td><?php echo e($res['seats']); ?></td>
                    <td><?php echo date('M d, Y', strtotime($res['created_at'])); ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($reservations)): ?>
                <tr>
                    <td colspan="5" style="text-align: center; padding: 4rem; color: var(--text-muted);">No reservations yet for this event.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
