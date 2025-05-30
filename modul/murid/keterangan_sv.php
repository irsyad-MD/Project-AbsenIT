<?php 
include 'koneksi.php'; // Pastikan koneksi ke database sudah benar

if (isset($_POST['simpan'])) {
    $id_karyawan = $_POST['id_karyawan'];
    $keterangan = $_POST['keterangan'];
    $alasan = $_POST['alasan'];
    $waktu = $_POST['waktu']; // Format: Y-m-d H:i:s

    // Prepared statement untuk menghindari SQL Injection
    $stmt = $koneksi->prepare("INSERT INTO tb_keterangan (id_karyawan, keterangan, alasan, waktu) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $id_karyawan, $keterangan, $alasan, $waktu);

    // Eksekusi query
    if ($stmt->execute()) {
        echo "<script>alert('Anda sudah memberi keterangan');</script>";
        echo '<script>window.history.back();</script>';
    } else {
        echo "Gagal: " . $stmt->error;
    }

    $stmt->close();
}
?>