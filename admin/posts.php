<?php
require_once '../functions.php';
redirect_if_not_logged_in();

$posts = get_all_posts_admin();
$page_title = 'Manage Posts';

$msg = $_GET['msg'] ?? '';
$err = $_GET['err'] ?? '';

if (isset($_GET['delete'])) {
    if (delete_post($_GET['delete'])) {
        header('Location: posts.php?msg=Post deleted successfully');
    } else {
        header('Location: posts.php?err=Failed to delete post. Please try again.');
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
        .status-published { background: #dcfce7; color: #15803d; }
        .status-draft { background: #fef9c3; color: #a16207; }
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
            <li><a href="posts.php" class="active">Manage Posts</a></li>
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
            <h1>Manage Posts</h1>
            <a href="post_add.php" class="btn-primary">+ Create New Post</a>
        </div>
        
        <?php if ($msg): ?><div class="alert alert-success" style="padding: 1rem; border-radius: 0.75rem; margin-bottom: 2rem; background: #dcfce7; color: #15803d; font-weight: 600;"><?php echo e($msg); ?></div><?php endif; ?>
        <?php if ($err): ?><div class="alert alert-error" style="padding: 1rem; border-radius: 0.75rem; margin-bottom: 2rem; background: #fee2e2; color: #b91c1c; font-weight: 600;"><?php echo e($err); ?></div><?php endif; ?>


        <table class="admin-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Featured</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post): ?>
                <tr>
                    <td style="font-weight: 600;"><?php echo e($post['title']); ?></td>
                    <td><?php echo e($post['category_name']); ?></td>
                    <td><?php echo e($post['author_name']); ?></td>
                    <td><span class="status-pill status-<?php echo $post['status']; ?>"><?php echo $post['status']; ?></span></td>
                    <td><?php echo $post['featured'] ? '✅' : '❌'; ?></td>
                    <td><?php echo format_date($post['created_at']); ?></td>
                    <td>
                        <a href="post_edit.php?id=<?php echo $post['id']; ?>" class="btn-action" style="color: var(--primary-700);">Edit</a>
                        <a href="javascript:void(0)" 
                           class="btn-action" 
                           style="color: #ef4444;" 
                           onclick="showDeleteModal('posts.php?delete=<?php echo $post['id']; ?>', '<?php echo e(addslashes($post['title'])); ?>')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <!-- Premium Delete Confirmation Modal -->
    <div id="deleteModal" style="display:none; position:fixed; inset:0; background: rgba(0,0,0,0.4); -webkit-backdrop-filter: blur(8px); backdrop-filter: blur(8px); z-index: 9999; align-items: center; justify-content: center;">
        <div style="background: white; padding: 3rem; border-radius: 2rem; max-width: 450px; width: 90%; text-align: center; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); border: 1px solid rgba(255,255,255,0.3);">
            <div style="width: 80px; height: 80px; background: #fee2e2; color: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin: 0 auto 2rem;">⚠️</div>
            <h2 style="font-size: 1.75rem; margin-bottom: 1rem;">Confirm Deletion</h2>
            <p style="color: var(--text-muted); margin-bottom: 2.5rem;">Are you sure you want to delete <strong id="deleteItemName"></strong>? This action cannot be undone.</p>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <button onclick="closeDeleteModal()" style="padding: 1rem; border-radius: 1rem; border: 1px solid var(--border); background: white; font-weight: 700; cursor: pointer; transition: all 0.3s ease;">Cancel</button>
                <a id="confirmDeleteLink" href="#" style="padding: 1rem; border-radius: 1rem; background: #ef4444; color: white; text-decoration: none; font-weight: 700; transition: all 0.3s ease;">Delete Now</a>
            </div>
        </div>
    </div>

    <script>
        function showDeleteModal(link, name) {
            document.getElementById('deleteItemName').textContent = name;
            document.getElementById('confirmDeleteLink').href = link;
            document.getElementById('deleteModal').style.display = 'flex';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        // Close on escape key
        window.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeDeleteModal();
        });
    </script>
</body>
</html>

