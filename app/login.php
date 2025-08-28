<?php

// 1. Setup & Autoloading
// Memuat semua class (seperti Profile) dan dependensi lain secara otomatis.
require_once __DIR__ . '/../vendor/autoload.php';
// Memuat koneksi database dan memulai sesi.
require_once __DIR__ . '/auth.php';

// Mengimpor class Profile agar bisa digunakan.
use App\Profile;

// Inisialisasi variabel untuk pesan error.
$error = "";

// 2. Logika Pemrosesan Form
// Hanya jalankan logika jika metode request adalah POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validasi input dasar.
    if (empty($username) || empty($password)) {
        $error = "Username dan password tidak boleh kosong.";
    } else {
        // Mencegah SQL Injection dengan Prepared Statements.
        $stmt = $GLOBALS['PDO']->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        // Memverifikasi password hash, bukan plain text.
        if ($user && password_verify($password, $user['password'])) {
            // Jika berhasil, simpan informasi ke session.
            $_SESSION['user'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect ke halaman dashboard.
            header("Location: dashboard.php");
            exit(); // Hentikan eksekusi skrip setelah redirect.
        } else {
            // Jika gagal, berikan pesan error yang umum.
            $error = "Login gagal. Periksa kembali username dan password Anda.";
        }
    }
}

// 3. Tampilan HTML
// Memuat file header.
require_once __DIR__ . '/_header.php';
?>

<article>
    <header>
        <h2>Login</h2>
    </header>

    <?php if (!empty($error)) : ?>
        <p style="color: var(--pico-color-red-500);"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post" action="login.php">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>
    </form>
</article>

<?php
// Memuat file footer.
require_once __DIR__ . '/_footer.php';
?>