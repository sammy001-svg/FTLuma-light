<?php
require_once '../functions.php';
redirect_if_not_logged_in();

// Ensure the table exists (in case subscribe.php was never hit yet)
if ($pdo) {
    $pdo->exec("CREATE TABLE IF NOT EXISTS subscribers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL UNIQUE,
        status ENUM('active', 'unsubscribed') DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
}

$msg = '';
if (isset($_GET['delete'])) {
    if (delete_subscriber($_GET['delete'])) {
        header('Location: subscribers.php?msg=Subscriber removed');
    } else {
        header('Location: subscribers.php?err=Failed to remove subscriber');
    }
    exit;
}

if (isset($_GET['msg'])) $msg = $_GET['msg'];
$err = $_GET['err'] ?? '';

$subscribers = get_subscribers();
$page_title = 'Newsletter Subscribers';
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
        .admin-sidebar { width: var(--sidebar-width); height: 100vh; background: var(--primary-900); color: white; position: fixed; padding: 2rem; overflow-y: auto; }
        .admin-main { margin-left: var(--sidebar-width); flex: 1; padding: 3rem; }
        .sidebar-nav { margin-top: 3rem; list-style: none; }
        .sidebar-nav li { margin-bottom: 1rem; }
        .sidebar-nav a { color: rgba(255,255,255,0.7); text-decoration: none; display: block; padding: 0.75rem 1rem; border-radius: 0.75rem; }
        .sidebar-nav a:hover, .sidebar-nav a.active { background: rgba(255,255,255,0.1); color: white; }
        .admin-table { width: 100%; background: white; border-radius: 1.5rem; border: 1px solid var(--border); border-collapse: collapse; overflow: hidden; margin-top: 2rem; }
        .admin-table th, .admin-table td { padding: 1.25rem 1.5rem; text-align: left; border-bottom: 1px solid var(--border); }
        .admin-table th { background: #f1f5f9; font-weight: 700; color: var(--primary-900); }
        .admin-table tr:last-child td { border-bottom: none; }
        .admin-table tr:hover td { background: #f8fafc; }
        .badge-active { background: #dcfce7; color: #15803d; padding: 0.25rem 0.75rem; border-radius: 2rem; font-size: 0.75rem; font-weight: 700; }
        .alert { padding: 1rem 1.5rem; border-radius: 0.75rem; margin-bottom: 2rem; font-weight: 600; }
        .alert-success { background: #dcfce7; color: #15803d; }
        .alert-error { background: #fee2e2; color: #b91c1c; }
        .stat-card { background: white; border: 1px solid var(--border); border-radius: 1.5rem; padding: 2rem; display: inline-block; min-width: 200px; margin-bottom: 2rem; }
        .stat-number { font-size: 3rem; font-weight: 900; color: var(--primary-800); line-height: 1; }
        .stat-label { color: var(--text-muted); margin-top: 0.5rem; font-size: 0.875rem; }
        .btn-danger { background: #fee2e2; color: #b91c1c; border: none; padding: 0.4rem 0.9rem; border-radius: 0.5rem; cursor: pointer; font-size: 0.8rem; font-weight: 600; text-decoration: none; }
        .btn-danger:hover { background: #fecaca; }
        .export-btn { background: var(--primary-800); color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 0.75rem; cursor: pointer; font-weight: 700; text-decoration: none; font-size: 0.875rem; display: inline-block; }
        .export-btn:hover { background: var(--primary-900); }
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
            <li><a href="reservations.php">Reservations</a></li>
            <li><a href="messages.php">Messages</a></li>
            <li><a href="subscribers.php" class="active">Subscribers</a></li>
            <li><a href="../index.php" target="_blank">View Site ↗</a></li>
            <li style="margin-top: 5rem;"><a href="logout.php" style="color: #f87171;">Logout</a></li>
        </ul>
    </aside>

    <main class="admin-main">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;">
            <div>
                <a href="index.php" style="text-decoration:none;color:var(--text-muted);display:inline-block;margin-bottom:0.5rem;">← Dashboard</a>
                <h1><?php echo $page_title; ?></h1>
            </div>
            <?php if (!empty($subscribers)): ?>
                <a href="export_subscribers.php" class="export-btn">Export CSV</a>
            <?php endif; ?>
        </div>

        <?php if ($msg): ?>
            <div class="alert alert-success"><?php echo e($msg); ?></div>
        <?php endif; ?>
        <?php if ($err): ?>
            <div class="alert alert-error"><?php echo e($err); ?></div>
        <?php endif; ?>

        <div class="stat-card">
            <div class="stat-number"><?php echo count($subscribers); ?></div>
            <div class="stat-label">Total Subscribers</div>
        </div>

        <?php if (!empty($subscribers)): ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Email Address</th>
                        <th>Status</th>
                        <th>Subscribed On</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($subscribers as $i => $sub): ?>
                        <tr>
                            <td><?php echo $i + 1; ?></td>
                            <td><?php echo e($sub['email']); ?></td>
                            <td><span class="badge-active"><?php echo ucfirst($sub['status']); ?></span></td>
                            <td><?php echo format_date($sub['created_at']); ?></td>
                            <td>
                                <a href="subscribers.php?delete=<?php echo $sub['id']; ?>"
                                   class="btn-danger"
                                   onclick="return confirm('Remove this subscriber?')">Remove</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div style="background:white;border:1px solid var(--border);border-radius:1.5rem;padding:4rem;text-align:center;color:var(--text-muted);">
                <p style="font-size:1.25rem;">No subscribers yet.</p>
                <p style="font-size:0.875rem;margin-top:0.5rem;">Subscribers will appear here after they sign up from the homepage.</p>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>
