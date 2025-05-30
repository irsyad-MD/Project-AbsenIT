<?php


include 'koneksi.php';

//proses input
if (isset($_POST['simpan'])) {
  $id_karyawan = $_POST['id_karyawan'];
  $username = $_POST['username'];
  $password = md5($_POST['password']);
  $nama = $_POST['nama'];

  if(isset($_POST['ubahfoto'])){ // Cek apakah user ingin mengubah fotonya atau tidak
    $foto     = $_FILES['inpfoto']['name'];
    $tmp      = $_FILES['inpfoto']['tmp_name'];
    $fotobaru = date('dmYHis').$foto;
    $path     = "../images/".$fotobaru;

    if(move_uploaded_file($tmp, $path)){ //awal move upload file
      $sql    = "SELECT * FROM tb_karyawan WHERE id_karyawan = '".$id_karyawan."' ";
      $query  = mysqli_query($koneksi, $sql);
      $hapus_f = mysqli_fetch_array($query);

//proses hapus gambar
      $file = "../images/".$hapus_f['foto'];
      unlink($file);//nama variabel yang ada di server

      // Proses ubah data ke Database
      $sql_f = "UPDATE tb_karyawan set username='$username', password='$password', nama='$nama' WHERE id_karyawan='$id_karyawan'";
      $ubah  = mysqli_query($koneksi, $sql_f);
      if($ubah){
        echo "<script>alert('Ubah Data Dengan ID Karyawan = ".$id_karyawan." Berhasil') </script>";
        header('Location:index.php?m=index');
       
      } else {
        $sql    = "SELECT * FROM tb_karyawan WHERE id_karyawan = '".$id_karyawan."' ";
        $query  = mysqli_query($koneksi, $sql);
        while ($row = mysqli_fetch_array($query)) {
          echo "Maaf, Terjadi kesalahan saat mencoba untuk menyimpan data ke database.";
         
        }
      }
    } //akhir move upload file
    else{
      // Jika gambar gagal diupload, Lakukan :
      echo "Maaf, Gambar gagal untuk diupload.";
      echo "<br><a href='datakaryawan.php'>Kembali Ke data karyawan</a>";
    }
 } //akhir ubah foto
 else { //hanya untuk mengubah data
   $sql_d   = "UPDATE tb_karyawan set username='$username', password='$password', nama='$nama' WHERE id_karyawan='$id_karyawan'";
   $data    = mysqli_query($koneksi, $sql_d);
   if ($data) {
     echo "<script>alert('Ubah Data Dengan ID Karyawan = ".$id_karyawan." Berhasil') </script>";
     header('Location:index.php?m=index');
   
   } else {
     $sql   = "SELECT * FROM tb_karyawan WHERE id_karyawan = '".$id_karyawan."' ";
     $query = mysqli_query($koneksi, $sql);
     while ($row = mysqli_fetch_array($query)) {
       echo "Maaf, Terjadi kesalahan saat mencoba untuk menyimpan data ke database.";
     
     }
   }
 } //akhir untuk mengubah data
}

?>
