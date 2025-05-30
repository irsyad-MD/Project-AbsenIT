<?php

include_once "sesi_murid.php";

$modul=(isset($_GET['s']))?$_GET['s']:"awal";
switch($modul){
	case 'awal': default: include "modul/murid/title.php"; break;
	case 'profil': include 'modul/murid/profil.php'; break;
	case 'edit': include 'modul/murid/edit.php'; break;
	case 'update': include 'modul/murid/update.php'; break;
	case 'index': include 'awal.php';
}
?>
