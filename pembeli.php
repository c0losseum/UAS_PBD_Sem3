<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pembeli</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>Data Pembeli</header>
    <div style="text-align: center; margin: 20px 0;">
        <a href="index.php" class="button-main">Kembali ke Menu Utama</a>
        <a href="?action=add" class="button-main">Tambah Pembeli Baru</a>
    </div>

    <?php
    // Proses menambahkan data pembeli
    if (isset($_POST['submit_add'])) {
        $nama = $_POST['nama'];
        $no_telepon = $_POST['no_telepon'];
        $alamat = $_POST['alamat'];

        // Insert pembeli baru ke tabel pembeli
        $conn->query("INSERT INTO pembeli (nama, no_telepon, alamat) VALUES ('$nama', '$no_telepon', '$alamat')");
        echo "<p>Pembeli baru berhasil ditambahkan!</p>";
    }

    // Proses mengedit data pembeli
    if (isset($_POST['submit_edit'])) {
        $id_pembeli = $_POST['id_pembeli'];
        $nama = $_POST['nama'];
        $no_telepon = $_POST['no_telepon'];
        $alamat = $_POST['alamat'];

        // Update data pembeli di tabel pembeli
        $conn->query("UPDATE pembeli SET nama='$nama', no_telepon='$no_telepon', alamat='$alamat' WHERE id_pembeli=$id_pembeli");

        // Menampilkan pop-up dan redirect setelah berhasil update
        echo "<script>
                alert('Data pembeli berhasil diperbarui!');
                window.location.href = 'pembeli.php';
              </script>";
    }

    // Menampilkan form tambah/edit data pembeli
    if (isset($_GET['action']) && ($_GET['action'] === 'add' || $_GET['action'] === 'edit')) {
        $data = ['id_pembeli' => '', 'nama' => '', 'no_telepon' => '', 'alamat' => ''];
        if ($_GET['action'] === 'edit' && isset($_GET['id_pembeli'])) {
            $id_pembeli = $_GET['id_pembeli'];
            $result = $conn->query("SELECT * FROM pembeli WHERE id_pembeli=$id_pembeli");
            $data = $result->fetch_assoc();
        }
        ?>
        <h2><?php echo ($_GET['action'] === 'add') ? 'Tambah Pembeli Baru' : 'Edit Data Pembeli'; ?></h2>
        <form method="POST" action="">
            <input type="hidden" name="id_pembeli" value="<?php echo $data['id_pembeli']; ?>">
            <label>Nama:</label>
            <input type="text" name="nama" value="<?php echo $data['nama']; ?>" required><br>
            <label>No Telepon:</label>
            <input type="number" name="no_telepon" value="<?php echo $data['no_telepon']; ?>" required><br>
            <label>Alamat:</label>
            <input type="text" name="alamat" value="<?php echo $data['alamat']; ?>" required><br>
            <button type="submit" name="<?php echo ($_GET['action'] === 'add') ? 'submit_add' : 'submit_edit'; ?>">
                <?php echo ($_GET['action'] === 'add') ? 'Simpan' : 'Update'; ?>
            </button>
            <a href="pembeli.php">Batal</a>
        </form>
        <?php
    } else {
        ?>
        <!-- Menampilkan Data Pembeli -->
        <table border="1">
            <tr>
                <th>Nama</th>
                <th>No Telepon</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
            <?php
            $result = $conn->query("SELECT * FROM pembeli");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['nama']}</td>
                    <td>{$row['no_telepon']}</td>
                    <td>{$row['alamat']}</td>
                    <td>
                        <a href='pembeli.php?action=edit&id_pembeli={$row['id_pembeli']}' class='button'>Edit</a>
                    </td>
                </tr>";
            }
            ?>
        </table>
        <?php
    }
    ?>
</body>
</html>
