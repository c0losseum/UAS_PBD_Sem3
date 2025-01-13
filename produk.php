<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stok Produk</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>Stok Produk Tersedia</header>
    <div style="text-align: center; margin: 20px 0;">
        <a href="index.php" class="button-main">Kembali ke Menu Utama</a>
    </div>

    <!-- Filter Berdasarkan Kategori -->
    <form method="GET" action="">
        <div class="filter-category">
            <label for="kategori">Filter Kategori:</label>
            <select name="kategori" id="kategori">
                <option value="">Semua Kategori</option>
                <?php
                // Mengambil daftar kategori unik dari tabel produk
                $result = $conn->query("SELECT DISTINCT kategori FROM produk");
                while ($row = $result->fetch_assoc()) {
                    $selected = ($_GET['kategori'] ?? '') == $row['kategori'] ? 'selected' : '';
                    echo "<option value='{$row['kategori']}' $selected>{$row['kategori']}</option>";
                }
                ?>
            </select>
            <button type="submit">Filter</button>
        </div>
    </form>

    <table border="1">
        <tr>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stok Tersedia</th>
        </tr>
        <?php
        // Filter kategori jika dipilih
        $kategoriFilter = $_GET['kategori'] ?? '';
        $query = "
            SELECT 
                p.nama, 
                p.kategori, 
                p.harga, 
                IFNULL(SUM(ps.stok), 0) AS stok_tersedia
            FROM produk p
            LEFT JOIN penyimpanan ps ON p.id_produk = ps.id_produk
        ";
        if ($kategoriFilter) {
            $query .= " WHERE p.kategori = '$kategoriFilter'";
        }
        $query .= " GROUP BY p.id_produk";

        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['nama']}</td>
                <td>{$row['kategori']}</td>
                <td>" . number_format($row['harga'], 2) . "</td>
                <td>{$row['stok_tersedia']}</td>
            </tr>";
        }
        ?>
    </table>
</body>
</html>
