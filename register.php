<?php
// Include file koneksi ke database
require_once 'connection.php';

// Inisialisasi variabel untuk menyimpan pesan error
$errors = [];
// Inisialisasi variabel untuk menyimpan pesan sukses
$success_message = '';

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validasi data (contoh sederhana)
    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        $errors[] = "Semua field harus diisi.";
    }

    if ($password !== $confirmPassword) {
        $errors[] = "Password dan konfirmasi password tidak cocok.";
    }

    // Validasi lebih lanjut bisa dilakukan di sini, seperti validasi format email, kekuatan password, dll.

    // Cek apakah username sudah ada di database
    $sqlUsernameExists = "SELECT * FROM users WHERE username = :username";
    $stmtUsernameExists = $pdo->prepare($sqlUsernameExists);
    $stmtUsernameExists->execute(['username' => $username]);
    $resultUsernameExists = $stmtUsernameExists->fetch();

    if ($resultUsernameExists) {
        $errors[] = "Username sudah digunakan.";
    }

    // Cek apakah email sudah ada di database
    $sqlEmailExists = "SELECT * FROM users WHERE email = :email";
    $stmtEmailExists = $pdo->prepare($sqlEmailExists);
    $stmtEmailExists->execute(['email' => $email]);
    $resultEmailExists = $stmtEmailExists->fetch();

    if ($resultEmailExists) {
        $errors[] = "Email sudah digunakan.";
    }

    // Jika tidak ada error, lakukan registrasi
    if (empty($errors)) {
        // Hash password sebelum disimpan ke database (disarankan menggunakan password_hash() untuk keamanan)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Query untuk menyimpan data user baru
        $sqlInsertUser = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmtInsertUser = $pdo->prepare($sqlInsertUser);

        // Bind parameter ke prepared statement
        $stmtInsertUser->bindParam(':username', $username);
        $stmtInsertUser->bindParam(':email', $email);
        $stmtInsertUser->bindParam(':password', $hashedPassword);

        // Eksekusi query
        if ($stmtInsertUser->execute()) {
            // Set pesan sukses
            $success_message = "Registrasi berhasil! Silakan login.";
            // Kosongkan form setelah registrasi berhasil
            $_POST = array();
        } else {
            $errors[] = "Gagal melakukan registrasi. Silakan coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div id="register" class="container">
        <h1>Register</h1>
        <?php if (!empty($success_message)): ?>
        <div class="success">
            <?php echo $success_message; ?>
        </div>
        <?php elseif (!empty($errors)): ?>
        <div class="error">
            <ul>
                <?php foreach ($errors as $error): ?>
                <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        <div id="registerForm">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username"
                    value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email"
                    value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password">
                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" id="confirmPassword" name="confirmPassword">
                <input type="submit" value="Register">
            </form>
        </div>
    </div>
</body>

</html>