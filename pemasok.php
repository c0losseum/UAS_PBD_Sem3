<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemasok Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>Pemasokan Barang</header>
    <div style="text-align: center; margin: 20px 0;">
        <a href="index.php" class="button-main">Kembali ke Menu Utama</a>
    </div>

    <!-- Form untuk menambah pemasok -->
    <form method="POST" action="">
        <label>Nama Pemasok:</label><input type="text" name="nama_pemasok" required><br>
        <label>Produk:</label>
        <select name="id_produk" required>
            <?php
            // Mengambil daftar produk
            $result = $conn->query("SELECT id_produk, nama FROM produk");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id_produk']}'>{$row['nama']}</option>";
            }
            ?>
        </select><br>
        <label>Jumlah Pasokan:</label><input type="number" name="jumlah" required><br>
        <button type="submit" name="submit">Tambah Pasokan</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $nama_pemasok = $_POST['nama_pemasok'];
        $id_produk = $_POST['id_produk'];
        $jumlah = $_POST['jumlah'];
        $tanggal = date('Y-m-d');

        // Menambah pemasok baru ke tabel pemasok
        $conn->query("INSERT INTO pemasok (nama, jumlah_pasokan, tanggal) VALUES ('$nama_pemasok', $jumlah, '$tanggal')");
        $id_pemasok = $conn->insert_id;

        // Memperbarui stok produk di tabel penyimpanan
        $conn->query("UPDATE penyimpanan SET stok = stok + $jumlah WHERE id_produk = $id_produk");

        echo "<p>Pasokan berhasil ditambahkan!</p>";
    }
    ?>

    <!-- Menampilkan Data Pemasok -->
    <header>Daftar Pemasok</header>
    <table border="1">
        <tr>
            <th>Nama Pemasok</th>
            <th>Produk</th>
            <th>Jumlah Pasokan</th>
            <th>Tanggal</th>
        </tr>
        <?php
        // Menampilkan data pemasok
        $result = $conn->query("SELECT p.nama, pr.nama AS produk, p.jumlah_pasokan, p.tanggal 
                                FROM pemasok p
                                JOIN penyimpanan ps ON ps.id_pemasok = p.id_pemasok
                                JOIN produk pr ON pr.id_produk = ps.id_produk");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['nama']}</td>
                    <td>{$row['produk']}</td>
                    <td>{$row['jumlah_pasokan']}</td>
                    <td>{$row['tanggal']}</td>
                  </tr>";
        }
        ?>
    </table>
</body>
</html>
