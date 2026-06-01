<?php
require_once '../functions.php';
redirect_if_not_logged_in();

$messages = get_all_messages();
$page_title = 'Contact Messages';

if (isset($_GET['delete'])) {
    delete_message($_GET['delete']);
    header('Location: messages.php?msg=Message deleted');
    exit;
}

if (isset($_GET['read'])) {
    mark_message_read($_GET['read']);
    header('Location: messages.php');
    exit;
}
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
        .sidebar-nav a { color: rgba(255,255,255,0.7); text-decoration: none; display: block; padding: 0.75rem 1rem; border-radius: 0.75rem; }
        .sidebar-nav a:hover, .sidebar-nav a.active { background: rgba(255,255,255,0.1); color: white; }
        .admin-table { width: 100%; background: white; border-radius: 1.5rem; border: 1px solid var(--border); border-collapse: collapse; overflow: hidden; margin-top: 2rem; }
        .admin-table th, .admin-table td { padding: 1.25rem 1.5rem; text-align: left; border-bottom: 1px solid var(--border); }
        .admin-table th { background: #f1f5f9; }
        .status-unread { font-weight: 800; color: var(--primary-700); }
        .status-read { color: var(--text-muted); }
        .message-preview { max-width: 400px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
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
            <li><a href="events.php">Upcoming Events</a></li>
            <li><a href="messages.php" class="active">Messages</a></li>
            <li><a href="reservations.php">Reservations</a></li>
            <li><a href="../index.php" target="_blank">View Site ↗</a></li>
            <li style="margin-top: 5rem;"><a href="logout.php" style="color: #f87171;">Logout</a></li>
        </ul>
    </aside>

    <main class="admin-main">
        <h1>Contact Messages</h1>

        <?php if (isset($_GET['msg'])): ?>
            <div style="padding: 1rem; background: #dcfce7; color: #15803d; border-radius: 0.75rem; margin-top: 2rem; font-weight: 600;">
                <?php echo e($_GET['msg']); ?>
            </div>
        <?php endif; ?>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>From</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $msg): ?>
                <tr class="status-<?php echo $msg['status']; ?>">
                    <td><?php echo date('M d, H:i', strtotime($msg['created_at'])); ?></td>
                    <td>
                        <strong><?php echo e($msg['name']); ?></strong><br>
                        <small><?php echo e($msg['email']); ?></small>
                    </td>
                    <td><?php echo e($msg['subject']); ?></td>
                    <td><div class="message-preview"><?php echo e($msg['message']); ?></div></td>
                    <td>
                        <?php if ($msg['status'] == 'unread'): ?>
                            <a href="messages.php?read=<?php echo $msg['id']; ?>" style="color: var(--primary-600); font-weight: 700; margin-right: 1rem;">Read</a>
                        <?php endif; ?>
                        <a href="messages.php?delete=<?php echo $msg['id']; ?>" style="color: #ef4444; font-weight: 700;" onclick="return confirm('Delete this message?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($messages)): ?>
                <tr>
                    <td colspan="5" style="text-align: center; padding: 5rem; color: var(--text-muted);">No messages found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
