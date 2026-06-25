<?php
require_once '../functions.php';
redirect_if_not_logged_in();

// ── Stats ─────────────────────────────────────────────────────────────────────
$total_posts      = count(get_all_posts_admin());
$published_posts  = get_published_posts_count();
$total_views      = get_total_views();
$total_events     = count(get_all_events());
$total_reservations = count(get_all_reservations());
$total_subscribers  = get_subscribers_count();
$unread_messages    = get_unread_messages_count();
$pending_comments   = get_pending_comments_count();

$recent_posts    = array_slice(get_all_posts_admin(), 0, 6);
$recent_messages = get_recent_messages(4);

$page_title = 'Admin Dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> | FTLuma Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        :root { --sidebar-width: 260px; }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            display: flex;
            min-height: 100vh;
            background: #f1f5f9;
            margin: 0;
        }

        /* ── Sidebar ── */
        .admin-sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--primary-900);
            color: white;
            position: fixed;
            top: 0; left: 0;
            display: flex;
            flex-direction: column;
            padding: 2rem 1.5rem;
            z-index: 100;
            overflow-y: auto;
        }
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-brand .logo-icon {
            width: 40px; height: 40px;
            background: var(--primary-500);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 900; font-size: 0.9rem;
        }
        .sidebar-brand span { font-size: 1.1rem; font-weight: 800; letter-spacing: 0.05em; }

        .sidebar-section-label {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: rgba(255,255,255,0.35);
            font-weight: 700;
            margin: 1.75rem 0 0.5rem 0.75rem;
        }
        .sidebar-nav { list-style: none; margin: 0; padding: 0; }
        .sidebar-nav li { margin-bottom: 0.25rem; }
        .sidebar-nav a {
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.7rem 0.75rem;
            border-radius: 0.625rem;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s;
            position: relative;
        }
        .sidebar-nav a:hover, .sidebar-nav a.active {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        .sidebar-nav a.active { font-weight: 700; }
        .sidebar-badge {
            margin-left: auto;
            background: #ef4444;
            color: white;
            font-size: 0.65rem;
            font-weight: 800;
            padding: 0.1rem 0.45rem;
            border-radius: 2rem;
            min-width: 18px;
            text-align: center;
        }
        .sidebar-bottom { margin-top: auto; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.1); }

        /* ── Main ── */
        .admin-main {
            margin-left: var(--sidebar-width);
            flex: 1;
            padding: 2.5rem 3rem;
            min-height: 100vh;
        }

        /* ── Top Bar ── */
        .dash-topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
        }
        .dash-topbar h1 { font-size: 1.75rem; font-weight: 800; color: var(--primary-900); margin: 0; }
        .dash-topbar p  { margin: 0; color: var(--text-muted); font-size: 0.9rem; }
        .quick-actions { display: flex; gap: 0.75rem; }
        .btn-quick {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            border-radius: 0.625rem;
            font-weight: 700;
            font-size: 0.875rem;
            text-decoration: none;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }
        .btn-quick-primary { background: var(--primary-700); color: white; }
        .btn-quick-primary:hover { background: var(--primary-800); }
        .btn-quick-outline { background: white; color: var(--primary-800); border: 1px solid var(--border); }
        .btn-quick-outline:hover { border-color: var(--primary-300); background: var(--primary-50); }

        /* ── Alert Banner ── */
        .alert-banner {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: #fef3c7;
            border: 1px solid #fcd34d;
            border-radius: 0.875rem;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            font-size: 0.9rem;
        }
        .alert-banner a { font-weight: 700; color: #92400e; }

        /* ── Stat Cards ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.25rem;
            margin-bottom: 2.5rem;
        }
        .stat-card {
            background: white;
            border-radius: 1.25rem;
            border: 1px solid var(--border);
            padding: 1.75rem;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            transition: box-shadow 0.2s;
        }
        .stat-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,0.07); }
        .stat-icon {
            width: 52px; height: 52px;
            border-radius: 0.875rem;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }
        .stat-icon-green  { background: #dcfce7; }
        .stat-icon-blue   { background: #dbeafe; }
        .stat-icon-amber  { background: #fef3c7; }
        .stat-icon-purple { background: #f3e8ff; }
        .stat-icon-rose   { background: #ffe4e6; }
        .stat-icon-teal   { background: #ccfbf1; }

        .stat-value { font-size: 2rem; font-weight: 900; color: var(--primary-900); line-height: 1; }
        .stat-label { font-size: 0.8rem; color: var(--text-muted); font-weight: 600; margin-top: 0.25rem; }
        .stat-sub   { font-size: 0.75rem; color: var(--primary-600); font-weight: 600; margin-top: 0.5rem; }

        /* ── Two-column layout ── */
        .dash-cols { display: grid; grid-template-columns: 1.5fr 1fr; gap: 1.5rem; }

        /* ── Panel ── */
        .dash-panel {
            background: white;
            border-radius: 1.25rem;
            border: 1px solid var(--border);
            overflow: hidden;
        }
        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border);
            background: #f8fafc;
        }
        .panel-header h3 { margin: 0; font-size: 0.95rem; font-weight: 800; color: var(--primary-900); }
        .panel-header a  { font-size: 0.8rem; font-weight: 700; color: var(--primary-600); text-decoration: none; }
        .panel-header a:hover { color: var(--primary-800); }

        /* ── Posts Table ── */
        .dash-table { width: 100%; border-collapse: collapse; }
        .dash-table th {
            padding: 0.75rem 1.25rem;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border);
            background: #f8fafc;
        }
        .dash-table td {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.875rem;
            vertical-align: middle;
        }
        .dash-table tr:last-child td { border-bottom: none; }
        .dash-table tr:hover td { background: #f8fafc; }

        .post-title-cell { font-weight: 700; color: var(--primary-900); max-width: 240px; }
        .post-title-cell small { display: block; font-weight: 500; color: var(--text-muted); font-size: 0.75rem; margin-top: 0.1rem; }

        .status-pill { padding: 0.2rem 0.6rem; border-radius: 2rem; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; }
        .status-published { background: #dcfce7; color: #15803d; }
        .status-draft     { background: #fef9c3; color: #a16207; }

        .views-badge { font-weight: 700; color: var(--primary-700); }

        .action-link { font-weight: 700; font-size: 0.8rem; text-decoration: none; color: var(--primary-600); }
        .action-link:hover { color: var(--primary-900); }

        /* ── Message Cards ── */
        .message-list { padding: 0; }
        .message-item {
            padding: 1.1rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            gap: 1rem;
            align-items: flex-start;
        }
        .message-item:last-child { border-bottom: none; }
        .msg-avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: var(--primary-100);
            color: var(--primary-700);
            font-weight: 800;
            font-size: 0.875rem;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .msg-avatar.unread { background: var(--primary-700); color: white; }
        .msg-body { flex: 1; min-width: 0; }
        .msg-name  { font-weight: 700; font-size: 0.875rem; color: var(--primary-900); }
        .msg-subject { font-size: 0.8rem; color: var(--text-muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .msg-time  { font-size: 0.7rem; color: var(--text-muted); white-space: nowrap; margin-top: 0.1rem; }
        .msg-unread-dot { width: 8px; height: 8px; background: var(--primary-500); border-radius: 50%; margin-top: 0.4rem; flex-shrink: 0; }

        .empty-state { padding: 3rem; text-align: center; color: var(--text-muted); font-size: 0.875rem; }
    </style>
</head>
<body>

<aside class="admin-sidebar">
    <div class="sidebar-brand">
        <div class="logo-icon">FT</div>
        <span>FTLuma Admin</span>
    </div>

    <p class="sidebar-section-label">Content</p>
    <ul class="sidebar-nav">
        <li><a href="index.php" class="active">📊 Dashboard</a></li>
        <li><a href="posts.php">📝 Posts</a></li>
        <li><a href="categories.php">🗂 Categories</a></li>
        <li><a href="authors.php">👤 Authors</a></li>
    </ul>

    <p class="sidebar-section-label">Community</p>
    <ul class="sidebar-nav">
        <li>
            <a href="messages.php">
                💬 Messages
                <?php if ($unread_messages > 0): ?>
                    <span class="sidebar-badge"><?php echo $unread_messages; ?></span>
                <?php endif; ?>
            </a>
        </li>
        <li>
            <a href="comments.php">
                🗨 Comments
                <?php if ($pending_comments > 0): ?>
                    <span class="sidebar-badge"><?php echo $pending_comments; ?></span>
                <?php endif; ?>
            </a>
        </li>
        <li><a href="subscribers.php">📧 Subscribers</a></li>
    </ul>

    <p class="sidebar-section-label">Events</p>
    <ul class="sidebar-nav">
        <li><a href="events.php">🗓 Events</a></li>
        <li><a href="reservations.php">🎟 Reservations</a></li>
    </ul>

    <div class="sidebar-bottom">
        <ul class="sidebar-nav">
            <li><a href="../index.php" target="_blank">🌐 View Site ↗</a></li>
            <li><a href="logout.php" style="color:#f87171;">🚪 Logout</a></li>
        </ul>
    </div>
</aside>

<main class="admin-main">

    <!-- Top Bar -->
    <div class="dash-topbar">
        <div>
            <h1>Dashboard</h1>
            <p>Welcome back, <strong><?php echo e($_SESSION['admin_username']); ?></strong> &nbsp;·&nbsp; <?php echo date('l, M j Y'); ?></p>
        </div>
        <div class="quick-actions">
            <a href="post_add.php"  class="btn-quick btn-quick-primary">+ New Post</a>
            <a href="event_add.php" class="btn-quick btn-quick-outline">+ New Event</a>
        </div>
    </div>

    <!-- Alert: pending comments -->
    <?php if ($pending_comments > 0): ?>
    <div class="alert-banner">
        <span style="font-size:1.25rem;">🗨</span>
        <span>
            <strong><?php echo $pending_comments; ?> comment<?php echo $pending_comments !== 1 ? 's' : ''; ?></strong>
            waiting for review.
            <a href="comments.php">Moderate now →</a>
        </span>
    </div>
    <?php endif; ?>

    <!-- Alert: unread messages -->
    <?php if ($unread_messages > 0): ?>
    <div class="alert-banner" style="background:#eff6ff;border-color:#bfdbfe;">
        <span style="font-size:1.25rem;">✉️</span>
        <span>
            <strong><?php echo $unread_messages; ?> unread message<?php echo $unread_messages !== 1 ? 's' : ''; ?></strong>
            in your inbox.
            <a href="messages.php" style="color:#1d4ed8;">Read now →</a>
        </span>
    </div>
    <?php endif; ?>

    <!-- Stat Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon stat-icon-green">📝</div>
            <div>
                <div class="stat-value"><?php echo $total_posts; ?></div>
                <div class="stat-label">Total Posts</div>
                <div class="stat-sub"><?php echo $published_posts; ?> published</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-icon-blue">👁</div>
            <div>
                <div class="stat-value"><?php echo number_format($total_views); ?></div>
                <div class="stat-label">Total Article Views</div>
                <div class="stat-sub">All time</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-icon-teal">📧</div>
            <div>
                <div class="stat-value"><?php echo $total_subscribers; ?></div>
                <div class="stat-label">Subscribers</div>
                <div class="stat-sub">Newsletter list</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-icon-purple">🗓</div>
            <div>
                <div class="stat-value"><?php echo $total_events; ?></div>
                <div class="stat-label">Events</div>
                <div class="stat-sub"><?php echo $total_reservations; ?> reservations</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-icon-rose">💬</div>
            <div>
                <div class="stat-value"><?php echo $unread_messages; ?></div>
                <div class="stat-label">Unread Messages</div>
                <div class="stat-sub"><a href="messages.php" style="color:var(--primary-600);font-weight:700;text-decoration:none;">View inbox →</a></div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-icon-amber">🗨</div>
            <div>
                <div class="stat-value"><?php echo $pending_comments; ?></div>
                <div class="stat-label">Pending Comments</div>
                <div class="stat-sub"><a href="comments.php" style="color:var(--primary-600);font-weight:700;text-decoration:none;">Moderate →</a></div>
            </div>
        </div>
    </div>

    <!-- Two-column layout -->
    <div class="dash-cols">

        <!-- Recent Posts -->
        <div class="dash-panel">
            <div class="panel-header">
                <h3>Recent Posts</h3>
                <a href="posts.php">View all →</a>
            </div>
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Views</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_posts as $post): ?>
                    <tr>
                        <td>
                            <div class="post-title-cell">
                                <?php echo e(mb_strimwidth($post['title'], 0, 45, '…')); ?>
                                <small><?php echo e($post['category_name']); ?> &middot; <?php echo format_date($post['created_at']); ?></small>
                            </div>
                        </td>
                        <td><span class="status-pill status-<?php echo $post['status']; ?>"><?php echo $post['status']; ?></span></td>
                        <td><span class="views-badge"><?php echo number_format($post['views'] ?? 0); ?></span></td>
                        <td><a href="post_edit.php?id=<?php echo $post['id']; ?>" class="action-link">Edit</a></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($recent_posts)): ?>
                    <tr><td colspan="4" class="empty-state">No posts yet. <a href="post_add.php">Create one →</a></td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Recent Messages -->
        <div class="dash-panel">
            <div class="panel-header">
                <h3>Recent Messages</h3>
                <a href="messages.php">View all →</a>
            </div>
            <div class="message-list">
                <?php foreach ($recent_messages as $m): ?>
                <div class="message-item">
                    <div class="msg-avatar <?php echo $m['status'] === 'unread' ? 'unread' : ''; ?>">
                        <?php echo strtoupper(substr($m['name'], 0, 1)); ?>
                    </div>
                    <div class="msg-body">
                        <div class="msg-name"><?php echo e($m['name']); ?></div>
                        <div class="msg-subject"><?php echo e(mb_strimwidth($m['subject'], 0, 40, '…')); ?></div>
                        <div class="msg-time"><?php echo date('M j, g:i A', strtotime($m['created_at'])); ?></div>
                    </div>
                    <?php if ($m['status'] === 'unread'): ?>
                        <div class="msg-unread-dot"></div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
                <?php if (empty($recent_messages)): ?>
                    <div class="empty-state">No messages yet.</div>
                <?php endif; ?>
            </div>
        </div>

    </div><!-- /.dash-cols -->

</main>
</body>
</html>
