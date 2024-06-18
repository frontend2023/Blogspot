<?php
// Include file koneksi ke database
require_once 'connection.php';

// Cek jika pengguna sudah login, redirect ke dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}

// Inisialisasi variabel untuk menyimpan pesan error
$errors = [];

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi data
    if (empty($username) || empty($password)) {
        $errors[] = "Username dan password harus diisi.";
    }

    if (empty($errors)) {
        // Query untuk mendapatkan user berdasarkan username
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        // Jika user ditemukan dan password sesuai
        if ($user && password_verify($password, $user['password'])) {
            // Set session user
            $_SESSION['user_id'] = $user['id_users'];
            $_SESSION['username'] = $user['username'];

            // Redirect ke dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            $errors[] = "Username atau password salah.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css"> <!-- Menghubungkan dengan file style.css -->
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div id="login">
        <h1>Login</h1>
        <?php if (!empty($errors)): ?>
        <div class="error">
            <ul>
                <?php foreach ($errors as $error): ?>
                <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        <div id="loginForm">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" class="input-field"
                    value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="input-field">
                <input type="submit" value="Login" class="submit-btn">
            </form>
        </div>
    </div>
</body>

</html>