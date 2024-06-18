<!-- navbar.php -->

<div id="navbar">
    <a href="index" class="nav-item">Home</a>
    <?php if (isset($_SESSION['username'])): ?>
    <a href="logout" class="nav-item">Logout</a>
    <?php else: ?>
    <a href="login" class="nav-item">Login</a>
    <a href="register" class="nav-item">Register</a>
    <?php endif; ?>
</div>