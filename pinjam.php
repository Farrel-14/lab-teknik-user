<?php
require_once "koneksi.php";

$nama = trim($_POST['nama'] ?? '');
$npm = trim($_POST['npm'] ?? '');
$alat_id = (int)($_POST['alat_id'] ?? 0);

if ($nama === '' || $npm === '' || $alat_id <= 0) {
    header("Location: index.php?msg=" . urlencode("Data peminjaman belum lengkap."));
    exit;
}

$conn->begin_transaction();

try {
    $stmt = $conn->prepare("SELECT tersedia FROM alat WHERE id = ? FOR UPDATE");
    $stmt->bind_param("i", $alat_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $alat = $result->fetch_assoc();

    if (!$alat || $alat['tersedia'] <= 0) {
        throw new Exception("Alat sedang tidak tersedia.");
    }

    $stmt = $conn->prepare(
        "INSERT INTO peminjaman (nama_mahasiswa, npm, alat_id) VALUES (?, ?, ?)"
    );
    $stmt->bind_param("ssi", $nama, $npm, $alat_id);
    $stmt->execute();

    $stmt = $conn->prepare("UPDATE alat SET tersedia = tersedia - 1 WHERE id = ?");
    $stmt->bind_param("i", $alat_id);
    $stmt->execute();

    $conn->commit();
    $msg = "Alat berhasil dipinjam.";
} catch (Exception $e) {
    $conn->rollback();
    $msg = $e->getMessage();
}

header("Location: index.php?msg=" . urlencode($msg));
exit;
?>
