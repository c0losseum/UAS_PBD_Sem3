<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Penjualan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>Riwayat Penjualan</header>
    <div style="text-align: center; margin: 20px 0;">
        <a href="index.php" class="button-main">Kembali ke Menu Utama</a>
    </div>

    <table border="1">
        <tr>
            <th>Tanggal Penjualan</th>
            <th>Pembeli</th>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
            <th>Aksi</th>
        </tr>
        <?php
        // Query menampilkan riwayat penjualan dan mengurutkan berdasarkan tanggal penjualan
        $query = "
            SELECT 
                pj.id_penjualan, pj.tanggal_penjualan, pb.nama AS pembeli, 
                pr.nama AS produk, dt.jumlah, dt.subtotal, dt.id_detail 
            FROM penjualan pj
            JOIN pesan ps ON pj.id_penjualan = ps.id_penjualan
            JOIN pembeli pb ON ps.id_pembeli = pb.id_pembeli
            JOIN detail dt ON pj.id_penjualan = dt.id_penjualan
            JOIN produk pr ON dt.id_produk = pr.id_produk
            ORDER BY pj.tanggal_penjualan DESC  -- Mengurutkan berdasarkan tanggal penjualan terbaru
        ";
        $result = $conn->query($query);

        // Tampilkan data hasil query
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['tanggal_penjualan']}</td>
                <td>{$row['pembeli']}</td>
                <td>{$row['produk']}</td>
                <td>{$row['jumlah']}</td>
                <td>{$row['subtotal']}</td>
                <td>
                    <a href='edit.php?id_detail={$row['id_detail']}' class='button'>Edit</a>
                    <a href='delete.php?id_detail={$row['id_detail']}' class='button' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
                </td>
            </tr>";
        }
        ?>
    </table>
</body>
</html>
