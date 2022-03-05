<?php
@session_start();
include "+koneksi.php";

if(!@$_SESSION['siswa']) {
    if(@$_GET['hal'] == 'daftar') {
        include "register.php";
    } else {
        include "login.php";
    }
} else { ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>E-Learning LP3i COLLEGE KUPANG</title>
    <link href="https://lrini.github.io/style/assets/css/bootstrap.css" rel="stylesheet" />
    <link href="https://lrini.github.io/style/assets/css/font-awesome.css" rel="stylesheet" />
    <link href="https://lrini.github.io/style/assets/css/style.css" rel="stylesheet" />
</head>
<body>

<script src="https://lrini.github.io/style/assets/js/jquery-1.11.1.js"></script>
<script src="https://lrini.github.io/style/assets/js/bootstrap.js"></script>
<?php
$sql_terlogin = mysqli_query($db, "SELECT * FROM tb_siswa JOIN tb_kelas ON tb_siswa.id_siswa = '$_SESSION[siswa]' AND tb_kelas.id_kelas = tb_siswa.id_kelas") or die ($db->error);
$data_terlogin = mysqli_fetch_array($sql_terlogin);
?>
    <header>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    Selamat datang, <u><?php echo ucfirst($data_terlogin['username']); ?></u>. Jangan lupa <a href="inc/logout.php?sesi=siswa" class="btn btn-xs btn-danger">Logout</a>
                </div>
            </div>
        </div>
    </header>
    <!-- HEADER END-->
    <div class="navbar navbar-inverse set-radius-zero">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="./">
                    <img src="https://lrini.github.io/style/assets/img/logo.png" />
                </a>

            </div>

            <div class="left-div">
                <div class="user-settings-wrapper">
                    <ul class="nav">

                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                <span class="glyphicon glyphicon-user" style="font-size: 25px;"></span>
                            </a>
                            <div class="dropdown-menu dropdown-settings">
                                <div class="media">
                                    <a class="media-left" href="#">
                                        <img src="img/foto_siswa/<?php echo $data_terlogin['foto']; ?>" class="img-rounded" />
                                    </a>
                                    <div class="media-body">
                                        <h4 class="media-heading"><?php echo $data_terlogin['nama_lengkap']; ?></h4>
                                        <h5>Kelas : <?php echo $data_terlogin['nama_kelas']; ?></h5>
                                    </div>
                                </div>
                                <hr />
                                <center><a href="?hal=detailprofil" class="btn btn-info btn-sm">Detail Profile</a> <a href="?hal=editprofil" class="btn btn-primary btn-sm">Edit Profile</a></center>

                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>

    <section class="menu-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse ">
                        <ul id="menu-top" class="nav navbar-nav navbar-right">
                            <li><a <?php if(@$_GET['page'] == '') { echo 'class="menu-top-active"'; } ?> href="./">Beranda</a></li>
                            <li><a <?php if(@$_GET['page'] == 'quiz') { echo 'class="menu-top-active"'; } ?> href="?page=quiz">Tugas / Quiz</a></li>
                            <li><a <?php if(@$_GET['page'] == 'materi') { echo 'class="menu-top-active"'; } ?> href="?page=materi">Materi</a></li>
                            <li><a <?php if(@$_GET['page'] == 'berita') { echo 'class="menu-top-active"'; } ?> href="?page=berita">Berita</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="content-wrapper">
        <div class="container" id="wadah">
        <?php
        if(@$_GET['page'] == '') {
            include "inc/beranda.php";
        } else if(@$_GET['page'] == 'quiz') {
            include "inc/quiz.php";
        } else if(@$_GET['page'] == 'nilai') {
            include "inc/nilai.php";
        } else if(@$_GET['page'] == 'materi') {
            include "inc/materi.php";
        } else if(@$_GET['page'] == 'berita') {
            include "inc/berita.php";
        } ?>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    &copy; LP3I COLLEGE KUPANG
                </div>

            </div>
        </div>
    </footer>
</body>
</html>
<?php
}
?>