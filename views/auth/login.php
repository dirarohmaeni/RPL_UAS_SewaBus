<?php
$error = '';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $q = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' LIMIT 1");

    if (mysqli_num_rows($q) === 1) {
        $u = mysqli_fetch_assoc($q);

        if (password_verify($password, $u['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['nama']  = $u['nama'];
            header("Location: index.php?page=dashboard");
            exit;
        } else {
            $error = "Password salah";
        }
    } else {
        $error = "Username tidak ditemukan";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Sewa Bus</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>

<body class="auth-body">

<div class="auth-card">
    <h2>Login Sewa Bus</h2>

    <?php if ($error): ?>
        <div class="auth-error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login" class="btn-login">🔐 Login</button>
    </form>
</div>

</body>
</html>
