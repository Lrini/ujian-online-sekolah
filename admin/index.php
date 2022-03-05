<?php
@session_start();
include "../+koneksi.php";

if(@$_SESSION['admin'] || @$_SESSION['pengajar']) {
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php cek_session("Halaman Administrator", "Halaman Pengajar"); ?> e-Learning</title>
    <link href="https://lrini.github.io/admin/style/assets/css/bootstrap.css" rel="stylesheet" />
    <link href="https://lrini.github.io/admin/style/assets/css/font-awesome.css" rel="stylesheet" />
    <link href="https://lrini.github.io/admin/style/assets/css/custom-styles.css" rel="stylesheet" />
    <link href='https://lrini.github.io/admin/style/assets/css/font-opensans.css' rel='stylesheet' />
    <link href="https://lrini.github.io/admin/style/assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <link href="https://lrini.github.io/admin/style/assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <style type="text/css">
    .link:hover { cursor:pointer; }
    </style>
</head>

<body>
    <script src="https://lrini.github.io/admin/style/assets/js/jquery-1.10.2.js"></script>
    <script src="https://lrini.github.io/admin/style/assets/js/bootstrap.min.js"></script>
    <script src="https://lrini.github.io/admin/style/assets/js/jquery.metisMenu.js"></script>
    <script src="https://lrini.github.io/admin/style/assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="https://lrini.github.io/admin/style/assets/js/morris/morris.js"></script>
    <script src="https://lrini.github.io/admin/style/assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="https://lrini.github.io/admin/style/assets/js/dataTables/dataTables.bootstrap.js"></script>
    <script src="https://lrini.github.io/admin/style/assets/js/custom-scripts.js"></script>    

    <div id="wrapper">
        <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="./"><?php cek_session("Administrator", "Pengajar"); ?></a>
            </div>

            <ul class="nav navbar-top-links navbar-right">
                <!-- <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-comment fa-fw"></i> New User
                                    <span class="pull-right text-muted small">4 min</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small">4 min</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                </li> -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <?php
                        if(@$_SESSION['admin']) {
                            $sesi_id = @$_SESSION['admin'];
                            $level = "admin";
                        } else if(@$_SESSION['pengajar']) {
                            $sesi_id = @$_SESSION['pengajar'];
                            $level = "pengajar";
                        }

                        if($level == 'admin') {
                            $sql_terlogin = mysqli_query($db, "SELECT * FROM tb_admin WHERE id_admin = '$sesi_id'") or die ($db->error);
                        } else if($level == 'pengajar') {
                            $sql_terlogin = mysqli_query($db, "SELECT * FROM tb_pengajar WHERE id_pengajar = '$sesi_id'") or die ($db->error);
                        }
                        $data_terlogin = mysqli_fetch_array($sql_terlogin);
                        echo ucfirst($data_terlogin['username']);
                        ?>
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li>
                            <a href="?hal=editprofil"><i class="fa fa-user fa-fw"></i> Edit Profil</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="<?php cek_session('../inc/logout.php?sesi=admin', '../inc/logout.php?sesi=pengajar'); ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>

        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li>
                        <a class="<?php if(@$_GET['page'] == '') { echo 'active-menu'; } ?>" href="./"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <?php
                    if(@$_SESSION['admin']) {
                    ?>
                        <li>
                            <a href="#"><i class="fa fa-sitemap"></i> Manajemen<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="?page=pengajar" class="<?php if(@$_GET['page'] == 'pengajar') { echo 'active-menu'; } ?>"># Manajemen Pengajar</a>
                                </li>
                                <li>
                                    <a href="?page=siswa" class="<?php if(@$_GET['page'] == 'siswa') { echo 'active-menu'; } ?>"># Manajemen Siswa</a>
                                </li>
                                <li>
                                    <a href="?page=siswaregistrasi" class="<?php if(@$_GET['page'] == 'siswaregistrasi') { echo 'active-menu'; } ?>"># Registrasi Siswa</a>
                                </li>
                            </ul>
                        </li>
                    <?php
                    }
                    ?>
                    <li>
                        <a class="<?php if(@$_GET['page'] == 'kelas') { echo 'active-menu'; } ?>" href="?page=kelas"><i class="fa fa-table"></i> Manajemen Kelas</a>
                    </li>
                    <li>
                        <a class="<?php if(@$_GET['page'] == 'mapel') { echo 'active-menu'; } ?>" href="?page=mapel"><i class="fa fa-fw fa-file"></i> Mata Pelajaran</a>
                    </li>
                    <li>
                        <a class="<?php if(@$_GET['page'] == 'quiz') { echo 'active-menu'; } ?>" href="?page=quiz"><i class="fa fa-bar-chart-o"></i> Manajemen Tugas / Quiz</a>
                    </li>
                    <li>
                        <a class="<?php if(@$_GET['page'] == 'materi') { echo 'active-menu'; } ?>" href="?page=materi"><i class="fa fa-qrcode"></i> Materi</a>
                    </li>
                    <li>
                        <a class="<?php if(@$_GET['page'] == 'berita') { echo 'active-menu'; } ?>" href="?page=berita"><i class="fa fa-desktop"></i> Berita</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div id="page-wrapper">
            <div id="page-inner">
                
                <?php
                if(@$_GET['page'] == '') {
                    include "inc/dashboard.php";
                } else if(@$_GET['page'] == 'pengajar') {
                    include "inc/pengajar.php";
                } else if(@$_GET['page'] == 'siswaregistrasi') {
                    include "inc/siswaregistrasi.php";
                } else if(@$_GET['page'] == 'siswa') {
                    include "inc/siswa.php";
                } else if(@$_GET['page'] == 'kelas') {
                    include "inc/kelas.php";
                } else if(@$_GET['page'] == 'mapel') {
                    include "inc/mapel.php";
                } else if(@$_GET['page'] == 'quiz') {
                    include "inc/quiz.php";
                } else if(@$_GET['page'] == 'materi') {
                    include "inc/materi.php";
                } else if(@$_GET['page'] == 'berita') {
                    include "inc/berita.php";
                } else {
                    echo "<div class='col-xs-12'><div class='alert alert-danger'>[404] Halaman tidak ditemukan! Silahkan pilih menu yang ada!</div></div>";
                } ?>
                
				<footer><p> &copy; LP3I COLLEGE KUPANG</p></footer>
            </div>
        </div>
    </div>
</body>
</html>
<?php
} else {
 include "login.php";
}
?>