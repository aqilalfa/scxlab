<?php

require_once 'auth.php'; // Memastikan sesi dimulai dan koneksi DB ada

// 1. Ganti mekanisme cookie dengan session yang lebih aman
// Ambil peran (role) pengguna dari session, bukan dari cookie.
$username = $_SESSION['user'] ?? null;
$role = $_SESSION['role'] ?? 'user';

if (!$username) {
    // Jika tidak ada sesi, paksa kembali ke halaman login.
    header('Location: login.php');
    exit();
}

// Tentukan status admin berdasarkan sesi
$isAdmin = ($role === 'admin');
$msg = "";

// 2. Gunakan Prepared Statements untuk mencegah SQL Injection
if ($isAdmin && isset($_POST['delete_user'])) {
    $target = $_POST['delete_user'];

    // Validasi tambahan: admin tidak bisa menghapus dirinya sendiri
    if ($target !== $username) {
        $stmt = $GLOBALS['PDO']->prepare("DELETE FROM users WHERE username = ?");
        $stmt->execute([$target]);
        $msg = "<p style='color:green'>User <b>" . htmlspecialchars($target) . "</b> berhasil dihapus!</p>";
    } else {
        $msg = "<p style='color:red'>Admin tidak dapat menghapus diri sendiri.</p>";
    }
}

require_once '_header.php';
?>

<h2>Profile Page</h2>
<p>User: <?= htmlspecialchars($username) ?>, Role: <?= htmlspecialchars($isAdmin ? "Admin" : "User") ?></p>

<?php if ($isAdmin) : ?>
  <h3>Admin Panel</h3>
  <form method="post">
    <label>Delete user:
      <select name="delete_user">
        <?php
        $users = $GLOBALS['PDO']->query("SELECT username FROM users");
        foreach ($users as $u) {
            // Tampilkan pengguna lain sebagai opsi untuk dihapus
            if ($u['username'] !== $username) {
                echo "<option value='" . htmlspecialchars($u['username']) . "'>" . htmlspecialchars($u['username']) . "</option>";
            }
        }
        ?>
      </select>
    </label>
    <button type="submit">Delete</button>
  </form>
  <?php if (!empty($msg)) {
      echo $msg;
  } ?>
<?php else : ?>
  <p style="color:red">You are a regular user. You do not have admin panel access.</p>
<?php endif; ?>

<?php require_once '_footer.php'; ?>