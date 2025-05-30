<?php
session_start();
include_once "sesi_murid.php";
$modul=(isset($_GET['m']))?$_GET['m']:"awal";
$jawal="Login murid || SI murid";
switch($modul){
    case 'awal': default: $aktif="Beranda"; $judul="Beranda $jawal"; include "awal.php"; break;
    case 'murid': $aktif="murid"; $judul="Modul murid $jawal"; include "modul/murid/index.php"; break;
    
   
}

?>
