<?php
require_once '../functions.php';
redirect_if_not_logged_in();

$error = '';
$success = '';

if (!isset($_GET['id'])) {
    header('Location: events.php');
    exit;
}

$event = get_event_by_id($_GET['id']);
if (!$event) {
    die("Event not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle Image Upload
    $image = $_POST['image_url'] ?: $event['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploaded_path = upload_image($_FILES['image']);
        if ($uploaded_path) {
            $image = $uploaded_path;
        }
    }

    $data = [
        'title' => $_POST['title'],
        'event_date' => $_POST['event_date'],
        'event_time' => $_POST['event_time'],
        'location' => $_POST['location'],
        'category' => $_POST['category'],
        'description' => $_POST['description'],
        'image' => $image,
        'status' => $_POST['status']
    ];

    if (update_event($_GET['id'], $data)) {
        $success = 'Event updated successfully!';
        // Refresh local data
        $event = get_event_by_id($_GET['id']);
    } else {
        $error = 'Failed to update event.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event | Admin</title>
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
        .admin-form-card { background: white; padding: 3rem; border-radius: 1.5rem; border: 1px solid var(--border); max-width: 900px; }
        .alert { padding: 1rem 1.5rem; border-radius: 0.75rem; margin-bottom: 2rem; font-weight: 600; }
        .alert-success { background: #dcfce7; color: #15803d; }
        .alert-error { background: #fee2e2; color: #b91c1c; }
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
            <h1>Edit Event</h1>
        </div>

        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="admin-form-card">
            <form action="event_edit.php?id=<?php echo $event['id']; ?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Event Title</label>
                    <input type="text" id="title" name="title" class="form-control" value="<?php echo e($event['title']); ?>" required>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                    <div class="form-group">
                        <label for="event_date">Event Date</label>
                        <input type="date" id="event_date" name="event_date" class="form-control" value="<?php echo $event['event_date']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="event_time">Event Time</label>
                        <input type="time" id="event_time" name="event_time" class="form-control" value="<?php echo $event['event_time']; ?>" required>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" id="location" name="location" class="form-control" value="<?php echo e($event['location']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <input type="text" id="category" name="category" class="form-control" value="<?php echo e($event['category']); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Event Image</label>
                    <?php if ($event['image']): ?>
                        <div style="margin-bottom: 1rem;">
                            <img src="<?php echo get_image_url($event['image']); ?>" alt="Current Image" style="height: 100px; border-radius: 0.5rem;">
                        </div>
                    <?php endif; ?>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; align-items: end;">
                        <div>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                        <div>
                            <input type="text" name="image_url" class="form-control" placeholder="OR new image URL">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Event Description</label>
                    <textarea id="description" name="description" class="form-control" style="min-height: 150px;"><?php echo e($event['description']); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-control" style="width: 200px;">
                        <option value="upcoming" <?php echo $event['status'] === 'upcoming' ? 'selected' : ''; ?>>Upcoming</option>
                        <option value="completed" <?php echo $event['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                        <option value="cancelled" <?php echo $event['status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                    </select>
                </div>

                <button type="submit" class="btn-primary" style="width: 100%; padding: 1.25rem; margin-top: 2rem;">Update Event</button>
            </form>
        </div>
    </main>
</body>
</html>
