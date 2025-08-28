<?php

// Muat autoloader Composer
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/auth.php'; // Untuk koneksi DB dan session_start()

// Impor class Profile dari namespace App
use App\Profile;

$error = "";

if ($_POST) {
    $u = $_POST['username'];
    $p = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$u' AND password='$p'";
    $res = $GLOBALS['PDO']->query($sql);
    if ($row = $res->fetch()) {
        $_SESSION['user'] = $row['username'];
        $_SESSION['role'] = $row['role'];

        $pObj = new Profile($row['username'], $row['role'] === 'admin');
        setcookie('profile', serialize($pObj));

        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Login failed.";
    }
}

require_once __DIR__ . '/_header.php';
?>

<h2>Login</h2>

<?php if (!empty($error)) : ?>
    <p style='color:red'><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="post">
  <label>Username <input name="username"></label>
  <label>Password <input type="password" name="password"></label>
  <button type="submit">Login</button>
</form>

<?php require_once __DIR__ . '/_footer.php'; ?>