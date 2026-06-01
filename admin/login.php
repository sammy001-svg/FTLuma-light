<?php
require_once '../functions.php';

if (is_admin_logged_in()) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!$pdo) {
        $error = 'Database connection error. Please ensure your database is set up and configured in config.php.';
    } elseif (admin_login($username, $password)) {
        header('Location: index.php');
        exit;
    } else {
        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | FTLuma-Light</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            background: linear-gradient(rgba(8, 28, 21, 0.6), rgba(8, 28, 21, 0.6)), url('../assets/images/login-bg.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            font-family: 'Inter', sans-serif;
        }
        .login-box {
            background: rgba(255, 255, 255, 0.9);
            -webkit-backdrop-filter: blur(10px);
            backdrop-filter: blur(10px);
            padding: 3.5rem;
            border-radius: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 480px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .login-logo {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        .login-logo .logo-icon {
            margin: 0 auto 1rem;
        }
        .error-msg {
            background: #fee2e2;
            color: #b91c1c;
            padding: 1rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <div class="login-logo">
            <img src="../assets/images/logo.jpg" alt="FTLuma Logo" style="height: 120px; width: auto; display: block; margin: 0 auto 1.5rem;">
            <h2>Admin Portal</h2>
        </div>



        <?php if ($error): ?>
            <div class="error-msg"><?php echo e($error); ?></div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Username or Email</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="admin or info@ftluma-light.com" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" required>
            </div>
            <button type="submit" class="btn-primary" style="width: 100%; margin-top: 1rem;">Sign In</button>
        </form>
        
        <p style="text-align: center; margin-top: 2rem; font-size: 0.875rem; color: var(--text-muted);">
            &copy; <?php echo date('Y'); ?> FTLuma-Light Administration
        </p>
    </div>
</body>
</html>
