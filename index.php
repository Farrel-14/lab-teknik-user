<?php
require_once "koneksi.php";

$alat = $conn->query("SELECT * FROM alat ORDER BY nama_alat");
$riwayat = $conn->query("
    SELECT p.*, a.kode_alat, a.nama_alat
    FROM peminjaman p
    JOIN alat a ON a.id = p.alat_id
    ORDER BY p.id DESC
    LIMIT 20
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lab Teknik - Pinjam Alat</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-4">
<div class="max-w-5xl mx-auto bg-white p-6 rounded-xl shadow">
    <h1 class="text-2xl font-bold mb-6">🔧 Lab Teknik - Pinjam Alat</h1>

    <?php if (isset($_GET['msg'])): ?>
        <div class="mb-4 p-3 rounded bg-blue-100 text-blue-800">
            <?= htmlspecialchars($_GET['msg']) ?>
        </div>
    <?php endif; ?>

    <form action="pinjam.php" method="POST" class="space-y-3 mb-8">
        <input name="nama" required placeholder="Nama Mahasiswa"
               class="w-full border p-3 rounded">
        <input name="npm" required placeholder="NPM"
               class="w-full border p-3 rounded">

        <select name="alat_id" required class="w-full border p-3 rounded">
            <option value="">-- Pilih Alat --</option>
            <?php while ($row = $alat->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>" <?= $row['tersedia'] <= 0 ? 'disabled' : '' ?>>
                    <?= htmlspecialchars($row['kode_alat']) ?> -
                    <?= htmlspecialchars($row['nama_alat']) ?>
                    (tersedia: <?= $row['tersedia'] ?>)
                </option>
            <?php endwhile; ?>
        </select>

        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white p-3 rounded font-bold">
            PINJAM ALAT
        </button>
    </form>

    <h2 class="font-bold text-xl mb-3">Status & Riwayat Peminjaman</h2>
    <div class="overflow-x-auto">
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Mahasiswa</th>
                <th class="border p-2">NPM</th>
                <th class="border p-2">Alat</th>
                <th class="border p-2">Tanggal Pinjam</th>
                <th class="border p-2">Status</th>
                <th class="border p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $riwayat->fetch_assoc()): ?>
            <tr>
                <td class="border p-2"><?= htmlspecialchars($row['nama_mahasiswa']) ?></td>
                <td class="border p-2"><?= htmlspecialchars($row['npm']) ?></td>
                <td class="border p-2">
                    <?= htmlspecialchars($row['kode_alat']) ?> -
                    <?= htmlspecialchars($row['nama_alat']) ?>
                </td>
                <td class="border p-2"><?= htmlspecialchars($row['tanggal_pinjam']) ?></td>
                <td class="border p-2">
                    <?php if ($row['status'] === 'dipinjam'): ?>
                        <span class="text-red-600 font-bold">Dipinjam</span>
                    <?php else: ?>
                        <span class="text-green-600 font-bold">Dikembalikan</span>
                    <?php endif; ?>
                </td>
                <td class="border p-2">
                    <?php if ($row['status'] === 'dipinjam'): ?>
                    <form action="kembali.php" method="POST">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button class="bg-green-600 text-white px-3 py-1 rounded">
                            Kembalikan
                        </button>
                    </form>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    </div>
</div>
</body>
</html>
