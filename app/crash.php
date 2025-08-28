<?php require_once 'auth.php'; ?>

<?php require_once '_header.php'; ?>

<h2>Crash Test</h2>

<?php

// 1. Sanitasi input: Ubah input menjadi integer.
// Ini memastikan input selalu berupa angka dan mencegah XSS.
$factor = (int) ($_GET['factor'] ?? 1);

// 2. Validasi input: Cek apakah input adalah nol untuk mencegah Division by Zero.
if ($factor === 0) {
    echo "Error: Tidak bisa melakukan pembagian dengan nol.";
} else {
    $result = 100 / $factor;
    // 3. Sanitasi output: Gunakan htmlspecialchars() untuk mencegah XSS saat menampilkan kembali input.
    echo "100 / " . htmlspecialchars((string)$factor) . " = " . htmlspecialchars((string)$result);
}

?>

<?php require_once '_footer.php'; ?>