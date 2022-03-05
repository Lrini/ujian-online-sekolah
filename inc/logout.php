<?php
@session_start();

if(@$_GET['sesi'] == 'admin') {
	@$_SESSION['admin'] = null;
	echo "<script>window.location='../admin';</script>";
} else if(@$_GET['sesi'] == 'pengajar') {
	@$_SESSION['pengajar'] = null;
	echo "<script>window.location='../admin';</script>";
} else if(@$_GET['sesi'] == 'siswa') {
	@$_SESSION['siswa'] = null;
	echo "<script>window.location='../';</script>";
}


?>