<?php 

include_once "koneksi.php";

$username = $_POST['username'];
$pass = md5($_POST['password']);


$stmt = $koneksi->prepare("SELECT * FROM tb_karyawan WHERE username=? AND password=?");
$stmt->bind_param("ss", $username, $pass);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    session_start();
    $b = $result->fetch_assoc();
    $_SESSION['idsi']   = $b['id_karyawan'];
    $_SESSION['usersi'] = $b['username'];
    $_SESSION['namasi'] = $b['nama'];
    $_SESSION['jabatansi'] = $b['jabatan'];
    header("location: index.php?m=awal");
} else {
    echo '<script language="javascript">';
    echo 'alert("Username/Password ada yang salah, atau akun anda belum Aktif")';
    echo '</script>';
    header("location: login_murid.php");
}

$stmt->close();
$koneksi->close();

?>