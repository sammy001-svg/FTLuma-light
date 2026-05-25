<?php
require_once '../functions.php';
redirect_if_not_logged_in();

$categories = get_categories();
$authors = get_authors();
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle Image Upload
    $featured_image = $_POST['featured_image_url'] ?: '';
    if (isset($_FILES['featured_image']) && $_FILES['featured_image']['name'] !== '') {
        if ($_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
            $uploaded_path = upload_image($_FILES['featured_image']);
            if ($uploaded_path) {
                $featured_image = $uploaded_path;
            } else {
                $error = 'Failed to move uploaded file. Check folder permissions.';
            }
        } else {
            $upload_errors = [
                UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
                UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
                UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded.',
                UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
                UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
                UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
                UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.',
            ];
            $error = 'Upload error: ' . ($upload_errors[$_FILES['featured_image']['error']] ?? 'Unknown error');
        }
    }

    $slug = $_POST['slug'] ?: $_POST['title'];
    $unique_slug = generate_unique_slug($slug);

    $data = [
        'category_id' => $_POST['category_id'],
        'author_id' => $_POST['author_id'],
        'title' => $_POST['title'],
        'slug' => $unique_slug,
        'content' => $_POST['content'],
        'excerpt' => $_POST['excerpt'],
        'featured_image' => $featured_image,
        'status' => $_POST['status'],
        'featured' => isset($_POST['featured']) ? 1 : 0
    ];

    if (create_post($data)) {
        $success = 'Post created successfully!';
    } else {
        $error = 'Failed to create post. An unexpected database error occurred.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Post | Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- Quill Rich Text Editor -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
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
        
        /* Quill Editor Adjustments */
        #editor-container {
            height: 400px;
            background: white;
            border-bottom-left-radius: 0.75rem;
            border-bottom-right-radius: 0.75rem;
        }
        .ql-toolbar {
            border-top-left-radius: 0.75rem;
            border-top-right-radius: 0.75rem;
            background: #f8fafc;
        }
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
            <li><a href="reservations.php">Reservations</a></li>
            <li><a href="../index.php" target="_blank">View Site ↗</a></li>
            <li style="margin-top: 5rem;"><a href="logout.php" style="color: #f87171;">Logout</a></li>
        </ul>
    </aside>

    <main class="admin-main">
        <div style="margin-bottom: 3rem;">
            <a href="posts.php" style="text-decoration: none; color: var(--text-muted); margin-bottom: 1rem; display: inline-block;">← Back to Posts</a>
            <h1>Create New Post</h1>
        </div>

        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="admin-form-card">
            <form action="post_add.php" method="POST" enctype="multipart/form-data" id="postForm">
                <div class="form-group">
                    <label for="title">Post Title</label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Enter an engaging title" required>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select id="category_id" name="category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo $cat['id']; ?>"><?php echo e($cat['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="slug">Slug (Optional)</label>
                        <input type="text" id="slug" name="slug" class="form-control" placeholder="post-url-slug">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                    <div class="form-group">
                        <label for="author_id">Author</label>
                        <select id="author_id" name="author_id" class="form-control" required>
                            <option value="">Select Author</option>
                            <?php foreach ($authors as $auth): ?>
                                <option value="<?php echo $auth['id']; ?>"><?php echo e($auth['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <!-- Placeholder for alignment -->
                    </div>
                </div>

                <div class="form-group">
                    <label>Featured Image</label>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; align-items: end;">
                        <div>
                            <small style="color: var(--text-muted); display: block; margin-bottom: 0.5rem;">Upload from computer</small>
                            <input type="file" id="featured_image" name="featured_image" class="form-control" accept="image/*">
                        </div>
                        <div>
                            <small style="color: var(--text-muted); display: block; margin-bottom: 0.5rem;">OR Paste image URL</small>
                            <input type="text" id="featured_image_url" name="featured_image_url" class="form-control" placeholder="https://unsplash.com/...">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="excerpt">Excerpt (Short Summary)</label>
                    <textarea id="excerpt" name="excerpt" class="form-control" style="min-height: 100px;" placeholder="Brief overview for cards"></textarea>
                </div>

                <div class="form-group">
                    <label for="content">Full Content</label>
                    <!-- Quill Container -->
                    <div id="editor-container"></div>
                    <!-- Hidden textarea to store Quill content for PHP -->
                    <textarea name="content" id="content-hidden" style="display:none;"></textarea>
                </div>

                <div style="display: flex; gap: 4rem; margin: 2rem 0;">
                    <div class="form-group" style="display: flex; align-items: center; gap: 1rem;">
                        <label for="status" style="margin-bottom: 0;">Status</label>
                        <select id="status" name="status" class="form-control" style="width: 150px;">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                        </select>
                    </div>
                    <div class="form-group" style="display: flex; align-items: center; gap: 1rem;">
                        <input type="checkbox" id="featured" name="featured" style="width: 20px; height: 20px;">
                        <label for="featured" style="margin-bottom: 0;">Feature on Homepage</label>
                    </div>
                </div>

                <button type="submit" class="btn-primary" style="width: 100%; padding: 1.25rem;">Publish Post</button>
            </form>
        </div>
    </main>

    <!-- Quill JS -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        var quill = new Quill('#editor-container', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }, { 'background': [] }], /* Color and Background pickers */
                    ['blockquote', 'code-block'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link', 'image'],
                    ['clean']
                ]
            }
        });

        // Sync Quill content to hidden textarea before submit
        var form = document.getElementById('postForm');
        form.onsubmit = function() {
            var content = document.querySelector('input[name=content]');
            document.getElementById('content-hidden').value = quill.root.innerHTML;
            return true;
        };
    </script>
</body>
</html>
