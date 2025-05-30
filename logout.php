<?php
session_start();
unset($_SESSION['idsi']);
unset($_SESSION['usersi']);
unset($_SESSION['namasi']);
unset($_SESSION['jabatansi']);
echo "<script>window.location='../'</script>";	
//session_destroy();
//  unset($_SESSION["sessidpks"]);
?>
