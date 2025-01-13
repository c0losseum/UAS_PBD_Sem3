<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Produk</title>
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript">
        // Menampilkan atau menyembunyikan input pembeli baru
        function togglePembeliBaru(select) {
            const pembeliBaruForm = document.getElementById("pembeliBaruForm");
            if (select.value === "baru") {
                pembeliBaruForm.style.display = "block";
            } else {
                pembeliBaruForm.style.display = "none";
            }
        }

        // Menampilkan pop-up untuk pesan
        function showAlert(message) {
            alert(message);
        }
    </script>
</head>
<body>
    <header>Pemesanan Produk</header>
    <div style="text-align: center; margin: 20px 0;">
        <a href="index.php" class="button-main">Kembali ke Menu Utama</a>
    </div>

    <form method="POST" action="">
        <h3>Data Pembeli</h3>
        <label for="pembeli">Pilih Pembeli:</label>
        <select name="id_pembeli" id="pembeli" onchange="togglePembeliBaru(this)" required>
            <option value="" disabled selected>Pilih pembeli</option>
            <option value="baru">Tambah Pembeli Baru</option>
            <?php
            // Menampilkan daftar pembeli yang sudah ada
            $result_pembeli = $conn->query("SELECT id_pembeli, nama FROM pembeli");
            while ($row = $result_pembeli->fetch_assoc()) {
                echo "<option value='{$row['id_pembeli']}'>{$row['nama']}</option>";
            }
            ?>
        </select><br>

        <div id="pembeliBaruForm" style="display: none; margin-top: 10px;">
            <label>Nama Pembeli Baru:</label>
            <input type="text" name="nama_baru" placeholder="Masukkan nama pembeli"><br>
            <label>No Telepon:</label>
            <input type="text" name="telepon_baru" placeholder="Masukkan no telepon"><br>
            <label>Alamat:</label>
            <input type="text" name="alamat_baru" placeholder="Masukkan alamat"><br>
        </div>

        <h3>Data Produk</h3>
        <label for="produk">Produk:</label>
        <select name="id_produk" id="produk" required>
            <?php
            // Menampilkan produk yang tersedia berdasarkan stok yang ada di tabel penyimpanan
            $result_produk = $conn->query("
                SELECT p.id_produk, p.nama, IFNULL(SUM(s.stok), 0) AS stok
                FROM produk p
                LEFT JOIN penyimpanan s ON p.id_produk = s.id_produk
                GROUP BY p.id_produk
                HAVING stok > 0
            ");
            while ($row = $result_produk->fetch_assoc()) {
                echo "<option value='{$row['id_produk']}'>{$row['nama']} (Stok: {$row['stok']})</option>";
            }
            ?>
        </select><br>

        <label>Jumlah:</label><input type="number" name="jumlah" required><br>
        <label>Metode Transaksi:</label>
        <select name="metode" required>
            <option value="online">Online</option>
            <option value="offline">Offline</option>
        </select><br>
        <button type="submit" name="submit">Simpan Pemesanan</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        // Cek apakah pembeli baru ditambahkan
        if ($_POST['id_pembeli'] === "baru") {
            $nama_baru = $conn->real_escape_string($_POST['nama_baru']);
            $telepon_baru = $conn->real_escape_string($_POST['telepon_baru']);
            $alamat_baru = $conn->real_escape_string($_POST['alamat_baru']);

            // Validasi input pembeli baru
            if (empty($nama_baru) || empty($telepon_baru) || empty($alamat_baru)) {
                echo "<script>showAlert('Data pembeli baru harus lengkap!');</script>";
                exit;
            }

            // Insert pembeli baru ke database
            $conn->query("INSERT INTO pembeli (nama, no_telepon, alamat) VALUES ('$nama_baru', '$telepon_baru', '$alamat_baru')");
            $id_pembeli = $conn->insert_id; // ID pembeli baru
        } else {
            $id_pembeli = $_POST['id_pembeli'];
        }

        // Ambil data produk dan jumlah dari form
        $id_produk = $_POST['id_produk'];
        $jumlah = $_POST['jumlah'];
        $metode = $_POST['metode'];
        $tanggal = date('Y-m-d');

        // Cek stok produk sebelum melanjutkan pemesanan
        $stok_tersedia = $conn->query("SELECT IFNULL(SUM(stok), 0) AS stok FROM penyimpanan WHERE id_produk = $id_produk")->fetch_assoc()['stok'];

        if ($jumlah > $stok_tersedia) {
            echo "<script>showAlert('Jumlah yang Anda beli melebihi stok yang tersedia! Stok saat ini: $stok_tersedia.');</script>";
        } else {
            // Insert data penjualan
            $conn->query("INSERT INTO penjualan (tanggal_penjualan, metode_transaksi) VALUES ('$tanggal', '$metode')");
            $id_penjualan = $conn->insert_id;

            // Mendapatkan harga produk
            $harga = $conn->query("SELECT harga FROM produk WHERE id_produk = $id_produk")->fetch_assoc()['harga'];
            $total_harga = $harga * $jumlah;

            // Insert data pesan
            $conn->query("INSERT INTO pesan (id_pembeli, id_penjualan, tanggal_penjualan, total_harga) VALUES ($id_pembeli, $id_penjualan, '$tanggal', $total_harga)");

            // Insert data detail penjualan
            $conn->query("INSERT INTO detail (id_penjualan, id_produk, jumlah, subtotal) VALUES ($id_penjualan, $id_produk, $jumlah, $total_harga)");

            // Update stok produk
            $conn->query("UPDATE penyimpanan SET stok = stok - $jumlah WHERE id_produk = $id_produk");

            echo "<script>showAlert('Pemesanan berhasil disimpan!');</script>";
        }
    }
    ?>
</body>
</html>
