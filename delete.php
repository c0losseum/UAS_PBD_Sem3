<?php 
include 'db.php';

if (isset($_GET['id_detail'])) {
    $id_detail = $_GET['id_detail'];

    $deleteQuery = "DELETE FROM detail WHERE id_detail = $id_detail";
    if ($conn->query($deleteQuery)) {
        header("Location: riwayat.php");
        exit();
    } else {
        echo "Gagal menghapus data: " . $conn->error;
    }
}
?>
