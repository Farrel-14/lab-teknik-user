<?php
require_once "koneksi.php";

$id = (int)($_POST['id'] ?? 0);

if ($id <= 0) {
    header("Location: index.php?msg=" . urlencode("ID peminjaman tidak valid."));
    exit;
}

$conn->begin_transaction();

try {
    $stmt = $conn->prepare(
        "SELECT alat_id, status FROM peminjaman WHERE id = ? FOR UPDATE"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();

    if (!$row) {
        throw new Exception("Data peminjaman tidak ditemukan.");
    }

    if ($row['status'] === 'dikembalikan') {
        throw new Exception("Alat sudah dikembalikan.");
    }

    $stmt = $conn->prepare(
        "UPDATE peminjaman SET status='dikembalikan', tanggal_kembali=NOW() WHERE id=?"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $stmt = $conn->prepare("UPDATE alat SET tersedia = tersedia + 1 WHERE id = ?");
    $stmt->bind_param("i", $row['alat_id']);
    $stmt->execute();

    $conn->commit();
    $msg = "Alat berhasil dikembalikan.";
} catch (Exception $e) {
    $conn->rollback();
    $msg = $e->getMessage();
}

header("Location: index.php?msg=" . urlencode($msg));
exit;
?>
