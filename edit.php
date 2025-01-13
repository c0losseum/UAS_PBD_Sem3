<?php 
include 'db.php';

if (isset($_GET['id_detail'])) {
    $id_detail = $_GET['id_detail'];
    $query = "SELECT * FROM detail WHERE id_detail = $id_detail";
    $result = $conn->query($query);
    $data = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jumlah = $_POST['jumlah'];
    $subtotal = $_POST['subtotal'];

    $updateQuery = "UPDATE detail SET jumlah = '$jumlah', subtotal = '$subtotal' WHERE id_detail = $id_detail";
    if ($conn->query($updateQuery)) {
        header("Location: riwayat.php");
        exit();
    } else {
        echo "Gagal mengupdate data: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>Edit Data</header>
    <form method="POST">
        <label>Jumlah:</label>
        <input type="number" name="jumlah" value="<?php echo $data['jumlah']; ?>" required><br>
        <label>Subtotal:</label>
        <input type="number" name="subtotal" value="<?php echo $data['subtotal']; ?>" required><br>
        <button type="submit">Simpan</button>
        <a href="riwayat.php">Batal</a>
    </form>
</body>
</html>