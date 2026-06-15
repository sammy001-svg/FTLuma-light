<?php
require_once '../functions.php';
redirect_if_not_logged_in();

if (isset($_GET['delete'])) {
    if (delete_author($_GET['delete'])) {
        header('Location: authors.php?msg=Author deleted successfully');
    } else {
        header('Location: authors.php?err=Cannot delete author with associated posts');
    }
    exit;
}

$authors = get_authors();
$page_title = 'Manage Authors';
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
        .admin-table { width: 100%; background: white; border-radius: 1.5rem; border: 1px solid var(--border); border-collapse: collapse; overflow: hidden; margin-top: 2rem; }
        .admin-table th, .admin-table td { padding: 1.25rem 1.5rem; text-align: left; border-bottom: 1px solid var(--border); }
        .admin-table th { background: #f1f5f9; font-weight: 700; }
        .author-img { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }
        .btn { padding: 0.75rem 1.5rem; border-radius: 0.75rem; font-weight: 700; text-decoration: none; display: inline-block; cursor: pointer; border: none; }
        .btn-primary { background: var(--primary-600); color: white; }
        .alert { padding: 1rem; border-radius: 0.75rem; margin-bottom: 2rem; font-weight: 600; }
        .alert-success { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .alert-error { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }
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
            <li><a href="messages.php">Messages</a></li>
            <li><a href="reservations.php">Reservations</a></li>
            <li><a href="messages.php">Messages</a></li>
            <li><a href="subscribers.php">Subscribers</a></li>

            <li><a href="../index.php" target="_blank">View Site ↗</a></li>
            <li style="margin-top: 5rem;"><a href="logout.php" style="color: #f87171;">Logout</a></li>
        </ul>
    </aside>

    <main class="admin-main">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h1>Manage Authors</h1>
            <a href="author_add.php" class="btn btn-primary">+ Add New Author</a>
        </div>

        <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-success"><?php echo e($_GET['msg']); ?></div>
        <?php endif; ?>
        <?php if (isset($_GET['err'])): ?>
            <div class="alert alert-error"><?php echo e($_GET['err']); ?></div>
        <?php endif; ?>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Bio</th>
                    <th>Date Added</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($authors as $author): ?>
                <tr>
                    <td>
                        <?php if ($author['image']): ?>
                            <img src="<?php echo get_image_url($author['image']); ?>" class="author-img" alt="">
                        <?php else: ?>
                            <div class="author-img" style="background: #e2e8f0; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #64748b;">
                                <?php echo substr($author['name'], 0, 1); ?>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td style="font-weight: 700;"><?php echo e($author['name']); ?></td>
                    <td style="max-width: 300px; color: var(--text-muted);"><?php echo e(substr($author['bio'], 0, 100)); ?>...</td>
                    <td><?php echo format_date($author['created_at']); ?></td>
                    <td>
                        <a href="author_edit.php?id=<?php echo $author['id']; ?>" style="color: var(--primary-700); font-weight: 700; margin-right: 1rem;">Edit</a>
                        <a href="javascript:void(0)" 
                           style="color: #ef4444; font-weight: 700;" 
                           onclick="showDeleteModal('authors.php?delete=<?php echo $author['id']; ?>', '<?php echo e(addslashes($author['name'])); ?>')">Delete</a>
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

        window.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeDeleteModal();
        });
    </script>
</body>
</html>

