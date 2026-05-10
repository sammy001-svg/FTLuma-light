<?php
require_once '../functions.php';
redirect_if_not_logged_in();

$events = get_all_events();
$page_title = 'Manage Events';

$msg = $_GET['msg'] ?? '';
$err = $_GET['err'] ?? '';

if (isset($_GET['delete'])) {
    if (delete_event($_GET['delete'])) {
        header('Location: events.php?msg=Event deleted successfully');
    } else {
        header('Location: events.php?err=Failed to delete event. Please try again.');
    }
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
        .sidebar-nav a { color: rgba(255,255,255,0.7); text-decoration: none; display: block; padding: 0.75rem 1rem; border-radius: 0.75rem; }
        .sidebar-nav a:hover, .sidebar-nav a.active { background: rgba(255,255,255,0.1); color: white; }
        .admin-table { width: 100%; background: white; border-radius: 1.5rem; border: 1px solid var(--border); border-collapse: collapse; overflow: hidden; margin-top: 2rem; }
        .admin-table th, .admin-table td { padding: 1.25rem 1.5rem; text-align: left; border-bottom: 1px solid var(--border); }
        .admin-table th { background: #f1f5f9; }
        .status-pill { padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; }
        .status-upcoming { background: #dcfce7; color: #15803d; }
        .status-completed { background: #f1f5f9; color: #64748b; }
        .btn-action { text-decoration: none; font-weight: 700; margin-right: 1rem; }
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
            <li><a href="authors.php">Authors</a></li>
            <li><a href="events.php" class="active">Upcoming Events</a></li>
            <li><a href="reservations.php">Reservations</a></li>
            <li><a href="../index.php" target="_blank">View Site ↗</a></li>
            <li style="margin-top: 5rem;"><a href="logout.php" style="color: #f87171;">Logout</a></li>
        </ul>
    </aside>

    <main class="admin-main">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem;">
            <h1>Manage Events</h1>
            <a href="event_add.php" class="btn-primary">+ Schedule New Event</a>
        </div>

        <?php if ($msg): ?><div class="alert alert-success" style="padding: 1rem; border-radius: 0.75rem; margin-bottom: 2rem; background: #dcfce7; color: #15803d; font-weight: 600;"><?php echo e($msg); ?></div><?php endif; ?>
        <?php if ($err): ?><div class="alert alert-error" style="padding: 1rem; border-radius: 0.75rem; margin-bottom: 2rem; background: #fee2e2; color: #b91c1c; font-weight: 600;"><?php echo e($err); ?></div><?php endif; ?>


        <table class="admin-table">
            <thead>
                <tr>
                    <th>Event Title</th>
                    <th>Date & Time</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $event): ?>
                <tr>
                    <td style="font-weight: 600;"><?php echo e($event['title']); ?></td>
                    <td>
                        <?php echo date('M d, Y', strtotime($event['event_date'])); ?><br>
                        <small style="color: var(--text-muted);"><?php echo date('h:i A', strtotime($event['event_time'])); ?></small>
                    </td>
                    <td><?php echo e($event['location']); ?></td>
                    <td><span class="status-pill status-<?php echo $event['status']; ?>"><?php echo $event['status']; ?></span></td>
                    <td>
                        <a href="event_edit.php?id=<?php echo $event['id']; ?>" class="btn-action" style="color: var(--primary-700);">Edit</a>
                        <a href="event_reservations.php?id=<?php echo $event['id']; ?>" class="btn-action" style="color: var(--amber-600);">People</a>
                        <a href="events.php?delete=<?php echo $event['id']; ?>" class="btn-action" style="color: #ef4444;" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($events)): ?>
                <tr>
                    <td colspan="5" style="text-align: center; padding: 4rem; color: var(--text-muted);">No events scheduled yet.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
